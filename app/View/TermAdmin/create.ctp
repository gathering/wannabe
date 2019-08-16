<form method="post">
	<fieldset>
		<legend><?=__("Create new term")?></legend>
        <?php foreach($langs as $lang => $locale) { ?>
            <div class="clearfix <? if($this->Form->error('Term.'.$lang.'.title')) echo "error"; ?>">
                <label for="data[Term][<?=$lang?>][content]"><?=__("Title")?> (<?=$lang?>)</label>
                <div class="input">
                    <?=$this->Form->input('Term.'.$lang.'.title', array('empty' => __("None"), 'div' => false, 'error' => false, 'label' => false, 'rows' => 3))?>
                    <span class="help-block"><?=$this->Form->error('Term.'.$lang.'.title')?></span>
                </div>
            </div>
            <div class="clearfix <? if($this->Form->error('Term.'.$lang.'.content')) echo "error"; ?>">
                <label for="data[Term][<?=$lang?>][content]"><?=__("Content")?> (<?=$lang?>)</label>
                <div class="input">
                    <?=$this->Form->input('Term.'.$lang.'.content', array('empty' => __("None"), 'div' => false, 'error' => false, 'label' => false, 'rows' => 3))?>
                    <span class="help-block"><?=$this->Form->error('Term.'.$lang.'.content')?></span>
                </div>
            </div>
        <?php } ?>
		<div class="clearfix <? if($this->Form->error('Term.version')) echo "error"; ?>">
			<label for="data[Term][version]"><?=__("Version")?></label>
			<div class="input">
				<?=$this->Form->input('Term.version', array('div' => false, 'error' => false, 'label' => false))?>
				<span class="help-block"><?=$this->Form->error('Term.version')?></span>
			</div>
		</div>
		<div class="clearfix">
            <label for="objectList"><?=__("Options")?></label>
			<div class="input">
				<ul class="inputs-list">
					<li>
						<label>
							<?=$this->Form->checkbox('Term.active', array('div' => false, 'error' => false, 'label' => false))?>
							<span><?=__("Activate term")?></span>
						</label>
					</li>
				</ul>
			</div>
		</div>
	</fieldset>
	<div class="actions">
		<?=$this->Form->submit(__("Create term"), array('div' => false, 'label' => false, 'class' => 'btn success'))?> <a href="<?=$this->Wb->eventUrl('/TermAdmin')?>" class="btn"><?=__("Back")?></a>
	</div>
</form>
