<form method="POST">
<?=$this->Html->script('wannabe/profile')?>
<? $this->Wb->useBootstrapForms(); ?>
<fieldset>
	<legend><?=__("Personal info")?></legend>
	<?=$this->Form->input('User.realname', array('value' => $user['User']['realname'], 'label' => __("Full name")))?>
	<?=$this->Form->input('User.nickname', array('value' => $user['User']['nickname'], 'label' => __("Nick")))?>
	<?=$this->Form->input('User.sexe', array('value' => $user['User']['sexe'], 'label' => __("Gender")))?>
	<div class="clearfix <? if($this->Form->error('User.birth')) echo "has-error"; ?>">
		<label for="data[User][birth]"><?=__("Birth")?></label>
		<div class="input">
			<div class="row">
				<div class="col-md-4">
				<?=$this->Form->day('User.birth', array('empty' => __("Day"), 'class' => 'form-control', 'div' => false, 'error' => false, 'label' => false, 'value' => $user['User']['birth']['day']))?>
				</div>
				<div class="col-md-4">
				<?=$this->Form->month('User.birth', array('empty' => __("Month"), 'class' => 'form-control', 'div' => false, 'error' => false, 'label' => false, 'value' => $user['User']['birth']['month']))?>
			</div>
			<div class="col-md-4">
				<?=$this->Form->year('User.birth', date('Y')-70, date('Y')-3, array('empty' => 'Year', 'class' => 'form-control', 'div' => false, 'error' => false, 'label' => false, 'value' => $user['User']['birth']['year']))?>
			</div>
			</div>
			<span class="help-block"><?=$this->Form->error('User.birth')?></span>
		</div>
	</div>
	<?=$this->Form->input('User.countrycode', array('value' => $user['User']['countrycode'], 'label' => __("Country")))?>
	<?=$this->Form->input('User.address', array('value' => $user['User']['address'], 'label' => __("Address")))?>
	<?=$this->Form->input('User.postcode', array('value' => $user['User']['postcode'], 'label' => __("Postnummer")))?>
	<?=$this->Form->input('User.town', array('value' => $user['User']['town'], 'label' => __("Town")))?>
</fieldset>
<fieldset>
	<legend><?=__("Contact info")?></legend>

<?php
$userphone = (isset($user['Userphone']) and sizeof($user['Userphone'])) ? $user['Userphone'] : [];
$userphone[] = [
	'phonetype_id' => null,
	'number' => null,
];
$first = true;
foreach($userphone as $index => $phone) {
	if ($first) {
		$first = false;
		echo $this->Form->label('Userphone'.$index.'PhonetypeId', __("Phone numbers"));
	}
?>
	<div class="clearfix <? if(isset($validateErrors['Userphone.'.$index.'.number'])) echo "has-error"; ?>">
		<div class="input">
			<div class="row">
				<div class="col-md-4">
					<?=$this->Form->input('Userphone.'.$index.'.phonetype_id', array('div' => false, 'label' => false,'empty' => __("Type"), 'value' => $phone['phonetype_id']))?>
				</div>
				<div class="col-md-8">
					<?=$this->Form->input('Userphone.'.$index.'.number', array('div' => false, 'label' => false, 'value' => $phone['number']))?>
				</div>
			</div>
			<span class="help-block"><? if(isset($validateErrors['Userphone.'.$index.'.number'])) { echo $validateErrors['Userphone.'.$index.'.number'][0]; } ?></span>
		</div>
	</div>
<?php
}

$userims = (isset($user['Userim']) && sizeof($user['Userim'])) ? $user['Userim'] : [];
$userims[] = [
	'improtocol_id' => null,
	'address' => null,
];
$first = true;
foreach($userims as $index => $account) {
	if ($first) {
		$first = false;
		echo $this->Form->label('Userim'.$index.'ImprotocolId', __("IM accounts"));
	}
?>
	<div class="clearfix <? if(isset($validateErrors['Userim.'.$index.'.improtocol_id'])) echo "has-error"; ?>">
		<div class="input">
			<div class="row">
				<div class="col-md-4">
					<?=$this->Form->input('Userim.'.$index.'.improtocol_id', ['div' => false, 'label' => false, 'empty' => __("Type"), 'value' => $account['improtocol_id']])?>
				</div>
				<div class="col-md-8">
					<?=$this->Form->input('Userim.'.$index.'.address', ['div' => false, 'label' => false, 'value' => $account['address']])?>
				</div>
			</div>
			<span class="help-block"><? if(isset($validateErrors['Userim.'.$index.'.improtocol_id'])) { echo __("IM account type must be chosen"); } ?></span>
		</div>
	</div>
<?php
}
?>
	</div>
	<div class="row">
		<div class="col-md-12" style="margin-top: 20px;">
			<?=$this->Form->submit($savebutton, array('class' => 'btn btn-lg btn-success','name'=>'save'))?>
		</div>
	</div>
</fieldset>
</form>
