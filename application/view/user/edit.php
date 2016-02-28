<link href="<?php echo Config::get('URL'); ?>css/plugins/iCheck/custom.css" rel="stylesheet">
<!-- iCheck -->
<script src="<?php echo Config::get('URL'); ?>js/plugins/iCheck/icheck.min.js"></script>
<script>
    $(document).ready(function () {
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
           });
        });
</script>
<div class="col-lg-12">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5><?php echo System::translate('Edit user profile'); ?></h5>
        </div>
        <div class="ibox-content">
            <form method="POST" action="<?php echo Config::get('URL'); ?>user/editprofile" class="form-horizontal">
            <input name="update_profile" type="hidden" value="1">   
			   <div class="form-group">
                    <label class="col-sm-2 control-label">
                        <?php echo System::translate('Your Email'); ?>
                    </label>
                    <div class="col-lg-10">
                        <p class="form-control-static"><?php echo System::escape($this->user->user_email); ?></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">
                        <?php echo System::translate('Your Username'); ?>
                    </label>
                    <div class="col-lg-10">
                        <p class="form-control-static"><?php echo System::escape($this->user->user_username); ?></p></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">
                        <?php echo System::translate('Change Password'); ?>
                    </label>
                    <div class="col-lg-10">
                        <div class="col-sm-10">
						<?php
							echo Form::input('password','text', array(
													'class'       => 'form-control',
													'placeholder' => System::translate("Enter Current Password"),
													'value'       => '')
													);
						?>	
                        </div>
                    </div>	
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">

                    </label>
                    <div class="col-lg-10">
                        <div class="col-sm-10">
						<?php
							echo Form::input('newpassword','text', array(
													'class'       => 'form-control',
													'placeholder' => System::translate("Enter New Password"),
													'value'       => '')
													);
						?>						
                        </div>
                    </div>	

                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">

                    </label>
                    <div class="col-lg-10">
                        <div class="col-sm-10">
						<?php
							echo Form::input('newpasswordconfirm','text', array(
													'class'       => 'form-control',
													'placeholder' => System::translate("Repeat New Password"),
													'value'       => '')
													);
						?>
                        </div>
                    </div>	

                </div>	
				<div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">
						<?php echo System::translate('Bitcoin Address'); ?>
                    </label>
                    <div class="col-lg-10">
                        <div class="col-sm-10">
						<?php
							echo Form::input('bitcoinaddress','text', array(
													'class'       => 'form-control',
													'placeholder' => System::translate("Enter Bitcoin Wallet Address"),
													'value'       => '')
													);
						?>
                         </div>
                    </div>	

                </div>	
				
				<div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">
						<?php echo System::translate('Account Security'); ?>
                    </label>
                    <div class="col-lg-10">
                        <div class="col-sm-10 col-xs-12">
                            <button class="col-sm-4 col-xs-12 btn btn-primary" type="submit"><?php echo System::translate('2Factor Authentication'); ?></button>
                        </div>
                    </div>	

                </div>				
                <div class="hr-line-dashed"></div>
				
	                <div class="form-group">
                    <label class="col-sm-2 control-label">
						<?php echo System::translate('Delivery Information'); ?>
                    </label>
                    <div class="col-lg-10">
                        <div class="col-sm-10">
						<?php
							echo Form::input('text', 'firstname', array(
													'class'       => 'form-control',
													'id'          => 'firstname',
													'maxlength'   => 100,
													'placeholder' => System::translate("Firstname"),
													'value'       => System::escape($this->user->user_firstname))
													);
						?>
                        </div>
                    </div>	
                </div>	
	                <div class="form-group">
                    <label class="col-sm-2 control-label">
						
                    </label>
                    <div class="col-lg-10">
                        <div class="col-sm-10">
						<?php
							echo Form::input('lastname','text', array(
													'class'       => 'form-control',
													'id'          => 'lastname',
													'maxlength'   => 100,
													'placeholder' => System::translate("Lastname"),
													'value'       => System::escape($this->user->user_lastname))
													);
						?>
                        </div>
                    </div>	
                </div>	
	                <div class="form-group">
                    <label class="col-sm-2 control-label">
						
                    </label>
                    <div class="col-lg-10">
                        <div class="col-sm-10">
						<?php
							echo Form::input('address1', 'text', array(
													'class'       => 'form-control',
													'id'          => 'address1',
													'maxlength'   => 100,													
													'placeholder' => System::translate("Address Line 1"),
													'value'       => System::escape($this->user->user_address1))
													);
						?>
                        </div>
                    </div>	
                </div>	
	                <div class="form-group">
                    <label class="col-sm-2 control-label">
						
                    </label>
                    <div class="col-lg-10">
                        <div class="col-sm-10">
						<?php
							echo Form::input('address2','text', array(
													'class'       => 'form-control',
													'id'          => 'address2',
													'maxlength'   => 100,													
													'placeholder' => System::translate("Address Line 2"),
													'value'       => System::escape($this->user->user_address2))
													);
						?>
                        </div>
                    </div>	
                </div>	

	                <div class="form-group">
                    <label class="col-sm-2 control-label">
                     </label>
                    <div class="col-lg-10">
                        <div class="col-sm-10">
						<?php
							echo Form::input('city','text', array(
													'class'       => 'form-control',
													'id'          => 'city',
													'maxlength'   => 100,													
													'placeholder' => System::translate("City"),
													'value'       => System::escape($this->user->user_city))
													);
						?>  
                        </div>
                    </div>	
                </div>	

	                <div class="form-group">
                    <label class="col-sm-2 control-label">
					
                    </label>
                    <div class="col-lg-10">
                        <div class="col-sm-10">
						<?php
							echo Form::input('zipcode','text', array(
													'class'       => 'form-control',
													'id'          => 'zipcode',
													'maxlength'   => 100,													
													'placeholder' => System::translate("Zip Code"),
													'value'       => System::escape($this->user->user_zipcode))
													);
						?>  
                        </div>
                    </div>	
                </div>	

	                <div class="form-group">
                    <label class="col-sm-2 control-label">
					
                    </label>
                    <div class="col-lg-10">
                        <div class="col-sm-10">
						<?php
							echo Form::input('state','text', array(
											 'class'       => 'form-control',
											 'id'          => 'state',
											 'maxlength'   => 100,											 
											 'placeholder' => System::translate("State"),
											 'value'       => System::escape($this->user->user_state))
											 );
						?>  
                        </div>
                    </div>	
                </div>	
				
	                <div class="form-group">
                    <label class="col-sm-2 control-label">
						 
                    </label>
                    <div class="col-lg-10">
                        <div class="col-sm-10">
						<?php
							echo Form::input('country','text', array(
											 'class'       => 'form-control',
											 'id'          => 'country',
											 'maxlength'   => 100,										
											 'placeholder' => System::translate("Country"),
											 'value'       => System::escape($this->user->user_country))
											);
						?>  
                        </div>
                    </div>	

                </div>	
                <div class="hr-line-dashed"></div>

	                <div class="form-group">
                    <label class="col-sm-2 control-label">
						 <?php echo System::translate('About Me'); ?>
                    </label>
                    <div class="col-lg-10">
                        <div class="col-sm-10">
						<?php
							echo Form::input('aboutme','text', array(
													'id'          => 'aboutme',
													'class'       => 'form-control',
													'maxlength'   => 150,
													'placeholder' => System::translate("Visible on your profile page"),
													'value'       => System::escape($this->user->user_about))
													);
						?>  
                        </div>
                    </div>	

                </div>		
		
                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-2 pull-right">
                        <button class="btn btn-white" type="submit"><?php echo System::translate('Cancel'); ?></button>
                        <button class="btn btn-primary" type="submit"><?php echo System::translate('Save changes'); ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>