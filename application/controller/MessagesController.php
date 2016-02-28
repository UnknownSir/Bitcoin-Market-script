<?php

class MessagesController extends Controller
{
	public function index()
	{
        if(!UsersModel::Loggedin() == true): Redirect::to('user/login'); exit(); endif;

		$username = UserModel::user();
		$type = Request::get('folder');
		
		//switch between inboxes
		switch($type):
			case 'sent':
				$messages = MessageModel::messages($username," WHERE username=? "," AND message_type='sent' ORDER BY message_date DESC");
			break;
			case 'trash':
				$messages = MessageModel::messages($username," WHERE username=? "," AND deleted='1' AND message_permdeleted='0' ORDER BY message_date DESC");
			break;
			default: $messages = MessageModel::messages($username," WHERE username=? "," AND message_type='received' AND deleted=0 AND message_permdeleted=0 ORDER BY message_date DESC");
		endswitch;
		
		//get the message count
		$inboxmessages = MessageModel::messages($username," WHERE username=? "," AND message_type='received' AND message_read='0'");

		$this->View->Render('messages/messages', array(
											'messages' => $messages,
											'inboxmessages' => $inboxmessages));
	}
	
	public function compose($to = '', $subject = '', $message = '')
	{
        if(!UsersModel::Loggedin() == true): Redirect::to('user/login'); exit(); endif;

		$username = UsersModel::user();
		
		$subjectTo = Request::post('subject');
		$messageTo = Request::post('content');
		$recipient = Request::post('to');
		
		//get the message count
		$inboxmessages = MessageModel::messages($username," WHERE username=? "," AND message_type='received' AND message_read='0'");
	
	
		if(Request::post('compose_message') == true):

		
			
		if(empty($subjectTo) || empty($messageTo) || empty($recipient)): Session::set('error',9); Redirect::to('messages/compose/'.$recipient.'/'.$subjectTo.'/'.$messageTo); exit(); endif;
		
		$addmessage = MessageModel::addmessage($subjectTo, $messageTo, $username, $recipient, '');
		if($addmessage == 1):
			Session::set('success', 12);
			System::action_tracking($username, 'Sent a message to '.$recipient);
			Redirect::to('messages/index');
		else:
			Session::set('error', 24);
			//Redirect::to('messages/compose/'.$recipient.'/'.$subjectTo.'/'.$messageTO);
		endif;
		
		endif;

		$this->View->Render('messages/compose', array(
										'inboxmessages' => $inboxmessages,
										'to'            => $to,
										'subject'       => $subject,
										'message'       => $message));

	}
	
	public function message($message = '') 
	{
       
   	    if(!UsersModel::Loggedin() == true): Redirect::to('user/login'); exit(); endif;

        $username = UsersModel::user();
        $messageid = $message;
		
        //mark message as read
        if (isset($message)) {
			MessageModel::messageread($message, $username);
			System::action_tracking($username, 'Read the message'.$message);
        }
		
		//how many unread inbox messages
		$inboxmessages = MessageModel::messages($username," WHERE username=? "," AND message_type='received' AND message_read='0'");

        $messages = MessageModel::message($username, $messageid);
		if(!isset($messages)): 
		//Redirect::to('messages/'); die(); 
		endif;
		
		$this->View->Render('messages/message', array('messages' => $messages,
											'inboxmessages' => $inboxmessages));
    }
	
	
	public function deletemessage($message = '', $type = '')
	{
	    if(!UsersModel::Loggedin() == true): Redirect::to('user/login'); exit(); endif;

		$username = UsersModel::user();
		
		//switch between perm delete or trash
		switch($type):
			case 'delete':
				$delete_message = MessageModel::deletemessage($username, $message);
				System::action_tracking($username, 'Deleted the message '.$message);
			break;
			case 'trash':
				echo 'ghghg';
				$delete_message = MessageModel::trashmessage($username, $message);	
				//track user's action
				System::action_tracking($username, 'added the message '.$message.' to the trash');
			break;
			default: $delete_message = MessageModel::trashmessage($username, $message);
		endswitch;
		
		if($delete_message == true):
			//success
			Session::set('success',33);
			Redirect::to('messages?folder=trash');
		else:
			//error
			Session::set('error',0);
			Redirect::to('messages');
		endif;
	}
}