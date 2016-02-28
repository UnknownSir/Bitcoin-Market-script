<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo System::Get('sitename'); ?> - Login</title>
    <link href="<?php echo Config::get('URL'); ?>css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo Config::get('URL'); ?>font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="<?php echo Config::get('URL'); ?>css/animate.css" rel="stylesheet">
    <link href="<?php echo Config::get('URL'); ?>css/style.css" rel="stylesheet">
</head>
<body class="gray-bg">

    <div class="loginColumns animated fadeInDown">
		<?php
		//error and success notifications because we're not including header
			System::error(Session::get('error'));
			System::success(Session::get('success'));
		?>
        <div class="row">
            <div class="col-md-6 ">
                <h2 class="font-bold"><?php echo System::translate("Welcome to"); ?> <?php echo System::Get('sitename'); ?></h2>

                <p>
                    <?php echo System::Get('sitename'); ?> <?php echo System::translate("is a Bitcoin auction website that allows its users to buy and sell their products for Bitcoins. Instant transactions"); ?>
                </p>
				<p>
					<?php echo System::translate("We offer a small fee alternative to other websites that charge fiat. Don't be over-charged for your own items."); ?>
				</p>
				<p>
					<?php echo System::translate("You can choose between auction listings, buy it now or make me an offer. Put a reserve price on an item so it doesn't sell for less than you want."); ?>
				</p>
                <p>
                    <small><?php echo System::translate("For our fee-markup, please see out fees page"); ?></small>
                </p>

            </div>
            <div class="col-md-6">
                <div class="ibox-content">
                    <form class="m-t" method="POST" role="form" action="<?php echo Config::get('URL'); ?>user/login">
                    <input type="hidden" name="user_login" value="1">
					 <div class="form-group">
						<?php
							echo Form::input('email', 'email', array(
													'class'       => 'form-control',
													'placeholder' => System::translate("Email"),
													'required'    => '',
													'value'       => System::escape(Request::get('email')))
													);
						?>  					 
                        </div>
                        <div class="form-group">
						<?php
							echo Form::input('password', 'password', array(
													'class'       => 'form-control',
													'placeholder' => System::translate("Password"),
													'required'    => ''
													));
						?>  
                        </div>
                        <button type="submit" class="btn btn-primary block full-width m-b"><?php echo System::translate("Login"); ?></button>

                        <a href="#">
                            <small><?php echo System::translate("Forgot your password?"); ?></small>
                        </a>

                        <p class="text-muted text-center">
                            <small><?php echo System::translate("Do not have an account?"); ?></small>
                        </p>
                        <a class="btn btn-sm btn-white btn-block" href="<?php echo Config::get('URL'); ?>/user/register"><?php echo System::translate("Create an account"); ?></a>
                    </form>
                    <p class="m-t">
                        <small><?php echo System::Get('sitename'); ?> <?php echo System::translate("Bitcoin Auction website"); ?> - <?php echo System::translate("Copyright"); ?> 2015</small>
                    </p>
                </div>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-md-6">
                <?php echo System::translate("Copyright"); ?> <?php echo System::Get('sitename'); ?>
            </div>
            <div class="col-md-6 text-right">
               <small>&copy; 2015</small>
            </div>
        </div>
    </div>
</body>
</html>

