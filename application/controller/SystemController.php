<?php

class SystemController extends Controller
{
	
	public function receivedpayment()
	{
		//initiate bitcoin client
		$btc = System::bitcoinconnect();
		$database = DatabaseFactory::getFactory()->getConnection();
        
		//check deposits
        print_r($btc->listtransactions('', 2000));
        
		//list the last 2,000 transaction, should be enough
		$transaction = $btc->listtransactions('', 2000);
		
		//check if the payment has already been stored in the database
        $checkdeposits = $database->prepare("SELECT * FROM orders WHERE orders_btcaddress=? AND orders_status='1'");
      
		//start from the 0 transaction
	    $i = 0;
		
		//count how many transactions, it's set above, but incase we change that
        $total = count($transaction);
        
		//loop through the transactions
		while ($i < $total) {

			//check the table incase we've already stored it.
            $checkdeposits->execute(array($transaction['transactions'][$i]['address']));
            $checkdeps = $checkdeposits->fetch();
            
			//make sure it has 2 min confirmations, and remove the minus from confirms
			if (str_replace("-", "", $transaction['transactions'][$i]['confirmations']) >= 2
				&& $checkdeps->orders_amount < $transaction['transactions'][$i]['amount']) {
                
				//if there's no row matching the data proceed
				if (!$checkdeps) {
				
					//the date of inserting the order
                    $date = date("y-m-d h:i:s");
					
                    //mark the item as paid
                    $update_order = $database->prepare("UPDATE orders SET orders_status=1 WHERE orders_btcaddress=?");
                    $update_order->execute(array($transaction['transactions'][$i]['address']));
                    
					/*
					 * get the order details 
					*/
					$get_order = $database->prepare("SELECT * FROM orders WHERE orders_btcaddress=?");
					$get_order->execute(array($transaction['transactions'][$i]['address']));
					$order_result = $get_order->fetch();

					/*
					 * add the transaction 
					*/
                    $adddeposit = $database->prepare("INSERT INTO 
				       transactions(address,username,confirmations,txid,amount,time,
					   date,transaction,item, transaction_orders) 
				       VALUES(?,?,?,?,?,?,?,'deposit',?, ?)");
                    
					//insert the values
					$adddeposit->execute(array(
					    $transaction['transactions'][$i]['address'],
                        $order_result->orders_username,
                        str_replace("-", "", $transaction['transactions'][$i]['confirmations']),
                        $transaction['transactions'][$i]['txid'],
                        number_format($transaction['transactions'][$i]['amount'], 8),
                        $transaction['transactions'][$i]['time'],
                        date("Y-m-d H:i:s"),
						$order_result->orders_product,
						$order_result->orders_id));
                }
            }
            $i++;
        }
	}
	
	public function send_payment()
	{
		//initiate bitcoin client
		$btc = System::bitcoinconnect();
		$database = DatabaseFactory::getFactory()->getConnection();

		$get_order = $database->prepare("SELECT * FROM orders WHERE orders_status=1 AND orders_delivered=1 AND orders_payment_sent=0");
		$get_order->execute();
		
		$order_result = $get_order->fetchAll();
		
		foreach($order_result as $orders):
		
			//get product info
			$product_details = $database->prepare("SELECT * FROM products WHERE id=?");
			$product_details->execute(array($orders->orders_product));
			
			$product_result = $product_details->fetch();
			
			//update a nigger's balance, yo.
			$update_balance = $database->prepare("UPDATE users SET btc=btc + ? WHERE username=?");
			$minusfee = (5 / 100) * $orders->orders_amount;
			$newbalance = $orders->orders_amount - $minusfee;
			echo $newbalance;
			$update_balance->execute(array($newbalance, $product_result->username));
			//mark as payment sent
			$mark_sent = $database->prepare("UPDATE orders SET orders_payment_sent=1 WHERE orders_id=?");
			$mark_sent->execute(array($orders->orders_id));

		endforeach;
	}
	
	
}
