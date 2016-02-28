<?php

class AdminController extends Controller
{

    public function index()
    {
        // load views
		//$site = $this->model->site();
		$this->View->RenderPage('error/index');
    }
	
	public function user_tracking()
	{
		$tracking = AdminModel::tracking();
		$this->View->Render('admin/tracking', array('tracking' => $tracking));
	}
	
}
