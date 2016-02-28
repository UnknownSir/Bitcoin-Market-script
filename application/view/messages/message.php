<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-content mailbox-content">
                    <div class="file-manager">
                        <a class="btn btn-block btn-primary compose-mail" href="<?php echo Config::get('URL'); ?>messages/compose"><?php echo System::translate("Compose Mail"); ?></a>
                        <div class="space-25"></div>
                        <h5><?php echo System::translate("Folders"); ?></h5>
                        <ul class="folder-list m-b-md" style="padding: 0">
                            <li><a href="<?php echo Config::get('URL'); ?>messages/"> <i class="fa fa-inbox "></i> <?php echo System::translate("Inbox"); ?> <span class="label label-warning pull-right"><?php echo count($this->inboxmessages); ?></span> </a></li>
                            <li><a href="<?php echo Config::get('URL'); ?>messages/?folder=sent"> <i class="fa fa-envelope-o"></i> <?php echo System::translate("Sent messages"); ?></a></li>
                            <li><a href="<?php echo Config::get('URL'); ?>messages/?folder=trash"> <i class="fa fa-trash-o"></i> <?php echo System::translate("Trash"); ?></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-9 animated fadeInRight">
            <div class="mail-box-header">
                <div class="pull-right tooltip-demo">
                    <a href="<?php echo Config::get('URL'); ?>messages/compose/<?php echo System::escape($this->messages->messagefrom); ?>/re: <?php echo System::escape($this->messages->subject); ?>" class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Reply"><i class="fa fa-reply"></i> <?php echo System::translate('Reply'); ?></a>
                    <a href="<?php echo Config::get('URL'); ?>messages/deletemessage/<?php echo System::escape($this->messages->id); ?>/trash" class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Move to trash"><i class="fa fa-trash-o"></i> </a>
                    <a href="<?php echo Config::get('URL'); ?>messages/deletemessage/<?php echo System::escape($this->messages->id); ?>/delete" class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Delete Message"><i class="fa fa-trash-o"></i> </a> 
 </div>
                <h2>
                    <?php echo System::translate('Viewing message'); ?>
                </h2>
                <div class="mail-tools tooltip-demo m-t-md">
                    <h3>
                        <span class="font-noraml"><?php echo System::translate('Subject'); ?></span> <?php echo System::escape($this->messages->subject); ?>
                    </h3>
                    <h5>
                        <span class="pull-right font-noraml"><?php echo System::escape($this->messages->message_date); ?></span>
                        <span class="font-noraml"><?php echo System::translate('From'); ?>: </span><?php echo System::escape($this->messages->messagefrom); ?>
                    </h5>
                </div>
            </div>
            <div class="mail-box">
                <div class="mail-body">
                    <?php echo System::wysiwyg($this->messages->message); ?>
                </div>
            </div>		
		</div>
	</div>
</div>