<form method="post">
	<fieldset>
		<legend><?=__("Edit term")?></legend>
		<?=$this->Form->hidden('Term.id', array('value' => $term['Term']['id']))?>
        <?php foreach($langs as $lang => $locale) {
            $title = '';
            foreach($term['titleTranslation'] as $t) {
                if($t['locale'] == $lang) {
                    $title = $t['content'];
                }
            }
            $content = '';
            foreach($term['contentTranslation'] as $c) {
                if($c['locale'] == $lang) {
                    $content = $c['content'];
                }
            }
            ?>
            <div class="clearfix <? if($this->Form->error('Term.'.$lang.'.title')) echo "error"; ?>">
                <label for="data[Term][<?=$lang?>][content]"><?=__("Title")?> (<?=$lang?>)</label>
                <div class="input">
                    <?=$this->Form->input('Term.'.$lang.'.title', array('empty' => __("None"), 'div' => false, 'error' => false, 'label' => false, 'rows' => 3, 'value' => $title))?>
                    <span class="help-block"><?=$this->Form->error('Term.'.$lang.'.title')?></span>
                </div>
            </div>
            <div class="clearfix <? if($this->Form->error('Term.'.$lang.'.content')) echo "error"; ?>">
                <label for="data[Term][<?=$lang?>][content]"><?=__("Content")?> (<?=$lang?>)</label>
                <div class="input">
                    <?=$this->Form->input('Term.'.$lang.'.content', array('empty' => __("None"), 'div' => false, 'error' => false, 'label' => false, 'rows' => 3, 'value' => $content))?>
                    <span class="help-block"><?=$this->Form->error('Term.'.$lang.'.content')?></span>
                </div>
            </div>
        <?php } ?>
		<div class="clearfix <? if($this->Form->error('Term.version')) echo "error"; ?>">
			<label for="data[Term][version]"><?=__("Version")?></label>
			<div class="input">
				<?=$this->Form->input('Term.version', array('div' => false, 'error' => false, 'label' => false, 'value' => $term['Term']['version']))?>
				<span class="help-block"><?=$this->Form->error('Term.version')?></span>
			</div>
		</div>
		<div class="clearfix">
            <label for="objectList"><?=__("Options")?></label>
			<div class="input">
				<ul class="inputs-list">
					<li>
						<label>
							<?=$this->Form->checkbox('Term.active', array('div' => false, 'error' => false, 'label' => false, 'checked' => $term['Term']['active']?'checked':''))?>
							<span><?=__("Activate term")?></span>
						</label>
					</li>
				</ul>
			</div>
		</div>
	</fieldset>
	<div class="actions">
		<?=$this->Form->submit(__("Save term"), array('div' => false, 'label' => false, 'class' => 'btn success'))?> <a href="<?=$this->Wb->eventUrl('/TermAdmin')?>" class="btn"><?=__("Back")?></a>
	</div>
</form>
