<script type="text/javascript">
    function CopyToClipboard()
    {
        document.getElementById('wallet').focus();
        document.getElementById('wallet').select();
    }
    function add_payee(a) {
        $('#address').val(a)
    }
    jQuery(document).ready(function ($)
    {
        $('.linkaddress').click(function (e) {
            e.preventDefault();
        });
        $('#amount').keyup(function ()
        {
            var total = $('#amount').val() - $('#fee').val();
            if (isNaN(total) == true)
            {
                var total = 0;
            }
            if (typeof total != 'undefined')
            {
                $('#total').val(total)
            }
        });
        $("#transactions").dataTable(
                {
                    aLengthMenu: [
                        [10, 25, 50, 100, -1],
                        [10, 25, 50, 100, "All"]
                    ]
                });
    });
</script>
<div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5><?php echo System::translate("Withdraw Bitcoin"); ?></h5>
                    </div>
                    <div class="ibox-content">
        <form action="<?php echo Config::get('URL'); ?>coins/withdraw" Method="GET">
            <input type="hidden" name="coin" value="<?php echo $coin; ?>">
            <div class="col-sm-4 col-xs-12">
                <?php System::translate('Withdraw your').' Bitcoin' ?>
                <br/>
                <br/>
                <b><?php echo System::translate("Total Balance"); ?>:</b>
                <?php echo System::escape($this->username->user_btc); ?><br/>
                <b><?php echo System::translate("Minimum withdrawal:"); ?></b> 0.0003
            </div>
            <div class="col-sm-8 col-xs-12">
                <div class="input-group">
                    <span class="input-group-btn"> 
                        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <?php echo System::translate("Payees"); ?>
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-info no-spacing">
                            <li>
                                <a href="<?php echo Config::get('URL'); ?>dashboard/payees">
                                    <?php echo System::translate("Manage Payees"); ?>
                                </a>
                            </li>
                            <?php foreach ($this->payees as $payee): ?>
                                <li><a onclick="add_payee('<?php echo System::escape($payee->address_address); ?>')" class="linkaddress" href="#" ><?php echo System::escape($payee->name); ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </span>
                    <input type="text" id="address" name="wallet" class="form-control no-left-border form-focus-blue">
                </div>
                <br>
                <div class="input-group">
                    <span class="input-group-addon"><?php echo System::translate("Amount"); ?></span>
                    <input type="text" id="amount" name="amount" class="form-control">
                </div>
                <br>
                <div class="input-group">
                    <span class="input-group-addon"><?php echo System::translate("Fee"); ?></span>
                    <input type="text" id="fee" disabled value="0.0002" class="form-control">
                </div>
                <br/>
                <div class="input-group">
                    <span class="input-group-addon"><?php echo System::translate("Total"); ?></span>
                    <input type="text" disabled id="total" value="" class="form-control">
                </div>
                <br/>
                <p class="tandc">IMPORTANT NOTE: Please ensure that all information given above is accurate and complete as any error or incomplete information may result in the transaction being delayed, lost or not being processed. We accept no responsibility for any loss or damage suffered by any person arising out of this transaction.
                </p>
                <br/>
                <div class="form-submit col-md-offset-1 col-md-10 pull-right">
                    <input class="btn btn-info btn-lg" type="submit" value="Submit">
                </div>
            </div>
            <br/>
            <br/>
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
                    <?php foreach ($this->withdraws as $r) { ?>
                        <tr role="row" class="odd">
                            <td>
                                <?php echo $r->address; ?></td>
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