<div class="col-xs-12 col-sm-10 col-sm-offset-1">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5><?php echo System::translate('Leave Feedback'); ?></h5>
        </div>
        <div class="ibox-content">
		<form action="<?php echo Config::get('URL'); ?>orders/leavefeedback" method="POST">
			<input name="order" value="<?php echo System::escape($this->order); ?>" type="hidden">
			<div class="row">
				
				<div class="form-group col-xs-12">
					<div class="col-sm-2">
					<?php $mainimage = explode(",",$this->feedback->images); ?>
					   <img height="140" src="<?php if(!empty($this->feedback->images)): echo Config::get('URL') .'images/products/'.System::escape($this->feedback->username). '/item' .System::escape($this->feedback->id) .'/'. System::escape($mainimage[0]); else: echo Config::get('URL').'images/noimage.jpg'; endif; ?>" class="front">	
					</div>
					<div class="col-sm-4">
						<?php echo System::translate('Product') .': <a href="'.Config::get('URL').'products/product/'.System::escape($this->feedback->id).'">'.System::escape($this->feedback->title); ?></a><br/>
						<?php echo System::translate('User') .': <a href="'.Config::get('URL').'user/profile/'.System::escape($this->feedback->username).'">'.System::escape($this->feedback->username); ?></a><br/>
						<?php echo System::translate('Price') .': '.System::escape($this->feedback->price); ?></br>
						<?php echo System::translate('Shipping Method') .': '.System::escape($this->feedback->shipping);  ?></br>
						<?php echo System::translate('Returns') .': '.System::escape($this->feedback->returns);  ?></br>
						<?php echo System::translate('Location') .': '.System::escape($this->feedback->location);  ?></br>
					</div>
					<div class="col-sm-6">
						<?php echo System::translate('Do not leave feedback until you have received your item. Help the seller improve by leaving detailed feedback.'); ?>
					</div>
				</div>
				
				<div class="form-group col-sm-8 col-xs-12">
					<input type="" id="feedback" maxlength="150" name="feedback" class="form-control" placeholder="<?php echo System::translate('Feedback '); ?>">
				</div>
				
				<div class="form-group col-sm-4 col-xs-12">
					<select name="level" class="form-control">
						<option value="positive"><?php echo System::translate('Positive'); ?></option>
						<option value="neutral"><?php echo System::translate('Neutral'); ?></option>
						<option value="negative"><?php echo System::translate('Negative'); ?></option>
					</select>
				</div>
				<div class="form-group col">
					<input type="submit" value="<?php echo System::translate('Leave Feedback'); ?>" class="btn btn-success pull-right">
				</div>
			</div>
		</form>
		</div>
	</div>
</div>