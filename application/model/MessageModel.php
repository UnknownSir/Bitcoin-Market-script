<?php

/**
 * MessageModel
 * 
 * @package   
 * @author 
 * @copyright 
 * @version 2015
 * @access public
 */
class MessageModel {

    /**
     * MessageModel::messages()
     * 
     * @param mixed $username
     * @param mixed $user
     * @param mixed $order
     * @return
     */
    public static function messages($username = null, $user = null, $order = null) 
	{
		
		//iniate the db
        $database = DatabaseFactory::getFactory()->getConnection();
        
		//run the sql
		$messages = $database->prepare("SELECT * FROM messages " . $user . " " . $order . "");
        $messages->execute(array($username->user_username));
        
		//what were the results?
		return $messages->fetchAll();
    }

    /**
     * MessageModel::messageread()
     * 
     * @param mixed $messageid
     * @param mixed $username
     * @return
     */
    public static function messageread($messageid, $username) {
		
		//start database
        $database = DatabaseFactory::getFactory()->getConnection();
		
		//sql to run
		$sql = "UPDATE messages 
				SET message_read='1' 
				WHERE id=? 
				AND username=?";
				
		//run the sql
        $markasread = $database->prepare($sql);
        $markasread->execute(array($messageid, $username->username));
    }

    /**
     * MessageModel::addmessage()
     * 
     * @param mixed $title
     * @param mixed $usermessage
     * @param mixed $user
     * @param mixed $userto
     * @param mixed $type
     * @return
     */
    public static function addmessage($title, $usermessage, $user, $userto, $type) 
	{

		//iniate database
        $database = DatabaseFactory::getFactory()->getConnection();
        
		//iniate datetime
		$date = date("Y-m-d h:i:s");
        
		//sql to run
		$sql = "INSERT INTO messages
		        (
					subject,
					message,
					username,
					message_type,
					message_date,
					message_read
				) 
				VALUES
				(
					?,
					?,
					?,
					'sent',
					?,
					'1'
				)";
				
		//run the sql
		$message = $database->prepare($sql);
        $result = $message->execute(array($title, $usermessage, $user->username, $date));

		//sql to run
		$sql2 = "INSERT INTO messages
				(
					subject,
					message,
					username,
					message_type,
					message_date,
					messagefrom
				) 
				VALUES
				(
					?,
					?,
					?,
					'received',
					?,
					?
				)";
				
        //insert receiver
        $messagetwo = $database->prepare($sql2);
        $resultone = $messagetwo->execute(array($title, $usermessage, $userto, $date, $user->username));

		//what were the results?
        if ($result && $resultone): return 1;
        endif; //success
    }

    /**
     * MessageModel::message()
     * Get messages from ID and username
     * @param mixed $username
     * @param mixed $messageid
     * @return
     */
    public static function message($username, $messageid) {

		//make sure message id is set
        if (!empty($messageid)) {
			
			//iniate db
            $database = DatabaseFactory::getFactory()->getConnection();
			
			//sql to run
			$sql = "SELECT * FROM messages 
					WHERE username = ? 
					AND id = ?";
					
			//run the sql
            $message = $database->prepare($sql);
            $message->execute(array($username->username, $messageid));
        } else {
            return 1;
        }

        return $message->fetch();
    }
	
	/**
	 * deletemessage()
	 * 
	 * @param mixed $username
	 * @param mixed $messageid
	 * @return
	 */
	public static function deletemessage($username,$messageid)
    {
		
		//iniate the database
		$database = DatabaseFactory::getFactory()->getConnection();
		
		//sql to run
		$sql = "UPDATE messages 
				SET deleted = 1 
				AND message_permdeleted = 1 
				WHERE username = ? 
				AND id = ?";
				
		//rub the sql
        $message = $database->prepare($sql);
        $res = $message->execute(array($username->username,$messageid));
		if($res):
			return true;
		endif;
    }

	/**
	 * deletemessage()
	 * 
	 * @param mixed $username
	 * @param mixed $messageid
	 * @return
	 */
	public static function trashmessage($username,$messageid)
    {
		
		//iniate the db
	    $database = DatabaseFactory::getFactory()->getConnection();
		
		//sql to run
		$sql = "UPDATE messages 
				SET deleted = 1 
				WHERE username = ? 
				AND id = ?";
				
		//run the sql
        $message = $database->prepare($sql);
        $res = $message->execute(array($username->username,$messageid));
		
		if($res):
			return true;
		endif;		
    }
}
