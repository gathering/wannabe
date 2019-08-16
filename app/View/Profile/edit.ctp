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
		<?php require_once('form.ctp'); ?>
	</div>
</div>
