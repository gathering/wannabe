<div class="row">
	<div class="span16">
		<form method="post" action="<?=$this->Wb->eventUrl('/ApplicationManager/greeting')?>">
			<fieldset>
				<legend><?=__("Personal greeting for %s", $crews[$this->data['EnrollGreeting']['crew_id']])?></legend>
				<?=$this->Form->hidden('EnrollGreeting.id')?>
				<?=$this->Form->hidden('EnrollGreeting.crew_id')?>
				<div class="clearfix">
					<label for="data[EnrollGreeting][message]"><?=__("Greeting")?></label>
					<div class="input">
						<?=$this->Form->textarea('EnrollGreeting.message', array('class' => 'xxlarge', 'rows' => '20'))?>
					</div>
				</div>
			</fieldset>
			<div class="actions">
				<?=$this->Form->submit(__("Save"), array('div' => false, 'name'=>'data[EnrollGreeting][save]', 'class' => 'btn success'))?>&nbsp;<?=$this->Form->submit(__("Delete"), array('name'=>'data[EnrollGreeting][delete]', 'class' => 'btn danger', 'div' => false))?>&nbsp;<a href="<?=$this->Wb->eventUrl('/ApplicationManager/greeting')?>" class="btn"><?=__("Back")?></a>
			</div>
		</form>
	</div>
</div>
