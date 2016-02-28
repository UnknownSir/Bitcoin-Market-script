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
                <h2>
                   <?php echo System::translate('Inbox'); ?>
                </h2>
				<!--
				<div class="mail-tools tooltip-demo m-t-md">
                    <div class="btn-group pull-right">
                        <button class="btn btn-white btn-sm"><i class="fa fa-arrow-left"></i></button>
                        <button class="btn btn-white btn-sm"><i class="fa fa-arrow-right"></i></button>
                    </div>
                    <button class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="left" title="Refresh inbox"><i class="fa fa-refresh"></i> Refresh</button>
                    <button class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Mark as read"><i class="fa fa-eye"></i> </button>
                    <button class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Mark as important"><i class="fa fa-exclamation"></i> </button>
                    <button class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Move to trash"><i class="fa fa-trash-o"></i> </button>

                </div>
				!-->
            </div>
            

                <div class="mail-box">

                <table class="table table-hover table-mail">
                <tbody>
				<?php foreach ($this->messages as $message): ?>
                <tr class="<?php if($message->message_read == 1): echo 'read'; else: echo 'unread'; endif; ?>">
                    <td class="check-mail">
                        <input type="checkbox" name="message" class="i-checks">
                    </td>
                    <td class="mail-ontact"><a href="<?php echo Config::get('URL'); ?>messages/message/<?php echo System::escape($message->id); ?>"><?php if(Request::get('folder') == '' || Request::get('folder') == 'trash'): echo System::escape($message->messagefrom); else: echo System::translate('Sent'); endif; ?></a></td>
                    <td class="mail-subject"><a href="<?php echo Config::get('URL'); ?>messages/message/<?php echo System::escape($message->id); ?>"><?php echo System::escape($message->subject); ?></a></td>
                    <td class="text-right mail-date"><?php echo System::escape($message->message_date); ?></td>
                </tr>  
				<?php endforeach; ?>
                </tbody>
                </table>
				
                </div>
            </div>
        </div>
       </div>
	 </div>