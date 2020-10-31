<form action="<?=$this->Wb->eventUrl("/FrontNewsManager/add")?>" id="FrontNewsAddForm" method="post" accept-charset="utf-8">
	<fieldset>
		<legend><?=__("Create news")?></legend>
		<div class="clearfix">
			<label for="data[locale]"><?=__("Locale")?></label>
			<div class="input">
				<?=$this->Form->input('locale', array('label' => false, 'div' => false, 'options' => array('nob' => __('Norwegian'), 'eng' => __('English'))))?>
			</div>
		</div>
		<div class="clearfix">
			<label for="data[name]"><?=__("Name")?></label>
			<div class="input">
				<?=$this->Form->input('name', array('label' => false, 'div' => false))?>
			</div>
		</div>
		<div class="clearfix">
			<label for="data[title]"><?=__("Title")?></label>
			<div class="input">
				<?=$this->Form->input('title', array('label' => false, 'div' => false))?>
				<span class="help-inline"><?=__("Translated")?></span>
			</div>
		</div>
		<div class="clearfix">
			<label for="data[title]"><?=__("Content")?></label>
			<div class="input">
				<?=$this->Form->textarea('content', array('rows' => 3, 'class' => 'xxlarge', 'label' => false, 'div' => false, 'id' => 'frontnewscontent'))?>
				<span class="help-inline"><?=__("Translated")?></span>
			</div>
		</div>
		<div class="clearfix">
			<label for="hund"><?=__("Options")?></label>
			<div class="input">
				<ul class="inputs-list">
					<li>
						<label>
							<?=$this->Form->checkbox('left_box', array('label' => false, 'div' => false))?>
							<span><?=__("This news will be displayed left")?></span>
						</label>
					</li>
					<li>
						<label>
							<?=$this->Form->checkbox('active', array('label' => false, 'div' => false))?>
							<span><?=__("Make this news active")?></span>
						</label>
					</li>
				</ul>
			</div>
		</div>
	</fieldset>
	<div class="actions">
		<?=$this->Form->submit(__("Create news"), array('label' => false, 'div' => false, 'class' => 'btn success'))?>
		<a href="<?=$this->Wb->eventUrl("/FrontNewsManager")?>" class="btn"><?=__("Back")?></a>
	</div>
</form>
