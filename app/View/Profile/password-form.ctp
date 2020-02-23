<? $this->Wb->useBootstrapForms(); ?>
<form method="POST">
<fieldset>
	<legend><?=__("Update password")?></legend>
	<?=$this->Form->input('User.password', ['label' => __("Old password"), 'type' => 'password'])?>
	<?=$this->Form->input('User.newpassword1', ['label' => __("Password"), 'type' => 'password'])?>
	<?=$this->Form->input('User.newpassword2', ['label' => __("Confirm password"), 'type' => 'password'])?>
	<div class="actions">
		<?=$this->Form->submit(__("Update password"), array('class' => 'btn btn-success','name'=>'save'))?>
	</div>
</fieldset>
</form>
