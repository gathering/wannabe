<div class="row">
    <div class="span6">
        <p><?=__("Administration for crew for a day")?></p>
    </div>
    <div class="span10">
        <a href="<?=$this->Wb->eventUrl('/cfad/Member')?>" class="btn"><?=__("View members")?></a> 
        <a href="<?=$this->Wb->eventUrl('/cfad/Crew')?>" class="btn"><?=__("Administer crews")?></a> 
        <a href="<?=$this->Wb->eventUrl('/cfad/CfadAdmin')?>" class="btn"><?=__("Application pages")?></a>
        <a href="<?=$this->Wb->eventUrl('/cfad/CfadAdmin/settings')?>" class="btn"><?=__("Application settings")?></a>
    </div>
</div>
<div class="row">
	<div class="span16">
		<h2><?=__("Applications")?></h2>
		<table class="bordered-table zebra-striped" id="sortTable">
			<thead>
				<tr>
					<th id="name" class="yellow"><?=__('Name')?></th>
					<th id="age" class="blue"><?=__('Age')?></th>
					<th id="crew" class="green"><?=__('Applying for')?></th>
					<th id="date" class="red"><?=__("Last updated")?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($cfads as $document) {
					$havepending = false;
					foreach($document['CfadApplicationChoice'] as $choice){
                       
                       if(isset($_REQUEST['denied'])) {
                            if($choice['accepted']) {
                                continue 2;
                            }
                            else if ($choice['denied']) {
                                $havepending = true;
                            }
                       }
                       else if($choice['crew_id'] != 0 && !$choice['accepted'] && !$choice['denied']) {
							$havepending = true;
						}
					}
					if(!$havepending)
						continue;
					$i = 0;
					$canview = false;
					foreach ($document['CfadApplicationChoice'] as $choice) {
						if ($choice['crew_id'] > 0)
							$i++;
					}
					if ($i > 0) { ?>
						<tr>
							<td><?=$this->Wb->link($document['User']['realname'].(!empty($document['User']['nickname']) ? ' aka ' . $document['User']['nickname'] : null), $this->Wb->eventUrl('/cfad/Handle/view/'.$document['User']['id']))?></td>
							<td><?=$document['User']['age']?></td>
							<td>
								<?php foreach($document['CfadApplicationChoice'] as $choice) { 
									if ($choice['crew_id'] != 0 && !$choice['accepted'] && !$choice['denied']) {?>
										<?=$this->Wb->link($crews[$choice['crew_id']], $this->Wb->eventUrl('/cfad/Filter?crew_id='.$choice['crew_id']))?>
									<?php } ?>
								<?php } ?>
							</td>
                            <td><?=date("M j, Y G:i", strtotime($document['CfadApplicationDocument']['updated']))?></td>
						</tr>
					<?php } ?>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
