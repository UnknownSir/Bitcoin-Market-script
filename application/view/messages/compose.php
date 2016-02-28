<script src="<?php echo Config::get('URL'); ?>js/plugins/summernote/summernote.min.js"></script>
<link href="<?php echo Config::get('URL'); ?>css/plugins/summernote/summernote.css" rel="stylesheet">
<link href="<?php echo Config::get('URL'); ?>css/plugins/summernote/summernote-bs3.css" rel="stylesheet">
<script>
        $(document).ready(function(){

            TinyMCEStart('#wysiwig_simple', null);

       });
</script>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-content mailbox-content">
                    <div class="file-manager">
                        <a class="btn btn-block btn-primary compose-mail" href="<?php echo Config::get('URL'); ?>messages"><?php echo System::translate("Mail Inbox"); ?></a>
                        <div class="space-25"></div>
                        <h5><?php echo System::translate("Folders"); ?></h5>
                        <ul class="folder-list m-b-md" style="padding: 0">
                            <li><a href="<?php echo Config::get('URL'); ?>messages/"> <i class="fa fa-inbox "></i> <?php echo System::translate("Inbox"); ?> <span class="label label-warning pull-right"><?php echo count($this->inboxmessages); ?></span> </a></li>
                            <li><a href="<?php echo Config::get('URL'); ?>messages/?folder=sent"> <i class="fa fa-envelope-o"></i> <?php echo System::translate("Sent Messages"); ?></a></li>
                            <li><a href="<?php echo Config::get('URL'); ?>messages/?folder=trash"> <i class="fa fa-trash-o"></i> <?php echo System::translate("Trash"); ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9 animated fadeInRight">
            <div class="mail-box-header">
                <div class="pull-right tooltip-demo">
                    <a href="<?php echo Config::get('URL'); ?>messages/" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Discard email"><i class="fa fa-times"></i> <?php echo System::translate("Discard"); ?></a>
                </div>
                <h2>
                    <?php echo System::translate("Compose mail"); ?>
                </h2>
            </div>
            <div class="mail-box">
                <div class="mail-body">
                    <form class="form-horizontal" method="POST" action="<?php echo Config::get('URL'); ?>messages/compose">
					<input type="hidden" name="compose_message" value="1">
                        <div class="form-group"><label class="col-sm-2 control-label"><?php echo System::translate("To"); ?></label>
                            <div class="col-sm-10"><input type="text" name="to" class="form-control" value="<?php echo System::escape($this->to); ?>"></div>
                        </div>
                        <div class="form-group"><label class="col-sm-2 control-label"><?php echo System::translate("Subject"); ?>:</label>
                            <div class="col-sm-10"><input type="text" name="subject" class="form-control" value="<?php echo System::escape($this->subject); ?>"></div>
                        </div><br/>
				<p class="container col-sm-12 row">
<textarea name="content" class="form-control " rows="15" id="wysiwig_simple">
								
		<?php echo System::wysiwyg($this->message); ?>						
								
</textarea>
				</p>
				
            <div class="clearfix"></div>
        <div class="mail-body text-right tooltip-demo">
            <input type="submit" value="<?php echo System::translate("Send"); ?>" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Send">
            <a href="<?php echo Config::get('URL'); ?>messages/" class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Discard email"><i class="fa fa-times"></i><?php echo System::translate("Discard"); ?></a>
        </div>
        <div class="clearfix"></div>
    </div>
	</form>
</div>
</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
	$('#summernote').summernote({
		height: "500px"
	});
});
var postForm = function() {
	var content = $('textarea[name="content"]').html($('#summernote').code());
}
</script>