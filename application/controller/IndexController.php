<?php

class IndexController extends Controller
{

    public function index()
    {
        $products = ProductModel::frontpage();
        // load views
		echo $this->View->Render('home/index', array('products' => $products));

	}


}
