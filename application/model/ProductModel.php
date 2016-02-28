<?php

class ProductModel {

    /**
     * ProductModel::userproducts()
     * 
     * @param mixed $user
     * @return
     */
    public static function userproducts($user) 
	{
		
		//iniate the database
        $database = DatabaseFactory::getFactory()->getConnection();
		
		//sql to run
		$sql = "SELECT * FROM products 
				WHERE product_username = ?";
				
		//run the sql
        $usersproducts = $database->prepare($sql);
        $usersproducts->execute(array($user->username));
        
		//return the results
		return $usersproducts->fetchAll();
    }

    /**
     * ProductModel::basket()
     * 
     * @param mixed $username
     * @return
     */
    public static function basket($username) 
	{
		
		//iniate the database
        $database = DatabaseFactory::getFactory()->getConnection();
		
		//sql to run
		$sql = "SELECT * FROM basket, products 
				WHERE basket.basket_username = ? 
				AND products.product_id = basket.basket_item 
				AND products.product_enddate > NOW() 
				AND products.product_quantity > 0";
				
		//run the sql
        $basket = $database->prepare($sql);
        $basket->execute(array($username->user_username));
        
		//return the results
		return $basket->fetchAll();
    }

    /**
     * ProductModel::watching()
     * 
     * @param mixed $username
     * @return
     */
    public static function watching($username) 
	{
		
		//iniate the database
        $database = DatabaseFactory::getFactory()->getConnection();
		
		//sql to run
		$sql = "SELECT * FROM watching 
				WHERE watching_username = ?";
				
		//run the sql
        $watching = $database->prepare($sql);
        $watching->execute(array($username->user_username));
        
		//return the results
		return $watching->fetchAll();
    }
	
	public static function won($username)
	{
		
		//iniate the database
        $database = DatabaseFactory::getFactory()->getConnection();
		
		//sql to run
		$sql = "SELECT * FROM products p 
				INNER JOIN bids b 
					ON b.bids_item = p.product_id 
				LEFT JOIN orders o 
					ON p.product_id = o.orders_product 
				WHERE o.orders_product IS NULL 
				AND b.bids_username = ? 
				AND Now() > enddate 
				AND enabled = 1 
				GROUP BY b.bids_item ";
				
		//run the sql
		$won = $database->prepare($sql); 
		$won->execute(array($username->username));
		
		//return the results
		return $won->fetchAll();
	}

    /**
     * ProductModel::products()
     * 
     * @param mixed $user
     * @param mixed $select
     * @param mixed $watching
     * @return
     */
    public static function products($user = null, $select = null, $watching = null) 
	{
		
		//iniate the database
        $database = DatabaseFactory::getFactory()->getConnection();
        
		//
		if (!empty($user) && isset($select) && !isset($watching)):
            $getproduct = $database->prepare("SELECT * FROM products WHERE product_username = ? " .$select . " ");
            $getproduct->execute(array($user));
        elseif (empty($user) && isset($select) && isset($watching)):
            $getproduct = $database->prepare("SELECT * FROM products WHERE product_enabled = 1 " . $select ." ");
            $getproduct->execute();
        else:
            $getproduct = $database->prepare("SELECT * FROM products");
            $getproduct->execute();
        endif;

		//return the results       
		return $getproduct->fetchAll();
    }

    /**
     * ProductModel::product()
     * 
     * @param mixed $productid
     * @return
     */
    public static function product($productid) 
	{
		
		//iniate the database
        $database = DatabaseFactory::getFactory()->getConnection();
		
		//sql to run
		$sql = "SELECT * FROM products 
				WHERE product_id = ?";
				
		//run the sql
        $getproduct = $database->prepare($sql);
        $getproduct->execute(array($productid));
        
		//return the results
		return $getproduct->fetch();
    }

    /**
     * ProductModel::sell()
     * 
     * @param mixed $user
     * @param mixed $type
     * @return
     */
    public static function sell($user, $type) 
	{
		
		//iniate the database
        $database = DatabaseFactory::getFactory()->getConnection();
        
		//get user's items that they're selling
		if ($type == 'selling'):
		
			//sql to run 
			$sql = "SELECT * FROM products 
					WHERE products.product_username = ? 
					AND NOW() < products.product_enddate 
					AND product_quantity > 0 
					AND product_enabled = 1 
					GROUP BY product_id";
			
			//run the sql
            $getproduct = $database->prepare($sql);
        
		//get the user's sold items
		elseif ($type == 'sold'):
            
			//sql to run
			$sql2 = "SELECT * FROM products 
					INNER JOIN orders 
						ON orders.orders_product = products.product_id  
					WHERE products.product_username = ? 
					AND product_enabled = 1 
					GROUP BY products.product_id";
					
			//run the sql
			$getproduct = $database->prepare($sql2);
		
		//get the user's unsold items
		elseif ($type == 'unsold'):
		
			//sql to run
			$sql3 = "SELECT * FROM products 
					 WHERE product_username = ? 
					 AND product_enabled = 1 
					 AND product_enddate < NOW() 
					 AND product_quantity > 0";
					 
			//run the sql
            $getproduct = $database->prepare($sql3);
		else:
		
			//sql to run
			$sql4 = "SELECT * FROM products 
					 WHERE product_username = ? 
					 AND NOW() < product_enddate 
					 GROUP BY product_id";
					 
			//run the sql
            $getproduct = $database->prepare($sql4);
        endif;

        $getproduct->execute(array($user->user_username));
        
		//return the results
		return $getproduct->fetchAll();
    }

    /**
     * ProductModel::unsold()
     * 
     * @param mixed $user
     * @return
     */
    public static function unsold($user) 
	{
		
		//iniate the database
        $database = DatabaseFactory::getFactory()->getConnection();
		
		//sql to run
		$sql = "SELECT * FROM products 
				WHERE product_username = ? 
				AND product_bids <= 0 
				AND NOW() > product_enddate";
 
		//run the sql
		$getproduct = $database->prepare($sql);
        $getproduct->execute(array($user->username));
        
		//return the results
		return $getproduct->fetchAll();
    }

    /**
     * ProductModel::addproduct()
     * 
     * @param mixed $title
     * @param mixed $description
     * @param mixed $price
     * @param mixed $startingprice
     * @param mixed $auction
     * @param mixed $condition
     * @param mixed $shortdescription
     * @param mixed $auctionlength
     * @param mixed $offer
     * @param mixed $country
     * @param mixed $shipping
     * @param mixed $quantity
     * @param mixed $startprice
     * @param mixed $user
     * @param mixed $shippingcost
     * @param mixed $returns
     * @param mixed $shippingtime
     * @return
     */
    public static function addproduct($title, $description, $price, $startingprice, $auction, $condition, $shortdescription, $auctionlength, 
									  $offer, $country, $shipping, $quantity, $startprice, $user, $shippingcost, $returns, $shippingtime) {

		
		//make sure price is numeric
        if (!is_numeric($price)):
            /* Session::set('error',4); return false; */
            return 1;
            exit();
        endif;

        //are they allowing best offers?
        $offers = ($offer == 1) ? 1 : 0;

        //do they accept returns?
        $returns = ($returns == 1) ? 1 : 0;
		
        $shippingtimes = ($shippingtime < 6) ? $shippingtime : 1;

        //quantity
        $quantity = isset($quantity) ? $quantity : 1;

        //stop hackers editing the source to change select value, if they do
        //it'll select the default option (auction)
        switch ($auction):
            case 'auction':
                $type = 0;
                break;
            case 'buyitnow':
                $type = 1;
                break;
            default:
                $type = 0;
        endswitch;

        //condition
        switch ($condition):
            case 'new':
                $condition = 'new';
                break;
            case 'used':
                $condition = 'used';
                break;
            case 'likenew':
                $condition = 'likenew';
                break;
            case 'spares':
                $condition = 'spares';
                break;
            default:
                $condition = 'used';
        endswitch;


        //when will the product end?
        switch ($auctionlength):
            case '3':
                $enddate = date("Y-m-d H:i:s", + strtotime("+3 days"));
                break;
            case '7':
                $enddate = date("Y-m-d H:i:s", + strtotime("+7 days"));
                break;
            case '14':
                $enddate = date("Y-m-d H:i:s", + strtotime("+14 days"));
                break;
            case '30':
                $enddate = date("Y-m-d H:i:s", + strtotime("+30 days"));
                break;
            case '365':
                $enddate = date("Y-m-d H:i:s", + strtotime("+365 days"));
                break;
            default:
                $enddate = date("Y-m-d H:i:s", + strtotime("+7 days"));
        endswitch;

        //get the country, check site countries from array
        $location = in_array($country, System::countries()) ? $country : 'Unknown';

        /*
         * Here we need to create the images, upload them in separate folders for 
         * each user: images/user/image.png
         */

        $maindescription = isset($description) ? $description : '';

        //iniate the database
        $database = DatabaseFactory::getFactory()->getConnection();
        
		//sql to run
		$sql = "INSERT INTO products
				(
					product_title, 
					product_description, 
					product_price,
					product_buyitnow, 
					product_itemcondition, 
					product_shortdescription, 
					product_enddate, 
					product_location, 
					product_shipping, 
					product_quantity, 
					product_date, 
					product_username, 
					product_shippingcost, 
					product_returns, 
					product_shippingtime
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
					?,
					?
				)";
				
		//run the sql
		$addproduct = $database->prepare($sql);
        $result = $addproduct->execute(array(
											$title,
											$maindescription,
											$price,
											$type,
											$condition,
											$shortdescription,
											$enddate,
											$location,
											$shipping,
											$quantity,
											date("Y-m-d: H:i:s"),
											$user->user_username,
											$shippingcost,
											$returns,
											$shippingtimes));

											
		//what was the results?
        if ($result):
		    Session::set('success', 15);
            return true;
        else:
            Session::set('error', 26);
            return false;
        endif;
    }

    /**
     * ProductModel::deleteproduct()
     * 
     * @param mixed $username
     * @param mixed $id
     * @return
     */
    public static function deleteproduct($username, $id) 
	{
		
		//iniate the database
        $database = DatabaseFactory::getFactory()->getConnection();
		
		//sql to run
		$sql = "DELETE FROM products 
				WHERE id = ? 
				AND username = ?";
		//run the sql
        $deleteproduct = $database->prepare($sql); //if the product is against TOS
        $deleteproduct->execute(array($id, $username));
    }

    /**
     * ProductModel::addtowatchlist()
     * 
     * @param mixed $username
     * @param mixed $productid
     * @return
     */
    public static function addtowatchlist($username, $productid) 
	{
		
		//iniate the database
        $database = DatabaseFactory::getFactory()->getConnection();
        
		//sql to run
		$sql = "SELECT * FROM watching 
				WHERE watching_username = ? 
				AND watching_product = ?";
		
		//make sure they're not already watching this item
        $checkwatchlist = $database->prepare($sql);
        $checkwatchlist->execute(array($username->user_username, $productid));
        
		//get the results
		$result = $checkwatchlist->fetch();

        //they're not watching so add it to watch list
        if (!$result):
		
			//sql to run
			$sql2 = "INSERT INTO watching
					(
						watching_username,
						watching_product
					) 
					VALUES
					(
						?,
						?
					)";
					
			//run the sql
            $addwatching = $database->prepare($sql2);
            $addwatching->execute(array($username->user_username, $productid));

            //set success
            Session::set('success', 2);
            return true;
        endif;

        return 2; //error
    }

    /**
     * ProductModel::removefromwatchlist()
     * 
     * @param mixed $username
     * @param mixed $productid
     * @return
     */
    public static function removefromwatchlist($username, $productid) 
	{
		
		//iniate the database
        $database = DatabaseFactory::getFactory()->getConnection();
        
		//sql to run
		$sql = "DELETE FROM watching 
				WHERE username = ? 
				AND product = ?";
				
		//remove from watch list
        $watchlist = $database->prepare($sql);
        $result = $watchlist->execute(array($username->username, $productid));
        
		//the results?
		if ($result >= 1):
            return 1;
        endif;
    }

    /**
     * ProductModel::addtowishlist()
     * 
     * @param mixed $username
     * @param mixed $productid
     * @return
     */
    public static function addtowishlist($username, $productid) 
	{
		
		//iniate the database
        $database = DatabaseFactory::getFactory()->getConnection();
        
		//sql to run
		$sql = "SELECT * FROM wishlist 
				WHERE wishlist_username = ? 
				AND wishlist_product = ?";
				
		//make sure they're not already watching this item
        $checkwishlist = $database->prepare($sql);
        $checkwishlist->execute(array($username->username, $productid));
        
		//fetch the info
		$result = $checkwishlist->fetch();

        //they're not watching so add it to watch list
        if (!$result):
		
			//sql to run
			$sql2 = "INSERT INTO wishlist
					(
						wishlist_username,
						wishlist_product
					) 
					VALUES
					(
						?,
						?
					)";
					
			//run the sql
            $addwishlist = $database->prepare($sql2);
            $addwishlist->execute(array($username->username, $productid));
            return 1;
        endif;

        return 2; //error
    }

    /**
     * ProductModel::removefromwishlist()
     * 
     * @param mixed $username
     * @param mixed $productid
     * @return
     */
    public static function removefromwishlist($username, $productid) 
	{
		
		//iniate the database
        $database = DatabaseFactory::getFactory()->getConnection();
        
		//remove from watch list
        $wishlist = $database->prepare("DELETE FROM wishlist WHERE wishlist_username=? AND wishlist_product=?");
        $result = $wishlist->execute(array($username->username, $productid));
        if ($result):
            return 1;
        endif;
    }

    /**
     * ProductModel::wishlist()
     * 
     * @param mixed $username
     * @return
     */
    public static function wishlist($username) 
	{
		
		//iniate database
        $database = DatabaseFactory::getFactory()->getConnection();
		
		//sql to run
		
		//run sql
        $wishlist = $database->prepare("SELECT * FROM wishlist WHERE wishlist_username=?");
        $wishlist->execute(array($username->user_username));
        return $wishlist->fetchAll();
    }

    /**
     * ProductModel::bidprice()
     * 
     * @param mixed $productid
     * @return
     */
    public static function bidprice($productid) 
	{
		
		//iniate the database
        $database = DatabaseFactory::getFactory()->getConnection();
		
		//sql to run
		$sql = "SELECT * FROM bids 
				WHERE bid_product = ? 
				ORDER BY bid_amount DESC";
				
		//run sql
        $getbid = $database->prepare($sql);
        $getbid->execute(array($productid));
        
		//return the results
		return $getbid->fetch();
    }

    /**
     * ProductModel::addbid()
     * 
     * @param mixed $productid
     * @param mixed $username
     * @param mixed $bidamount
     * @param mixed $productresult
     * @return
     */
    public static function addbid($productid, $username, $bidamount, $productresult) 
	{
        
		//iniate the database
		$database = DatabaseFactory::getFactory()->getConnection();
        
		//sql to run
		$sql = "INSERT INTO bids
				(
					bid_product,
					bid_username,
					bid_amount,
					bid_date,
					bid_timestamp
				) 
				VALUES
				(
					?,
					?,
					?,
					?,
					?
				)";
		
		//awesome, passed basic checks, if I think of more I'll add... add the bid
        $insertbid = $database->prepare($sql);
        $insertbid->execute(array(
								$productid,
								$username->user_username,
								$bidamount,
								date("Y-m-d H:i:s"),
								strtotime("now")));

        //update the bid count -- might remove and use count on bids
        $updatebidamount = $database->prepare("UPDATE products SET bids = ? WHERE product_id = ?");
        $updatebidamount->execute(array($productresult->product_bids + 1, $productresult->id));
        return 1;
    }

    /**
     * ProductModel::search()
     * 
     * @param mixed $productsearch
     * @param mixed $local
     * @param mixed $country
     * @param mixed $auction
     * @param mixed $itemcondition
     * @return
     */
    public static function search($productsearch, $local, $country, $auction, $itemcondition, $category) 
	{
        
		//get international shipping or local
        switch ($local):
            case 'international':
                $international = "AND product_international = 1";
                break;
            case 'local':
                $international = "AND product_international = 0";
                break;
            default:
                $international = "";
        endswitch;


        //get buy it now or auction
        switch ($auction):
            case 'buyitnow':
                $auction = "AND product_buyitnow = 1";
                break;
            case 'auction':
                $auction = "AND product_buyitnow = 0";
                break;
            default:
                $auction = "";
                break;
        endswitch;


        //get the condtion of the item
        switch ($itemcondition):
            case 'new':
                $condition = "AND product_itemcondition = 'new'";
                break;
            case 'likenew':
                $condition = "AND product_itemcondition = 'likenew'";
                break;
            case 'used':
                $condition = "AND product_itemcondition = 'used'";
                break;
            case 'spares':
                $condition = "AND product_itemcondition = 'spares'";
                break;
            default:
                $condition = "";
        endswitch;

        //get location and category
        $location = !empty($country) ? " AND product_location = '" . System::escape($country) .
                "'" : '';
        $category = !empty($category) ? " AND product_category = '" . System::escape($category) . 
		 "'" : '';


        $database = DatabaseFactory::getFactory()->getConnection();
        $getproduct = $database->prepare("SELECT * FROM products WHERE product_title LIKE ? " .
                $international . " " . $auction . " AND NOW() < product_enddate " . $location . " " . $condition .
                " " . $category . " AND product_quantity > 0 AND product_enabled=1");
        $getproduct->execute(array("%" . $productsearch . "%"));
        
		//get the results
		return $getproduct->fetchAll();
    }

    /**
     * ProductModel::purchased()
     * 
     * @param mixed $username
     * @return
     */
    public static function purchased($username) 
	{
		
		//iniate the database
        $database = DatabaseFactory::getFactory()->getConnection();
		
		//sql to run
		$sql = "SELECT * FROM products 
				INNER JOIN orders 
					ON products.product_id = orders.orders_product 
				WHERE orders.orders_username = ? 
				ORDER BY orders.orders_date DESC";
				
		//run the sql
        $purchased = $database->prepare($sql);
        $purchased->execute(array($username->user_username));
        return $purchased->fetchAll();
    }

    /**
     * ProductModel::relatedproducts()
     * 
     * @param mixed $productid
     * @return
     */
    public static function relatedproducts($productid) 
	{
		
		//iniate the database
        $database = DatabaseFactory::getFactory()->getConnection();
        
		//sql to run
		$sql = "SELECT * FROM products 
				WHERE product_title LIKE ? 
				AND product_enddate > NOW() 
				AND product_quantity > 0 
				AND product_enabled = 1 
				GROUP BY product_id LIMIT 8";
				
		//run the sql
		$related = $database->prepare($sql);
        $related->execute(array("%" . $productid . "%"));
        
		//return the results?
		return $related->fetchAll();
    }

    /**
     * ProductModel::addtobasket()
     * 
     * @param mixed $username
     * @param mixed $item
     * @return
     */
    public static function addtobasket($username, $item) 
	{
        
		//make sure item is set
		if (isset($item)):
			
			//iniate database
            $database = DatabaseFactory::getFactory()->getConnection();
            
			//sql to run
			$sql = "SELECT * FROM products 
					WHERE product_id = ? 
					AND product_quantity > 0 
					AND product_enabled = 1";
			
			//run the sql
			$checkitem = $database->prepare($sql);
            $checkitem->execute(array($item));
            $result = $checkitem->fetch();

            //check if the product exists or if it has ended
            if (!$result->id):
                return 1;
                die();
            endif;
            if (date("Y-m-d H:i:s") > $result->enddate):
                return 1;
                die();
            endif;
            if ($result->buyitnow != 1):
                return 1;
                die();
            endif;

            //need to check if item is already in basket if so add quantity
            $addtobasket = $database->prepare("INSERT INTO basket(item, username, date,
		                                                	timestamp) VALUES(?,?,?,?)");
            $added = $addtobasket->execute(array(
                $item,
                $username->username,
                date("Y-m-d H:i:s"),
                strtotime("now")));

            if ($added):
                return 2; //success
            else:
                return 1; //error
            endif;

        endif;
    }

    /**
     * ProductModel::removefrombasket()
     * 
     * @param mixed $username
     * @param mixed $item
     * @return
     */
    public static function removefrombasket($username, $item) 
	{
		
		//make sure item is set
        if (isset($item)):
		
			//iniate the database
            $database = DatabaseFactory::getFactory()->getConnection();
			
			//sql to run
			$sql = "DELETE FROM basket 
					WHERE basket_id = ? 
					AND username = ?";
			
			//run the sql
            $checkitem = $database->prepare($sql);
            $result = $checkitem->execute(array($item, $username->username));
            //check result
            if ($result):
                return 1; //success
            else:
                return 2; //error
            endif;

        endif;
    }

    //get the products for the front page, 4 rows, 16 in total
    /**
     * ProductModel::frontpage()
     * 
     * @return
     */
    public static function frontpage() 
	{
		
		//iniate the database
        $database = DatabaseFactory::getFactory()->getConnection();
		
		//sql to run
		$sql = "SELECT * FROM products 
				WHERE product_enddate > Now() 
				AND product_quantity > 0 
				AND product_enabled = 1 
				GROUP BY product_id 
				ORDER BY product_id DESC LIMIT 16";
		
		//run the sql
        $product = $database->prepare($sql);
        $product->execute();
		
		//return the results
        return $product->fetchAll();
    }

    /**
     * ProductModel::categories()
     * 
     * @return
     */
    public static function categories() 
	{
		
		//iniate the database
        $database = DatabaseFactory::getFactory()->getConnection();
		
		//sql to run
		$sql = "SELECT * FROM categories 
				ORDER BY main_category ASC";
		
		//run the sql
        $categories = $database->prepare($sql);
        $categories->execute();
		
		//return the results
        return $categories->fetchAll();
    }

    /**
     * ProductModel::relist()
     * 
     * @param mixed $username
     * @param mixed $item
     * @return
     */
    public static function relist($username, $item) 
	{
		
		//iniate the database
        $database = DatabaseFactory::getFactory()->getConnection();
        
		//sql to run
		$sql = "SELECT * FROM products 
				WHERE product_username = ? 
				AND product_id = ? 
				AND product_enabled = 1 
				AND product_quantity > 0 
				AND NOW() > product_enddate";
				
		//check if the user owns product, if it's unsold and has ended
        $getitem = $database->prepare($sql);
        $getitem->execute(array($username->username, $item));
        $result = $getitem->fetch();

		//the results?
        if ($result):
		
			//sql to run
			$sql2 = "UPDATE products 
					SET enddate = ? 
					WHERE username = ? 
					AND id = ?";
					
			//run the sql
            $relist = $database->prepare($sql2);
            $relistresult = $relist->execute(array(
                date("Y-m-d H:i:s", strtotime("+30 days")),
                $username->username,
                $item));
            
			//what were the results?
			if ($relistresult):
                Session::set('success', 16);
                return true;
            else:
                Session::set('error', 27);
                return false;
            endif;
        else:
            Session::set('error', 27);
            return false;
        endif;
    }

    /**
     * ProductModel::enditem()
     * 
     * @param mixed $username
     * @param mixed $item
     * @return
     */
    public static function enditem($username, $item) 
	{
        
		//iniate the database
		$database = DatabaseFactory::getFactory()->getConnection();
        
		//sql to run
		$sql = "SELECT * FROM products 
				WHERE product_username = ? 
				AND product_id = ? 
				AND NOW() < product_enddate";
				
		//check if the user owns product, if it's not ended
        $getitem = $database->prepare($sql);
        $getitem->execute(array($username->username, $item));
        $result = $getitem->fetch();

		//what were the results?
        if ($result):
		
			//sql to run
			$sql2 = "UPDATE products 
					SET product_enddate = ? 
					WHERE product_username = ? 
					AND product_id = ?";
					
			//run the sql
            $relist = $database->prepare($sql2);
            $relistresult = $relist->execute(array(
                date("Y-m-d H:i:s", strtotime("-1 minutes")),
                $username->username,
                $item));
            
			//what were the results?
			if ($relistresult):
                Session::set('success', 17);
                return true;
            else:
                Session::set('error', 28);
                return false;
            endif;
        else:
            Session::set('error', 28);
            return false;
        endif;
    }
	
	
	public static function productbids($productid) 
	{
		
		//iniate the database
        $database = DatabaseFactory::getFactory()->getConnection();
		
		//sql to run
		$sql = "SELECT * FROM bids 
				WHERE bid_product = ? 
				ORDER BY bid_amount DESC 
				LIMIT 8";
		
		//run the sql
		$bids = $database->prepare($sql);
        $bids->execute(array($productid));
        
		//return the results
		return $bids->fetchAll();
    }

}
