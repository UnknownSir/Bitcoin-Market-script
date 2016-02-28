<?php

/*
 * Models all need redesigning and commenting. Too fucking bulky lol
 *
 */

class UsersModel {

    /**
     * UsersModel::LoggedIn()
     * 
     * @return
     */
    public static function LoggedIn() {
        return (Session::get('username') ? true : false);
    }

    /**
     * UsersModel::newtoken()
     * 
     * @return
     */
    public static function newtoken() {
        //this needs generating on each form action
        $_SESSION['token'] = md5(uniqid()); //will eventually make a better one, FTB it'll do
        session_regenerate_id(); //generate them a new session
    }

    /**
     * UsersModel::Authentication()
     * 
     * @return
     */
    public static function Authentication() {
        // initialize the session (if not initialized yet)
        Session::init();

        // if user is not logged in...
        if (!Users::LoggedIn()) {
            // ... then treat user as "not logged in", destroy session, redirect to login page
            Session::destroy();
            Redirect::to('user/login');
            exit();
        }
    }

    /**
     * UsersModel::isstaff()
     * 
     * @return
     */
    public static function isstaff() 
	{
        $checksupport = UsersModel::user();

        if ($checksupport->user_staff == '1') {
            return true;
        }
    }
	
	public static function withdraws($username)
	{
		
		//iniate the database
		$database = DatabaseFactory::getFactory()->getConnection();
		
		//sql to run
		$sql = "SELECT * FROM transactions 
				WHERE transaction_username = ? 
				AND transaction_transaction = 'withdraw'";
		
		//run the sql
		$transaction = $database->prepare($sql);
		$transaction->execute(array($username->user_username));
		
		//return the results
		return $transaction->fetchAll();
	}

    /**
     * UsersModel::login()
     * 
     * @param mixed $email
     * @param mixed $password
     * @return
     */
    public static function login($email, $password) 
	{
		
		//iniate the database
        $database = DatabaseFactory::getFactory()->getConnection();
		
		//check if email is valid
        if (UsersModel::checkuser($email) == true):

            //user exists, hash password, compare hashes with compare_hash so there's no memory leak
            $getuser = $database->prepare("SELECT user_password, user_salt, user_username FROM users WHERE user_email=? LIMIT 1");
            $getuser->execute(array($email));

            //okay we can hash the info now
            $userinfo = $getuser->fetch();

            //this is the login user's hashed password
            $loginhash = hash_hmac('sha256', $password, $userinfo->salt, 0);

            //needs removing once I find the hash compare function
            if ($loginhash == $userinfo->password):

                //user exists and has correct password
                Session::set('username', $userinfo->username);
                //cross site forgery token
                UsersModel::newtoken();
                return 1; //success blah blah
            endif;
            return 2;  //wrong username/password error
        endif;
        return 2; //wrong username/password error
    }

    /**
     * UsersModel::register()
     * 
     * @param mixed $username
     * @param mixed $email
     * @param mixed $password
     * @param mixed $passwordconfirm
     * @return
     */
    public static function register($username, $email, $password, $passwordconfirm) 
	{
        //check if it's a valid email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)): return 1;
            exit();
        endif;

        //check if passwords match
        if (!$password == $passwordconfirm): return 2;
            exit();
        endif;

		//check if the username or email is taken
        if (UsersModel::checkusername($username, $email) == true): return 3;
            exit();
        endif;

		$emailhash = sha1(uniqid(mt_rand(), true));
        
		//good stuff, register the user... 
        $register_user = UsersModel::registeruser($username, $email, $password, $emailhash);

        if ($register_user == 1):
			    
				//has successfully registered log them in
                Session::set('username', $username);
                
				//cross site forgery token
                UsersModel::newtoken();
				
				//send them an email
                System::email($email, 'Email verification', array(
                     'main' => 'Before you can start buying and/or selling you must first verify your email',
                     'url' => 'Copy the following url in to your browser\'s url bar <a href="">click me</a>'));
             
			return 4;
        else:
            false;
        endif;
    }

    /**
     * UsersModel::user()
     * 
     * @param mixed $username
     * @param mixed $userid
     * @return
     */
    public static function user($username = null, $userid = null) 
	{
		
		//iniate the database
        $database = DatabaseFactory::getFactory()->getConnection();
		
		//get user from session, or supplied name
        if (isset($username) && !isset($userid)):
            $getuser = $database->prepare("SELECT * FROM users WHERE user_username = ? LIMIT 1");
            $getuser->execute(array($username));
            return $getuser->fetch();
        elseif (isset($username) && isset($userid)):
            $getuser = $database->prepare("SELECT * FROM users WHERE user_id = ? LIMIT 1");
            $getuser->execute(array($username));
            return $getuser->fetch();
        else:
            $getuser = $database->prepare("SELECT * FROM users WHERE user_username = ? LIMIT 1");
            $getuser->execute(array(Session::get('username')));
            return $getuser->fetch();
        endif;
    }

    /**
     * UsersModel::users()
     * 
     * @param mixed $select
     * @return
     */
    public static function users($select = null) 
	{
        //get specific user
        $database = DatabaseFactory::getFactory()->getConnection();
        $getuser = $database->prepare("SELECT * FROM users " . $select . " ");
        $getuser->execute();
        return $getuser->fetchAll();
    }

    /**
     * UsersModel::follow()
     * 
     * @param mixed $userid
     * @return
     */
    public static function follow($userid) 
	{
		
        //note -- follow and unfollow should be in same function and use a switch 
        $database = DatabaseFactory::getFactory()->getConnection();
       
	   //grab all user info
        $username = $userid;
        $user = UsersModel::user();
        $result = UsersModel::user($username, 'id');

        //get user from email check exists add follow, redirect wirh success
        if ($result->id != null):

            //check if they're already following the user
            $checkfollowing = $database->prepare("SELECT * FROM followers WHERE username=? AND following=? LIMIT 1");
            $checkfollowing->execute(array($user->username, $username));
            $followresult = $checkfollowing->fetch();

            if (!isset($followresult->id)):

                //exists add to follow:
                $date = date("Y-m-d h:i:s");
                $time = strtotime("now");
                $addfollow = $database->prepare("INSERT INTO followers(username,following,followdate,followtime) VALUES(?,?,?,?)");
                $addfollow->execute(array($user->username, $username, $date, $time));
                return 1;
            endif;
            return 2;
        endif;
        return 3;
    }

    /**
     * UsersModel::unfollow()
     * 
     * @param mixed $userid
     * @return
     */
    public static function unfollow($userid) {
        //get the user info
        $database = DatabaseFactory::getFactory()->getConnection();
        $username = $userid;
        $user = UsersModel::user();
        $result = UsersModel::user($username, 'id');

        //get user from email check exists add follow, redirect wirh success
        if ($result->id != null):

            //check if they're already following the user
            $checkfollowing = $database->prepare("SELECT * FROM followers WHERE username=? AND following=? LIMIT 1");
            $checkfollowing->execute(array($user->username, $username));
            $followresult = $checkfollowing->fetch();

            if (isset($followresult->id)):
                //exists remove from following
                $date = date("Y-m-d h:i:s");
                $time = strtotime("now");
                $unfollow = $database->prepare("DELETE FROM followers WHERE username=? AND following=?");
                $unfollow->execute(array($user->username, $username));
                return 1;
            endif;
            return 2;
        endif;
    }

    /**
     * UsersModel::checkuser()
     * 
     * @param mixed $email
     * @return
     */
    public static function checkuser($email) {
        //check user exists, for login or register
        $database = DatabaseFactory::getFactory()->getConnection();
        $checkuser = $database->prepare("SELECT id FROM users WHERE email=? LIMIT 1");
        $checkuser->execute(array($email));
        $result = $checkuser->fetch();
        if ($result):
            return true;
        endif;
    }

    /**
     * UsersModel::checkusername()
     * 
     * @param mixed $username
     * @return
     */
    public static function checkusername($username, $email) 
	{
        //check username exists, for register
        $database = DatabaseFactory::getFactory()->getConnection();
		
		//sql to run
		$sql = "SELECT user_id FROM users 
				WHERE user_username = ? 
				OR user_email = ? 
				LIMIT 1";
		
		//run the sql
        $checkuser = $database->prepare($sql);
        $checkuser->execute(array($username, $email));
        $result = $checkuser->fetch();
        
		//the results
		if ($result->id):
            return true;
        endif;
    }

    /**
     * UsersModel::following()
     * 
     * @param mixed $username
     * @return
     */
    public static function following($username) 
	{
        //iniate the database
        $database = DatabaseFactory::getFactory()->getConnection();
		
		//sql to run
		$sql = "SELECT * FROM followers 
				WHERE follower_username = ?";
		
		//run the sql
        $following = $database->prepare($sql);
        $following->execute(array($username->user_username));
		
		//return the results
        return $following->fetchAll();
    }

    /**
     * UsersModel::feedback()
     * 
     * @param mixed $username
     * @return
     */
    public static function feedback($username) 
	{
        //iniate the database
        $database = DatabaseFactory::getFactory()->getConnection();
		
		//sql to run
		$sql = "SELECT * FROM feedback 
				WHERE feedback_username = ?";
		
		//run the sql
        $feedback = $database->prepare($sql);
        $feedback->execute(array($username));
        return $feedback->fetchAll();
    }

    /**
     * UsersModel::registeruser()
     * 
     * @param mixed $username
     * @param mixed $email
     * @param mixed $pass
     * @param mixed $emailhash
     * @return
     */
    public static function registeruser($username, $email, $pass, $emailhash) 
	{
		
        //iniate the database
        $database = DatabaseFactory::getFactory()->getConnection();
        
		//iniate the salt for the password
		$salt = md5(uniqid()); 
		
		//create the password
        $password = hash_hmac('sha256', $pass, $salt, 0); 
		
		//sql to run
		$sql = "INSERT INTO users 
				(
					user_username,
					user_email,
					user_password,
					user_salt,
					user_emailhash
				) 
				VALUES
				(
					?,
					?,
					?,
					?,
					?
				)";
		
		//run the sql
        $registeruser = $database->prepare($sql);
        $result = $registeruser->execute(array($username, $email, $password, $salt, $emailhash));
		
		if($result):
			return 1;
		endif;
    }

    /**
     * UsersModel::addressset()
     * 
     * @param mixed $username
     * @return
     */
    public static function addressset($username) 
	{
        //iniate the database
        $database = DatabaseFactory::getFactory()->getConnection();
        
		//sql to run
		$sql = "SELECT * FROM users 
				WHERE user_username = ?";
		
		//run the sql
		$user = $database->prepare($sql);
        $user->execute(array($username->user_username));
        $userinfo = $user->fetch();

        if (!empty($userinfo->user_address1) && !empty($userinfo->user_address2) &&
                !empty($userinfo->user_city) && !empty($userinfo->user_zipcode) && !empty($userinfo->user_country)):
            return 1;
        endif;
    }

    /**
     * UsersModel::wonitem()
     * 
     * @param mixed $username
     * @return
     */
    public static function wonitem($username) 
	{
		
        //iniate the database
        $database = DatabaseFactory::getFactory()->getConnection();
		
		//sql to run
		$sql = "SELECT * FROM products 
				LEFT JOIN orders on orders.orders_product = products.id 
				WHERE orders.orders_username = ? 
				AND orders.orders_status = 0";
        
		//run the sql
		$wonitem = $database->prepare($sql);
        $wonitem->execute(array($username->username));
        return $wonitem->fetchAll();
    }

    /**
     * UsersModel::updateprofile()
     * 
     * @param mixed $oldpassword
     * @param mixed $newpassword
     * @param mixed $newpasswordconfirm
     * @param mixed $bitcoinaddress
     * @param mixed $address1
     * @param mixed $address2
     * @param mixed $city
     * @param mixed $zipcode
     * @param mixed $country
     * @param mixed $aboutme
     * @param mixed $theme
     * @param mixed $username
     * @return
     */
    public static function updateprofile($oldpassword, $newpassword, $newpasswordconfirm, $bitcoinaddress, $address1, $address2, $city, 
										 $zipcode, $country, $aboutme, $theme, $username) 
	{
		
        //update address etc without having to fill out password inputs
        if (!isset($oldpassword) || !isset($newpassword) || !isset($newpasswordconfirm) || !isset($bitcoinaddress)): goto address;

        endif;

        address:
		
		//iniate the database
        $database = DatabaseFactory::getFactory()->getConnection();
		
		//sql to run
		$sql = "UPDATE users 
				SET user_address1 = ?, 
				    user_address2 = ?, 
					user_city = ?, 
					user_zipcode = ?, 
					user_country = ?, 
					user_about = ?, 
					user_theme = ? 
					WHERE user_username = ?";
					
		//run the sql
        $update = $database->prepare($sql);
        $result = $update->execute(array($address1, $address2, $city, $zipcode, $country, $aboutme, $theme, $username->username));
        if ($result): 
			return 1;
        endif;
    }

    public static function addpayee($name, $address)
	{
		if(isset($name) && isset($address)):
			$date = date("y-m-d h:i:s");
			
			//sql to run
			$sql = "INSERT INTO addresses
					(
						address,
						coin,
						name,
						type,
						date,
						username
					)
					VALUES
					(
						?,
						?,
						?,
						?,
						?,
						?
					)";
					
			//run the database
			$addpayee = $this->db->prepare($sql);
				$addpayee->execute(array($address,$coins,$name,'payee',$date,$username->username));
				return 1;
			endif;		
	}
	
	public static function payees($username)
	{
		
		//iniate the database
		$database = DatabaseFactory::getFactory()->getConnection();
		
		//sql to run
		$sql = "SELECT * FROM addresses 
				WHERE address_username = ?";
		
		//run the sql
		$addresses = $database->prepare($sql);
		$addresses->execute(array($username->user_username));
		
		//return the results
		return $addresses->fetchAll();
	}

}
