</div></div></div></div>
<div class="footer" id="footer">
    <div class="container">
      <div class="row">
        <div class="col-sm-3 col-xs-12">
          <h3>Help & Contact</h3>
		  <ul>
			<li><a href="<?php echo Config::get('URL'); ?>support"><?php echo System::translate('Resolution Centre'); ?></a></li>
			<li><a href="<?php echo Config::get('URL'); ?>support"><?php echo System::translate('Terms and conditions'); ?></a></li>
			<li><a href="<?php echo Config::get('URL'); ?>support/privacy"><?php echo System::translate('Privacy Policies'); ?></a></li>
			<li><a href="<?php echo Config::get('URL'); ?>support/faq"><?php echo System::translate('Frequently Asked Questions'); ?></a></li>
			</ul> 
        </div>
        <div class="col-sm-3 col-xs-12">
          <h3><?php echo SITE_NAME; ?></h3>
          <ul>
            <li><a href="<?php echo Config::get('URL'); ?>"><?php echo System::translate('Home'); ?></a></li>
            <li><a href="<?php echo Config::get('URL'); ?>products/search"><?php echo System::translate('Advanced Search'); ?></a></li>
            <li><a href="<?php echo Config::get('URL'); ?>dashboard/addproduct"><?php echo System::translate('Sell an item'); ?></a></li>
          </ul>
        </div>
        <div class="col-sm-3 col-xs-12">
          <h3><?php echo System::translate('Account'); ?></h3>
          <ul>
		  <?php if(UsersModel::LoggedIn() == true): ?>
            <li><a href="<?php echo Config::get('URL'); ?>dashboard"><?php echo System::translate('Dashboard'); ?></a></li>
            <li><a href="<?php echo Config::get('URL'); ?>dashboard/selling"><?php echo System::translate('Sell'); ?></a></li>
            <li><a href="<?php echo Config::get('URL'); ?>dashboard/purchased"><?php echo System::translate('Purchased Items'); ?></a></li>
            <li><a href="<?php echo Config::get('URL'); ?>dashboard/following"><?php echo System::translate('Following'); ?></a></li>
            <li><a href="<?php echo Config::get('URL'); ?>dashboard/wishlist"><?php echo System::translate('Wishlist'); ?></a></li>
          <?php else: ?>
            <li><a href="<?php echo Config::get('URL'); ?>user/register"><?php echo System::translate('Create an account'); ?></a></li>
            <li><a href="<?php echo Config::get('URL'); ?>user/login"><?php echo System::translate('Login'); ?></a></li>		  
		  <?php endif; ?>
		  </ul>
        </div>
        <div class="col-sm-3 col-xs-12">
          <h3><?php echo System::translate('Other'); ?></h3>
		  	<div class="bfh-selectbox bfh-languages" data-language="en_US" data-available="en_US,fr_CA,es_MX" data-flags="true">
			</div>
        </div>
      </div>
      <!--/.row--> 
    </div>
    <!--/.container--> 
  </div>
<div class="footer-bottom">
    <div class="container">
      <p class="pull-left"> &copy; <?php echo SITE_NAME; ?> 2015 - <?php echo date("Y"); ?>. All right reserved. </p>
      <div class="pull-right paymentMethodImg"> 
	     <img height="40" class="pull-right" src="<?php echo Config::get('URL'); ?>img/btc.png" alt="img"> 
	  </div>
</div>
    <link href="<?php echo Config::get('URL'); ?>css/plugins/steps/jquery.steps.css" rel="stylesheet">
    <script src="<?php echo Config::get('URL'); ?>js/plugins/staps/jquery.steps.min.js"></script>
    <script src="<?php echo Config::get('URL'); ?>js/plugins/validate/jquery.validate.min.js"></script>    
    <!-- define the project's URL (to make AJAX calls possible, even when using this in sub-folders etc) -->
    <script>
        var url = "<?php echo Config::get('URL'); ?>";
    </script>
	<!--End Container-->
 
</body>
</html>
