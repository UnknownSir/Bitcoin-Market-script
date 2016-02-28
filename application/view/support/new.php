<script src="<?php echo Config::get('URL'); ?>js/wysihtml5/lib/js/wysihtml5-0.3.0.js" id="script-resource-7"></script>
<script src="<?php echo Config::get('URL'); ?>js/wysihtml5/src/bootstrap-wysihtml5.js" id="script-resource-8"></script>
<link rel="stylesheet" href="<?php echo Config::get('URL'); ?>js/wysihtml5/src/bootstrap-wysihtml5.css" id="style-resource-1">
<div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-content mailbox-content">
                        <div class="file-manager">
                            <a class="btn btn-block btn-primary compose-mail" href="<?php echo Config::get('URL'); ?>support/newticket"><?php echo System::translate("Open Ticket"); ?></a>
                            <div class="space-25"></div>
                            <h5><?php echo System::translate("Ticket"); ?></h5>
                            <ul class="folder-list m-b-md" style="padding: 0">
                                <li><a href="<?php echo Config::get('URL'); ?>support/"> <i class="fa fa-inbox "></i> <?php echo System::translate("All Tickets"); ?> </a></li>
                                <li><a href="<?php echo Config::get('URL'); ?>support/?type=open"> <i class="fa fa-envelope-o"></i> <?php echo System::translate("Open Tickets"); ?></a></li>
                                <li><a href="<?php echo Config::get('URL'); ?>support/?type=closed"> <i class="fa fa-trash-o"></i> <?php echo System::translate("Closed Tickets"); ?></a></li>
                                <?php if (Usersmodel::isstaff() == true): ?> <li> <a href="<?php echo Config::get('URL'); ?>support/admin"><?php echo System::translate("Admin"); ?></a> </li> <?php endif; ?>
							</ul>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
      <div class="col-sm-9 mailbox-right panel">
<div class="modal-body">
  <div class="form-group">
  <form role="form" method="post">
  <input type="hidden" name="check_submit" value="1">
    <label for="title"><?php echo System::translate("Title"); ?>:</label>
    <input class="form-control" name="title" type="text" id="title">
  </div>
  <div class="form-group">
    <label for="client"><?php echo System::translate("Category"); ?>:</label>
    <select name="category" class="form-control">
      <option value="account"><?php echo System::translate("Account"); ?></option>
      <option value="general"><?php echo System::translate("General Enquiries"); ?></option>
	  <option value="technical"><?php echo System::translate("Technical Department"); ?></option>
	  <option value="nonpayment"><?php echo System::translate("Non-payment"); ?></option>
	  <option value="nondelivery"><?php echo System::translate("Non-delivery"); ?></option>
    </select>
  </div>

  <div class="form-group">
    <label for="status"><?php echo System::translate("Status"); ?>:</label>
    <select name="status" class="form-control">
      <option value="basic"><?php echo System::translate("Basic"); ?></option>
      <option value="medium"><?php echo System::translate("Medium"); ?></option>
	  <option value="urgent"><?php echo System::translate("Urgent"); ?></option>
    </select>
  </div>
  <div class="form-group">
    <textarea class="form-control wysihtml5" name="message"></textarea>
  </div>
<div class="modal-footer clearfix">
    <button type="button" class="btn btn-danger" data-dismiss="modal">
	<i class="fa fa-times"></i>Discard
    </button>
    <button type="submit" class="btn btn-primary pull-left" style="background-color: #428bca;">
	<i class="fa fa-envelope"></i>Submit Ticket
    </button>
	</form>
</div>
<br />