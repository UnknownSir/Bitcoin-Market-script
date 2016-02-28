<?php

/*
 * this is the product controller to control all localhost/products/ pages
 */

class ProductsController extends Controller {

    public function product($productid = '') 
	{
		
        //get the bids and product info
        $product = ProductModel::product($productid);

        //check if product exists, if not set error 'n' redirect
        if (!isset($product->product_id)): Session::set('error', 16);
            Redirect::to('/dashboard');
            exit();
        endif;

        //track the user
        System::click_tracking($productid);

        //get the username of whom owns the product
        $productuser = UsersModel::user($product->product_username);

        //total user feedback number
        $feedbacktotal = $productuser->user_positive + $productuser->user_neutral + $productuser->user_negative;

        //feedback percentage
        $total = $productuser->user_positive + $productuser->user_negative;

        //fix division by zero. Only Chuck norris shall do that.
        if ($productuser->user_positive != 0 && $productuser->user_negative != 0):
            $feedbackpercentage = ($productuser->user_positive - $productuser->user_negative) / $total * 100;
        else:
            $feedbackpercentage = 0;
        endif;

		
		//item bids
		$bids = ProductModel::productbids($productid);
		
		
        //related products for the bottom
        $related = ProductModel::relatedproducts($product->product_title);

        $this->View->render('products/product', array(
            'product' => $product,
            'productuser' => $productuser,
            'feedbacktotal' => $feedbacktotal,
            'feedbackpercentage' => $feedbackpercentage,
            'related' => $related,
			'bids' => $bids
        ));
    }

    public function watchlist($item = '', $type = '') {

        if (!UsersModel::Loggedin() == true): Redirect::to('user/login?refer=' . Request::get('url'));
            exit();
        endif;

        //get the user and the product id
        $username = UsersModel::user();
        $productid = $item;

        //check if product is set
        if (!isset($productid)): Session::set('error', 10);
            Redirect::to('dashboard');
            exit();
        endif;

        //check if they're adding to watch list
        if ($type == 'add'):

            //add it to the watchlist
            $addtowatchlist = ProductModel::addtowatchlist($username, $item);

            //get the results
            if ($addtowatchlist == 1):
                Session::set('success', 2);
                Redirect::to('dashboard');
                exit();
            else:
                Session::set('error', 11);
                Redirect::to('dashboard');
                exit();
            endif;

        //check if they're deleting from the watchlist
        elseif ($type == 'delete'):
            $removefromwatchlist = ProductModel::removefromwatchlist($username, $item);

            //check result
            if ($removefromwatchlist == 1):
                Session::set('success', 4);
                Redirect::to('dashboard');
                exit();
            endif;
        endif;

        Session::set('error', 0);
        Redirect::to('dashboard');
        exit();
    }

    public function wishlist($item = '', $type = '') {
        if (!UsersModel::Loggedin() == true): Redirect::to('user/login?refer=' . Request::get('url'));
            exit();
        endif;

        $username = UsersModel::user();
        $productid = $item;

        //check if product is set
        if (!isset($productid)): Session::set('error', 10);
            Redirect::to('dashboard');
            exit();
        endif;

        if (UsersModel::addressset($username) != 1): Session::set('error', 21);
            Redirect::to('user/editprofile');
            exit();
        endif;

        //check if they're adding to watch list
        if ($type == 'add'):

            //add it to the watchlist
            $addtowishlist = ProductModel::addtowishlist($username, $productid);

            //get the results
            if ($addtowishlist == 1):
                Session::set('success', 8);
                Redirect::to('dashboard/wishlist');
                exit();
            else:
                Session::set('error', 20);
                Redirect::to('dashboard/wishlist');
                exit();
            endif;

        //check if they're deleting from the watchlist
        elseif ($type == 'remove'):
            $removefromwishlist = ProductModel::removefromwishlist($username, $productid);

            //get the result
            if ($removefromwishlist == 1):
                Session::set('success', 9);
                Redirect::to('dashboard/wishlist');
                exit();
            endif;
        endif;

        Session::set('error', 0);
        Redirect::to('dashboard/wishlist');
        exit();
    }

    public function addbid() {
        if (!UsersModel::Loggedin() == true): echo System::translate('You must be logged in to bid');
            exit();
        endif;

        //product info
        $productid = Request::get('item');
        $bidamount = Request::post('price');
        $username = UsersModel::user();


        //check bids, to see if it's above top bidder, if not show error
        $result = ProductModel::bidprice(Request::get('item'));

        //get the product information
        $productresult = ProductModel::product(Request::get('item'));

        //check bidamount
        if (!$result)
            goto addbid; //I know I should restructure, but IDGAF

            
        //check if bid is above top bid
        if ($bidamount <= $result->bids_amount): echo System::translate("Your bid is lower than the top bid.");
            die();
        endif;

        //see if the user is the top bidder.
        if ($result->bids_username == $username->username): echo System::translate("You are already the highest bidder.");
            die();
        endif;

        //check if the item is a BIN (buy it now)
        if ($productresult->buyitnow == 1) : echo System::translate("This item is a buy it now not an auction listing");
            die();
        endif;

        //check if it's ended
        if (date("Y-m-d H:i:s") >= $productresult->enddate): echo System::translate("This item has already ended");
            die();
        endif;

        //goto, bad programming but w/e
        addbid:

		
        /*make sure they're not bidding on their own item {shillbidding}
        if ($productresult->product_username == $username->user_username): echo System::translate("You cannot bid on your own item");
            die();
        endif;
*/
        //passed the checks add the bid.
        $addbid = ProductModel::addbid($productid, $username, $bidamount, $productresult);

        //tell 'em their bid was placed
        if ($addbid == 1):
            echo System::translate("You have bid on this item");
        else:
            echo System::translate("Your bid couldn't be added");
        endif;
    }

    public function search() {

        //contains wildcard, above I'll do category search etc
        $buyitnow = Request::get('buyitnow');
        $auction = Request::get('auction');

        //search
        $productsearch = Request::get('search');
        $products = ProductModel::search($productsearch, Request::get('international'), 
			Request::get('country'), Request::get('auction'), Request::get('condition'),
			Request::get('categories'));


        $this->View->render('products/search', array(
            'productsearch' => $productsearch,
            'products' => $products));
    }

}

?>