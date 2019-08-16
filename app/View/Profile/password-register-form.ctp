<form method="POST">
<fieldset>
	<legend><?=__("Create password")?></legend>
	<div class="clearfix <? if($this->Form->error('User.newpassword1')) echo "error"; ?>">
		<label for="data[User][newpassword1]"><?=__("Password")?></label>
		<div class="input">
			<?=$this->Form->password('User.newpassword1', array('div' => false, 'error' => false, 'class'=>'form-control', 'label' => false, 'value' => ''))?>
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
	<div class="actions" style="margin-top: 20px;">
		<?=$this->Form->submit(__("Create password"), array('class' => 'btn btn-success','name'=>'save'))?>
	</div>
</fieldset>
</form>
