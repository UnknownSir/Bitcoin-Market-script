<?php

class OrdersModel
{

	public function __construct()
	{
		$btc = System::bitcoinconnect();
		
	}
	
	
	public static function wishlistcreate($item, $user, $username)
	{
		
		//iniate the database
		$database = DatabaseFactory::getFactory()->getConnection();
		
		//sql to run
		$sql = "SELECT * FROM products 
				INNER JOIN wishlist 
					ON wishlist.wishlist_product = products.id 
				WHERE wishlist_username = ? 
				AND products.enddate > NOW() 
				AND products.quantity > 0 
				AND products.enabled = 1";
				
		//get the wishlist product, where username and still for sale 
		$wishlist = $database->prepare($sql);
		$wishlist->execute(array($user));
		$product = $wishlist->fetch();
		
		//the results?
		if($product):
		
			//sql to run
			$sql2 = "SELECT * FROM users 
					 WHERE username = ?";
					 
			//run the sql
			$get_user_information = $database->prepare($sql2);
			$get_user_information->execute(array($user));
			$user_result = $get_user_information->fetch();
			
			//sql to run
			$sql3 = "INSERT INTO orders
					(
						orders_username,
						orders_amount,
						orders_product,
						orders_firstname, 
						orders_lastname, 
						orders_address1, 
						orders_address2, 
						orders_zipcode, 
						orders_city, 
						orders_country, 
						orders_btcaddress, 
						orders_status,
						orders_wishlist, 
						orders_wishlist_user
					) 
					VALUES
					(
						?,
						?,
						?,
						?,
						?,
						?,
						?,
						?,
						?,
						?,
						?,
						?,
						?,
						?
					)";
			
			//run the sql
		    $createorder = $database->prepare($sql3);
			$createorder->execute(array($username->username, 
										$product->price + $product->shippingcost, 
										$product->wishlist_product, 
										$user_result->firstname, 
										$user_result->lastname, 
										$user_result->address1, 
										$user_result->address2, 
										$user_result->zipcode, 
										$user_result->city, 
										$user_result->country, 
										$btc->getnewaddress(), 
										0, 
										1, 
										$user));
			
		else:
		//echo 'nahhh'; //dbg
			//error, item has ended or item not in users watch list.
		endif;
	}
	
	public static function vieworder($order, $username)
	{
		
		//iniate db
		$database = DatabaseFactory::getFactory()->getConnection();
		
		//sql to run
		$sql = "SELECT * FROM products 
				RIGHT JOIN orders 
					ON orders.orders_product = products.id 
					WHERE orders.orders_username = ? 
					AND orders.orders_id = ?";
					
		//run sql
		$view_order = $database->prepare($sql);
		$view_order->execute(array($username->username, $order));
		
		//get the order details if there is any
		$result = $view_order->fetch();
		
		if($result):
			return $result;
			return true; //success
		else:
			return false; //error
		endif;
	}
    /**
     * UsersModel::feedback()
     * 
     * @param mixed $item
     * @param mixed $user
     * @return
     */
    public static function feedback($item, $user) 
	{
     
		//iniate the db
		$database = DatabaseFactory::getFactory()->getConnection();
		
		//sql to run
		$sql = "SELECT * FROM products 
				RIGHT JOIN orders 
					ON orders.orders_product = products.id 
					WHERE orders.orders_username = ? 
					OR products.username = ? 
					AND orders.orders_id = ?";
					
		//run the sql
		$product = $database->prepare($sql);
		$product->execute(array($user->username,$user->username,$item));
		
		//return the results
		return $product->fetch();		
    }

	
    public static function leavefeedback($order, $feedback, $level, $user) 
	{
		
		//iniate the database
		$database = DatabaseFactory::getFactory()->getConnection();
		
		//sql to run
		$sql = "SELECT * FROM products 
				RIGHT JOIN orders 
					ON orders.orders_product = products.id 
				WHERE orders.orders_id = ?";
				
		//run the sql
		$selectorder = $database->prepare($sql);
		$selectorder->execute(array($order));
		$order_info = $selectorder->fetch();
		
		//switch between feedback
		switch($level):
			case 'positive':
				$type = 'Positive';
				$userfeedback = $database->prepare("UPDATE users SET positive = positive + 1 WHERE username = ?");
			break;
			case 'neutral':
				$type = 'Neutral';
				$userfeedback = $database->prepare("UPDATE users SET neutral = neutral + 1 WHERE username = ?");
			break;
			case 'negative':
				$type = 'Negative';
				$userfeedback = $database->prepare("UPDATE users SET negative = negative +1 WHERE username = ?");
			break;
			$type = 'Neutral';
				$userfeedback = $database->prepare("UPDATE users SET positive = positive +1 WHERE username = ?");
		endswitch;
			

		//check if the sender of the feedback is the seller or buyer
		if($order_info->username == $user->username && $order_info->orders_feedback_seller != 1): 
			
			//sql to run
			$sql2 = "INSERT INTO feedback
					(
						feedback_username, 
						feedback_type, 
						feedback_description, 
						feedback_sent, 
						feedback_date, 
						feedback_order
					) 
					VALUES
					(
						?,
						?,
						?,
						?,
						NOW(),
						?
					)";
					
			/* user is seller and hasn't left feedback yet */
			$add_feedback = $database->prepare($sql2);
			//add the info
			$add_feedback->execute(array($user->username, $type, $feedback, 
										 $order_info->orders_username, $order));
			
			//sql to run
			$sql3 = "UPDATE orders 
					SET orders_feedback_seller = 1 
					WHERE orders_id = ?";
					
			//update the orders
			$feedback_order = $database->prepare($sql3);
			$feedback_order->execute(array($order));
			
			//update the number in the users row
			$userfeedback->execute(array($order_info->orders_username));
			Session::set('success',20);
			return true;
			
		elseif($order_info->username != $user->username && $order_info->orders_feedback_buyer != 1 ):

			//sql to run
			$sql4 = "INSERT INTO feedback
					(
						feedback_username, 
						feedback_type, 
						feedback_description, 
						feedback_sent, 
						feedback_date, 
						feedback_order
					)
					VALUES
					(
						?,
						?,
						?,
						?,
						NOW(),
						?
					)";
					
			/* user is the buyer and hasn't left feedback before */
			$add_feedback = $database->prepare($sql4);
			//add the info
			$add_feedback->execute(array($user->username, $type, $feedback, 
										 $order_info->username, $order));
			
			//update the orders
			$feedback_order = $database->prepare("UPDATE orders SET orders_feedback_buyer = 1 WHERE orders_id = ?");
			$feedback_order->execute(array($order));
			
			//update the number in the users row
			$userfeedback->execute(array($order_info->username));
			Session::set('success',20);
			return true;
		else:
			Session::set('error',31);
			return false;
		endif;
	}	
		
	/**
	 * OrdersModel::createbasketorder()
	 * 
	 * @param mixed $firstname
	 * @param mixed $lastname
	 * @param mixed $email
	 * @param mixed $phone
	 * @param mixed $address1
	 * @param mixed $address2
	 * @param mixed $city
	 * @param mixed $zipcode
	 * @param mixed $country
	 * @param mixed $state
	 * @param mixed $username
	 * @return
	 */
	public static function createbasketorder($firstname, $lastname, $email, $phone,
						$address1,$address2, $city, $zipcode, $country, $state, $username)
	{
		
		//iniate the database
		$database = DatabaseFactory::getFactory()->getConnection();
		
		//start bitcoin rpc
		$btc = System::bitcoinconnect();
		
		//get the items in the basket
		$getitems = $database->prepare("SELECT * FROM basket WHERE username = ?");
		$getitems->execute(array($username->username));
		
		//get all the items
		$items = $getitems->fetchAll();
		
		//loops through basket items and create orders
		foreach($items as $item):
			
			//sql to run
			$sql2 = "SELECT * FROM products 
					 WHERE id = ? 
					 AND NOW() < enddate 
					 AND quantity > 0 
					 AND enabled = 1";
					 
			//get productid
			$product = $database->prepare($sql2);
			$product->execute(array($item->item));
			$productid = $product->fetch();

			//if product exists
			if($productid):
			
				//sql to run
				$sql3 = "INSERT INTO orders
						(
							orders_username,
							orders_amount,
							orders_product,
							orders_firstname, 
							orders_lastname, 
							orders_address1, 
							orders_address2, 
							orders_zipcode, 
							orders_city, 
							orders_country, 
							orders_btcaddress, 
							orders_status
						) 
						VALUES
						(
							?,
							?,
							?,
							?,
							?,
							?,
							?,
							?,
							?,
							?,
							?,
							?
						)";
						
				//run the sql
				$createorder = $database->prepare($sql3);
				$createorder->execute(array($username->username, 
											$productid->price + $productid->shippingcost, 
											$item->item, 
											$firstname, 
											$lastname, 
											$address1, 
											$address2, 
											$zipcode, 
											$city, 
											$country, 
											$btc->getnewaddress(), 
											0));
											
				//remove 1 (will eventually allow more than 1 item grouped) from quantity
				$updatequality = $database->prepare("UPDATE products SET quantity = quantity - 1, purchases = purchases + 1 WHERE id = ?");
				$updatequality->execute(array($item->item));
				
				//delete from basket
				$delete_basket = $database->prepare("DELETE FROM basket WHERE item = ?");
				$delete_basket->execute(array($item->item)); 
			else:
				$updatequality = false;
			endif;
        endforeach;
			
			//was this successful
			if($updatequality):
				Session::set('success',18);
				return true;
			else:
				return false;
			endif;
		
	}
	
	public static function received($order, $username)
	{
		
		//iniate the database
		$database = DatabaseFactory::getFactory()->getConnection();
		
		//sql to run
		$sql = "SELECT * FROM orders 
				WHERE orders_username = ? 
				AND orders_id = ? 
				AND orders_delivered = 0 
				AND orders_status = 1";
				
		//check if the order exists and if its not been marked as delivered
		$order_status = $database->prepare($sql);
		$result = $order_status->execute(array($username->username, $order));
 
		//the results?
		if($result):
		
			//sql to run
			$sql2 = "UPDATE orders 
					SET orders_delivered = 1 
					WHERE orders_username = ? 
					AND orders_id = ?";
					
			//run the sql
			$mark_as_delivered = $database->prepare($sql2);
			$success = $mark_as_delivered->execute(array($username->username, $order));
			Session::set('success',19);
			return true;
		else:
			Session::set('error', 29);
		endif;
		
		Session::set('error', 0);
	}
	
	public static function dispatched($order, $username)
	{
		
		//iniate the database
		$database = DatabaseFactory::getFactory()->getConnection();
		
		//sql to run
		$sql = "SELECT * FROM products 
				RIGHT JOIN orders 
					ON orders.orders_product = products.id 
				WHERE orders.orders_username = ? 
				AND orders.orders_id = ?";
				
		//run the sql
		$product = $database->prepare($sq;);
		$product->execute(array($username->username,$order));
		$result = $product->fetch();
		
		//the results?
		if($result->username == $username->username && $result->orders_shipped != 1):
			$update = $database->prepare("UPDATE orders SET orders_shipped = 1 WHERE orders_id = ?");
			$update->execute(array($order));
			Session::set('success',21);
			return true;
		else:
			Session::set('error', 32);
			return false;
		endif;
	}
}