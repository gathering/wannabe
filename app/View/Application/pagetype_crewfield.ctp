<? foreach ($page['ApplicationAvailableField'] as $index => $field) {
	switch ($field['ApplicationFieldType']['name'])
	{
		case 'textarea':
			?><div class="clearfix">
				<label for="data[ApplicationField][<?=$index?>][value]"><?=$field['name']?></label>
				<div class="input">
					<?php
						print $this->Wb->hidden('ApplicationField.'.$index.'.id');
						print $this->Wb->hidden('ApplicationField.'.$index.'.application_availablefield_id', array('value'=>$field['id']));
						print $this->Wb->textarea('ApplicationField.'.$index.'.value', array('class' => 'form-control', 'rows' => '3', 'div' => false, 'disabled' => $readonly));
					?>
					<span class="help-block"><?=$field['description']?></span>
				</div>
			</div><?
			break;
		case 'crewwhy':
			foreach ($this->data['ApplicationChoice'] as $choice_id) {
				if($choice_id['crew_id'] == 0) {
					continue;
				}
				$match = false;
				$crewindex = 'crew' . $choice_id['crew_id'] . '-'. $field['id'];
				foreach ($this->data['ApplicationField'] as $current_id => $current) {
					if($current['crew_id'] == 0) {
						continue;
					}
				    	if($choice_id['crew_id'] == $current['crew_id']) {
						if($choice_id['denied']) {
							$match = true;
							break 1;
						}
                        if($this->data['ApplicationDocument']['applyingopen'] && $settings['ApplicationSetting']['open'] == $choice_id['crew_id']) {
                            $crewname = 'Hvorfor ønsker du å legge inn en åpen søknad';
                            $description = 'Her forteller du litt om hva du kunne tenke deg å gjøre for The Gathering, og hvilke kvalifikasjoner du har.';
                        } else {
                            $crewname = $field['name'].'<br>'.$crews[$current['crew_id']];
                            $description = $field['description'];
                        }
						$match = true;
						?>
						<div class="clearfix">
							<label for="data[ApplicationField][<?=$crewindex?>][value]"><?=$crewname?>?</label>
							<div class="input">
								<?
									print $this->Wb->hidden('ApplicationField.'.$crewindex.'.id', null, false, $current['id']);
									print $this->Wb->hidden('ApplicationField.'.$crewindex.'.crew_id', null, false, $current['crew_id']);
									print $this->Wb->hidden('ApplicationField.'.$crewindex.'.application_availablefield_id', array('value'=>$field['id']));
									print "<textarea class='form-control' rows='3' name='data[ApplicationField][{$crewindex}][value]'>{$current['value']}</textarea>";
									print "<span class='help-block'>".$description."</span>";
								?>
							</div>
						</div>

						<? break;
					}
				}
				if(!$match) {
                    if($this->data['ApplicationDocument']['applyingopen'] && $settings['ApplicationSetting']['open'] == $choice_id['crew_id']) {
                        $crewname = 'Hvorfor ønsker du å legge inn en åpen søknad';
                        $description = 'Her forteller du litt om hva du kunne tenke deg å gjøre for The Gathering, og hvilke kvalifikasjoner du har.';
                    } else {
                        $crewname = $field['name'].'<br>'.$crews[$choice_id['crew_id']];
                        $description = $field['description'];
                    }
					?>
					<div class="clearfix">
						<label for="data[ApplicationField][<?=$crewindex?>][value]"><?=$crewname?>?</label>
						<div class="input">
							<?
								print $this->Wb->hidden('ApplicationField.'.$crewindex.'.id');
								print $this->Wb->hidden('ApplicationField.'.$crewindex.'.crew_id', null, false, $choice_id['crew_id']);
								print $this->Wb->hidden('ApplicationField.'.$crewindex.'.application_availablefield_id', array('value'=>$field['id']));
								print $this->Wb->textarea('ApplicationField.'.$crewindex.'.value', array('class' => 'form-control', 'rows' => '3', 'div' => false, 'disabled' => $readonly), false, '');
								print "<span class='help-block'>".$description."</span>";
							?>
						</div>
					</div>
				<?php }
			}
			break;
	}
} ?>
