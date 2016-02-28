<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $("#tickets").dataTable({
            aLengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]
        });
    });
</script>
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
        <table style="margin-top:75px;" class="table table-bordered dataTable no-footer"  id="tickets">
            <thead>
            <td>
                <?php echo System::translate("ID"); ?>
            </td>
            <td>
                <?php echo System::translate("Title"); ?>
            </td>
            <?php if (Usersmodel::isstaff() == true): ?> 
                <td>
                    <?php echo System::translate("User"); ?>
                </td>
            <?php endif; ?>
            <td>
                <?php echo System::translate("Status"); ?>
            </td>
            <td>
                <?php echo System::translate("Last update"); ?>
            </td>
            </thead>
            <tbody>
                <?php foreach ($this->tickets as $ticket): ?>
                    <tr>
                        <td>
                            <?php echo System::escape($ticket->support_id); ?>
                        </td>
                        <td>
                            <?php echo '<a href="' . Config::get('URL') . 'support/ticket/?id=' . System::escape($ticket->support_id) . '">' . System::escape($ticket->support_title) . '</a>'; ?>
                        </td>

                        <?php if (Usersmodel::isstaff() == true): ?> 

                            <td>
                                <?php echo System::escape($ticket->support_username); ?>
                            </td>
                        <?php endif; ?>
                        <td>
                            <?php if ($ticket->support_status == 0) {
                                echo '<span class="label label-success">Open</span>';
                            } else {
                                echo '<span class="label label-danger">closed</span>';
                            } ?>
                        </td>
                        <td>
							<?php echo System::escape($ticket->support_lastupdate); ?>
                        </td>
                    </tr>
<?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</section>