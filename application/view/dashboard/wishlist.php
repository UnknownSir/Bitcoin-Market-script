<div class="col-lg-12">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5><?php echo System::translate("Wish list"); ?> </h5>
        </div>
        <div class="ibox-content">
            <table id="watching" class="table table-striped table-bordered table-checks media-table dataTable" style="table-layout: fixed;">
                <thead>
                    <tr role="row">
                        <th width="15%"><?php echo System::translate("Image"); ?></th>
                        <th width="25%"><?php echo System::translate("Product"); ?></th>
                        <th width="35%"><?php echo System::translate("Description"); ?></th>
                        <th width="25%"><?php echo System::translate("Info"); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($this->product)): foreach ($this->product as $products): ?>
                        <tr>
                            <td>
							<?php $mainimage = explode(",",$products->images); ?>
							    <img height="115" src="<?php if(!empty($products->images)): echo Config::get('URL') .'images/products/'.System::escape($products->username). '/item' .System::escape($products->id) .'/'. System::escape($mainimage[0]); else: echo Config::get('URL').'images/noimage.jpg'; endif; ?>" class="front">	
                                <td>
                                <a href="<?php echo Config::get('URL'); ?>products/product/<?php echo System::escape($products->id); ?>"><?php echo System::escape($products->title); ?></a>
                            </td>
                            <td><?php echo System::escape($products->shortdescription); ?></td>
                            <td>
                    <?php echo System::escape($products->price); ?><br/>
                   <br/>
					<?php if (date("Y-m-d H:i:s") >= $products->enddate): echo '<span style="color:red;">' . System::translate("Ended") . '</span><br/>';
					else: echo '<div id="productenddate"></div>';
					endif; ?>
					<a href="<?php echo Config::get('URL'); ?>products/wishlist/<?php echo System::escape($products->id); ?>/remove"><?php echo System::translate("Remove from Wishlist"); ?></a>
                    </td>
                    </tr>
					
                    <script type="text/javascript">
                        $("#productenddate").countdown("<?php echo $products->enddate; ?>", function (event) {
                            $(this).text(event.strftime('%D days %H:%M:%S'));
                        });
                    </script>
				<?php endforeach; endif;?>

                </tbody>
            </table>
        </div>
    </div>
</div>