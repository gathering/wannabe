<div class="row">
</div>
<div class="row">
	<div class="span10">
		<?php if(!empty($greetings)): ?>
			<h2><?=__('Created greetings you have access to')?></h2>
			<dl>
				<?php foreach($greetings as $greeting): ?>
					<dd>
						<h3><?=$this->Wb->eventLink($crews[$greeting['EnrollGreeting']['crew_id']], '/Crew/View/'.strtolower($crews[$greeting['EnrollGreeting']['crew_id']]))?></h3>
						<div class="crew-description">
							<p><?=nl2br($greeting['EnrollGreeting']['message'])?></p>
							<p><a href="<?=$this->Wb->eventUrl('/ApplicationManager/greeting/'.$greeting['EnrollGreeting']['crew_id'])?>" class="btn primary"><?=__("Edit")?></a></p>
						</div>
					</dd>
					<hr />
				<?php endforeach; ?>
			</dl>
		<?php endif; ?>
		<?php if(isset($parent)): ?>
			<?=__('Greeting from parent crew')?>
			<?=$crews[$parent['EnrollGreeting']['crew_id']]?>
			<?=$this->Wb->eventLink('crewlink', '/Crew/View/'.strtolower($crews[$parent['EnrollGreeting']['crew_id']]))?>
			<?=nl2br($parent['EnrollGreeting']['message'])?>
		<?php endif; ?>
	</div>
	<div class="span2">&nbsp;</div>
	<div class="span4">
		<script type="text/javascript">
		function Toggle(IDS) {
		        var sel = document.getElementById(IDS);
		        sel.style.display =  (sel.style.display) != 'block' ? 'block' : 'none';
		} 
		</script>
		<? if(!empty($crew_without_greeting)): ?>
		<form method="post" action="<?=$this->Wb->eventUrl('/ApplicationManager/greeting')?>">
			<h4><?=__('Create a greeting')?></h4>
			<div class="well">
				<div class="clearfix">
					<?=$this->Form->select('EnrollGreeting.crew_id', $crew_without_greeting, array('value' => $wannabe->user['Crew'][0]['id'], 'empty' => __("Choose"), 'class' => 'span3'))?>
				</div>
				<?=$this->Form->submit(__("Create"), array('name'=>'data[EnrollGreeting][create]', 'div' => false, 'class' => 'btn success'))?>
			</div>
		</form>
		<?php endif; ?>
	</div>
</div>
