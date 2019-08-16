<?
$document_id = $document['CfadApplicationDocument']['id'];

$crews_applied = array();
foreach ($document['CfadApplicationChoice'] as $choice) {
	$crews_applied[] = (int)$choice['crew_id'];
}


?>
<div class="row">
	<div class="span8">
		<?=$this->element('profile', array('user' => $document['User']['id'], 'header' => __("Profile")))?>
	</div>
	<div class="span8">
		<?php foreach ($page as $current) {
			switch ($current['CfadApplicationPage']['type']) {
				case 'crewchoice': ?>
					<h3><?=$current['CfadApplicationPage']['name']?> 
					</h3>
					<table class="bordered-table zebra-striped">
						<thead>
							<tr>
								<th><?=__("Choice")?></th>
								<th><?=__("Actions")?></th>
							</tr>
						</thead>
						<tbody>
							<? foreach ( $document['CfadApplicationChoice'] as $choice ) {
								echo "<tr>";
								if (!$choice['crew_id'])
									break;
								echo "<td>";
								if ($choice['denied']) {
									?><del><?=$crews[$choice['crew_id']]?></del><?
								} else {
									?><?=$crews[$choice['crew_id']]?><?
								}
								echo "</td>";
                                echo "<td>&nbsp;";
                                if(!$choice['denied']) {
                                    if($choice['accepted']) {
                                        echo __("Accepted");
                                    } else {
                                        echo "<a class='btn success' href='".$this->Wb->eventUrl('/cfad/Handle/accept?document_id='.$document_id.'&choice_id='.$choice['id'])."'>".__('Accept')."</a>&nbsp;";
                                        echo "<a class='btn danger' href='".$this->Wb->eventUrl('/cfad/Handle/deny?document_id='.$document_id.'&choice_id='.$choice['id'])."'>".__('Deny')."</a>";
                                    }
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
			switch ($current['CfadApplicationPage']['type']) {
				case 'crewfield':
					foreach ($document['CfadApplicationField'] as $custom) {
						foreach ($current['CfadApplicationAvailableField'] as $field) {
							if ($custom['application_availablefield_id'] == $field['id']) {
								if ($custom['crew_id'] != 0 && !in_array((int)$custom['crew_id'], $crews_applied))
                                    continue;
								?><p><strong><?=$field['name']?><?=$custom['crew_id'] != 0? " ".$crews[$custom['crew_id']]."?":''?></strong><br /><?
								?><small><?=$field['description']?></small></p><?
								?><p class="justify"><?=nl2br($custom['value'])?></p><?
							}
						}
					}
				break;
			}
		} ?>
	</div>
</div>
