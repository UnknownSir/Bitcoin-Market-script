<div class="col-xs-12 col-sm-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5><?php echo System::translate('Advanced Search'); ?></</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="form-group" id="data_1">
							
							<?php echo Form::init(Config::get('URL').'products/search', 'GET'); ?>
                                
								<label class="font-noraml"><?php echo System::translate("Keywords"); ?></label>
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
									<?php 
								        echo Form::input('search', 'text', array(
													'class' => 'form-control',
													'value' => System::escape($this->productsearch)
												    ));
							        ?> 
                                </div>
                            </div>

                            <div class="form-group" id="data_2">
                                <label class="font-noraml"><?php echo System::translate("Country"); ?></label>
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-globe"></i></span>
									<select name="country" class="form-control col-sm-12">
									    <?php foreach(System::countries() as $country): ?>
									    <option value="<?=System::escape($country); ?>"><?=System::escape($country); ?></option>
									    <?php endforeach; ?>
									</select>
                                </div>
                            </div>

                            <div class="form-group" id="data_2">
                                <label class="font-noraml"><?php echo System::translate("Categories"); ?></label>
                                <div class="input-group date">							
								<?php 
									Form::categories();
								?>						
                                </div>
                            </div>
							
                            <div class="form-group" id="data_3">
                                <label class="font-noraml"><?php echo System::translate('International Shipping'); ?></label>
									<select name="international" class="form-control m-b">
										<option value=""> <?php echo System::translate('All'); ?></option>
										<option value="international"> <?php echo System::translate('International'); ?></option>
										<option value="local"> <?php echo System::translate('Local'); ?></option>
									</select>
                            </div>

                            <div class="form-group" id="data_5">
                                <label class="font-noraml"><?php echo System::translate('Item Condition'); ?></label>
                                <div class="input-group col-sm-12">
                                    <select name="condition" class="form-control m-b">
										<option value=""><?php echo System::translate('All'); ?></option>
										<option value="new"> <?php echo System::translate('New'); ?></option>
										<option value="likenew"> <?php echo System::translate('Like New'); ?></option>
										<option value="used"> <?php echo System::translate('Used'); ?></option>
										<option value="spares"> <?php echo System::translate('Spares and repair'); ?></option>
									</select>
								</div>
                            </div>
		                    <div class="form-group" id="data_5">
							<?php 
								echo Form::input('', 'submit', array(
													'value' => System::translate('Search'),
													'class' => 'btn btn-success'
												    ));
							?>
							</div>					
                        </div>
                    </div>
                </div>

				
<?php
	
$nb_elem_per_page = 10;
$page = (Request::Get('page') == true) ? intval(Request::Get('page')-1):0;
$data = (array)$this->products;
$number_of_pages = intval(count($data)/$nb_elem_per_page)+1;

foreach (array_slice($data, $page*$nb_elem_per_page, $nb_elem_per_page) as $products) { 
?>

	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 product-cols first">
    <div class="product-block">
        <div class="image ">
            <span class="product-label product-label-special">
                <span><?php echo System::translate('Item'); ?></span>
            </span>
            <!-- Swap image -->
            <div class="flip">
                <a href="<?php echo Config::get('URL'); ?>products/product/<?php echo System::escape($products->product_id); ?>" class="swap-image">
                    <?php $mainimage = explode(",",$products->product_images); ?>
					<img height="190" width="226" src="<?php if(!empty($products->product_images)): echo Config::get('URL') .'images/products/'.System::escape($products->product_username). '/item' .System::escape($products->product_id) .'/'. System::escape($mainimage[0]); else: echo Config::get('URL').'images/noimage.jpg'; endif; ?>" class="front">	
                </a>
            </div>
            <!-- /Swap image -->
            <a href="<?php echo Config::get('URL'); ?>products/product/<?php echo System::escape($products->product_id); ?>" class="pav-colorbox btn btn-theme-default cboxElement"><em class="fa fa-plus"></em><span><?php echo System::translate('View Product'); ?></span></a>
        </div>
        <div class="product-meta">
            <div class="left">
                <h3 class="name"><a href="<?php echo Config::get('URL'); ?>products/product/<?php echo System::escape($products->product_id); ?>"><?php echo System::escape($products->product_title); ?></a></h3>
                <div class="price">
                    <span class="price-new"><li class="fa fa-btc"></li><?php echo System::escape($products->product_price); ?></span>
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
                        <!-- <input type="button" value="" onclick="addToCart('');" class="product-icon fa fa-shopping-cart shopping-cart" /> -->
                        <button class="btn btn-shopping-cart">
                            <span class="fa fa-shopping-cart product-icon hidden-sm" style="background-color:#59ab02">&nbsp;</span>
                            <span><?php echo System::translate('Add to Cart'); ?></span>
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

<?php } ?>

<ul class="pagination">
<?php
for($i = 1; $i <= $number_of_pages; $i++) {
?>
    <li><a href='<?php echo $_SERVER['REQUEST_URI']; ?>&page=<?php echo System::escape($i);?>'><?php echo System::escape($i);?></a></li>
<?php } ?>
</ul>