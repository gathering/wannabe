<form action="<?=$this->Wb->eventUrl("/FrontNewsManager/edit/".$this->data['FrontNews']['id'])?>" id="FrontNewsEditForm" method="post" accept-charset="utf-8">
	<fieldset>
		<legend><?=__("Edit %s", $this->data['FrontNews']['name'])?></legend>
		<?=$this->Form->hidden('id', array('value' => $this->data['FrontNews']['id']))?>
		<?=$this->Form->hidden('locale', array('value' => $this->data['FrontNews']['locale']))?>
		<div class="clearfix">
			<label for="data[name]"><?=__("Name")?></label>
			<div class="input">
				<?=$this->Form->input('name', array('value' => $this->data['FrontNews']['name'], 'label' => false, 'div' => false))?>
			</div>
		</div>
		<div class="clearfix">
			<label for="data[title]"><?=__("Title")?></label>
			<div class="input">
				<?=$this->Form->input('title', array('value' => $this->data['FrontNews']['title'], 'label' => false, 'div' => false))?>
				<span class="help-inline"><?=__("Translated")?></span>
			</div>
		</div>
		<div class="clearfix">
			<label for="data[title]"><?=__("Content")?></label>
			<div class="input">
				<?=$this->Form->textarea('content', array('rows' => 3, 'class' => 'xxlarge', 'value' => $this->data['FrontNews']['content'], 'label' => false, 'div' => false, 'id' => 'frontnewscontent'))?>
				<span class="help-inline"><?=__("Translated")?></span>
			</div>
		</div>
		<div class="clearfix">
			<label for="hund"><?=__("Options")?></label>
			<div class="input">
				<ul class="inputs-list">
					<li>
						<label>
							<?=$this->Form->checkbox('left_box', array('checked' => $this->data['FrontNews']['left_box'], 'label' => false, 'div' => false))?>
							<span><?=__("This news will be displayed left")?></span>
						</label>
					</li>
					<li>
						<label>
							<?=$this->Form->checkbox('active', array('checked' => $this->data['FrontNews']['active'], 'label' => false, 'div' => false))?>
							<span><?=__("Make this news active")?></span>
						</label>
					</li>
				</ul>
			</div>
		</div>
	</fieldset>
	<div class="actions">
		<?=$this->Form->submit(__("Save news"), array('label' => false, 'div' => false, 'class' => 'btn success'))?>
		<a href="<?=$this->Wb->eventUrl("/FrontNewsManager")?>" class="btn"><?=__("Back")?></a>&nbsp;
		<a href="<?=$this->Wb->eventUrl("/FrontNewsManager/edit/".$this->data['FrontNews']['id']."?locale=".($this->data['FrontNews']['locale'] === 'nob' ? 'eng' : 'nob'))?>"><?= $this->data['FrontNews']['locale'] === 'nob' ? __("To English version") : __("To Norwegian version")?></a>
	</div>
</form>
