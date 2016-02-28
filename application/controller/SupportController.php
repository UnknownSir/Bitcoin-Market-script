<?php

class SupportController extends Controller
{

    public function index()
    {

        if(!UsersModel::Loggedin() == true): Redirect::to('user/login'); exit(); endif;

        $user = Usersmodel::user();
        $type = Request::get('type'); 
		
        //switch between open and closed
        switch ($type):
            case 'open':
                $tickets = SupportModel::tickets($user->user_username, '0');
                break;
            case 'closed':
                $tickets = SupportModel::tickets($user->user_username, '1');
                $type = '';
                break;
            default:
                $tickets = SupportModel::tickets($user->user_username);
        endswitch;

        $all = count($tickets);		
		$this->View->Render('support/index', array('tickets' => $tickets, 'all' => $all, ));

    }

    public function newticket()
    {
        if(!UsersModel::Loggedin() == true): Redirect::to('user/login'); exit(); endif;

        $user = UsersModel::user();
        $tickets = SupportModel::tickets($user->user_username);
        $all = count($tickets);
		
        if (Request::post('check_submit') == true):
		
            //I could check if vars are empty but fuck it.
            $addticket = SupportModel::addticket(Request::post('title'), Request::post('category'), 
			                                     Request::post('status'), Request::post('message'), 
												 $user->user_username);
            
			//check the result of the query
			if ($addticket == true):
				Session::set('success', 7);
                Redirect::to('/support'); 
                exit();
            endif;
        endif;

		$this->View->Render('support/new');
    }

    public function admin()
    {
        /*
        * I am creating this because I don't want support staff to access the main
        * admin control panel, so I can set them a role of support and they can access
        * this page and other staff pages
        */
		
		//check if they're logged in
		if(!UsersModel::Loggedin() == true): Redirect::to('user/login'); exit(); endif;
		
		//check if the user is a staff member
        if (!UsersModel::isstaff() == true): Redirect::to('user/login'); exit(); endif;

		$user = UsersModel::user();
		
        $tickets = SupportModel::tickets($user->username, '0', 'all');
        $all = count($tickets);


        $this->View->Render('support/index', array(
											'tickets' => $tickets, 
											'all' => $all));
    }

    public function ticket()
    {
        // load views
		if(!UsersModel::Loggedin() == true): Redirect::to('user/login'); exit(); endif;


        $user = Usersmodel::user();
        $id = Request::get('id');

        $ownsticket = SupportModel::ownsticket($user,$id);

        //doesn't own it, redirect them
        /*
		if (!UsersModel::isstaff() == true):
            if (count($ownsticket->id) == 0):
                Redirect::to('support/?error=22');
                exit();
            endif;
        endif;
		*/

        //is staff, above all peasants
        if (UsersModel::isstaff() == true):
            $tickets = SupportModel::ticket('', $id);
        else:
            $tickets = SupportModel::ticket($user->user_username, $id);
        endif;
		
        $ticketreply = SupportModel::ticketreplies($id);
        $all = count($tickets);

			
		$this->View->Render('support/ticket', array(
											'tickets' => $tickets,
											'ticketreply' => $ticketreply,
											'all' => $all
											));

        }

    public function reply()
    {
        if(!UsersModel::Loggedin() == true): Redirect::to('user/login'); exit(); endif;

        $user = UsersModel::user();

        //if it's been submitted
        if (Request::post('check_submit') == true):

            //get the ticket id
            $ticket = Request::post('ticket'); 

            //get the reply message
            $message = Request::post('message');

			$ownsticket = SupportModel::ownsticket($user,$ticket);

            //doesn't own it, redirect them
            if (!UsersModel::isstaff() == true):
                if (count($ownsticket->id) == 0):
					Session::set('error', 22);
                    Redirect::to('support/'); exit();
                endif;
            endif;
				
            //I could check if vars are empty but fuck it
            $addticket = SupportModel::addticketreply($message, $user->username, $ticket);
                Session::set('error', 18);
				Redirect::to('support/'); 
                if ($addticket == true):
					Session::set('success', 7);
                    Redirect::to('support/ticket/?id='. $ticket);
                    exit();
                endif;
            endif;
        }

    public function resolved()
    {
        if(!UsersModel::Loggedin() == true): Redirect::to('user/login'); exit(); endif;

        if (!$this->model->isstaff() == true):
            header('location: ' . URL . 'support'); exit();
        endif;

		//close and resolve the ticket
		$update = SupportModel::closeticket(Request::get('ticket'), Request::get('id'));
		
        if ($update == 1):
            Redirect::to('support/'); exit();
        endif;
    }
   
	public function faq()
	{
		$faq = SupportModel::faqs();
		
		$this->View->Render('support/faq', array(
								'faq' => $faq
								));
	}
	
	public function privacy()
	{
		$this->View->Render('support/privacy');
	}

}

?>