<div class="wrapper wrapper-content">
    <div class="animated fadeInRight">
        <div class="col-md-12">
            <div class="table-responsive shopping-cart-table">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td class="text-center">
                                <?php echo System::translate('Image'); ?>
                            </td>
                            <td class="text-center">
                                <?php echo System::translate('Product Details'); ?> 
                            </td>							
                            <td class="text-center">
                                <?php echo System::translate('Quantity'); ?>
                            </td>
                            <td class="text-center">
                                <?php echo System::translate('Price'); ?>
                            </td>
                            <td class="text-center">
                                <?php echo System::translate('Total'); ?>
                            </td>
                            <td class="text-center">
                                <?php echo System::translate('Action'); ?>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($this->baskets)): $totalcost = 0;
                            $subtotal = 0;
                            foreach ($this->baskets as $basket):
                                ?>
                                <tr>
                                    <td class="text-center">
                                        <a href="<?php echo Config::get('URL'); ?>products/product/<?php echo System::escape($basket->id); ?>">
                                            <img height="137" width="91" src="<?php
                                            if (!empty($basket->images)): echo Config::get('URL') . 'images/products/' . System::escape($basket->username) . '/item' . System::escape($basket->id) . '/' . System::escape($basket->images);
                                            else: echo Config::get('URL') . 'images/noimage.jpg';
                                            endif;
                                            ?>" alt="<?php echo System::escape($basket->title); ?>" title="<?php echo System::escape($basket->title); ?>" class="img-thumbnail">
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?php echo Config::get('URL'); ?>products/product/<?php echo System::escape($basket->id); ?>"><?php echo System::escape($basket->title); ?></a>
                                    </td>							
                                    <td class="text-center">
                                        <div class="input-group btn-block">
                                            <input type="text" name="quantity" value="1" size="1" class="form-control">
                                        </div>								
                                    </td>
                                    <td class="text-center">
                            <li class="fa fa-btc"></li> <?php echo System::escape($basket->price); ?>
                            </td>
                            <td class="text-center">
                            <li class="fa fa-btc"></li> <?php echo System::escape($basket->price); ?>
                            </td>
                            <td class="text-center">
                                <button type="submit" title="" class="btn btn-white tool-tip" data-original-title="Update">
                                    <i class="fa fa-refresh"></i>
                                </button>                                
                                <a class="btn btn-white tool-tip" href="<?php echo Config::get('URL'); ?>dashboard/removefrombasket/<?php echo System::escape($basket->basket_id); ?>">
                                    <i class="fa fa-times-circle"></i></a>
                            </td>
                            </tr>
                            <?php
                            if (isset($basket->price)):
                                $totalcost += $basket->price + $basket->shippingcost;
                                $subtotal += $basket->price;
                            endif;
                        endforeach;
                    endif;
                    ?>	
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-right">
                                <strong><?php echo System::translate('Total'); ?>:</strong>
                            </td>
                            <td colspan="2" class="text-left">
                    <li class="fa fa-btc"></li> <?php echo number_format(System::escape($subtotal), 8); ?>
                    </td>
                    </tr>
                    </tfoot>
                </table>				
            </div>
        </div>      
    </div>
</div>
</div>
<div class="col-md-7" style="padding-top:25px;">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5><?php echo System::translate("Delivery Address"); ?></h5>
        </div>
        <div class="ibox-content">
		<form class="form-horizontal" action="<?php echo Config::get('URL'); ?>dashboard/checkout" method="POST" role="form">
        <input type="hidden" name="basket" value="1"> 
		 <div class="form-group">
                <label for="inputFname" class="col-sm-3 control-label">First Name :</label>
                <div class="col-sm-9">
                    <input name="firstname" type="text" value="<?php echo System::escape($user->user_firstname); ?>" class="form-control" id="inputFname" placeholder="First Name">
                </div>
            </div>
            <div class="form-group">
                <label for="inputLname" class="col-sm-3 control-label">Last Name :</label>
                <div class="col-sm-9">
                    <input name="lastname" type="text" value="<?php echo System::escape($user->user_lastname); ?>" class="form-control" id="inputLname" placeholder="Last Name">
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail" class="col-sm-3 control-label">Email :</label>
                <div class="col-sm-9">
                    <input type="email" value="<?php echo System::escape($user->user_email); ?>" class="form-control" id="inputEmail" placeholder="Email">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPhone" class="col-sm-3 control-label">Phone :</label>
                <div class="col-sm-9">
                    <input type="text" <?php echo System::escape($user->user_phone); ?> class="form-control" id="inputPhone" placeholder="Phone">
                </div>
            </div>
            <div class="form-group">
                <label for="inputAddress1" class="col-sm-3 control-label">Address/1 :</label>
                <div class="col-sm-9">
                    <input name="address1" type="text" value="<?php echo System::escape($user->user_address1); ?>" class="form-control" id="inputAddress1" placeholder="Address/1">
                </div>
            </div>
            <div class="form-group">
                <label for="inputAddress2" class="col-sm-3 control-label">Address/2 :</label>
                <div class="col-sm-9">
                    <input name="address2" type="text" value="<?php echo System::escape($user->user_address2); ?>" class="form-control" id="inputAddress2" placeholder="Address/2">
                </div>
            </div>
            <div class="form-group">
                <label for="inputCity" class="col-sm-3 control-label">City :</label>
                <div class="col-sm-9">
                    <input name="city" type="text" value="<?php echo System::escape($user->user_city); ?>" class="form-control" id="inputCity" placeholder="City">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPostCode" class="col-sm-3 control-label">Postal Code :</label>
                <div class="col-sm-9">
                    <input name="zipcode" type="text" value="<?php echo System::escape($user->user_zipcode); ?>" class="form-control" id="inputPostCode" placeholder="Postal Code">
                </div>
            </div>
            <div class="form-group">
                <label for="inputCountry" class="col-sm-3 control-label">Country :</label>
                <div class="col-sm-9">
					<select name="country" class="form-control col-sm-12">
					    <?php foreach(System::countries() as $country): ?>
						   <option value="<?=System::escape($country); ?>"><?=System::escape($country); ?></option>
						<?php endforeach; ?>
					</select>
                </div>
            </div>
            <div class="form-group">
                <label for="inputRegion" class="col-sm-3 control-label">Region :</label>
                <div class="col-sm-9">
                    <input name="state" type="text" value="<?php echo System::escape($user->user_state); ?>" class="form-control" id="inputCity" placeholder="State">
                </div>
            </div>
        </div>
    </div></div>
<div class="col-md-5 pull-right" style="padding-top:25px;">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5><?php echo System::translate("Basket"); ?></h5>
        </div>
        <div class="ibox-content">
            <h3 style="font-family: Inika; font-weight: 700;"><?php echo System::translate('Sub-Total') . ': <li class="fa fa-btc"></li> ' . System::escape(number_format($subtotal, 8)); ?></h3>
            <h3 style="font-family: Inika; font-weight: 700;"><?php echo System::translate('Total Cost') . ': <li class="fa fa-btc"></li> ' . System::escape(number_format($totalcost, 8)); ?></h3> 
            <br/><span class=""><i><?php echo System::translate('Please note, if you proceed to checkout you will engage in a binding contract to purchase these items within 48hours from checkout. Failing to do so could cause your account to be suspended or deleted.'); ?></i></span>
            <div class="hr-line-dashed"></div>
            <a href="<?php echo Config::get('URL'); ?>" class="btn btn-white"><?php echo System::translate('Continue shopping'); ?></a>
            <input type="submit"class="btn btn-primary pull-right" value="<?php echo System::translate('Proceed to checkout'); ?>">
			</form>
		</div>
    </div>
</div>	
</div></div>