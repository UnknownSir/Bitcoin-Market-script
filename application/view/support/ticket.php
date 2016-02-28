<script src="<?php echo Config::get('URL'); ?>js/wysihtml5/lib/js/wysihtml5-0.3.0.js" id="script-resource-7"></script>
<script src="<?php echo Config::get('URL'); ?>js/wysihtml5/src/bootstrap-wysihtml5.js" id="script-resource-8"></script>
<link rel="stylesheet" href="<?php echo Config::get('URL'); ?>js/wysihtml5/src/bootstrap-wysihtml5.css" id="style-resource-1">

<div class="wrapper wrapper-content">
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
        <div class="mail-single">
            <!-- Email Title and Button Options -->
            <div class="mail-single-header">
                <h2><?php echo System::escape($this->tickets->support_title); ?>
                    <span class="badge badge-success badge-roundless pull-right upper">
                        <?php echo System::escape($this->tickets->support_category); ?></span>
                    <a href="<?php echo Config::get('URL'); ?>support" class="go-back">
                        <i class="fa-angle-left"></i>Go Back</a></h2>
            </div>
            <div class="mail-single-info">
                <div class="mail-single-info-user dropdown">
                    <em class="time"><?php echo System::escape($this->tickets->support_date); ?></em>
                </div>
            </div>
            <div class="mail-single-body">
                <?php echo System::wysiwyg($this->tickets->support_message); ?>
            </div>
        </div>
    </div>
    <?php foreach ($this->ticketreply as $ticket): ?>

        <div class="col-sm-9 mailbox-right">
            <div class="mail-single">
                <div class="mail-single-info">
                    <div class="mail-single-info-user dropdown">
                        <em class="time"><?php echo System::escape($ticket->ticket_date); ?></em> 
                    </div>
                </div>
                <div class="mail-single-body">
                    <?php echo System::wysiwyg($ticket->ticket_message); ?>
                </div>
            </div>
        </div>



    <?php endforeach;
    if ($this->tickets->support_status == 0): ?>
        <div class="col-sm-9 mailbox-right">
            <div class="form-group">
                <form role="form" action="<?php echo Config::get('URL'); ?>support/reply" method="post">
                    <input type="hidden" name="check_submit" value="1">
                    <!-- you can try to change this but if you don't own the ticket it won't work, nice try. !-->
                    <input type="hidden" name="ticket" value="<?php echo System::escape($tickets->id); ?>">
                    <textarea name="message" class="form-control wysihtml5"> 
                    </textarea>
            </div>
            <div class="modal-footer clearfix">
                <button type="submit" class="btn btn-primary pull-left" style="background-color: #428bca;">
                    <i class="fa fa-envelope"></i><?php echo System::translate("Submit Ticket"); ?>
                </button>
				<?php if (UsersModel::isstaff() == true): ?> 
                    <a href="<?php echo Config::get('URL'); ?>support/resolved?id=<?php echo System::escape($tickets->support_id); ?>&ticket=close" type="submit" class="btn btn-primary pull-right" style="background-color: #428bca;">
                        <i class="fa fa-tick"></i><?php echo System::translate("Ticket Resolved"); ?>
                    </a>
				<?php endif; ?>
            </div>
            </form>
        </div>
    <?php endif;
    if (UsersModel::isstaff() == true && $this->tickets->support_status == 1):
        ?> 
        <div class="col-sm-9 mailbox-right">
            <div class="modal-footer clearfix">
                <a href="<?php echo Config::get('URL'); ?>support/resolved?id=<?php echo System::escape($this->tickets->id); ?>&ticket=open" type="submit" class="btn btn-primary pull-right" style="background-color: #428bca;">
                    <i class="fa fa-tick"></i><?php echo System::translate("Open Ticket"); ?>
                </a>
            </div>
        </div>
<?php endif; ?>