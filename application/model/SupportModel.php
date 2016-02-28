<?php

Class SupportModel {

    /**
     * SupportModel::tickets()
     * 
     * @param mixed $user
     * @param mixed $type
     * @param mixed $admin
     * @return
     */
    public static function tickets($user, $type = null, $admin = null) 
	{
       
	    //iniate the database
        $database = DatabaseFactory::getFactory()->getConnection();
        
		//get  the different types of tickets
		if (isset($type)):
		
			//sql to run
			$sql = "SELECT * FROM support 
					WHERE support_username = ? 
					AND support_status = ? 
					ORDER BY support_lastupdate DESC";
			
			//run the sql
            $tickets = $database->prepare($sql);
            $tickets->execute(array($user, $type));
        else:
		
			//sql to run
			$sql2 = "SELECT * FROM support 
					WHERE support_username = ? 
					ORDER BY support_lastupdate DESC";
			
			//run the sql
            $tickets = $database->prepare($sql2);
            $tickets->execute(array($user));
        endif;
		
			//if the user is an admin
			if (isset($admin)):
			
				//sql to run
				$sql3 = "SELECT * FROM support 
						ORDER BY support_lastupdate DESC";
				
				//run the sql
				$tickets = $database->prepare($sql3);
				$tickets->execute();
			endif;
			
		//return the results
        return $tickets->fetchAll();
    }

    /**
     * SupportModel::ticket()
     * 
     * @param mixed $user
     * @param mixed $id
     * @return
     */
    public static function ticket($user, $id) 
	{
		
		
        //iniate the database
        $database = DatabaseFactory::getFactory()->getConnection();
        
		//get the users supports ticket
		if (!empty($user)):
		
			//sql to run
			$sql = "SELECT * FROM support 
					WHERE support_username = ? 
					AND support_id = ?";
					
			//run the sql
            $tickets = $database->prepare($sql);
            $tickets->execute(array($user, $id));
        else:
		
			//sql to run
			$sql = "SELECT * FROM support WHERE support_id = ?";
			
			//run the sql
            $tickets = $database->prepare($sql);
            $tickets->execute(array($id));
        endif;
		
		//what were the results?
        return $tickets->fetch();
    }

    /**
     * SupportModel::ticketreplies()
     * 
     * @param mixed $id
     * @return
     */
    public static function ticketreplies($id) 
	{
		
		//iniate the database
        $database = DatabaseFactory::getFactory()->getConnection();
        
		//sql to run
		$sql = "SELECT * FROM tickets 
				WHERE ticket_mainticket = ?";
		
		//run the sql
		$tickets = $database->prepare($sql);
        $tickets->execute(array($id));
		
		//return the results
        return $tickets->fetchAll();
    }

    /**
     * SupportModel::addticket()
     * 
     * @param mixed $title
     * @param mixed $category
     * @param mixed $status
     * @param mixed $message
     * @param mixed $user
     * @return
     */
    public static function addticket($title, $category, $status, $message, $user) 
	{
       
	   //switch between categories 
        switch ($category):
            case 'account':
                $category = 'Account';
                break;
            case 'general':
                $category = "General";
                break;
            case 'technical':
                $category = "Technical";
                break;
            case 'nonpayment':
                $category = "Non-Payment";
                break;
            case 'nondelivery':
                $category = "Non-Delivery";
                break;
            default:
                $category = 'Other';
        endswitch;

		//iniate the database
        $database = DatabaseFactory::getFactory()->getConnection();
		
		//sql to run
		$sql = "INSERT INTO support
				(
					support_title,
					support_category,
					support_priority,
					support_message,
					support_username,
					support_lastupdate
				) 
				VALUE
				(
					?,
					?,
					?,
					?,
					?,
					?
				)";
				
		//create date
        $date = date("y-m-d h:i:s");
		
		//run the sql
        $addticket = $database->prepare($sql);
        $addticket->execute(array(
            $title,
            $category,
            $status,
            $message,
            $user,
            $date));
        
		//what were the results?
		if ($addticket):
            return true;
        endif;
    }

    /**
     * SupportModel::addticketreply()
     * 
     * @param mixed $message
     * @param mixed $user
     * @param mixed $ticket
     * @return
     */
    public static function addticketreply($message, $user, $ticket) 
	{
		
		//iniate the database
        $database = DatabaseFactory::getFactory()->getConnection();
        
		//sql to run
		$sql = "INSERT INTO tickets
				(
					ticket_message,
					ticket_username,
					ticket_mainticket
				) 
				VALUE
				(
					?,
					?,
					?
				)";
		
		//run the sql
        $addticket = $database->prepare($sql);
        $addticket->execute(array(
            $message,
            $user,
            $ticket));
			
			
		//sql to run
		$sql = "UPDATE support 
				SET support_lastupdate = ? 
				WHERE support_id = ?";
		
        //run the sql2
        $lastupdate = $database->prepare($sql2);
        $lastupdate->execute(array($date, $ticket));
        
		//what happened?
		if ($addticket):
            return true;
        endif;
    }

    /**
     * SupportModel::closeticket()
     * 
     * @param mixed $type
     * @param mixed $id
     * @return
     */
    public static function closeticket($type, $id) 
	{
		
		//iniate the database
        $database = DatabaseFactory::getFactory()->getConnection();

        switch ($type):
            case 'close':
                $update = $database->prepare("UPDATE support SET support_status = '1' WHERE id = ?");
                break;
            case 'open':
                $update = $database->prepare("UPDATE support SET support_status = '0' WHERE id = ?");
                break;
            default:
                $update = $database->prepare("UPDATE support SET support_status = '1' WHERE id = ?");
        endswitch;

		
		//run the sql
        $result = $update->execute(array($ticket));
		
		//get the result to show success message
        if ($result):
            return 1;
        endif;
    }

    /**
     * SupportModel::ownsticket()
     * 
     * @param mixed $user
     * @param mixed $ticket
     * @return
     */
    public static function ownsticket($user, $ticket) 
	{
		
		//iniate the database
        $database = DatabaseFactory::getFactory()->getConnection();
        
		//sql to run
		$sql = "SELECT * FROM support 
				WHERE support_username = ? 
				AND support_id = ?";
		
		//check if it's staff or the owned ticket user
        $checkticket = $database->prepare($sql);
        $checkticket->execute(array($user->user_username, $ticket));
		
		//return the results
        return $checkticket->fetch();
    }

    /**
     * SupportModel::faqs()
     * 
     * @return
     */
    public static function faqs()
	{
		
		//iniate the database
        $database = DatabaseFactory::getFactory()->getConnection();
       
		//sql to run
		$sql = "SELECT * FROM faq";
		
		//run the sql
		$getfaq = $database->prepare($sql);
        $getfaq->execute();
        
		//return the results
		return $getfaq->fetchAll();
    }

}
