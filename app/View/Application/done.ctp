<div class="row">
	<div class="col-md-6">
		<h4><strong><?=__("Congratulations, %s!",$name)?></strong></h4>
		<p class="justify"><?=$settings['ApplicationSetting']['donestring']?></p>

		<?
		if($settings['ApplicationSetting']['privacy']) {
			?><p><?=__("This application can be reviewed by:")?>
		<?
		if($document['ApplicationDocument']['enableprivacy']) {
			print __("Only leaders of the crews you have chosen to apply for.")."</p>";
		} else {
			print __("Leaders of any crew.")."</p>";
		} ?>
		<? } ?>
	</div>
	<div class="col-md-6">
		<h4><?=__("This is what your application looks like")?></h4>
		<dl style="padding: 0;">
		<? foreach($page as $current) { ?>
			<? switch ($current['ApplicationPage']['type'])
				{
					case 'crewchoice':
						?><dt><?=$current['ApplicationPage']['name']?></dt> <?
						?> <dd><ul class="crewoptions">
						<? foreach ( $document['ApplicationChoice'] as $choice ) {
							if($choice['crew_id'] == 0 ) { continue; }
							if($choice['denied']) continue; ?>
							<li style="">
							<? if($document['ApplicationDocument']['orderedchoices']) { ?>
								<em><? print ((int)$choice['priority'] + 1); ?>.</em>
							<? } ?>
                            <?php if(isset($document['ApplicationDocument']['applyingopen']) && $document['ApplicationDocument']['applyingopen']): ?>
                                Åpen søknad
                            <?php else: ?>
                                <?=$crews[$choice['crew_id']]?></li>
                            <?php endif; ?>
						<? } ?>
						</ul></dd> <?
						break;
					case 'crewfield':
						foreach ( $document['ApplicationField'] as $custom ) {
							foreach ( $current['ApplicationAvailableField'] as $field ) {
								if($field['ApplicationFieldType']['name'] == 'textarea' && $custom['application_availablefield_id'] == $field['id']) {
									?>
										<dt style="width:350px;"><?=$field['name']?></dt>
                                    <dd class="textarea"><pre><?=WbSanitize::clean($custom['value'])?></pre></dd>
									<?

								} else {
									foreach ( $document['ApplicationChoice'] as $fieldchoice ) {
										if( $fieldchoice['crew_id'] == $custom['crew_id'] ) {
										if($fieldchoice['denied']) break 2;
											if($custom['application_availablefield_id'] == $field['id']) {
                                                if($document['ApplicationDocument']['applyingopen']): ?>
                                                    <dt style="width:350px;">Hvorfor søker du med åpen søknad?</dt>
                                                <?php else: ?>
                                                    <dt style="width:350px;"><?=$field['name']?><? if($custom['crew_id'] != 0) { print " ".$crews[$custom['crew_id']]."?"; } ?></dt>
                                                <?php endif; ?>
                                                <dd class="textarea"><pre><?=WbSanitize::clean($custom['value'])?></pre></dd>
                                            <?php }
										}
									}
								}
							}
						}
						break;
					case 'crewquestion':
							foreach ( $document['ApplicationChoice'] as $fieldchoice ) {
								foreach ( $current['ApplicationAvailableField'] as $field ) {
									if( $fieldchoice['crew_id'] == $field['crew_id']) {
										if($fieldchoice['denied']) break 1;
										foreach($document['ApplicationField'] as $custom) {
										if($custom['application_availablefield_id'] == $field['id']) {
											?>
											<dt style="width:350px;"><?=__("From")?> <?=$crews[$custom['crew_id']]?>: <?=$field['name']?></dt>
                                            <dd class="textarea"><pre><?=WbSanitize::clean($custom['value'])?></pre></dd>
											<?
											break;
										}
									}
								}
							}
						}
						break;
				}
		} ?>
		</dl>
	</div>
</div>
<div class="row">
	<div class="col-md-3 COL-MD-OFFSET-9">
		<div class="pull-right">
			<a class="btn" href="<?=$this->Wb->eventUrl('/Application')?>"><?=__("Edit your application")?></a>
		</div>
	</div>
</div>
