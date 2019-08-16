<form method="post">
	<fieldset>
		<legend><?=__("Create new rule")?></legend>
        <?php foreach($langs as $lang => $locale) { ?>
            <div class="clearfix <? if($this->Form->error('PictureRule.'.$lang.'.rule_text')) echo "error"; ?>">
                <label for="data[PictureRule][<?=$lang?>][rule_text]"><?=__("Rule")?> (<?=$lang?>)</label>
                <div class="input">
                    <?=$this->Form->input('PictureRule.'.$lang.'.rule_text', array('div' => false, 'error' => false, 'label' => false))?>
                    <span class="help-block"><?=$this->Form->error('PictureRule.'.$lang.'.rule_text')?></span>
                </div>
            </div>
            <div class="clearfix <? if($this->Form->error('PictureRule.'.$lang.'.denied_text')) echo "error"; ?>">
                <label for="data[PictureRule][<?=$lang?>][denied_text]"><?=__("Denied text")?> (<?=$lang?>)</label>
                <div class="input">
                    <?=$this->Form->input('PictureRule.'.$lang.'.denied_text', array('div' => false, 'error' => false, 'label' => false))?>
                    <span class="help-block"><?=$this->Form->error('PictureRule.'.$lang.'.denied_text')?></span>
                </div>
            </div>
        <?php } ?>
	</fieldset>
	<div class="actions">
		<?=$this->Form->submit(__("Create rule"), array('div' => false, 'label' => false, 'class' => 'btn success'))?> <a href="<?=$this->Wb->eventUrl('/PictureRule')?>" class="btn"><?=__("Back")?></a>
	</div>
</form>
