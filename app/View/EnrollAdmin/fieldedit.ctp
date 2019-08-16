<form method="post">
	<fieldset>
		<legend><?=__("Edit field %s", $field['EnrollMailfield']['name'])?></legend>
		<?=$this->Form->hidden('EnrollMailfield.id', array('value' => $field['EnrollMailfield']['id']))?>
		<?=$this->Form->hidden('EnrollMailfield.enroll_mail_id', array('value' => $field['EnrollMailfield']['enroll_mail_id']))?>
		<div class="clearfix <? if($this->Form->error('EnrollMailfield.name')) echo "error"; ?>">
			<label for="data[EnrollMailfield][name]"><?=__("Name")?></label>
			<div class="input">
				<?=$this->Form->input('EnrollMailfield.name', array('div' => false, 'error' => false, 'label' => false, 'value' => $field['EnrollMailfield']['name']))?>
				<span class="help-block"><?=$this->Form->error('EnrollMailfield.name')?></span>
			</div>
		</div>
		<div class="clearfix <? if($this->Form->error('EnrollMailfield.content')) echo "error"; ?>">
			<label for="data[EnrollMailfield][content]"><?=__("Content")?></label>
			<div class="input">
				<?=$this->Form->textarea('EnrollMailfield.content', array('class' => 'xxlarge', 'rows' => 10, 'div' => false, 'error' => false, 'label' => false, 'value' => $field['EnrollMailfield']['content']))?>
				<span class="help-block"><?=$this->Form->error('EnrollMailfield.content')?></span>
			</div>
		</div>
		<div class="clearfix <? if($this->Form->error('EnrollMailfield.position')) echo "error"; ?>">
			<label for="data[EnrollMailfield][position]"><?=__("Position")?></label>
			<div class="input">
				<?=$this->Form->input('EnrollMailfield.position', array('class' => 'span2', 'div' => false, 'error' => false, 'label' => false, 'value' => $field['EnrollMailfield']['position']))?>
				<span class="help-block"><?=$this->Form->error('EnrollMailfield.position')?></span>
			</div>
		</div>
		<div class="clearfix <? if($this->Form->error('EnrollMailfield.name_as_header')) echo "error"; ?>">
			<label for="data[EnrollMailfield][name_as_header]"><?=__("Options")?></label>
			<div class="input">
				<ul class="inputs-list">
					<li>
						<label>
							<?=$this->Form->input('EnrollMailfield.name_as_header', array('div' => false, 'error' => false, 'label' => false, 'checked' => $field['EnrollMailfield']['name_as_header']?'checked':''))?>
							<span><?=$this->Form->error('EnrollMailfield.name_as_header')?$this->Form->error('EnrollMailfield.name_as_header'):__("Use name as header")?></span>
						</label>
					</li>
				</ul>
			</div>
		</div>
	</fieldset>
	<div class="actions">
		<?=$this->Form->submit(__("Edit field"), array('div' => false, 'label' => false, 'class' => 'btn success'))?> <a href="<?=$this->Wb->eventUrl('/EnrollAdmin/mail/'.$field['EnrollMailfield']['enroll_mail_id'])?>" class="btn"><?=__("Back")?></a>
	</div>
</form>
