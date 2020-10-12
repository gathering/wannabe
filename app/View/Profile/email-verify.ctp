<? $this->Wb->useBootstrapForms(); ?>
<div class="row">
	<div class="col-md-4">
		<h2><?=__("Verify email")?></h2>
		<p><?=__("Please click the link in your email to verify your new email address. If you would like to cancel please do so by clicking the button to the right.")?></p>
	</div>
	<div class="col-md-8">
		<form method="POST">
		<fieldset>
			<legend><?=__("Change email")?></legend>
	        <?=$this->Form->input('User.email', ['disabled' => true, 'value' => $data['User']['email'], 'label' => __("New email")])?>
			<div class="actions">
				<?=$this->Form->submit(__("Cancel email change"), array('class' => 'btn btn-danger','name'=>'cancel'))?>
			</div>
		</fieldset>
		</form>
	</div>
</div>
