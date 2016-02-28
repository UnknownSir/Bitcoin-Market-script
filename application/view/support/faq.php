<div class="faq" style="padding-top:25px;">
<?php foreach ($this->faq as $faq) { ?>
<div class="col-md-8 col-md-offset-2">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5 class="list-group-item-heading" style="font-family: Inika; font-weight: 700; font-size: 18px;"> <?php echo System::escape($faq->faq_title); ?></h5>
                        </div>
                        <div class="ibox-content">
                            <p>
								<?php echo System::escape($faq->faq_message); ?>
                            </p>
                        </div>
                    </div>
                </div>
<?php } ?>
</div>