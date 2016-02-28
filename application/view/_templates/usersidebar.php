<style>
.glyphicon { margin-right:10px; }
.panel-body { padding:0px; }
.panel-body table tr td { padding-left: 15px }
.panel-body .table {margin-bottom: 0px; }
</style>
        <div class="col-sm-3 col-md-3">
            <div class="panel-group" id="accordion">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"><span class="glyphicon glyphicon-folder-close">
                            </span><?php echo System::translate('Buy'); ?></a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in">
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <td>
                                       <a href="<?php echo Config::get('URL'); ?>dashboard/purchased"><?php echo System::translate('Purchased'); ?></a>
                                    </td>
                                </tr>								
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"><span class="glyphicon glyphicon-th">
                            </span><?php echo System::translate('Sell'); ?></a>
                        </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse">
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <td>
                                        <a href="<?php echo Config::get('URL'); ?>dashboard/selling"><?php echo System::translate('Selling'); ?></a> 
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="<?php echo Config::get('URL'); ?>dashboard/selling?type=sold"><?php echo System::translate('Sold'); ?></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="<?php echo Config::get('URL'); ?>dashboard/selling?type=unsold"><?php echo System::translate('Not Sold'); ?></a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>