  <script>
        $(document).ready(function() {
            $('.dataTables-example').dataTable({
                responsive: true,
                "dom": 'T<"clear">lfrtip',
                "tableTools": {
                    "sSwfPath": "js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
                }
            });

            /* Init DataTables */
            var oTable = $('#editable').dataTable();

            /* Apply the jEditable handlers to the table */
            oTable.$('td').editable( '../example_ajax.php', {
                "callback": function( sValue, y ) {
                    var aPos = oTable.fnGetPosition( this );
                    oTable.fnUpdate( sValue, aPos[0], aPos[1] );
                },
                "submitdata": function ( value, settings ) {
                    return {
                        "row_id": this.parentNode.getAttribute('id'),
                        "column": oTable.fnGetPosition( this )[2]
                    };
                },

                "width": "90%",
                "height": "100%"
            } );


        });

        function fnClickAddRow() {
            $('#editable').dataTable().fnAddData( [
                "Custom row",
                "New row",
                "New row",
                "New row",
                "New row" ] );

        }
    </script>
 <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5><?php echo System::translate("User Tracking"); ?></h5>
                    </div>
                    <div class="ibox-content">

                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                        <th><?php echo System::translate("Tracking ID"); ?></th>
                        <th><?php echo System::translate("Date"); ?></th>
                        <th><?php echo System::translate("Referrer"); ?></th>
                        <th><?php echo System::translate("Action Performed"); ?></th>
						<th><?php echo System::translate("User"); ?></th>
                        <th><?php echo System::translate("Browser"); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($this->tracking as $tracking): ?>
					<tr class="gradeX">
                        <td><?php echo System::escape($tracking->action_tracking_id); ?></td>
                        <td><?php echo System::escape($tracking->action_tracking_datetime); ?></td>
                        <td><?php echo System::escape($tracking->action_tracking_reffer); ?></td>
                        <td class="center"><?php echo System::escape($tracking->action_tracking_action); ?></td>
                        <td class="center"><?php echo System::escape($tracking->action_tracking_username); ?></td>
                        <td class="center"><?php echo System::escape($tracking->action_tracking_browser); ?></td>
                    </tr>
					<?php endforeach; ?>
                    </tfoot>
                    </table>

                    </div>
                </div>
            </div>
            </div>