<? $this->Wb->useBootstrapForms(); ?>
<form method="POST">
<fieldset>
	<legend><?=__("Create password")?></legend>
	<?=$this->Form->input('User.newpassword1', ['label' => __("Password"), 'type' => 'password'])?>
	<?=$this->Form->input('User.newpassword2', ['label' => __("Confirm password"), 'type' => 'password'])?>
	<div class="actions" style="margin-top: 20px;">
		<?=$this->Form->submit(__("Create password"), array('class' => 'btn btn-success','name'=>'save'))?>
	</div>
</fieldset>
</form>
