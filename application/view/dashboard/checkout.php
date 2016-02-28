<link href="<?php echo Config::get('URL'); ?>css/plugins/iCheck/custom.css" rel="stylesheet">
<!-- iCheck -->
<script src="<?php echo Config::get('URL'); ?>js/plugins/iCheck/icheck.min.js"></script>
        

    <h5><?php echo System::translate('Item(s) Checkout'); ?></h5>
		<?php
			foreach($this->orders as $orders): 
		?>		
		<div class="col-sm-6">
        <div class="ibox-content">
            <div class="row">      
				<div id="warning" class="text-center col-sm-10 col-sm-offset-1 alert alert-warning" style=""><?php echo System::translate('Once you have paid for your item(s) do not mark as received until you actually receive the items as this will release the payment to the seller. If you have a problem with your purchase, please open a ticket and we will sort it out for you, as soon as possible. Once you have sent the payment, please allow sometime for our system to mark the order as paid.'); ?></div>

				<div class="form-group col-sm-12">
                    <label class="col-lg-3 control-label"><?php echo System::translate('Status'); ?></label>
                    <div class="col-lg-9">
                        <p class="form-control-static">Awaiting Payment</p>
                    </div>
                </div>
				
                <div class="form-group col-sm-12">
                    <label class="col-lg-3 control-label"><?php echo System::translate('Product'); ?></label>
                    <div class="col-lg-9">
                        <?php echo System::escape($orders->title); ?>
					</div>
                </div>
				
                <div class="form-group col-sm-12">
                    <label class="col-lg-3 control-label"><?php echo System::translate('Amount due'); ?></label>
                    <div class="col-lg-9">
                        <p class="form-control-static fa fa-btc"> <?php echo System::escape($orders->orders_amount); ?></p></div>
                </div>				

                <div class="form-group col-sm-12">
                    <label class="col-lg-3 control-label"><?php echo System::translate('Payment address'); ?></label>
                    <div class="col-lg-9">
                        <input type="text" name="address1" value="<?php echo System::escape($orders->orders_btcaddress); ?>" placeholder="" class="form-control">
                    </div>
                </div>
			</div>
		</div>
		</div>
				<?php endforeach; ?>

						   
</div>
</div>