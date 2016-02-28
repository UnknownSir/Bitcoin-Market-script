    <link href="<?php echo Config::get('URL'); ?>css/plugins/toastr/toastr.min.css" rel="stylesheet">
	
    <link href="<?php echo Config::get('URL'); ?>css/plugins/toastr/toastr.min.css" rel="stylesheet">
	<script src="<?php echo Config::get('URL'); ?>js/plugins/toastr/toastr.min.js"></script>
	<script>

$(document).ready(function(){
	toastr.options = {
	  "closeButton": true,
	  "debug": false,
	  "progressBar": true,
	  "positionClass": "toast-top-full-width",
	  "onclick": null,
	  "showDuration": "600",
	  "hideDuration": "50",
	  "timeOut": "7000",
	  "extendedTimeOut": "1000",
	  "showEasing": "swing",
	  "hideEasing": "linear",
	  "showMethod": "fadeIn",
	  "hideMethod": "fadeOut"
	}
	
	if(window.location.href.indexOf("#bids") > -1) {
					$("#buyitem").hide();
                    $("#bidsshow").show();  
	}

		$("#showbids").on('click',function(){
                    $("#buyitem").hide();
                    $("#bidsshow").show();        
        });
		$("#buyinfo").on('click',function(){
                    $("#bidsshow").hide();
                    $("#buyitem").show();        
        });
	$('#bidplace').click(function()
	{
		$.ajax({
		    type: 'POST',
			url: '<?php echo Config::get('URL'); ?>products/addbid?item=<?php echo System::escape($this->product->product_id); ?>',
			data: '&price=' + $('#bidprice').val(),
			success: function(msg){
				  toastr.info(msg, "<?php echo System::translate("Bid Notification"); ?>")
			}
		});
	});
});

</script>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-8">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div>
                        <h3 class="font-bold no-margins">
                            <?php echo System::escape($this->product->product_title); ?>
                        </h3>
                    </div>
                    <div class="m-t-sm">
                        <div class="row">
                            <div class="col-md-5 col-xs-12">
                                <div>
                                    <img class="col-xs-12" height="250" width="250" src="http://i.ebayimg.com/00/s/Nzg2WDgzOA==/z/LYoAAOxy79JSUXTC/$T2eC16VHJGgFFmyUS,W)BSU(TBvWWg~~60_57.JPG">
                                </div>
                            </div>
							<div class="col-sm-7 col-xs-12" id="bidsshow" style="display:none;">
							<table class="table table-responsive">
								<thead>
									<th><?php echo System::translate("Username"); ?></th>
									<th><?php echo System::translate("Amount"); ?></th>
									<th><?php echo System::translate("Date"); ?></th>
								</thead>
								<tbody>
							<?php foreach($this->bids as $bid): ?>
									<tr>
										<td><?php echo System::escape($bid->bid_username); ?></td>
										<td><?php echo System::escape($bid->bid_amount); ?></td>
										<td><?php echo System::escape($bid->bid_date); ?></td>
									<tr/>
							<?php endforeach; ?>
								</tbody>
								</table>							
							<li class="fa fa-btc"></li> <span><a id="buyinfo" href=""><?php echo System::translate("Show buy information"); ?></a></span>
							
							</div>
                            <div class="col-sm-7 col-xs-12" id="buyitem">
								<div class="form-group">
								   <div id="condition" class="col-sm-offset-4"><?php echo System::translate("Condtion"); ?>: <b><?php echo System::escape($this->product->product_itemcondition); ?></b></div>
                                   <div id="time" class="col-sm-offset-4"><b><?php if(date("Y-m-d H:i:s") >= $this->product->product_enddate): echo '<span style="color:red">Ended</span>'; else: echo '<div id="enddate"></div>'; endif; ?></b></div>
								</div>
                                <div class="ibox-content">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="form-group col-sm-8 col-sm-offset-3">
                                                <span><?php echo System::translate("Current Price"); ?> <li class="fa fa-btc"></li> <b><div id="currentbidprice"></div></b></span>
                                            </div>
                                            <div class="form-group">
											<?php if(!$this->product->product_buyitnow == 1): ?>
                                                <input type="text" <?php if(date("Y-m-d H:i:s") >= $this->product->product_enddate): echo 'disabled'; endif; ?> class="form-control" id="bidprice" name="bidprice">
											<?php endif; ?>
											</div>
                                            <div class="form-group">
											<?php if($this->product->product_buyitnow == 1): ?>
                                                <input type="submit" class="col-xs-12 btn btn-success <?php if(date("Y-m-d H:i:s") >= $this->product->enddate): echo 'disabled'; endif; ?>" value="Buy it now">
                                            <?php else: ?>
											    <input type="submit" id="bidplace" class="col-xs-12 btn btn-success <?php if(date("Y-m-d H:i:s") >= $this->product->product_enddate): echo 'disabled'; endif; ?>" value="Place Bid">
											<?php endif; ?>
											</div>
                                            <div class="form-group col-sm-8 col-sm-offset-3">
												<br/>
                                                <li class="fa fa-eye"></li> <span><a href="<?php echo Config::get('URL'); ?>products/watchlist?id=<?php echo System::escape($this->product->product_id); ?>&add=true"><?php echo System::translate("Add to watch list"); ?> </a></span>
												<Br/><li class="fa fa-gavel"></li> <span><a id="showbids"><?php echo System::translate("Show bids"); ?></a></span>
											</div>
											
                                        </div>
                                    </div>
                                </div>
								
						<div class="ibox-content">
							<div class="row">
								<div class="col-xs-12">
									<tr><td><?php echo System::translate("Postage"); ?>: &nbsp; <?php if($this->product->product_shippingcost == 0): echo '<b>'.System::translate("Free").'</b>'; else: echo '<li class="fa fa-btc"></li> '.System::escape($this->product->product_shippingcost); endif; ?> &nbsp; <?php echo System::escape($this->product->product_shipping); ?> </td></tr>
								</div>
								<div class="col-xs-12">
									<tr><td><?php echo System::translate("Posts to"); ?>: <?php if($this->product->product_international == 1): echo '<b>'.System::translate("International").'</b>'; else: echo System::escape($this->product->product_shipsto); endif; ?> </td></tr> 
								</div>
								<div class="col-xs-12">
									<tr><td><?php echo System::translate("Item Location"); ?>: <?php echo '<b>'.System::escape($this->product->product_location).'</b>'; ?> </td></tr> 
								</div>
							</div>
						    </div>
						    </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-xs-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?php echo System::translate("Listing User"); ?></h5>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-xs-12">
                            <tr><td><?php echo System::translate("User"); ?>: &nbsp; <a href="<?php echo Config::get('URL'); ?>user/profile/<?php echo System::escape($this->product->product_username); ?>"><?php echo System::escape($this->product->product_username); ?></a> &nbsp; (<?php echo $this->feedbacktotal;?>)</td></tr>
                        </div>
						<div class="col-xs-12">
						    <tr><td><?php echo number_format($this->feedbackpercentage,2); ?>% <?php echo System::translate("Positive feedback"); ?></td></tr> 
                        </div>
						<div class="col-xs-12">
						    <tr><td><li class="fa fa-plus"></li> <a href="<?php echo Config::get('URL'); ?>user/follow/<?php echo System::escape($this->productuser->user_id); ?>"><?php echo System::translate("Follow this user"); ?></a></td></tr> 
                        </div>							
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-xs-4">
                            <small class="stats-label"><?php echo System::translate("Positive"); ?></small>
                            <h4><?php echo System::escape($this->productuser->user_positive); ?></h4>
                        </div>
                        <div class="col-xs-4">
                            <small class="stats-label"><?php echo System::translate("Neutral"); ?></small>
                            <h4><?php echo System::escape($this->productuser->user_neutral); ?></h4>
                        </div>
                        <div class="col-xs-4">
                            <small class="stats-label"><?php echo System::translate("Negative"); ?></small>
                            <h4><?php echo System::escape($this->productuser->user_negative); ?></h4>
                        </div>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-xs-6">
                            <small class="stats-label"><?php echo System::translate("Member since"); ?></small>
                            <h4><?php echo date("F jS, Y", strtotime($this->productuser->user_register_date)); ?></h4>
                        </div>
                    </div>
                </div>  					
            </div>
        </div>

    </div>

    <div class="row">

        <div class="col-md-12 col-xs-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?php echo System::translate("Product Description"); ?> </h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-xs-12"><?php echo System::wysiwyg($this->product->product_description); ?></div>
                    </div>	
                </div>
            </div>
        </div>
    </div>
</div>
        
		<!-- related products !-->
		
		<div class="row">
	    <div class="masonry-grid-fitrows row grid-space-20" style="position: relative; height: 801.71875px; margin-top:50px;">
				
		<?php foreach($this->related as $related): ?>
		<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 product-cols first">
        <div class="product-block">
        <div class="image ">
            <span class="product-label product-label-special">
                <span><?php echo System::translate('Related'); ?></span>
            </span>
            <!-- Swap image -->
            <div class="flip">
                <a href="<?php echo Config::get('URL'); ?>products/product/<?php echo System::escape($related->product_id); ?>" class="swap-image">
                <?php $mainimage = explode(",",$this->product->product_images); ?>
					<img height="190" width="226" src="<?php if(!empty($related->product_images)): echo Config::get('URL') .'images/products/'.System::escape($related->product_username). '/item' .System::escape($related->product_id) .'/'. System::escape($mainimage[0]); else: echo Config::get('URL').'images/noimage.jpg'; endif; ?>" class="front">	
                </a>
            </div>
            <!-- /Swap image -->
            <a href="<?php echo Config::get('URL'); ?>products/product/<?php echo System::escape($related->product_id); ?>" class="pav-colorbox btn btn-theme-default cboxElement"><em class="fa fa-plus"></em><span><?php echo System::translate('View Product'); ?></span></a>
        </div>
        <div class="product-meta">
            <div class="left">
                <h3 class="name"><a href="<?php echo Config::get('URL'); ?>products/product/<?php echo System::escape($related->product_id); ?>"><?php echo System::escape($related->product_title); ?></a></h3>
                <div class="price">
                    <span class="price-new"><li class="fa fa-btc"></li> <?php echo System::escape($related->product_price); ?></span>
                </div>
            </div>
            <div class="right">
			<br/>
                <div class="action">
					<br/>
                    <div class="cart">
                        <!-- <input type="button" value="" onclick="addToCart('');" class="product-icon fa fa-shopping-cart shopping-cart" /> -->
                        <button class="btn btn-shopping-cart">
                            <span class="fa fa-shopping-cart product-icon hidden-sm" style="background-color:#59ab02">&nbsp;</span>
                            <span><?php echo System::translate('Add to Cart'); ?></span>
						</button>
                    </div>
                    <div class="button-group">
                        <div class="wishlist">
                            <a title="<?php echo System::translate('Add to Wish List'); ?>" class="fa fa-heart product-icon">
                                <span><?php echo System::translate('Add to Wish List'); ?></span>
                            </a>
                        </div>
                        <div class="compare">
                            <a title="<?php echo System::translate('Add to Watchlist'); ?>" class="fa fa-eye product-icon">
                                <span><?php echo System::translate('Add to Watchlist'); ?></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
			<?php endforeach; ?>
</div>
</div>
</div>		

<script type="text/javascript">
    $("#enddate").countdown("<?php echo $this->product->enddate; ?>", function (event) {
        $(this).text(event.strftime('%D days %H:%M:%S'));
    });
	

function getContent(timestamp)
{
    var queryString = {'timestamp' : timestamp };

    $.ajax(
        {
            type: 'GET',
            url: '<?php echo Config::get('URL'); ?>system/lastbid?item=<?php echo $this->product->id; ?>',
            data: queryString,
            success: function(data){
                var obj = jQuery.parseJSON(data);
                $('#currentbidprice').html(obj.bidamount);
                getContent(obj.timestamp);
            }
        }
    );
}

$(function() {
    getContent();
});

$(document).ready(function(){

});
</script>
