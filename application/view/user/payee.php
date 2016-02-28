<script type="text/javascript">
jQuery(document).ready(function($)
{
  $("#payees").dataTable(
  {
    aLengthMenu: [
      [10, 25, 50, 100, -1],
      [10, 25, 50, 100, "All"]
    ]
  });
});
</script>
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"><?php  echo System::translate("Manage Payees");?></h3>
  </div>
  <div class="panel-body">
  <form action="" method="POST">
  <input type="hidden" name="add_payee" value="1">
      <div class="col-xs-12">
        <div class="input-group">
          <span class="input-group-addon"><?php echo System::translate("Payee Address"); ?></span>
          <input type="text" id="address" name="address" class="form-control">
        </div>
		<br/>
		 <div class="input-group">
          <span class="input-group-addon"><?php echo System::translate("Payee Name"); ?></span>
          <input type="text" id="name" name="name" class="form-control">
        </div>
        <br/>

        <p class="tandc">IMPORTANT NOTE: Please ensure that all information given above is accurate and complete as any error or incomplete information may result in the transaction being delayed, lost or not being processed. We accept no responsibility for any loss or damage suffered by any person arising out of this transaction.
        </p>
        <br/>
        <div class="form-submit col-md-offset-1 col-md-10 pull-right">
          <input class="btn btn-info btn-lg pull-right" type="submit" value="Submit"> <br/></br>
        </div>
      </div>
	  </form>
      <br/>
      <br/>
      <table class="table table-bordered table-striped dataTable no-footer" id="payees" role="grid" aria-describedby="payees_info">
        <thead>
          <tr role="row">
            <th class="sorting" tabindex="0" aria-controls="payees" rowspan="1" colspan="1" aria-label="<?php  System::translate(" Address "); ?>: <?php  System::translate("activate to sort column ascending "); ?>" style="width: 111px;">
              <?php echo System::translate( "Address"); ?>
            </th>
            <th class="sorting" tabindex="0" aria-controls="payees" rowspan="1" colspan="1" aria-label="<?php  System::translate(" Payee Name "); ?>: <?php  System::translate("activate to sort column ascending "); ?>" style="width: 111px;">
              <?php echo System::translate( "Payee Name"); ?>
            </th>
			<th class="sorting" tabindex="0" aria-controls="payees" rowspan="1" colspan="1" aria-label="<?php  System::translate("Coin"); ?>: <?php  System::translate("activate to sort column ascending "); ?>" style="width: 111px;">
              <?php echo System::translate("Coin"); ?>
            </th>
            </th>
          </tr>
        </thead>
        <tbody class="middle-align">
          <?php foreach($this->payees as $payee){ ?>
          <tr role="row" class="odd">
		  <td>
            <?php echo htmlentities($payee->address,ENT_QUOTES); ?></td>
            <td>
              <?php echo htmlentities($payee->name,ENT_QUOTES); ?></td>
			<td>
              </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
  </div>
</div>
</div>
</div>
</div>