<div class="col-xs-12 col-sm-8">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5><?php echo System::translate('Order Details'); ?></h5>
        </div>
        <div class="ibox-content">
			<div class="row">
				<div class="form-group col-xs-12">
					<div class="col-sm-3">
						<?php $mainimage = explode(",",$this->orders->images); ?>
						<img height="140" src="<?php if(!empty($this->orders->images)): echo Config::get('URL') .'images/products/'.System::escape($this->orders->username). '/item' .System::escape($this->orders->id) .'/'. System::escape($mainimage[0]); else: echo Config::get('URL').'images/noimage.jpg'; endif; ?>" class="front">	
					</div>
					<div class="col-sm-6">
						<?php echo '<b>'.System::translate('Product') .':</b> <a href="'.Config::get('URL').'products/product/'.System::escape($this->orders->id).'">'.System::escape($this->orders->title); ?></a><br/>
						<?php echo '<b>'.System::translate('User') .':</b> <a href="'.Config::get('URL').'user/profile/'.System::escape($this->orders->username).'">'.System::escape($this->orders->username); ?></a><br/>
						<?php echo '<b>'.System::translate('Price') .':</b> '.System::escape($this->orders->price); ?></br>
						<?php echo '<b>'.System::translate('Shipping Method') .':</b> '.System::escape($this->orders->shipping);  ?></br>
						<?php echo '<b>'.System::translate('Returns') .':</b> '.(System::escape($this->orders->returns) == 0) ? System::translate("Returns Not Accepted") : System::translate("Returns Accepted");  ?></br>
						<?php echo '<b>'.System::translate('Location') .':</b> '.System::escape($this->orders->location);  ?></br>
					</div>
					<div class="col-sm-3">
						<a href="<?php echo Config::get('URL'); ?>orders/feedback/<?php echo System::escape($this->orders->orders_id); ?>" class="btn btn-white col-sm-12"><?php echo System::translate('Leave Feedback'); ?></a>
						<a href="<?php echo Config::get('URL'); ?>messages/compose/<?php echo System::escape($this->orders->username); ?>" class="btn btn-white col-sm-12"><?php echo System::translate('Contact User'); ?></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

				<div class="col-xs-12 col-sm-4">
				    <div class="ibox float-e-margins">
						<div class="ibox-title">
							<h5><?php echo System::translate('Delivery Address'); ?></h5>
						</div>
					<div class="ibox-content">
					<?php if($this->orders->orders_wishlist == 1 && $this->orders->orders_wishlist_user != $user->username): 
							echo System::translate("You cannot view this address because you bought it for another user"); 
						  else:
				    ?>
						<b><?php echo System::escape($this->orders->orders_firstname);  ?>
						<?php echo System::escape($this->orders->orders_lastname);  ?></b></br>
						<?php echo System::escape($this->orders->orders_address1);  ?></br>
						<?php echo System::escape($this->orders->orders_address2);  ?></br>
						<?php echo System::escape($this->orders->orders_city);  ?>
						<?php echo System::escape($this->orders->orders_state);  ?>
						<?php echo System::escape($this->orders->orders_zipcode);  ?><br/>
						<?php echo System::escape($this->orders->orders_country);  ?><br/>
						<?php echo System::escape($this->orders->orders_phone);  ?><br/>
						<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>