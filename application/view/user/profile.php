<script>
    $(document).ready(function () {
        $('#feedback').DataTable({
            responsive: true
        });
</script>
<div class="wrapper wrapper-content">
    <div class="animated fadeInRight">
        <div class="col-md-4">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?php echo System::translate("Profile Details"); ?></h5>
                </div>
                <div>
                    <div class="ibox-content no-padding border-left-right">
                        <img alt="image" class="img-responsive" src="http://webapplayers.com/inspinia_admin-v1.9.2/img/profile_big.jpg">
                    </div>
                    <div class="ibox-content profile-content">
                        <h4><strong><?php echo System::escape(ucwords($this->userinfo->user_username)); ?></strong></h4>
                        <p><i class="fa fa-map-marker"></i> <?php echo System::escape($this->userinfo->user_country); ?></p>
                        <h5>
                            <?php echo System::translate("About me"); ?>
                        </h5>
                        <p>
                            <?php echo System::escape($this->userinfo->user_about); ?>
                        </p>
                        <div class="row m-t-md">
                            <div class="col-xs-4">
                                <li class="fa fa-arrow-up fa-2x" style="color:green"></li>
                                <h5><strong><?php echo System::escape($this->userinfo->user_positive); ?></strong> <?php echo System::translate("Positive"); ?></h5>
                            </div>
                            <div class="col-xs-4">
                                <li class="fa fa-arrow-right fa-2x" style="color:orange"></li>
                                <h5><strong><?php echo System::escape($this->userinfo->user_neutral); ?></strong> <?php echo System::translate("Neutral"); ?></h5>
                            </div>
                            <div class="col-xs-4">
                                <li class="fa fa-arrow-down fa-2x" style="color:red"></li>
                                <h5><strong><?php echo System::escape($this->userinfo->user_negative); ?></strong> <?php echo System::translate("Negative"); ?></h5>
                            </div>
                        </div>
                        <div class="user-button">
                            <div class="row">
                                <div class="col-md-6">
                                    <a class="btn btn-primary btn-sm btn-block btn-message" href="<?php echo Config::get('URL') . 'messages/compose/' . System::escape($this->userinfo->username); ?>"><?php echo System::translate("Send message"); ?></a>
                                </div>
                                <div class="col-md-6">
                                    <a class="btn btn-default btn-sm btn-block" href="<?php echo Config::get('URL') . 'user/follow/' . System::escape($this->userinfo->id); ?>"><?php echo System::translate("Follow user"); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?php echo System::translate("WishList"); ?></h5>
                </div>
                <div>
                    <div class="ibox-content no-padding border-left-right">
                        <div class="col-sm-12 ibox-content">
                            <table>
                                <?php if (isset($this->wishlist)): foreach ($this->wishlist as $wishlist): ?>
								<div class="col-sm-6">
								<div class="row text-center">
                                   <div class="col-sm-12"> <a href="<?php echo Config::get('URL'); ?>product/<?php echo System::escape($wishlist->id); ?>"><?php echo System::escape($wishlist->title); ?></div>
                                   <div class="col-sm-12"> 
								   	<?php $mainimage = explode(",",$wishlist->images); ?>
										<img class="col-sm-12" src="<?php if(!empty($wishlist->images)): echo Config::get('URL') .'images/products/'.System::escape($wishlist->username). '/item' .System::escape($wishlist->id) .'/'. System::escape($mainimage[0]); else: echo Config::get('URL').'images/noimage.jpg'; endif; ?>" class="front">	
									</div>
                                   <div class="col-sm-12"> <br/><li class="fa fa-btc"></li> <?php echo System::escape($wishlist->price); ?></div>
								   <div class="col-sm-12"> <br/><a href="<?php echo Config::get('URL'); ?>dashboard/checkout/<?php echo System::escape($wishlist->id); ?>/<?php echo System::escape($this->userinfo->username); ?>/wishlist" class="btn btn-primary btn-sm btn-block btn-message"><?php echo System::translate('Purchase for'); ?></a></div>
                                </div>  
								</div>
									<?php endforeach;
                                endif; ?>
                            </table>
                        </div>
                    </div>
                    <div class="ibox-content profile-content">

                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">

<?php foreach ($this->recentitems as $products): ?>

 <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12 product-cols first">
    <div class="product-block">
        <div class="image ">
            <span class="product-label product-label-special">
                <span><?php echo System::translate('NEW'); ?></span>
            </span>
            <!-- Swap image -->
            <div class="flip">
                <a href="<?php echo Config::get('URL'); ?>products/product/<?php echo System::escape($products->product_id); ?>" class="swap-image">
					<?php $mainimage = explode(",",$products->product_images); ?>
					<img height="190" width="226" src="<?php if(!empty($products->images)): echo Config::get('URL') .'images/products/'.System::escape($products->product_username). '/item' .System::escape($products->product_id) .'/'. System::escape($mainimage[0]); else: echo Config::get('URL').'images/noimage.jpg'; endif; ?>" class="front">	
                </a>
            </div>
            <!-- /Swap image -->
            <a href="<?php echo Config::get('URL'); ?>products/product/<?php echo System::escape($products->product_id); ?>" class="pav-colorbox btn btn-theme-default cboxElement"><em class="fa fa-plus"></em><span><?php echo System::translate('View Product'); ?></span></a>
        </div>
        <div class="product-meta">
            <div class="left">
                <h3 class="name"><a href="<?php echo Config::get('URL'); ?>products/product/<?php echo System::escape($products->product_id); ?>"><?php echo System::escape($products->product_title); ?></a></h3>
                <div class="price">
                    <span class="price-new"><li class="fa fa-btc"></li> <?php echo System::escape($products->product_price); ?></span>
                </div>
            </div>
            <div class="right">
			<br/>
                <p class="description">
                   <?php echo System::escape($products->product_shortdescription); ?>
                </p>
                <div class="action">
					<br/>
                    <div class="cart">
                        <button class="btn btn-shopping-cart">
                            <span class="fa fa-shopping-cart product-icon hidden-sm" style="background-color:#59ab02">&nbsp;</span>
                            <span><a href="<?php echo Config::get('URL'); ?>dashboard/addtobasket/<?php echo System::escape($products->product_id);?>"><?php echo System::translate('Add to Cart'); ?></a></span>
						</button>
                    </div>
                    <div class="button-group">
                        <div class="wishlist">
                            <a href="<?php echo Config::get('URL'); ?>products/wishlist/<?php echo System::escape($products->product_id); ?>/add" title="<?php echo System::translate('Add to Wish List'); ?>" class="fa fa-heart product-icon">
                                <span><?php echo System::translate('Add to Wish List'); ?></span>
                            </a>
                        </div>
                        <div class="compare">
                            <a href="<?php echo Config::get('URL'); ?>products/watchlist/<?php echo System::escape($products->product_id); ?>/add" title="<?php echo System::translate('Add to Watchlist'); ?>" class="fa fa-eye product-icon">
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
                            </tbody>
                        </table>
                    </div>    

<div class="col-sm-12" style="padding-top:25px;">
<div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?php echo System::translate("Feedback"); ?></h5>
                </div>
    <div class="ibox-content">
	
	<table id="feedback" class="table table-striped table-bordered table-checks media-table dataTable">
		<thead>
		<tr role="row">
			<th><?php echo System::translate("Product"); ?></th>
			<th><?php echo System::translate("Username"); ?></th>
			<th><?php echo System::translate("Feedback Description"); ?></th>
			<th><?php echo System::translate("Feedback Type"); ?></th>
		</tr>
		</thead>
		<tbody>
		<?php foreach($this->feedback as $feedback): ?>
			<tr>
				<td><?php echo System::escape($feedback->feedback_order); ?></td>
				<td><?php echo System::escape($feedback->feedback_username); ?></td>
				<td><?php echo System::escape($feedback->feedback_description); ?></td>
				<td><?php 
				if(System::escape($feedback->feedback_type == 'Positive')): 
					echo '<font color="green">'.System::escape($feedback->feedback_type).'</font>'; 
			    elseif(System::escape($feedback->feedback_type == 'Neutral')): 
					echo '<font color="blue">'.System::escape($feedback->feedback_type).'</font>'; 
			    else: 
					echo '<font color="red">'.System::escape($feedback->feedback_type).'</font>'; 
				endif; ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
           </div>					
        </div>
    </div>
</div>