<div class="row">
	<div class="col-md-3">
		<h2><?=__("Edit your profile")?></h2>
		<p><?=__("On this page you edit your profile.")?></p>
		<p><?=__("If you would like to change you password or update your email address, you can do so by clicking the corresponding button below.")?></p>
		<p><a href="<?=$this->Wb->eventUrl('/Profile/password')?>" class="btn btn-default"><?=__("Update password")?></a></p>
		<p><a href="<?=$this->Wb->eventUrl('/Profile/email')?>" class="btn btn-default"><?=__("Change email")?></a></p>
		<p><a href="<?=$this->Wb->eventUrl('/Profile/picture')?>" class="btn btn-default"><?=__("Change picture")?></a></p>
	</div>
	<div class="col-md-9">
		<form method="POST">
		<fieldset>
			<legend><?=__("Change email")?></legend>
			<div class="clearfix">
				<div class="input">
					<span><?=__("Your current email: %s", $wannabe->user['User']['email'])?></span>
				</div>
			</div>
			<div class="clearfix <? if($this->Form->error('User.email')) echo "error"; ?>">
				<label for="data[User][email]"><?=__("New email")?></label>
				<div class="input">
					<?=$this->Form->input('User.email', array('div' => false, 'error' => false, 'class'=>'form-control', 'label' => false, 'value' => $data['User']['email']))?>
					<span class="help-block"><?=$this->Form->error('User.email')?></span>
				</div>
			</div>
			<div class="actions">
				<?=$this->Form->submit(__("Change email"), array('class' => 'btn btn-success','name'=>'change'))?>
			</div>
		</fieldset>
		</form>
	</div>
</div>
