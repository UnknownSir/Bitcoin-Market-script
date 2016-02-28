<script>
    $(document).ready(function () {
        $('#purchased').DataTable({
            responsive: true
        });		
    });
</script>
<div class="col-lg-9">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5><?php echo System::translate("Purchased"); ?> </h5>
            <div class="ibox-tools">
                <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                </a>
                <a class="close-link">
                    <i class="fa fa-times"></i>
                </a>
            </div>
        </div>
        <div class="ibox-content">
            <table id="purchased" class="table table-striped table-bordered table-checks media-table dataTable" style="table-layout: fixed;">                <thead>
                    <tr role="row">
                        <th width="15%"><?php echo System::translate("Image"); ?></th>
                        <th width="25%"><?php echo System::translate("Product"); ?></th>
                        <th width="35%"><?php echo System::translate("Description"); ?></th>
                        <th width="25%"><?php echo System::translate("Info"); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($this->product as $products): ?>
                    <tr>
                        <td>
						<?php $mainimage = explode(",",$products->images); ?>
							<img height="115" src="<?php if(!empty($products->images)): echo Config::get('URL') .'images/products/'.System::escape($products->username). '/item' .System::escape($products->id) .'/'. System::escape($mainimage[0]); else: echo Config::get('URL').'images/noimage.jpg'; endif; ?>" class="front">	
						</td>
                        <td>
                            <a href="<?php echo Config::get('URL'); ?>products/product/<?php echo System::escape($products->id); ?>"><?php echo System::escape($products->title); ?></a>
                            <br/> (<?php echo System::escape($products->id); ?>)
                            <br/>
                            <a href="<?php echo Config::get('URL'); ?>user/profile/<?php echo System::escape($products->username); ?>">
                                <?php echo System::escape($products->username); ?>
                            </a>
						</td>
                        <td>
							<?php echo System::escape($products->shortdescription); ?></td>
                        <td>
						<li class="fa fa-btc"></li>
					  <?php 
							echo System::escape($products->orders_amount);
							echo '<Br/><span style="color:red;">' . System::translate("Ended") . '</span><br/>';
							?>
							<li class="fa fa-btc" style="color:<?php if($products->orders_status == 1): echo 'black" Title="Paid"'; else: echo '#C8C8C8" Title="Not paid'; endif;?>"></li>
							&nbsp;<li class="fa fa-cube" style="color:<?php if($products->orders_shipped == 1): echo 'black" Title="Dispatched"'; else: echo '#C8C8C8" Title="Not Dispatched"'; endif;?>"></li>
							&nbsp;<li class="fa fa-pencil-square-o" style="color:<?php if($products->orders_feedback_buyer == 1): echo 'black" Title="Sent Feedback"'; else: echo '#C8C8C8" Title="Not Sent Feedback"'; endif;?>"></li>
							&nbsp;<li class="fa fa-check" style="color:<?php if($products->orders_feedback_seller == 1): echo 'black" Title="Received Feedback"'; else: echo '#C8C8C8" Title="Not Received Feedback"'; endif;?>"></li>
							&nbsp;<li class="fa fa-archive" style="color:<?php if($products->orders_delivered == 1): echo 'black" Title="Item Received"'; else: echo '#C8C8C8" Title="Item Not Received"'; endif;?>"></li>

							<br/><br/>
							<?php if($products->orders_delivered != 1) : ?>
								<a  href="<?php echo Config::get('URL'); ?>orders/received/<?php echo System::escape($products->orders_id); ?>" class="btn btn-info"><?php echo System::translate('Mark As Received'); ?></a>
							    <br>
                            <?php endif; ?>
							
							<div class="ibox-tools col-sm-12">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <?php echo System::translate("More action"); ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
									<a href="<?php echo Config::get('URL'); ?>orders/order/<?php echo System::escape($products->orders_id); ?>"><?php echo System::translate("View Order"); ?></a>
                                </li>
                                <li>
									<a href="<?php echo Config::get('URL'); ?>orders/feedback/<?php echo System::escape($products->orders_id); ?>"><?php echo System::translate("Leave Feedback"); ?></a>
                                </li>
                                <li>
									<a href="<?php echo Config::get('URL'); ?>messages/compose/<?php echo System::escape($products->username); ?>"><?php echo System::translate("Contact Seller"); ?></a>
                                </li>
                                <li>
									<a href="<?php echo Config::get('URL'); ?>user/follow/<?php echo System::escape($products->username); ?>"><?php echo System::translate("Follow Seller"); ?></a>
                                </li>								
                            </ul>

                        </div>
							
							</td>
					</td>
                    </tr>
			<?php endforeach; ?>

                </tbody>
            </table>
        </div>
    </div>
</div>