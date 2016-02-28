<script type="text/javascript">
    jQuery(document).ready(function ($)
    {
        $("#transactions").dataTable(
                {
                    aLengthMenu: [
                        [10, 25, 50, 100, -1],
                        [10, 25, 50, 100, "All"]
                    ]
                });
    });
    function CopyToClipboard()
    {
        document.getElementById('wallet').focus();
        document.getElementById('wallet').select();
    }
</script>
<div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5><?php echo System::translate("Withdraw Bitcoin"); ?> <small class="m-l-sm">This is custom panel</small></h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
				<table class="table table-hover">

        <div class="col-sm-4 col-sm-offset-4">
            <img src="https://www.google.com/chart?cht=qr&chs=300x300&chl=<?php echo strtolower($market); ?>%3A<?php echo $deposit; ?>">
        </div>
        <div class="col-sm-6 col-sm-offset-3">
            <div class="input-group">
                <input type="text" value="<?php echo $deposit; ?>" id="wallet" class="form-control">
                <span class="input-group-addon">
                    <span onClick="CopyToClipboard();
                            return false" style="cursor: pointer; cursor: hand; "><?php System::translate("Copy"); ?></span> </a>
                </span>
                <span class="input-group-addon">
                    <a href="<?php echo Config::get('URL'); ?>coins/GenerateWallet?coin=btc"><span onClick="CopyToClipboard();
                            return false" style="cursor: pointer; cursor: hand; "><?php System::translate("New Address"); ?></span> </a>
                </span>
            </div>
        </div>
        <br/>
    </div>
    <table class="table table-bordered table-striped dataTable no-footer" id="transactions" role="grid" aria-describedby="transactions_info">
        <thead>
            <tr role="row">
                <th class="sorting" tabindex="0" aria-controls="transactions" rowspan="1" colspan="1" aria-label="<?php System::translate(" Address "); ?>: <?php System::translate("activate to sort column ascending "); ?>" style="width: 111px;">
					<?php echo System::translate("Address"); ?>
                </th>
                <th class="sorting" tabindex="0" aria-controls="transactions" rowspan="1" colspan="1" aria-label="<?php System::translate(" Transaction ID "); ?>: <?php System::translate("activate to sort column ascending "); ?>" style="width: 111px;">
					<?php echo System::translate("Transaction ID"); ?>
                </th>
                <th class="sorting" tabindex="0" aria-controls="transactions" rowspan="1" colspan="1" aria-label="<?php System::translate(" Amount "); ?>: <?php System::translate("activate to sort column ascending "); ?>" style="width: 55px;">
					<?php echo System::translate("Amount"); ?>
                </th>
                <th class="sorting" tabindex="0" aria-controls="transactions" rowspan="1" colspan="1" aria-label="<?php System::translate(" Date "); ?>:  <?php System::translate("activate to sort column ascending "); ?>" style="width: 81px;">
					<?php echo System::translate("Date"); ?>
                </th>
                </th>
            </tr>
        </thead>
        <tbody class="middle-align">
<?php foreach ($deposits as $r) { ?>
                <tr role="row" class="odd">
                    <td>
                        <?php echo $r->wallet; ?></td>
                    <td>
                        <?php echo $r->txid; ?></td>
                    <td>
                        <?php echo $r->amount; ?></td>
                    <td>
                <?php echo $r->date; ?></td>
                </tr>
<?php } ?>
        </tbody>
    </table>
</div>
</div>
</div>
</div>
</div>