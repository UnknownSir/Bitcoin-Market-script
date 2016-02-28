<?php

class System
{
    		
	public static function bitcoinconnect() 
	{
        include Config::get('PATH_LIBS')."jsonRPCClient.php";
        //connect to bitcoin rpc use https ALWAYS!! for this we'll use http
        $bitcoin = new Bitcoin("https://deamonhereilldefinethisinanupdate");
        return $bitcoin;
    }
	
	
	
	public static function action_tracking($user = null, $action = null)
	{
		//track the products the users are viewing etc. We can then optimise recs
		$timestamp = strtotime("NOW");
 
		//get the refering page
		$refer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'none'; 
		
		//their browser details
		$browser = $_SERVER['HTTP_USER_AGENT'];
		
		//the user's ip
		$ip = $_SERVER['REMOTE_ADDR'];
		
		//get the user
		$user = isset($user->username) ? $user->username : 'guest'; 
		
		//action performed
		$user_action = isset($action) ? $action : 'unknown';
		
		//iniat the database
		$database = DatabaseFactory::getFactory()->getConnection();
		
		//sql to run
		$sql = "INSERT INTO action_tracking
				(
					action_tracking_timestamp, 
 					action_tracking_reffer, 
					action_tracking_browser, 
					action_tracking_username, 
					action_tracking_action
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
		$inserttracking = $database->prepare($sql);
		
		//insert the values
		$inserttracking->execute(array($timestamp, $refer, $browser, $user, $user_action));
	}	
	
	public static function click_tracking($item = null)
	{
		//track the products the users are viewing etc. We can then optimise recs
		$timestamp = strtotime("NOW");
		
		//get the referer
		$refer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'none'; 
		
		//get the person's browser info
		$browser = $_SERVER['HTTP_USER_AGENT'];
		
		//get their ip
		$ip = $_SERVER['REMOTE_ADDR'];
		
		//get the user
		$user = isset($user->username) ? $user->username : 'guest'; 
		
		//get the item
		$item = isset($item) ? $item : 0;
		
		//iniate the database
		$database = DatabaseFactory::getFactory()->getConnection();
		
		//sql to run
		$sql = "INSERT INTO click_tracking
				(
					click_tracking_timestamp, 
					click_tracking_refer, 
					click_tracking_browser, 
					click_tracking_user_ip, 
			        click_tracking_user, 
					click_tracking_item
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
				
		//run the sql
		$inserttracking = $database->prepare($sql);
		
		//insert the values
		$inserttracking->execute(array($timestamp, $refer, $browser, $ip, $user, $item));
	}

	/*
	 * Sanitise source, 'compile' all code to 'speed' up the website
	*/
	public static function Sanitise()
	{
	    function sanitize_output($buffer) 
		{

            $search = array(
                '/\>[^\S ]+/s', // strip whitespaces after tags, except space
                '/[^\S ]+\</s', // strip whitespaces before tags, except space
                '/(\s)+/s'       // shorten multiple whitespace sequences
            );

            $replace = array(
                '>',
                '<',
                '\\1'
            );

            $buffer = preg_replace($search, $replace, $buffer);

            return $buffer;
        }

        ob_start("sanitize_output");
	}
	
	/*
	 * Escape all database outputs incase they're tryin' to hack us
	*/
	public static function escape($str)
	{
		return htmlspecialchars($str, ENT_QUOTES);
	}
	
	/*
	 * Show errors to the user to make it more user-friendly
	 * System::error('errornumber');
	*/
	public static function error($errorid) {
	
        $errors = array(
			0 => 'General error, our system does not know what happened.',
            1 => 'Product does not exist.',
            2 => 'Passwords do not match. Try again',
            3 => 'Wrong email and/or password. Try again',
            4 => 'User already exists. Try a new one',
            5 => 'Price must be a number',
            6 => 'Wallet and amount must be set',
            7 => 'Invalid bitcoin address',
			9 => 'Message could not be sent',
            10 => 'Product id was not set.',
            11 => 'You are already watching this item',
            12 => 'Cannot follow this user as they do not exist',
            13 => 'You are already following this user',
            14 => 'You are not following this user',
            15 => 'Cannot unfollow this user as they do not exist',
            16 => 'This item does not exist. Try again.',
            17 => 'This user does not exist. Try again',
            18 => 'This is not your ticket to view',
			19 => 'Not a valid email address. Try again.',
			20 => 'Item is already in your wish list',
			21 => 'Address must be set before you can perform that action.',
			22 => 'Ticket does not belong to you. Create a new ticket',
			23 => 'The item has already ended or the item does not exist.',
			24 => 'There was an error sending the message. Try again',
			25 => 'There was an error removing an item from your basket',
			26 => 'There was an error adding this product.',
			27 => 'There was an error relisting your item',
			28 => 'There was an error ending your listing',
			29 => 'There was an error marking this item as received.',
			30 => 'This order does not belong to you, or no order exists',
			31 => 'You have already left feedback or order does not belong to you',
			32 => 'You have already dispatched item or order does not belong to you',
			33 => 'You have successfully deleted your message'
			);

        if (is_numeric($errorid) && isset($errors[$errorid])):
            echo'
				<div class="row"> 
			    <div class="col-xs-12 col-md-4 col-md-offset-4 alert alert-danger alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                     ' . $errors[$errorid] . '
                </div></div>
				';
			unset($_SESSION['error']);
        endif;
    }

    /*
	 * Show success messages to the user to make it more user-friendly
	 * System::success('successmessagenumber');
	*/
    public static function success($successid = null) 
	{
        $success = array(
            1 => 'You have successfully registered. Please login',
            2 => 'You have successfully added this item to your watch list',
            3 => 'You have successfully logged in. Welcome.',
            4 => 'You have successfully removed this item from your watch list',
            5 => 'You have successfully followed this user',
            6 => 'You have successfully unfollowed this user',
            7 => 'You have successfully submitted a support ticket',
			8 => 'You have successfully added this item to your wish list',
			9 => 'You have successfully removed this item to your wish list',
			10 => 'You have successfully updated your userprofile',
			11=> 'You have successfully added an item to your basket',
			12 => 'You have successfully sent this message.',
			13 => 'You have successfully removed an item to your basket',
			14 => 'You have successfully logged out.',
			15 => 'You have successfully added a product',
			16 => 'You have successfully relisted your item',
			17 => 'You have successfully ended your listing',
			18 => 'Your order has been initiated. Please pay for your item(S)',
			19 => 'You have marked this item as received.',
			20 => 'You have successfully left feedback',
			21 => 'You have marked this item as dispatched'
			
        );
		
	    if (is_numeric($successid) && isset($success[$successid])):
            echo'
			<div class="row">
			    <div class="col-xs-12 col-md-4 col-md-offset-4 alert alert-success alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                     ' . $success[$successid] . '
                </div>
			</div>
				';
			unset($_SESSION['success']);
        endif;
	}
	
	
	public static function translate($str)
	{
		return $str;
	}
	
	
	public static function wysiwyg($str) {
        return strip_tags($str, "
				<br><p><a><img><h1><h2><h3><h4>
				<font><li><ul><table><tr><td><tbody>
				<thead><span><blockquote>");
    }
	
	public static function email($to, $subject, array $body = null)
	{
		$rows = ''; //fix undefined variable
		foreach ($body as $row => $key):
		$rows .= '<tr style="margin: 0;padding: 0;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;box-sizing: border-box;font-size: 14px;">
                <td class="content-block" style="margin: 0;padding: 0 0 20px;font-family: &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;box-sizing: border-box;font-size: 14px;vertical-align: top;">     
		            '.$key.'
			     </td>
		    <tr/>				
		';
		endforeach;
		
	    Mail::sendMailWithPHPMailer($to, SITE_EMAIL, SITE_NAME, SITE_NAME.' '.$subject, $rows);
	}
	
	
	public static function countries()
	{
		return  array("United Kingdom", "United States", "Afghanistan", "Albania", "Algeria", "American Samoa", 
				    "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", 
				    "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", 
					"Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", 
					"Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", 
					"Bouvet Island", "Brazil", "British Indian Ocean Territory", 
					"Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", 
					"Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", 
					"Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", 
					"Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", 
					"Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", 
					"Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic",
					"East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", 
					"Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", 
					"Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", 
					"French Guiana", "French Polynesia", "French Southern Territories", 
					"Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", 
					"Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", 
					"Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", 
					"Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", 
					"India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", 
					"Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", 
					"Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", 
					"Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", 
					"Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", 
					"Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", 
					"Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", 
					"Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", 
					"Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", 
					"Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", 
					"New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island",
					"Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", 
					"Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", 
					"Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", 
					"Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", 
					"Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", 
					"San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", 
					"Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", 
					"Slovenia", "Solomon Islands", "Somalia", "South Africa", 
					"South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", 
					"St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", 
					"Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", 
					"Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", 
					"Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", 
					"Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", 
					"Tuvalu", "Uganda", "Ukraine", "United Arab Emirates",
					"United States Minor Outlying Islands", "Uruguay", "Uzbekistan", 
					"Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", 
					"Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", 
					"Yemen", "Yugoslavia", "Zambia", "Zimbabwe");
	}
}