<?php
/* debug, remove on release */
if(Session::Get('username') != false):
	$user = UsersModel::user();
endif;

//System::Sanitise();
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo SITE_NAME; ?></title>	
        <link href="<?php echo Config::get('URL'); ?>css.php?t=<?php echo time(); ?>" rel="stylesheet">
		<link href="<?php echo Config::get('URL'); ?>custom.css?t=<?php echo time(); ?>" rel="stylesheet">
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="<?php echo Config::get('URL'); ?>plugins/jquery/jquery-2.1.0.min.js"></script>
        <script src="<?php echo Config::get('URL'); ?>plugins/jquery-ui/jquery-ui.min.js"></script>
        <script src="<?php echo Config::get('URL'); ?>js/bootstrap.min.js"></script>
        <script src="<?php echo Config::get('URL'); ?>js/plugins/metisMenu/jquery.metisMenu.js"></script>
        <!-- Custom and plugin javascript -->
        <script src="<?php echo Config::get('URL'); ?>js/jquery.countdown.js"></script>
        <script src="<?php echo Config::get('URL'); ?>plugins/tinymce/tinymce.min.js"></script>
        <script src="<?php echo Config::get('URL'); ?>plugins/tinymce/jquery.tinymce.min.js"></script>
        <script src="<?php echo Config::get('URL'); ?>js/inspinia.js"></script>
	    <script src="<?php echo Config::get('URL'); ?>js/plugins/dataTables/jquery.dataTables.js"></script>
        <script src="<?php echo Config::get('URL'); ?>js/plugins/dataTables/dataTables.bootstrap.js"></script>
        <script src="<?php echo Config::get('URL'); ?>js/plugins/dataTables/dataTables.responsive.js"></script>
        <script src="<?php echo Config::get('URL'); ?>js/plugins/dataTables/dataTables.tableTools.min.js"></script>
		<script src="<?php echo Config::get('URL'); ?>js/main.js"></script>
		<script src="<?php echo Config::get('URL'); ?>js/bootstrap-maxlength.js"></script>

		<!--
		<script src="<?php echo Config::get('URL'); ?>sockets/js/node_modules/socket.io/node_modules/socket.io-client/dist/socket.io.js"></script>
		<script src="<?php echo Config::get('URL'); ?>sockets/js/nodeClient.js"></script>
		-->
		</head>
		
	<body class="top-navigation">
    <div id="wrapper">
        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom white-bg">
        <nav class="navbar navbar-static-top" role="navigation">
            <div class="navbar-header">
                <button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
                    <i class="fa fa-reorder"></i>
                </button>
                <a href="<?php echo Config::get('URL'); ?>" class="navbar-brand"><?php echo SITE_NAME; ?></a>
            </div>
            <div class="navbar-collapse collapse" id="navbar">
                <ul class="nav navbar-nav">
				 <?php if(UsersModel::LoggedIn() == true): ?>
                    <li class="dropdown">
                        <a aria-expanded="false" role="button" href="#" class="dropdown-toggle" data-toggle="dropdown"> <?php echo System::translate('Dashboard'); ?> <span class="caret"></span></a>
                        <ul role="menu" class="dropdown-menu">
                            <li><a href="<?php echo Config::get('URL'); ?>dashboard"><?php echo System::translate('Dashboard'); ?></a></li>
                            <li><a href="<?php echo Config::get('URL'); ?>dashboard/withdraw"><?php echo System::translate('Withdraw'); ?></a></li>
                            <li><a href="<?php echo Config::get('URL'); ?>dashboard/selling"><?php echo System::translate('Sell'); ?></a></li>
                            <li><a href="<?php echo Config::get('URL'); ?>dashboard/purchased"><?php echo System::translate('Purchased Items'); ?></a></li>
                            <li><a href="<?php echo Config::get('URL'); ?>dashboard/following"><?php echo System::translate('Following'); ?></a></li>
                            <li><a href="<?php echo Config::get('URL'); ?>dashboard/wishlist"><?php echo System::translate('WIshlist'); ?></a></li>
                    </ul>
                    </li>
                    
					
					<li><a href="<?php echo Config::get('URL'); ?>dashboard/addproduct"><?php echo System::translate('Start Selling'); ?></a></li>


                    <li class="dropdown">
                        <a aria-expanded="false" role="button" href="#" class="dropdown-toggle" data-toggle="dropdown"> <?php echo System::translate('Messages'); ?> <span class="caret"></span></a>
                        <ul role="menu" class="dropdown-menu">
                            <li><a href="<?php echo Config::get('URL'); ?>messages"><?php echo System::translate('Inbox'); ?></a></li>
                            <li><a href="<?php echo Config::get('URL'); ?>messages/compose"><?php echo System::translate('Compose Message'); ?></a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a aria-expanded="false" role="button" href="#" class="dropdown-toggle" data-toggle="dropdown"> <?php echo System::translate('Account'); ?> <span class="caret"></span></a>
                        <ul role="menu" class="dropdown-menu">
                            <li><a href="<?php echo Config::get('URL'); ?>user/profile/<?php echo System::escape($user->user_username); ?>"><?php echo System::translate('Profile'); ?></a></li>
                            <li><a href="<?php echo Config::get('URL'); ?>user/editprofile"><?php echo System::translate('Edit Profile'); ?></a></li>
                            <li><a href="<?php echo Config::get('URL'); ?>support"><?php echo System::translate('Support'); ?></a></li>

							</ul>
                    </li>
					
					<li class="dropdown">
                        <a aria-expanded="false" role="button" href="#" class="dropdown-toggle" data-toggle="dropdown"> <?php echo System::translate('Categories'); ?> <span class="caret"></span></a>
                        <ul role="menu" class="dropdown-menu">
                            <li><a href="<?php echo Config::get('URL'); ?>messages"><?php Form::Linkcategories(); ?></a></li>
                        </ul>
                    </li>
					
				<?php else: ?>
                    <li>
                        <a href="<?php echo Config::get('URL'); ?>user/login">
                            <i class="fa fa-sign-out"></i><?php echo System::translate('Login'); ?>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo Config::get('URL'); ?>user/register">
                            <i class="fa fa-sign-out"></i><?php echo System::translate('Register'); ?>
                        </a>
                    </li>					
				<?php endif;?>
                </ul>
				
				<?php if(UsersModel::LoggedIn() == true): ?>
                <ul class="nav navbar-top-links navbar-right">
                    <li class="active">
                        <a aria-expanded="false" role="button" href="<?php echo Config::get('URL'); ?>dashboard/basket"><?php echo System::translate('Basket'); echo '&nbsp;<span class="label label-warning pull-right">'.count(ProductModel::basket($user)).'</span>' ?></a>
                    </li>
                    <li>
                        <a href="<?php echo Config::get('URL'); ?>user/logout/<?php echo System::escape(Session::get('token')); ?>">
                            <i class="fa fa-sign-out"></i><?php echo System::translate('Logout'); ?>
                        </a>
                    </li>
                </ul>
				<?php endif; ?>
				
            </div>
        </nav>
        </div>
		<div class="wrapper wrapper-content">
        <div class="container-fluid">
		<div class="form-group">
		<div class="row">
        <div class="input-group col-sm-10 col-sm-offset-2 col-xs-12" style="padding-top:25px">
			<form action="<?php echo Config::get('URL'); ?>products/search" method="get" >
			   <div class="col-sm-8 col-xs-8">
			       <input type="text" name="search" placeholder="<?php echo System::translate('Search for a product'); ?>" class="form-control input-lg m-b"> 
			    </div>
				<div class="col-sm-4 col-xs-4">
			        <input type="submit" class="btn btn-primary input-lg m-b" value="<?php echo System::translate('Search'); ?>"> </span>
			    </div>
			</form>
	    </div>
		</div>
		
		<?php  		
				//error and success notifications
				System::error(Session::get('error'));
				System::success(Session::get('success'));
		?>