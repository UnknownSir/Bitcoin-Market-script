<?php

class DashboardController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {

        //make sure the user is logged in
        if (!UsersModel::Loggedin() == true): Redirect::to('user/login?refer=' . Request::get('url'));
            exit();
        endif;

        //get the user's username to check their products
        $user = UsersModel::user();
		$product = ProductModel::purchased($user);

        //get the ids that the user is watching... surely there's a better way than this
        $watchingids = ProductModel::watching($user);
        $watchingproducts = array();
        foreach ($watchingids as $watching):
            $watchingproducts[] = $watching->watching_product;
        endforeach;

        //if not watching anything define var as null -- maybe make this shorthand
        if (!empty($watchingproducts)):                                         //system escape               
            $imwatching = ProductModel::products("", " AND product_id IN (" . implode(",", $watchingproducts) . ")", 'watching');
        else:
            $imwatching = null;
        endif;

        $this->View->renderSidebar('/dashboard/index', array(
            'product' => ProductModel::purchased($user),
            'imwatching' => $imwatching)
        );
		
    }

    public function selling() {

        //make sure the user is logged in
        if (!UsersModel::Loggedin() == true): Redirect::to('user/login?refer=' . Request::get('url'));
            exit();
        endif;

        //get the user's username to check their products
        $user = UsersModel::user();
        $type = Request::get('type');

        //switch between sell types
        switch ($type) {
            case 'selling':
                $product = ProductModel::sell($user, 'selling');
                break;
            case 'sold':
                $product = ProductModel::sell($user, 'sold');
                break;
            case 'unsold':
                $product = ProductModel::sell($user, 'unsold');
                break;
            default: $product = ProductModel::sell($user, 'selling');
        }
				
        $this->View->renderSidebar('dashboard/selling', array(
            'product' => $product));
    }

    public function purchased() {
        if (!UsersModel::Loggedin() == true): Redirect::to('user/login');
            exit();
        endif;

        $username = UsersModel::user();
        $bought = ProductModel::purchased($username);
        $this->View->renderSidebar('dashboard/purchased', array('product' => $bought));
    }
	
    public function withdraw() {
       
	   if (!UsersModel::Loggedin() == true): Redirect::to('user/login');
            exit();
        endif;

        $username = UsersModel::user();
		$payees = UsersModel::payees($username,'');
		$withdraw = UsersModel::withdraws($username);
        $this->View->render('dashboard/withdraw', array('username' => $username,
														'withdraws' => $withdraw,
														'payees' => $payees));
    }
	

    public function addproduct() {
	
        //if not logged in redirect them
        if (!UsersModel::Loggedin() == true): Redirect::to('user/login?refer=' . Request::get('url'));
            exit();
        endif;

		$username = UsersModel::user();
		
        //if they're adding a product
        if (Request::post('add_product') == 1):

            $addproduct = ProductModel::AddProduct(Request::post('title'), Request::post('description'), Request::post('price'), Request::post('startingprice'), Request::post('type'), Request::post('condition'), Request::post('shortdescription'), Request::post('auctionlength'), Request::post('offers'), Request::post('country'), Request::post('shipping'), Request::post('quantity'), Request::post('startprice'), UsersModel::user(), Request::post('shippingcost'), Request::post('returns'), Request::post('shippingtime'));
			
            if ($addproduct == true):
				System::action_tracking($username, 'added a product');
                Redirect::to('dashboard/selling');
                exit();
            else:
				System::action_tracking($username, 'failed to add a product');
                Redirect::to('dashboard/addproduct');
                exit();
            endif;

        endif;

        $this->View->Render('dashboard/addproduct');
    }

    public function following() {
        // load views
        $page = 'following';

        //check if they're logged in
        if (!UsersModel::Loggedin() == true): Redirect::to('user/login?refer=' . Request::get('url'));
            exit();
        endif;

        //username of the session holder
        $username = UsersModel::user();

        //session holders is following
        $imfollowing = UsersModel::following($username);

        $followingusers = array();
        foreach ($imfollowing as $follow):
            $followingusers[] = $follow->following;
        endforeach;


        if (!empty($followingusers)):
            $following = UsersModel::users(" WHERE id IN (" . implode(",", $followingusers) . ")");
            $notfollowing = null;
        else:
            $following = null;
            $notfollowing = System::translate("You are not following anyone at the moment. Explore to find someone to follow.");
        endif;

        $this->View->render('dashboard/following', array(
            'following' => $following,
            'notfollowing' => $notfollowing));
    }

    public function wishlist() {
        $username = UsersModel::user();

        if (!UsersModel::Loggedin() == true): Redirect::to('user/login');
            exit();
        endif;

		//get the ids in the wishlist
        $wishlistids = ProductModel::wishlist($username);
        $wishlistproducts = array();
        
		//loops through them
		foreach ($wishlistids as $wishlist):
            $wishlistproducts[] = $wishlist->wishlist_product;
        endforeach;

        if (!empty($wishlistproducts)):                                         //system escape               
            $mywishlist = ProductModel::products("", " AND id IN (" . implode(",", $wishlistproducts) . ")", 'watching');
        else:
            $mywishlist = null;
        endif;
        $this->View->render('dashboard/wishlist', array('product' => $mywishlist));
    }

    public function basket() {
        
		if (!UsersModel::Loggedin() == true): Redirect::to('user/login?refer=' . Request::get('url'));
            exit();
        endif;
        
		$username = UsersModel::user();
        
		$baskets = ProductModel::basket($username);
       
	   $this->View->Render('dashboard/basket', array('baskets' => $baskets));
    }

    public function addtobasket($item = '') {
        if (!UsersModel::Loggedin() == true): Redirect::to('user/login');
            exit();
        endif;

        //get the username
        $username = UsersModel::user();

        //add the item to the basket
        $addtobasket = ProductModel::addtobasket($username, $item);
        if ($addtobasket == 2):
			System::action_tracking($username, 'Added an item to the basket Item: '.$item);
            Session::set('success', 11);
            Redirect::to('dashboard/basket');
        else:
			System::action_tracking($username, 'Failed to add an item to the basket. Item: '.$item);
            Session::set('error', 23);
            Redirect::to('dashboard/basket');
        endif;
    }

    public function removefrombasket($item = '') {
        if (!UsersModel::Loggedin() == true): Redirect::to('user/login?refer=' . Request::get('url'));
            exit();
        endif;

        //get the username
        $username = UsersModel::user();

        //remove item from basket
        $addtobasket = ProductModel::removefrombasket($username, $item);
        //check results, act accordingly 
        if ($addtobasket == 1):
            Session::set('success', 13);
			System::action_tracking($username, 'Removed an item from the basket Item: '.$item);
            Redirect::to('dashboard/basket');
        else:
            Session::set('error', 25);
			System::action_tracking($username, 'Failed to remove an item from the basket Item: '.$item);
            Redirect::to('dashboard/basket');
        endif;
    }

    public function checkout($item = '', $user = '', $type = '') {
        if (!UsersModel::Loggedin() == true): Redirect::to('user/login?refer=' . Request::get('url'));
            exit();
        endif;

        //get the user
        $username = UsersModel::user();

		//create the wishlist order
		if(!empty($item) && !empty($user) && !empty($type)&& $type === 'wishlist'):
			$create_wishlist_order = OrdersModel::wishlistcreate($item, $user, $username);
		endif;
		
        //$baskets = ProductModel::basket($username);
        $orders = UsersModel::wonitem($username);

        if (Request::post('basket') == 1):
          
			//make sure their address is set otherwise redirect 'em	
			if (UsersModel::addressset($username) != 1): Session::set('error', 21);
				Redirect::to('user/editprofile');
				exit();
			endif;
            //because I am inserting the data on the page, I need to refresh :(      
            $createbasket = OrdersModel::createbasketorder(Request::post('firstname'), 
								Request::post('lastname'), Request::post('email'), 
								Request::post('phone'), Request::post('address1'), 
								Request::post('address2'), Request::post('city'), 
								Request::post('zipcode'), Request::post('country'), 
								Request::post('state'), $username);

            if ($createbasket == true):
                Redirect::to('dashboard/checkout');
            endif;
        endif;

        $this->View->Render('dashboard/checkout', array(
		    'user' => $username,
            'orders' => $orders));
    }

    public function relist($item = '') {
        if (!UsersModel::Loggedin() == true): Redirect::to('user/login');
            exit();
        endif;

        $username = UsersModel::user();

        $relist = ProductModel::relist($username, $item);

        if ($relist == true):
			System::action_tracking($username, 'Relisted an item. Item: '.$item);
            Redirect::to('dashboard/selling');
            exit();
        else:
			System::action_tracking($username, 'Failed to Relist an item. Item: '.$item);
            Redirect::to('dashboard/selling?type=unsold');
            exit();
        endif;
    }

    public function enditem($item = '') {
        if (!UsersModel::Loggedin() == true): Redirect::to('user/login?refer=' . Request::get('url'));
            exit();
        endif;

        $username = UsersModel::user();

        $enditem = ProductModel::enditem($username, $item);

        if ($enditem == true):
			System::action_tracking($username, 'Ended an item. Item: '.$item);
            Redirect::to('dashboard/selling?type=unsold');
            exit();
        else:
			System::action_tracking($username, 'Failed to end an item. Item: '.$item);
            Redirect::to('dashboard/selling');
            exit();
        endif;
    }

}
