<?
$unordered = $document['ApplicationDocument']['orderedchoices'];
$privacy = $document['ApplicationDocument']['enableprivacy'];
$document_id = $document['ApplicationDocument']['id'];
$priority = $document['ApplicationDocument']['priority'];

$crews_applied = array();
foreach ($document['ApplicationChoice'] as $choice) {
	$crews_applied[] = (int)$choice['crew_id'];
}

$private = true;
foreach ($crews_applied as $choice) {
	foreach($manageable_crews as $index => $manage) {
		if($choice == $index && $manage)
			$private = false;
	}
}

if($private && $privacy) {
	throw new BadRequestException(__("This applicant has chosen to restrict viewing of this application to chiefs of the crews the applicant is currently applying for."));
}
$sideheader = null;
if($settings['ApplicationSetting']['privacy'] && $superuser) {
	if ($document['ApplicationDocument']['enableprivacy']) {
		$sideheader = __("Restricted application");
	} else {
		$sideheader = __("Open application");
	}
}
?>
<div class="row">
	<div class="span8">
		<?=$this->element('profile', array('user' => $document['User']['id'], 'header' => $sideheader))?>
	</div>
	<div class="span8">
		<?php foreach ($page as $current) {
			switch ($current['ApplicationPage']['type']) {
				case 'crewchoice': ?>
					<h3><?=$current['ApplicationPage']['name']?>
					<? if($settings['ApplicationSetting']['priority']) { ?>
						<small>
						<? if ($document['ApplicationDocument']['orderedchoices']) { ?>
							<?=__("Prioritized")?>
						<? } else { ?>
							<?=__("Not prioritized")?>
						<? } ?>
						</small>
					<? } ?>
					</h3>
					<table class="bordered-table zebra-striped">
						<thead>
							<tr>
								<?php if ($document['ApplicationDocument']['orderedchoices']) {
									?><th><?=__("#")?></th><?
								} ?>
								<th><?=__("Choice")?></th>
								<th><?=__("Actions")?></th>
							</tr>
						</thead>
						<tbody>
							<? foreach ( $document['ApplicationChoice'] as $choice ) {
								echo "<tr>";
								if (!$choice['crew_id'])
									break;
								if ($document['ApplicationDocument']['orderedchoices']) {
									?><td><? print ((int)$choice['priority'] + 1); ?>.</td><?
								}
								echo "<td>";
								if ($choice['denied'] || $choice['disabled']) {
									?><del><?=$crews[$choice['crew_id']]?></del><?
                                } else if ($choice['waiting']) {
                                    ?><?=$crews[$choice['crew_id']]?> &ndash; <?=__("wait list")?><?
								} else {
									?><?=$crews[$choice['crew_id']]?><?
								}
								echo "</td>";
								echo "<td>&nbsp;";
								if ($choice['acceptable'] && ($enrollsetting['EnrollSetting']['enrollaccept'] || $superuser)) {
									?> <a class="btn success" href="<?=$this->Wb->eventUrl('/Enroll/accept?document_id='.$document_id.'&choice_id='.$choice['id'])?>"><?=__('Accept')?></a><?
								}
								if ($choice['deniable'] && ($enrollsetting['EnrollSetting']['enrollaccept'] || $superuser)) {
									?> <a class="btn danger" href="<?=$this->Wb->eventUrl('/Enroll/deny?document_id='.$document_id.'&choice_id='.$choice['id'])?>"><?=__('Deny')?></a><?
								}
								if ($choice['waitable'] && ($enrollsetting['EnrollSetting']['enrollaccept'] || $superuser)) {
									?> <a class="btn info" href="<?=$this->Wb->eventUrl('/Enroll/wait?document_id='.$document_id.'&choice_id='.$choice['id'])?>"><?=__('Wait list')?></a><?
								}
								if ($choice['disableable'] && ($enrollsetting['EnrollSetting']['enrollaccept'] || $superuser)) {
									?> <a class="btn" href="<?=$this->Wb->eventUrl('/Enroll/disable?document_id='.$document_id.'&choice_id='.$choice['id'])?>"><?=__('Disable')?></a><?
								}
								echo "</td>";
								echo "</tr>";
							} ?>
						</tbody>
					</table>
				<?php break;
			}
		} ?>
	</div>
</div>
<hr />
<div class="row">
	<div class="span8">
		<h2><?=__("Application")?></h2>
		<? foreach ($page as $current) {
			switch ($current['ApplicationPage']['type']) {
				case 'crewfield':
				foreach ($document['ApplicationField'] as $custom) {
					foreach ($current['ApplicationAvailableField'] as $field) {
						if ($custom['application_availablefield_id'] == $field['id']) {
							if ($custom['crew_id'] != 0 && !in_array((int)$custom['crew_id'], $crews_applied))
							continue;
							if(isset($document['ApplicationDocument']['applyingopen']) && $document['ApplicationDocument']['applyingopen']){
								$crews[$custom['crew_id']] = 'åpent';
							}
							?><p><strong><?=$field['name']?><?=$custom['crew_id'] != 0? " ".$crews[$custom['crew_id']]."?":''?></strong><br /><?
							?><small><?=WbSanitize::clean($field['description'])?></small></p><?
							?><pre> <?=WbSanitize::clean($custom['value'])?> </pre><?
						}
					}
				}
				break;
			}
		} ?>
	</div>
	<div class="span8 span-left-rule">
		<h2><?=__("Crew questions")?></h2>
		<? $crewq = false;
		foreach ($page as $current) {
			switch ($current['ApplicationPage']['type']) {
				case 'crewquestion':
					if(!$settings['ApplicationSetting']['crewquestion'])
						break;
					foreach ( $document['ApplicationChoice'] as $fieldchoice ) {
						foreach ( $current['ApplicationAvailableField'] as $field ) {
							if( $fieldchoice['crew_id'] == $field['crew_id']) {
								if($fieldchoice['denied'])
									break 1;
								foreach($document['ApplicationField'] as $custom) {
									if($custom['application_availablefield_id'] == $field['id']) {
										$crewq = true;
										?>
										<p><strong><?=__("From")?> <?=$crews[$custom['crew_id']]?>: <?=$field['name']?></strong><br />
										<small><?=WbSanitize::clean($field['description'])?></small></p>
										<pre> <?=WbSanitize::clean($custom['value'])?> </pre>
										<?
										break;
									}
								}
							}
						}
					}
				break;
			}
		}
		if(!$crewq) echo "<p>".__("The crews the applicant has applied for has no questions")."</p>"; ?>
	</div>
</div>
<hr />
<div class="row">
	<div class="span8">
		<form method="post" id="tagform" action="<?=$this->Wb->eventUrl('/Enroll/savetags/'.$document['ApplicationDocument']['id'])?>">
			<fieldset>
				<div class="clearfix">
					<label for="data[tags]"><?=__("Tags")?></label>
					<div class="input">
						<input type="text" name="data[tags]" value="<?=$tags?>" size="64" />&nbsp;<input type="submit" value="<?=__("Save")?>" class="btn" />
						<span class="help-block"><?=__("Separate each tag with a comma (these tag are only available to you)")?></span>
					</div>
				</div>
			</fieldset>
		</form>
		<form method="post" id="priorityform" action="<?=$this->Wb->eventUrl('/Enroll/savepriority/'.$document['ApplicationDocument']['id'])?>">
			<fieldset>
				<div class="clearfix">
					<label for="data[priority]"><?=__("Priority")?></label>
					<div class="input">
						<select name="data[priority]">
							<? for($i = 1; $i <= 6; $i++) {
								?><option value=<?=$i?><?=($i == (int)$priority ? " selected='selected'" : "")?>><?=$i?></option><?
							} ?>
						</select>
						<input type="submit" value="<?=__("Save")?>" class="btn">
						<span class="help-block"><?=__("Priority for sorting in the overview (6 is lowest, 1 is highest)")?></span>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
	<div class="span8 span-left-rule">
		<h2><?=__("Comments")?></h2>
		<form method="post" id="commentform" action="<?=$this->Wb->eventUrl('/Enroll/addcomment/'.$document['ApplicationDocument']['id'])?>">
			<fieldset>
				<div class="clearfix">
					<textarea style="width:100%;" name="data[comment]"></textarea>
					<br />
					<input type="submit" value="<?=__("Add")?>" class="btn" />
				</div>
			</fieldset>
		</form>
		<? foreach ($comments as $comment) {
			$time = strtotime($comment["ApplicationComment"]["created"]." UTC");
			$localTime = date("Y-m-d H:i:s", $time);
			?><hr><p><strong><?=$this->Html->link($comment['User']['realname'].(!empty($comment['User']['nickname']) ? ' aka ' . $comment['User']['nickname'] : null), $this->Wb->eventUrl('/Profile/view/'.$comment['User']['id']))?></strong><br /><?
			?><small><?=$localTime?></small></p><?
			?><p><?=$comment["ApplicationComment"]["content"]?></p><?
		} ?>
	</div>
</div>
