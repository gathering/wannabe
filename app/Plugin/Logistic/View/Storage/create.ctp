<ul class="breadcrumb"><li><a href="<?=$this->Wb->eventUrl('/Logistic')?>"><?=__('Logistics')?></a> <span class="divider"></span></li><li class="active"><?=$title_for_layout?></li></ul>
<form method="post" action="/<?=WB::$event->reference?>/logistic/Storage/create">
	<fieldset>
		<legend><?=__("Create new storage unit")?></legend>
		<div class="clearfix <? if(isset($validateErrors['LogisticStorage.name'])) echo "error"; ?>">
			<label for="data[LogisticStorage][name]"><?=__("Name")?></label>
			<div class="input">
				<?=$this->Form->input('LogisticStorage.name', array('div' => false, 'error' => false, 'label' => false))?>
			    <span class="help-block"><?=isset($validateErrors['LogisticStorage.name'])?$validateErrors['LogisticStorage.name'][0]:''?></span>
			</div>
		</div>
		<div class="clearfix">
			<label for="data[LogisticStorage][type]"><?=__("Type")?></label>
			<div class="input">
                            <?=$this->Form->select('LogisticStorage.type', array(
                                    'default' => __('Normal storage'),
                                    'unrig' => __('Unrig destination')),
                                array('div' => false, 'error' => false, 'empty' => false))?>
			</div>
		</div>
		<div class="clearfix <? if($this->Form->error('LogisticStorage.comment')) echo "error"; ?>">
			<label for="data[LogisticStorage][comment]"><?=__("Comment")?></label>
			<div class="input">
				<?=$this->Form->textarea('LogisticStorage.comment', array('div' => false, 'error' => false))?>
				<span class="help-block"><?=$this->Form->error('LogisticStorage.comment')?></span>
			</div>
		</div>
	</fieldset>
	<div class="actions">
		<?=$this->Form->submit(__("Create storage unit"), array('div' => false, 'label' => false, 'class' => 'btn btn-primary'))?></a>
	</div>
</form>
