<form method="post" action="/<?=WB::$event->reference?>/logistic/Storage/edit/<?=$unit['LogisticStorage']['id']?>">
	<fieldset>
		<legend><?=__("Edit %s", $unit['LogisticStorage']['name'])?></legend>
		<?=$this->Form->hidden('LogisticStorage.id', array('value' => $unit['LogisticStorage']['id']))?>
		<div class="clearfix <? if(isset($validateErrors['LogisticStorage.name']) || $this->Form->error('LogisticStorage.name')) echo "error"; ?>">
			<label for="data[LogisticStorage][name]"><?=__("Name")?></label>
			<div class="input">
				<?=$this->Form->input('LogisticStorage.name', array('div' => false, 'error' => false, 'label' => false, 'value' => $unit['LogisticStorage']['name']))?>
			    <span class="help-block"><?=isset($validateErrors['LogisticStorage.name'])?$validateErrors['LogisticStorage.name'][0]:''?></span>
                <span class="help-block"><?=$this->Form->error('LogisticStorage.name')?></span>
			</div>
		</div>
		<div class="clearfix <? if($this->Form->error('LogisticStorage.comment')) echo "error"; ?>">
			<label for="data[LogisticStorage][comment]"><?=__("Comment")?></label>
			<div class="input">
				<?=$this->Form->input('LogisticStorage.comment', array('label' => false, 'div' => false, 'error' => false, 'value' => $unit['LogisticStorage']['comment']))?>
                <span class="help-block"><?=$this->Form->error('LogisticStorage.comment')?></span>
			</div>
		</div>
	</fieldset>
	<div class="actions">
		<?=$this->Form->submit(__("Save storage unit"), array('div' => false, 'label' => false, 'class' => 'btn btn-success'))?> <a href="<?=$this->Wb->eventUrl('/logistic')?>" class="btn btn-info"><?=__("Back")?></a>
	</div>
</form>