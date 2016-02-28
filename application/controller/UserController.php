<?php

class UserController extends Controller {

    public function index() {
        Redirect::to('user/login');
        exit();
    }

    public function login() {


        //check if user is logged in
        if (UsersModel::Loggedin() == true): Session::set('success', 3);
            Redirect::to('dashboard');
            exit();
        endif;

        //get the refer to take 'em back to the page before login
        if (Session::get('refer') != true && Request::get('refer') == true):
            Session::set('refer', Request::get('refer'));
        endif;

        if (isset($_POST['user_login'])) {
            $login = UsersModel::login(Request::post('email'), Request::post('password'));

            if ($login == 1):
                if (Session::get('refer') == true):
                    Session::set('success', 3);
                    Redirect::to(Session::get('refer'));
                    unset($_SESSION['refer']);
                    exit();
                endif;
                Session::set('success', 3);
                Redirect::to('dashboard');
                exit();
            elseif ($login == 2):
                Session::set('error', 3);
                Redirect::to('user/login?email=' . Request::post('email') . '');
                exit();
            else:
                Session::set('error', 3);
                Redirect::to('user/login?email=' . Request::post('email') . '');
                exit();
            endif;
        }

        $this->View->renderPage('/user/login');
    }

    public function register() {
        //start register process
        if (Request::post('register_user') == true) {
            $register_user = UsersModel::register(Request::post('username'), Request::post('email'), Request::post('password'), Request::post('passwordconfirm'));

            //check if it's a valid email
            if ($register_user == 1):
                Session::set('error', 19);
                Redirect::to('user/register');
                exit();
            elseif ($register_user == 2):
                Session::set('error', 2);
                Redirect::to('user/register');
                exit();
            elseif ($register_user == 3):
                Session::set('error', 4);
                Redirect::to('user/register');
                exit();
            elseif ($register_user == 4):
			    Session::set('success', 1);
                Redirect::to('user/editprofile');
                exit();
            endif;
        }

        $this->View->RenderPage('user/register');
    }

    public function logout($token = '') {
        Session::init();
        if (!UsersModel::Loggedin() == true): Redirect::to('user/login');
            exit();
        endif;

        //get the cross-site forgery token, make sure it's the actual user
        if ($token == Session::get('token')):
            Session::destroy();
            Session::set('success', 14);
            Redirect::to('index');
        else:
            Session::set('error', 24);
            Redirect::to('index');
        endif;
    }

    public function profile($username = '') 
	{
		
        // who're they viewing 
        $username = $username;

        //check if they're logged in
        //user information
        $feedback = UsersModel::feedback($username);
        $userinfo = UsersModel::user($username);

        //does the user exist or not?
        if (!isset($userinfo->user_id)): Session::set('error', 17);
            Redirect::to('dashboard');
            exit();
        endif;

        //last 10 items from the user you (session) is viewing
        $recentitems = ProductModel::products($username, " AND product_enddate > NOW() AND product_quantity > 0 AND product_enabled = 1 ORDER BY product_date DESC LIMIT 10");

        //get the users wishlist so others can buy for them
        $wishlistids = ProductModel::wishlist($userinfo);
        $wishlistproducts = array();
        foreach ($wishlistids as $wishlist):
            $wishlistproducts[] = $wishlist->wishlist_product;
        endforeach;

		//get feedback for user
		$feedback = UsersModel::feedback($username);

        if (!empty($wishlistproducts)):                                         //system escape               
            $mywishlist = ProductModel::products("", " AND id IN (" . implode(",", $wishlistproducts) . ")", 'watching');
        else:
            $mywishlist = null;
        endif;

        $this->View->render('user/profile', array(
            'userinfo' => $userinfo,
            'feedback' => $feedback,
            'recentitems' => $recentitems,
            'username' => $username,
            'wishlist' => $mywishlist));
    }

    public function editprofile() {
        if (!UsersModel::Loggedin() == true): Redirect::to('user/login');
            exit();
        endif;

        $user = UsersModel::user();

        //check if they're updating their profile
        if (Request::post('update_profile') == true):

            $updateprofile = UsersModel::updateprofile(Request::post('password'), Request::post('newpassword'), Request::post('newpasswordconfirm'), Request::post('bitcoinaddress'), Request::post('address1'), Request::post('address2'), Request::post('city'), Request::post('zipcode'), Request::post('country'), Request::post('aboutme'), Request::post('theme'), $user);

            //check if it was a success or not
            if ($updateprofile == 1):
                Session::set('success', 10);
                Redirect::to('user/editprofile');
            else:
                Session::set('error', 0);
                redirect::to('user/editprofile');
            endif;
        endif;
        $this->View->render('user/edit', array('user' => $user));
    }

    public function follow($user = '') {

        if (!UsersModel::Loggedin() == true): Redirect::to('user/login');
            exit();
        endif;

        //get the user id to start following
        $follow = UsersModel::Follow($user);

        if ($follow == 1):
            Session::set('success', 5);
            Redirect::to('dashboard/following');
        elseif ($follow == 2):
            Session::set('error', 13);
            Redirect::to('dashboard/following');
        else:
            Session::set('error', 0);
            Redirect::to('dashboard/following');
        endif;
    }

    public function unfollow($user = '') {
        if (!UsersModel::Loggedin() == true): Redirect::to('user/login');
            exit();
        endif;

        //get the userid to unfollow
        $unfollow = UsersModel::unfollow($user);

        if ($unfollow == 1):
            Session::set('success', 6);
            Redirect::to('dashboard/following');
        elseif ($unfollow == 2):
            Session::set('error', 15);
            Redirect::to('dashboard/following');
        else:
            Session::set('error', 15);
            Redirect::to('dashboard/following');
        endif;
    }

    public function feedback($user = '') {
	    if (!UsersModel::Loggedin() == true): Redirect::to('user/login');
            exit();
        endif;
		
        $this->View->render('user/feedback', array('user' => $user));
    }

    public function payees()
    {
        // load views
        if (!UsersModel::Loggedin() == true): Redirect::to('user/login');
            exit();
        endif;
        
		$username = UsersModel::user();
		
		//add the payee and get the payees
		$payees = UsersModel::payees($username);
		

		$payees = UsersModel::payees($username,'');
		
		$this->View->render('user/payee', array('payees' => $payees));
	}
	
	public function add_payee()
	{
	    // load views
        if (!UsersModel::Loggedin() == true): Redirect::to('user/login');
            exit();
        endif;
		$addpayee = UsersModel::addpayee(Request::post('name'), Request::post('address'));	

		if($addpayee == 1):
			//success
			Session::set('success', 0);
            Redirect::to('user/payees');
		else:
			Session::set('error', 0);
            Redirect::to('user/payees');
		endif;
	}

}

?>