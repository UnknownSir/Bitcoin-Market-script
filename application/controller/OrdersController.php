<?php
class OrdersController extends Controller
{

	public function order($order = '')
	{	
		if (!UsersModel::Loggedin() == true): Redirect::to('user/login'); exit(); endif;
		
		//get the session user
		$username = UsersModel::user();
		
		//get the order info if user owns it.
		$view_order = OrdersModel::vieworder($order, $username);
		
		if($view_order == true):
			$this->View->Render('orders/vieworder', array('orders' => $view_order));
		else:
			Session::set('error', 30 );
			Redirect::to('dashboard/purchased');
		endif;
	}
	
	
	public function feedback($order = '') {
        
		if(empty($order)): Session::set('error',0); Redirect::to('dashboard'); exit(); endif;
		
		if (!UsersModel::Loggedin() == true): Redirect::to('user/login'); exit(); endif;

        $username = UsersModel::user();

        //get the feedback info
        $feedback = OrdersModel::feedback($order, $username);
		
		if($feedback == false):
			//Session::set('error',0); 
			//Redirect::to('dashboard'); exit();
		endif;
		
        $this->View->render('orders/leavefeedback', array('feedback' => $feedback,
														  'order' => $order));
    }
	
	public function leavefeedback()
	{
		if (!UsersModel::Loggedin() == true): Redirect::to('user/login'); exit(); endif;
		
		$username = UsersModel::user();
		if(Request::post('order') == true && Request::post('feedback') == true &&
		   Request::post('level') == true):
			
			//insert the feedback
			$leave_feedback = OrdersModel::leavefeedback(Request::post('order'), Request::post('feedback'),
														 Request::post('level'), $username);
		else:
			Redirect::to('dashboard/feedback');
		endif;
		if($leave_feedback == true):
			Redirect::to('dashboard/purchased');
		else:
			Redirect::to('dashboard/purchased');
		endif;
		
	}
	
	
	public function received($order = '')
	{
		if (!UsersModel::Loggedin() == true): Redirect::to('user/login'); exit(); endif;

		if(!isset($order)): Redirect::to('dashboard/purchased'); exit(); endif;
		
		$username = UsersModel::user();
		
		//mark as received
		$order_received = OrdersModel::received($order, $username);
		
		if($order_received == true):
			Redirect::to('dashboard/purchased');
		else:
			Redirect::to('dashboard/purchased');
		endif;
	}
	
	public function dispatched($order = '')
	{
		if (!UsersModel::Loggedin() == true): Redirect::to('user/login'); exit(); endif;

		if(!isset($order)): Redirect::to('dashboard/selling?type=sold'); exit(); endif;
		
		$username = UsersModel::user();
		
		$item_dispatched = OrdersModel::dispatched($order, $username);
		
		if($item_dispatched == true):
			Redirect::to('dashboard/selling?type=sold');
		else:
			Redirect::to('dashboard/selling?type=sold');
		endif;
		
	}
}
?>