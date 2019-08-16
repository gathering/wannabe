<form method="POST">
<?=$this->Html->script('wannabe/profile')?>
<fieldset>
	<legend><?=__("Personal info")?></legend>
	<div class="clearfix <? if($this->Form->error('User.realname')) echo "error"; ?>">
		<label for="data[User][realname]"><?=__("Full name")?></label>
		<div class="input">
			<?=$this->Form->input('User.realname', array('div' => false, 'error' => false,'class'=>'form-control', 'label' => false, 'value' => $user['User']['realname']))?>
			<span class="help-block"><?=$this->Form->error('User.realname')?></span>
		</div>
	</div>
	<div class="clearfix  <? if($this->Form->error('User.nickname')) echo "error"; ?>">
		<label for="data[User][nickname]"><?=__("Nick")?></label>
		<div class="input">
			<?=$this->Form->input('User.nickname', array('div' => false, 'error' => false, 'class'=>'form-control', 'label' => false, 'value' => $user['User']['nickname']))?>
			<span class="help-block"><?=$this->Form->error('User.nickname')?></span>
		</div>
	</div>
	<div class="clearfix <? if($this->Form->error('User.sexe')) echo "error"; ?>">
		<label for="data[User][sexe]"><?=__("Gender")?></label>
		<div class="input">
			<?=$this->Form->select('User.sexe', $sexes, array('div' => false, 'error' => false,'class'=>'form-control', 'label' => false, 'empty' => __("Gender"), 'value' => $user['User']['sexe']))?>
			<span class="help-block"><?=$this->Form->error('User.sexe')?></span>
		</div>
	</div>
	<div class="clearfix <? if($this->Form->error('User.birth')) echo "error"; ?>">
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
	<div class="clearfix <? if($this->Form->error('User.countrycode')) echo "error"; ?>">
		<label for="data[User][countrycode]"><?=__("Country")?></label>
		<div class="input">
			<?=$this->Form->select('User.countrycode', $countrycodes, array('empty' => __("Country"), 'div' => false, 'class'=>'form-control', 'error' => false, 'label' => false, 'value' => $user['User']['countrycode']))?>
			<span class="help-block"><?=$this->Form->error('User.countrycode')?></span>
		</div>
	</div>
	<div class="clearfix <? if($this->Form->error('User.address')) echo "error"; ?>">
		<label for="data[User][address]"><?=__("Address")?></label>
		<div class="input">
			<?=$this->Form->text('User.address', array('div' => false, 'error' => false, 'label' => false, 'class'=>'form-control', 'value' => $user['User']['address']))?>
			<span class="help-block"><?=$this->Form->error('User.address')?></span>
		</div>
	</div>
	<div class="clearfix <? if($this->Form->error('User.postcode')) echo "error"; ?>">
		<label for="data[User][postcode]"><?=__("Postnummer")?></label>
		<div class="input">
			<?=$this->Form->text('User.postcode', array('div' => false, 'error' => false, 'label' => false, 'class'=>'form-control', 'value' => $user['User']['postcode']))?>
			<span class="help-block"><?=$this->Form->error('User.postcode')?></span>
		</div>
	</div>
	<div class="clearfix <? if($this->Form->error('User.town')) echo "error"; ?>">
		<label for="data[User][town]"><?=__("Town")?></label>
		<div class="input">
			<?=$this->Form->text('User.town', array('div' => false, 'error' => false, 'label' => false, 'class'=>'form-control', 'value' => $user['User']['town']))?>
			<span class="help-block"><?=$this->Form->error('User.town')?></span>
		</div>
	</div>
</fieldset>
<fieldset>
	<legend><?=__("Contact info")?></legend>
<?php
$lastindex = -1;
if(isset($user['Userphone']) and sizeof($user['Userphone'])) {
	$first = true;
	foreach($user['Userphone'] as $index => $phone) {
	$lastindex = $index;
?>
	<div class="clearfix <? if(isset($validateErrors['Userphone.'.$index.'.number'])) echo "error"; ?>">
<?php
		if($first) {
			$first = false;
?>
		<label for="data[Userphone][<?=$index?>][phonetype_id]"><?=__("Phone numbers")?></label>
<?php
		}
?>
		<div class="input">
			<div class="row">
				<div class="col-md-4">
				<?=$this->Form->select('Userphone.'.$index.'.phonetype_id', $phonetypes, array('div' => false, 'class'=>'form-control', 'label' => false,'empty' => __("Type"), 'value' => $phone['phonetype_id']))?>
				</div>
				<div class="col-md-8">
					<?=$this->Form->text('Userphone.'.$index.'.number', array('div' => false, 'label' => false, 'class'=>'form-control', 'value' => $phone['number']))?>
				</div>
			</div>
			<span class="help-block"><? if(isset($validateErrors['Userphone.'.$index.'.number'])) { echo $validateErrors['Userphone.'.$index.'.number'][0]; } ?></span>
		</div>
	</div>
<?php
	}
}
		$lastindex = $lastindex+1;
?>
	<div class="clearfix <? if(isset($validateErrors['Userphone.'.$lastindex.'.number'])) echo "error"; ?>">
<?php
		if($lastindex == 0) {
?>
		<label for="data[Userphone][<?=$lastindex?>][phonetype_id]"><?=__("Phone numbers")?></label>
<?php
		}
?>
		<div class="input">
			<div class="row">
			<div class="col-md-4">
				<?=$this->Form->select('Userphone.'.$lastindex.'.phonetype_id', $phonetypes, array('div' => false, 'class'=>'form-control', 'label' => false, 'empty' => __("Type")))?>
				</div>
				<div class="col-md-8">
				<?=$this->Form->text('Userphone.'.$lastindex.'.number', array('div' => false, 'class'=>'form-control', 'label' => false))?>
				</div>
			</div>
			<span class="help-block"><? if(isset($validateErrors['Userphone.'.$lastindex.'.number'])) { echo $validateErrors['Userphone.'.$lastindex.'.number'][0]; } else { echo __("Phone numbers should be entered with country prefix"); } ?></span>
		</div>
	</div>
<?php
$lastindex = -1;
if(isset($user['Userim']) && sizeof($user['Userim'])) {
	$first = true;
	foreach($user['Userim'] as $index => $account) {
		$lastindex = $index;
?>
	<div class="clearfix <? if(isset($validateErrors['Userim.'.$index.'.improtocol_id'])) echo "error"; ?>">
<?php
		if($first) {
			$first = false;
?>
		<label for="data[Userim][<?=$index?>][improtocol_id]"><?=__("IM accounts")?></label>
<?php
		}
?>
		<div class="input">
			<div class="row">
			<div class="col-md-4">
				<?=$this->Form->select('Userim.'.$index.'.improtocol_id', $improtocols, array('class' => 'form-control','div' => false, 'label' => false, 'empty' => __("Type"), 'value' => $account['improtocol_id']))?>
			</div>
			<div class="col-md-8">
				<?=$this->Form->text('Userim.'.$index.'.address', array('class' => 'form-control','div' => false, 'label' => false, 'value' => $account['address']))?>
			</div>
			</div>
			<span class="help-block"><? if(isset($validateErrors['Userim.'.$index.'.improtocol_id'])) { echo __("IM account type must be chosen"); } ?></span>
		</div>
	</div>

<?php
	}
}
?>
	<div class="clearfix">
<?php
		$lastindex = $lastindex+1;
		if($lastindex == 0) {
?>
		<label for="data[Userim][<?=$lastindex?>][improtocol_id]"><?=__("IM accounts")?></label>
<?php
		}
?>
		<div class="input">
			<div class="row">
				<div class="col-md-4">
				<?=$this->Form->select('Userim.'.$lastindex.'.improtocol_id', $improtocols, array('class' => 'form-control','div' => false, 'label' => false, 'empty' => __("Type")))?>
			</div>
			<div class="col-md-8">
				<?=$this->Form->text('Userim.'.$lastindex.'.address', array('class' => 'form-control','div' => false, 'label' => false))?>
			</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12" style="margin-top: 20px;">
			<?=$this->Form->submit($savebutton, array('class' => 'btn btn-lg btn-success','name'=>'save'))?>
		</div>
	</div>
</fieldset>
</form>
