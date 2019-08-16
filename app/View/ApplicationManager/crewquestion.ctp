<div class="row">
	<div class="span12">
		<form method="post" action="<?=$this->Wb->eventUrl('/ApplicationManager/question')?>">
			<fieldset>
				<legend><?=__("Create new")?></legend>
				<?=$this->Form->hidden('ApplicationAvailableField.event_id', array('value' => WB::$event->id))?>
				<?=$this->Form->hidden('ApplicationAvailableField.application_fieldtype_id', array('value' => '10'))?>
				<?=$this->Form->hidden('ApplicationAvailableField.application_page_id', array('value' => $pageid))?>
				<?=$this->Form->hidden('ApplicationAvailableField.user_id', array('value' => $wannabe->user['User']['id']))?>
				<div class="clearfix">
					<label for="data[ApplicationAvailableField][name]"><?=__("Question")?></label>
					<div class="input">
						<?=$this->Form->text('ApplicationAvailableField.name', array('div' => false, 'label' => false, 'class' => 'span8'))?>
					</div>
				</div>
				<div class="clearfix">
					<label for="data[ApplicationAvailableField][description]"><?=__("Description")?></label>
					<div class="input">
						<?=$this->Form->textarea('ApplicationAvailableField.description', array('div' => false, 'label' => false, 'rows' => 5, 'class' => 'span8'))?>
					</div>
				</div>
				<div class="clearfix">
					<label for="data[ApplicationAvailableField][crew_id]"><?=__("For crew")?></label>
					<div class="input">
						<select name="data[ApplicationAvailableField][crew_id]">
							<option selected="selected" value="0"><?=__("Choose")?></option>
							<? foreach ($manageable_crews as $crew_id => $current): ?>
								<? if($current[0]): ?>
									<option value="<?=$crew_id?>"<? if($filter_id == $crew_id) { ?>selected="selected" <? } elseif(!$filter_id && $crew_id == $wannabe->user['Crew'][0]['id']) { ?>selected="selected" <? } ?>><?=$current[1]?></option>
								<? endif; ?>
							<? endforeach; ?>
						</select>
					</div>
				</div>
				<div class="clearfix">
					<div class="input">
						<?=$this->Form->submit(__("Create"), array('name'=>'data[ApplicationAvailableField][new]', 'class' => 'btn success', 'div' => false))?>
					</div>
				</div>
			</fieldset>
		</form>
		<? if(empty($fields)): ?>
		<hr />
		<div class="clearfix">
			<div class="input">
				<p><?=__("No questions")?>.</p>
			</div>
		</div>
		<? endif; ?>

		<? foreach ($fields as $index => $field): ?>
		<hr />
		<form method="post" action="<?=$this->Wb->eventUrl('/ApplicationManager/question')?>">
			<fieldset>
				<legend><?=$this->Wb->crewLink2($crews[$field['ApplicationAvailableField']['crew_id']])?>: <?=$field['ApplicationAvailableField']['name']?></legend>
				<?=$this->Form->hidden('ApplicationAvailableField.id', array('value' => $field['ApplicationAvailableField']['id']))?>
				<div class="clearfix">
					<label for="data[ApplicationAvailableField][name]"><?=__("Question")?></label>
					<div class="input">
						<?=$this->Form->text('ApplicationAvailableField.name', array('value' => $field['ApplicationAvailableField']['name'], 'div' => false, 'label' => 'false', 'class' => 'span8'))?>
					</div>
				</div>
				<div class="clearfix">
					<label for="data[ApplicationAvailableField][description]"><?=__("Description")?></label>
					<div class="input">
						<?=$this->Form->textarea('ApplicationAvailableField.description', array('value' => $field['ApplicationAvailableField']['description'], 'rows' => 5, 'class' => 'span8'))?>
					</div>
				</div>
				<?php
					$createdby = array();
					$createdby['User'] = $field['CreatedBy'];
				?>
				<div class="clearfix">
					<div class="input">
						<p><small><?=__("Created by %s", $this->Wb->userLink($createdby))?></small></p>
					</div>
				</div>
				<div class="clearfix">
					<div class="input">
						<div class="inline-inputs">
							<?=$this->Form->submit(__("Update"), array('name'=>'data[ApplicationAvailableField][update]', 'div' => false, 'class' => 'btn success'))?>
							<?=$this->Form->submit(__("Delete"), array('name'=>'data[ApplicationAvailableField][delete]', 'div' => false, 'class' => 'btn danger'))?>
						</div>
					</div>
				</div>
			</fieldset>
		</form>
		<? endforeach; ?>
		
		
	</div>
	<div class="span4">
		<form method="post" action="<?=$this->Wb->eventUrl('/ApplicationManager/filter')?>">
			<h4><?=__("Filter")?></h4>
			<div class="well">
				<div class="clearfix">
					<select class="span3" name="data[crew_id]">
						<option value="0"><?=__("Choose")?></option>
						<? foreach ($manageable_crews as $crew_id => $current): ?>
							<? if($current[0]): ?>
								<option value="<?=$crew_id?>" <? if($filter_id == $crew_id) { ?>selected="selected" <? } elseif(!$filter_id && $crew_id == $wannabe->user['Crew'][0]['id']) { ?>selected="selected" <? } ?>><?=$current[1]?></option>
							<? endif; ?>
						<? endforeach; ?>
					</select>
				</div>
				<?=$this->Form->submit('Filter', array('name'=>'data[filter]', 'div' => 'false', 'label' => 'false', 'class'=> 'btn primary'))?>
			</div>
		</form>
	</div>
</div>
