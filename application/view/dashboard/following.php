<div class="wrapper wrapper-content">
		<?php if(isset($this->notfollowing)): ?>
		<div class="col-xs-12 col-sm-6 col-sm-offset-3 alert alert-info alert-dismissable"><?php echo $this->notfollowing; ?></div>
		<?php endif;?>
		<?php if(isset($this->following)):  foreach ($this->following as $follower): ?>
            <div class="col-sm-4">
                <div class="contact-box animated pulse">
                    <a href="<?php echo Config::get('URL'); ?>user/profile/<?php echo System::escape($follower->username);?>">
                    <div class="col-sm-4">
                        <div class="text-center">
                            <img alt="image" class="img-circle m-t-xs img-responsive" src="<?php echo Config::get('URL'); ?>img/avatar.jpg">
                            <div class="m-t-xs font-bold"><?php echo System::escape($follower->username); ?></div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <h3><strong><?php echo ucwords(System::escape($follower->firstname)); ?> <?php echo ucwords(System::escape($follower->lastname)); ?></strong></h3>
                        <p><i class="fa fa-map-marker"></i> <?php echo System::escape($follower->country); ?></p>
                        <address><br>
						        <?php echo System::escape($follower->about); ?>
                        </address>
                    </div>
                    <div class="clearfix"><li class="fa fa-minus"></li> <a href="<?php echo Config::get('URL'); ?>user/unfollow/<?php echo System::escape($follower->id); ?>"><?php echo System::translate("Unfollow this user"); ?></a></div>
                        </a>
                </div>
            </div>
			<?php endforeach; endif;?>
                    <div class="clearfix"></div>
                    </a>
    </div>
 