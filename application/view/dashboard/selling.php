<script>
    $(document).ready(function () {
        $('#selling').DataTable({
            responsive: true
        });		
    });
</script>
<div class="col-lg-9">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5><?php echo System::translate("Sell"); ?> </h5>
        </div>
        <div class="ibox-content">
            <table id="selling" class="table table-striped table-bordered table-checks media-table dataTable" style="table-layout: fixed;">                <thead>
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
                            <td>
                                <a href="<?php echo Config::get('URL'); ?>products/product/<?php echo System::escape($products->id); ?>"><?php echo System::escape($products->title); ?></a>
                            </td>
                            <td><?php echo System::escape($products->shortdescription); ?></td>
                            <td>
                    <li class="fa fa-btc"></li>
                    <?php 
						echo System::escape($products->price);
						echo '<br/>';
						if($products->enddate > date("Y-m-d H:i:s")):
							echo '<div id="enddate-'.System::escape($products->id).'"></div>';
						else:
							echo '<span class="info-danger">'.System::translate("Ended").'</span>';
						endif;
						echo '<br/>';

                    if(Request::get('type') == 'sold'):
					
						if($products->orders_shipped != 1): ?>
						<a href="<?php echo Config::get('URL'); ?>orders/dispatched/<?php echo System::escape($products->orders_id); ?>" class="btn btn-success"><?php echo System::translate('Mark as Dispatched'); ?></a><br />
					<?php
					endif;
					?>
							<li class="fa fa-btc" style="color:<?php if($products->orders_status == 1): echo 'black" Title="Paid"'; else: echo '#C8C8C8" Title="Not paid'; endif;?>"></li>
							&nbsp;<li class="fa fa-cube" style="color:<?php if($products->orders_shipped == 1): echo 'black" Title="Dispatched"'; else: echo '#C8C8C8" Title="Not Dispatched'; endif;?>"></li>
							&nbsp;<li class="fa fa-pencil-square-o" style="color:<?php if($products->orders_feedback_buyer == 1): echo 'black" Title="Sent Feedback"'; else: echo '#C8C8C8" Title="Not Sent Feedback"'; endif;?>"></li>
							&nbsp;<li class="fa fa-check" style="color:<?php if($products->orders_feedback_seller == 1): echo 'black" Title="Received Feedback"'; else: echo '#C8C8C8" Title="Not Received Feedback"'; endif;?>"></li>
							&nbsp;<li class="fa fa-archive" style="color:<?php if($products->orders_delivered == 1): echo 'black" Title="Item Received"'; else: echo '#C8C8C8" Title="Item Not Received"'; endif;?>"></li>

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
					
					<?php elseif(Request::get('type') == 'unsold'): ?>
				        <a href="<?php echo Config::get('URL'); ?>dashboard/relist/<?php echo System::escape($products->id); ?>" class="btn btn-success"><?php echo System::translate('Relist'); ?></a>
					<?php elseif(Request::get('type') == 'selling' || Request::get('type') == ''): ?>
					    <a href="<?php echo Config::get('URL'); ?>dashboard/enditem/<?php echo System::escape($products->id); ?>" class="btn btn-danger"><?php echo System::translate('End Item'); ?></a>
					<?php elseif(Request::get('type') == 'sold'): ?>
					    <a href="<?php echo Config::get('URL'); ?>user/leavefeedback/<?php echo System::escape($products->id); ?>" class="btn btn-success"><?php echo System::translate('Leave Feedback'); ?></a>
					<?php endif; ?>
					</td>
                    </tr>
					<script type="text/javascript">
                            $("#enddate-<?php echo System::escape($products->id); ?>").countdown("<?php echo System::escape($products->enddate); ?>", function (event) {
                                $(this).text(event.strftime('%D days %H:%M:%S'));
                            });
					</script>
                <?php endforeach; ?>

                </tbody>
            </table>
        </div>
    </div>
</div>