<div class="row">
	<div class="col-md-4">
		<h2><?=__("Verify email")?></h2>
		<p><?=__("Please click the link in your email to verify your new email address. If you would like to cancel please to som by clicking the button to the right.")?></p>
	</div>
	<div class="col-md-8">
		<form method="POST">
		<fieldset>
			<legend><?=__("Change email")?></legend>
			<div class="clearfix">
				<label for="data[User][email]"><?=__("New email")?></label>
				<div class="input">
					<?=$this->Form->input('User.email', array('disabled' => 'disabled', 'div' => false, 'error' => false, 'label' => false, 'value' => $data['User']['email']))?>
				</div>
			</div>
			<div class="actions">
				<?=$this->Form->submit(__("Cancel email change"), array('class' => 'btn danger','name'=>'cancel'))?>
			</div>
		</fieldset>
		</form>
	</div>
</div>
