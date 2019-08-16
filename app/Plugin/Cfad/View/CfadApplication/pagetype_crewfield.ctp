<? foreach ($page['CfadApplicationAvailableField'] as $index => $field) {
	switch ($field['ApplicationFieldType']['name'])
	{
		case 'textarea':
			?><div class="clearfix">
				<label for="data[CfadApplicationField][<?=$index?>][value]"><?=$field['name']?></label>
				<div class="input">
					<?php
						print $this->Wb->hidden('CfadApplicationField.'.$index.'.id');
						print $this->Wb->hidden('CfadApplicationField.'.$index.'.application_availablefield_id', array('value'=>$field['id']));
						print $this->Wb->textarea('CfadApplicationField.'.$index.'.value', array('class' => 'xxlarge', 'rows' => '3', 'div' => false));
					?>
					<span class="help-block"><?=$field['description']?></span>
				</div>
			</div><?
			break;
		case 'crewwhy':
			foreach ($this->data['CfadApplicationChoice'] as $choice_id) {
				if($choice_id['crew_id'] == 0) {
					continue;
				}
				$match = false;
				$crewindex = 'crew' . $choice_id['crew_id'] . '-'. $field['id'];
				foreach ($this->data['CfadApplicationField'] as $current_id => $current) {
					if($current['crew_id'] == 0) { 
						continue;
					}
				    	if($choice_id['crew_id'] == $current['crew_id']) {
						if($choice_id['denied']) {
							$match = true;
							break 1;
						}
                        $crewname = $field['name'].'<br>'.$crews[$current['crew_id']];
                        $description = $field['description'];
						$match = true;
						?>
						<div class="clearfix">
							<label for="data[CfadApplicationField][<?=$crewindex?>][value]"><?=$crewname?>?</label>
							<div class="input">
								<?
									print $this->Wb->hidden('CfadApplicationField.'.$crewindex.'.id', null, false, $current['id']);
									print $this->Wb->hidden('CfadApplicationField.'.$crewindex.'.crew_id', null, false, $current['crew_id']);
									print $this->Wb->hidden('CfadApplicationField.'.$crewindex.'.application_availablefield_id', array('value'=>$field['id']));
									print "<textarea class='xxlarge' rows='3' name='data[CfadApplicationField][{$crewindex}][value]'>{$current['value']}</textarea>";			
									print "<span class='help-block'>".$description."</span>";
								?>
							</div>
						</div>
			
						<? break;
					}
				}
				if(!$match) {
                    $crewname = $field['name'].'<br>'.$crews[$choice_id['crew_id']];
                    $description = $field['description'];
					?>
					<div class="clearfix">
						<label for="data[CfadApplicationField][<?=$crewindex?>][value]"><?=$crewname?>?</label>
						<div class="input">
							<?
								print $this->Wb->hidden('CfadApplicationField.'.$crewindex.'.id');
								print $this->Wb->hidden('CfadApplicationField.'.$crewindex.'.crew_id', null, false, $choice_id['crew_id']);
								print $this->Wb->hidden('CfadApplicationField.'.$crewindex.'.application_availablefield_id', array('value'=>$field['id']));
								print $this->Wb->textarea('CfadApplicationField.'.$crewindex.'.value', array('class' => 'xxlarge', 'rows' => '3', 'div' => false), false, '');
								print "<span class='help-block'>".$description."</span>";
							?>
						</div>
					</div> 
				<?php }
			}
			break;
	}
} ?>
