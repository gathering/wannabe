<p></p>
<input type="hidden" name="data[User][id]" value="<?=$user['User']['id']?>" />
<div class="clearfix <? if($this->Form->error('User.password')) echo "error"; ?>">

	<div class="clearfix <? if($this->Form->error('User.newpassword1')) echo "error"; ?>">
		<label for="data[User][newpassword1]"><?=__("New password")?></label>
		<div class="input">
			<?=$this->Form->password('User.newpassword1', array('div' => false, 'error' => false, 'class'=>'form-control','label' => false, 'value' => ''))?>
			<span class="help-block"><?=$this->Form->error('User.newpassword1')?></span>
		</div>
	</div>
	<div class="clearfix <? if($this->Form->error('User.newpassword2')) echo "error"; ?>">
		<label for="data[User][newpassword2]"><?=__("Confirm password")?></label>
		<div class="input">
			<?=$this->Form->password('User.newpassword2', array('div' => false, 'error' => false, 'class'=>'form-control', 'label' => false, 'value' => ''))?>
			<span class="help-block"><?=$this->Form->error('User.newpassword2')?></span>
		</div>
	</div>

</div>
