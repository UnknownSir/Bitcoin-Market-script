<?php

class ErrorController extends Controller
{

    public function index()
    {
        // load views
		//$site = $this->model->site();
		$this->View->RenderPage('error/index');
    }
}
