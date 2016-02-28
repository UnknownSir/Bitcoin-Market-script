<div class="row">
    <div class="col-lg-12">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5><?php echo System::translate("Your Products"); ?></h5>
                </div>
                <div class="ibox-content">
                    <div class="content clearfix">
                        <form id="form" method="POST" action="#" class="wizard-big" enctype="multipart/form-data">    
                            <input type="hidden" name="add_product" value="1">
                            <h1><?php echo System::translate('Product Information'); ?></h1>
                            <fieldset> 
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="form-group col-sm-12">
                                            <label><?php echo System::translate('Product Name'); ?></label>
                                            <input value="<?php echo System::escape(Request::post('title')); ?>" name="title" id="producttitle" maxlength="100" type="text" class="form-control required error" >
                                        </div>
                                        <div class="form-group col-sm-3">
                                            <label><?php echo System::translate('Product Condition'); ?></label>
                                            <select name="condition" class="col-sm-6 form-control" >
                                                <label><?php echo System::translate('Choose an option'); ?></label>
												<option value="new" <?php if(Request::post('auctionlength') == 'new'): echo 'selected'; endif; ?>><?php echo System::translate("New"); ?></option>
                                                <option value="likenew" <?php if(Request::post('auctionlength') == 'likenew'): echo 'selected'; endif; ?>><?php echo System::translate("Like New"); ?></option>
                                                <option value="used" <?php if(Request::post('auctionlength') == 'used'): echo 'selected'; endif; ?>><?php echo System::translate("Used"); ?></option>
                                                <option value="spares" <?php if(Request::post('auctionlength') == 'spares'): echo 'selected'; endif; ?>><?php echo System::translate("For parts or not working"); ?></option>
                                            </select>
                                        </div>

                                        <div class="buyitnow">
                                            <div class="form-group col-sm-3">
                                                <label><?php echo System::translate('Buy it now Price'); ?></label>
                                                <input value="0" value="<?php echo System::escape(Request::post('price')); ?>" type="text" name="price" class="form-control required error" >
                                            </div>
                                        </div>
										
										<div class="form-group col-sm-3">
											<label><?php echo System::translate('Quantity'); ?></label>
											<input value="1" value="<?php echo System::escape(Request::post('quantity')); ?>" type="text" name="quantity" class="form-control required error" >
										</div>
														

                                        <div class="form-group col-sm-3">
                                            <label><?php echo System::translate('Listing Duration'); ?></label>
                                            <select name="type" name="auctionlength" id="auctionlength" class="form-control">
												<option value="3" <?php if(Request::post('auctionlength') == '3'): echo 'selected'; endif; ?>><?php echo System::translate("3 Days"); ?></option>
                                                <option value="7" <?php if(Request::post('auctionlength') == '7'): echo 'selected'; endif; ?>><?php echo System::translate("7 Days"); ?></option>   
                                                <option value="14" <?php if(Request::post('auctionlength') == '14'): echo 'selected'; endif; ?>><?php echo System::translate("14 Days"); ?></option>
                                                <option value="30" <?php if(Request::post('auctionlength') == '30'): echo 'selected'; endif; ?>><?php echo System::translate("30 Days"); ?></option>
                                                <option value="365" <?php if(Request::post('auctionlength') == '365'): echo 'selected'; endif; ?>><?php echo System::translate("365 Days"); ?></option>
                                            </select> 
                                        </div>

                                        <div class="form-group col-sm-12">
                                            <label><?php echo System::translate('Product Short Description'); ?></label>
                                            <input value="<?php echo System::escape(Request::post('shortdescription')); ?>" id="shortdescription" maxlength="100" name="shortdescription" type="text" class="form-control required error" >
                                        </div>
																
										<div class="form-group col-sm-12">
										<label><?php echo System::translate('Category'); ?></label>
											<?php
											Form::categories();
											?>										
										</div>
										
                                        <div class="form-group col-sm-12">
                                            <label><?php echo System::translate('Product Description'); ?></label>
                                            <textarea name="description" id="wysiwig_simple" class="form-control">
											  <?php echo System::escape(Request::post('description')); ?>
											</textarea>
                                        </div>

                                    </div>
                                </div>

                            </fieldset>
                            <h1><?php echo System::translate('Shipping Information'); ?></h1>
                            <fieldset>
                                <h2><?php echo System::translate('Shipping Information'); ?></h2>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group col-sm-4">
                                            <label><?php echo System::translate('International shipping'); ?></label>
                                            <select name="international" class="form-control required error">
												<label><?php echo System::translate('Choose an option'); ?></label>
                                                <option value="0" <?php if(Request::post('returns') == '0'): echo 'selected'; endif; ?>><?php echo System::translate('No International postage'); ?></option>
                                                <option value="1" <?php if(Request::post('returns') == '1'): echo 'selected'; endif; ?>><?php echo System::translate('International postage'); ?></option>
                                            </select>											
                                        </div>
                                        <div class="form-group col-sm-3">
                                            <label><?php echo System::translate('Shipping Price'); ?></label>
                                            <div class="input-group m-b">
                                                <span class="input-group-addon"><li class="fa fa-btc"></li></span> 
                                                <input value="<?php echo System::escape(Request::post('shippingcost')); ?>" type="text" name="shippingcost" class="form-control required error">
                                            </div>
                                        </div>

                                        <div class="form-group col-sm-5">
                                            <label><?php echo System::translate('Shipping courier'); ?></label>
                                            <div class="input-group m-b">
                                                <span class="input-group-addon"><li class="fa fa-truck"></li></span> 
                                                <input type="text" name="shipping" class="form-control required error" value="<?php echo System::escape(Request::post('shipping')); ?>">
                                            </div>								
                                        </div>

                                        <div class="form-group col-sm-4">
                                            <label><?php echo System::translate('Dispatch Time'); ?></label>
                                            <select name="shippingtime" class="form-control required error">
											    <label><?php echo System::translate('Choose an option'); ?></label>
                                                <option value="0" <?php if(Request::post('shippingtime') == 'same'): echo 'selected'; endif; ?>><?php echo System::translate('Same Working Day'); ?></option>
                                                <option value="1" <?php if(Request::post('shippingtime') == '1'): echo 'selected'; endif; ?>><?php echo System::translate('1 Working Day'); ?></option>
                                                <option value="2" <?php if(Request::post('shippingtime') == '2'): echo 'selected'; endif; ?>><?php echo System::translate('2 Working Days'); ?></option>
                                                <option value="3" <?php if(Request::post('shippingtime') == '3'): echo 'selected'; endif; ?>><?php echo System::translate('3 Working Days'); ?></option>
                                                <option value="4" <?php if(Request::post('shippingtime') == '4'): echo 'selected'; endif; ?>><?php echo System::translate('4 Working Days'); ?></option>
                                            </select>
                                        </div>

                                        <div class="form-group col-sm-4">
                                            <label><?php echo System::translate('Returns'); ?></label>
                                            <select name="returns" class="form-control required error">
												<label><?php echo System::translate('Choose an option'); ?></label>
                                                <option value="0" <?php if(Request::post('returns') == '0'): echo 'selected'; endif; ?>><?php echo System::translate('Returns Not Accepted'); ?></option>
                                                <option value="1" <?php if(Request::post('returns') == '1'): echo 'selected'; endif; ?>><?php echo System::translate('Returns Accepted'); ?></option>
                                            </select>
                                        </div>

                                        <div class="form-group col-sm-4">
                                            <label><?php echo System::translate('Item Location'); ?></label>
                                            <select name="country" class="form-control required error">
                                                <?php foreach (System::countries() as $country): ?>
                                                    <option value="<?= System::escape($country) ?>"><?= System::escape($country) ?></option>
                                                <?php endforeach; ?>	
                                            </select>
                                        </div>
                                        </form>
			<link href="http://webapplayers.com/inspinia_admin-v1.9.2/css/plugins/dropzone/basic.css" rel="stylesheet">
			<link href="http://webapplayers.com/inspinia_admin-v1.9.2/css/plugins/dropzone/dropzone.css" rel="stylesheet">					

										<div class="form-group col-sm-12">
										    <form id="my-awesome-dropzone" class="dropzone" action="#">
												<div class="dropzone-previews"></div>
											</form>
										</div>

                                        <div class="form-group col-sm-12" style="padding-top:30px;">
                                            <i><?php echo System::translate("Please note: Do not post your Bitcoin address anywhere in the listing. Our site automatically generates a payment address for the buyer. This is to protect the buyer from any misdoings or potential scams. Doing so will result in your product listing being closed and your account being suspended or deactivated."); ?></i>
                                        </div>
                                    </div>
                            </fieldset>
                    </div>
                </div>
            </div>
        </div>
<script src="http://webapplayers.com/inspinia_admin-v1.9.2/js/plugins/dropzone/dropzone.js"></script>	
	<script>
        $(document).ready(function(){

            Dropzone.options.myAwesomeDropzone = {

                autoProcessQueue: false,
                uploadMultiple: true,
                parallelUploads: 100,
                maxFiles: 100,

                // Dropzone settings
                init: function() {
                    var myDropzone = this;

                    this.element.querySelector("button[type=submit]").addEventListener("click", function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        myDropzone.processQueue();
                    });
                    this.on("sendingmultiple", function() {
                    });
                    this.on("successmultiple", function(files, response) {
                    });
                    this.on("errormultiple", function(files, response) {
                    });
                }

            }

       });
    </script>