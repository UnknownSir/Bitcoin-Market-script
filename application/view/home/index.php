<div id="carousel-example-generic" class="carousel slide" data-ride="carousel" style="margin-top:50px;">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
        <li data-target="#carousel-example-generic" data-slide-to="1"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
        <div class="item active">
            <img src="<?php echo Config::get('URL'); ?>images/slider1.jpg" alt="slider1">
            <div class="carousel-caption">
               
            </div>
        </div>
        <div class="item">
            <img src="<?php echo Config::get('URL'); ?>images/slider2.png" alt="slider2">
            <div class="carousel-caption">
                
            </div>
        </div>
        ...
    </div>

    <!-- Controls -->
    <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>


<div class="row" id="Container">
    <?php foreach ($this->products as $products): ?>
	
<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 product-cols first">
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
                <p style="display: inline-block !important;" class="description">
                   <?php echo System::escape($products->product_shortdescription); ?>
                </p>
                <div class="action">
					<br/>
                    <div class="cart">
                        <button class="btn btn-shopping-cart">
						<?php if($products->product_buyitnow == 1): ?>
                            <span class="fa fa-shopping-cart product-icon hidden-sm" style="background-color:#59ab02">&nbsp;</span>
                            <span><a href="<?php echo Config::get('URL'); ?>dashboard/addtobasket/<?php echo System::escape($products->product_id);?>"><?php echo System::translate('Add to Cart'); ?></a></span>
                        <?php else: ?>
						    <span class="fa fa-shopping-cart product-icon hidden-sm" style="background-color:#59ab02"><a href="<?php echo Config::get('URL'); ?>products/product/<?php echo System::escape($products->product_id); ?>">&nbsp;</a></span>
                            <span><a href="<?php echo Config::get('URL'); ?>products/product/<?php echo System::escape($products->product_id); ?>"><?php echo System::translate('Bid On Item'); ?></a></span>
						<?php endif; ?>
						</button>
                    </div>
                    <div class="button-group">
                        <div class="wishlist">
                            <a href="<?php echo Config::get('URL'); ?>products/wishlist/<?php echo System::escape($products->product_id); ?>/add" title="<?php echo System::translate('Add to Wish List'); ?>" class="fa fa-heart product-icon">
                                <span><?php echo System::translate('Add to Wish List'); ?></span>
                            </a>
                        </div>
                        <div class="compare">
                            <a href="<?php echo Config::get('URL'); ?>products/watchlist/<?php echo System::escape($products->id); ?>/add" title="<?php echo System::translate('Add to Watchlist'); ?>" class="fa fa-eye product-icon">
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