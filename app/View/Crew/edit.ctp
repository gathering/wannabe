<?
App::uses('WbSanitize', 'Lib');
?>
<? if($subpageset == True) {
	$baseurl = $this->Wb->eventUrl('/Crew/Edit/'.$crew['Crew']['name']);
	$activecrewapplications_label = ($applications==1 ? __("%s active application", $applications) : __("%s active applications", $applications));
	$waitingcrewapplications_label = ($waitingapplications==1 ? __("%s application on waiting list", $waitingapplications) : __("%s applications on waiting list", $waitingapplications));
	if($accessToEnroll) {
		$activecrewapplications_label = '<a href="'. $this->Wb->eventUrl('/Enroll/Filter?crew_id='.$crew['Crew']['id']) .'">' . $activecrewapplications_label . '</a>';
		$waitingcrewapplications_label = '<a href="'. $this->Wb->eventUrl('/Enroll/Filter?crew_id='.$crew['Crew']['id']) .'&waiting=waiting">' . $waitingcrewapplications_label . '</a>';
	}
	$canManageSomeMembers = false;
?>
	<div class="row">
		<div class="col-md-12">
			<ul class="nav nav-tabs">
				<li class="active"><a data-toggle="tab" href="#members"><?=__("Members")?></a></li>
				<? if($canManage) { ?><li><a data-toggle="tab" href="#teams"><?=__("Teams")?></a></li><? } ?>
				<? if($canManage && $isLevelFour) { ?><li><a data-toggle="tab" href="#new-member"><?=__("Add new member")?></a></li><? } ?>
				<? if($canManage) { ?><li><a data-toggle="tab" href="#description"><?=__("Description")?></a></li><? } ?>
				<? if($canManage && $isSuperUser) { ?><li><a data-toggle="tab" href="#settings"><?=__("Options")?></a></li><? } ?>
			</ul>

			<div class="tab-content">
				<div id="members" class="tab-pane fade in active">
					<div class="row">
						<div class="col-md-12">
							<ul>
								<li><? $status = $crew['Crew']['canapply'] ? __("open") : __("closed"); echo __("The crew is %s for new applications", $status); ?>
								</li>
								<? if($enrollActive) { ?><li><?=$activecrewapplications_label?><? if($waitingapplications) { ?> (<?=$waitingcrewapplications_label?>)<? } ?></li><? } ?>
							</ul>
							<form method="POST" action="<?=$baseurl.'/reject-all'?>" id="crew-rejectall-form">
								<?=$canRejectAll && $applications && $enrollActive ? $this->Form->submit(__('Deny all active applications'), array('name' => 'reject-all', 'class' => 'btn btn-danger')) : null?>
							</form>

							<? if($canManage) { ?>
								<form method="POST" action="<?=$baseurl.'/set-canapply'?>" id="crew-canapply-form">
									<?php
									if( $crew['Crew']['canapply'] ) { ?>
										<?=$this->Form->hidden('Crew.canapply', array('value' => 'FALSE') )?>
										<?=$this->Form->submit(__('Close the crew for new applications'), array('div' => false, 'name' => 'set-canapply', 'class' => 'btn btn-danger'))?>
									<? } else { ?>
										<?=$this->Form->hidden('Crew.canapply', array('value' => 'TRUE') )?>
										<?=$this->Form->submit(__('Open the crew for new applications'), array('div' => false, 'name' => 'set-canapply', 'class' => 'btn btn-success'))?>
									<? } ?>
								</form>
								<br/>
							<?php } ?>
							<a href="<?=$this->Wb->eventUrl('/Crew/viewTaskStatus/'.$crew['Crew']['name'])?>" class="btn btn-default"><?=__("View task status for members")?></a>
							<a href="<?=$this->Wb->eventUrl('/Cleanup/Admin/assign/crew:'.$crew['Crew']['id'])?>" class="btn btn-default"><?=__("Cleanup times for crew")?></a>
						</div>
						<div class="col-md-12">
							<form method="POST" action="<?=$baseurl.'/save-members'?>" id="crew-members-form">
								<hr />
								<h2><?=__("Members")?></h2>

								<? if ( is_array($members) && count($members) > 0 ) { ?>
									<div class="table-responsive">
										<table class="table table-striped">
											<tr>
												<th>&nbsp;</th>
												<th><?=__("Name")?></th>
												<th><?=__("Role")?></th>
												<? if(count($crew['Team'])) { ?>
													<th><?=__("Team")?></th>
												<? } ?>
												<th><?=__("Custom title")?></th>
												<? if($canDeleteMembers) { ?>
													<th>&nbsp;</th>
												<? } ?>
											</tr>
											<? $prevteam = -1; $canManageSomeMembers = false; ?>
											<? foreach ( $members as $member ) { $membertitle = $this->Wb->getUsertitleForCrew($member, $crew['Crew']['id']);?>
											<? if($prevteam != $member['Team']['id']) { $prevteam = $member['Team']['id']; ?>
											<tr><td colspan="8"><strong><? if($member['Team']['name'] == 'NO') { echo __("No teams"); } else { echo WbSanitize::clean($member['Team']['name']); } ?></strong></td></tr>
										<? } ?>
										<tr>
											<td>&nbsp;</td>
											<td><?=$this->Wb->userLink($member)?> (<?=strlen($member['CrewsUser']['title']) ? '<strong>'.$member['CrewsUser']['title'].'</strong>' : $membertitle?>)</td>
											<? if($member['canManage'] && count($manageUserRoles)) { $canManageSomeMembers = true; ?>
												<td><?=$this->Form->select('UserRoles.'.$member['User']['id'], $manageUserRoles, array('value' => (string)$member['CrewsUser']['leader'], 'class' => 'span3', 'empty' => __("Select role")))?> </td>
											<? } else { ?>
												<td><?=$this->Form->select('UserRoles.'.$member['User']['id'], array($member['CrewsUser']['leader'] => $membertitle), array('value' => (string)$member['CrewsUser']['leader'], 'disabled' => 'disabled', 'class' => 'span3'))?> </td>
											<? } ?>

											<? if(count($crew['Team'])) if($member['canManage']) { ?>
												<td><?=$this->Form->select('Userteams.'.$member['User']['id'], $manageTeams, array('value' => (string)$member['Team']['id'], 'class' => 'span4'))?> </td>
											<? } else if(count($crew['Team'])) { ?>
												<td><?=$this->Form->select('Userteams.'.$member['User']['id'], array($member['Team']['id'] => $member['Team']['name']), array('value' => (string)$member['Team']['id'], 'disabled' => 'disabled', 'class' => 'span4'))?> </td>
											<? } ?>

											<? if($isLevelFour or ($isLevelThree and $member['canManage'])) { ?>
												<td><?=$this->Form->text('Customtitle.'.$member['User']['id'], array('title' => __("crewuser-customtitle"), 'value' => $member['CrewsUser']['title'], 'class' => 'span2'))?></td>
											<? } else {
												?>
												<td><?=$this->Form->text('Customtitle.'.$member['User']['id'], array('disabled'=>'true', 'value' => $member['CrewsUser']['title'], 'class' => 'span2'))?></td>
												<?php
											} ?>

											<? if($canDeleteMembers) { ?>
												<td><?=$this->Html->link(__('Remove'), $baseurl.'/delete-member/'.$member['User']['id'], array('class' => 'btn btn-danger'))?></td>
											<? } ?>
										</tr>
									<? } ?>
								</table></div>
							<? } else { ?>
								<p><?=__("No members")?>.</p>
							<? } ?>

							<a class="btn btn-default pull-right" href="#top"><?=__("&#x2191; To top")?></a>
							<?=$canManageSomeMembers ? $this->Form->submit(__('Save'), array('name' => 'save-members', 'class' => 'btn btn-default primary')) : ''?>
						</form>
					</div></div></div>
					<div id="teams" class="tab-pane fade">
						<div class="row">
							<div class="col-md-12">
								<? if($canManage) { ?>
									<form method="POST" action="<?=$baseurl.'/add-team'?>" id="crew-team-form">
										<? if ( is_array($crew['Team']) && count($crew['Team']) ) { ?>
											<ul>
												<? foreach ( $crew['Team'] as $team ) { ?>
													<li> <?=WbSanitize::clean($team['name'])?>&nbsp;<?=$team['locked']?__("(Cannot delete, has mailing list assigned)"):$this->Html->link(__("Delete"), $baseurl.'/delete-team/'.$team['id'])?></li>
												<? } ?>
											</ul>
										<? } else { ?>
											<ul><li><?=__("This crew contains no teams")?></li></ul>
										<? } ?>

										<div class="input-group">
											<span class="input-group-addon" id="basic-addon1"><?=__("Name")?></span>
											<input type="text" class="form-control" name="data[newteam][name]" id="newteamName" placeholder="<?=__("Name")?>" aria-describedby="basic-addon1">
										</div>
										<input name="add-team" class="btn btn-default" type="submit" value="<?=__("Add team")?>" style="margin-top: 20px;">
									</form>
								<? } ?>
							</div></div></div>
							<div id="new-member" class="tab-pane fade">
								<div class="row">
									<div class="col-md-12">
										<? if($canManage && $isLevelFour) { ?>
											<p><?=__("Type in a user ID to add a member manually")?></p>
											<form method="POST" action="<?=$baseurl.'/add-member'?>" id="crew-new-member-form">
												<div class="row">
													<div class="col-md-8">
														<div class="input-group">
															<span class="input-group-addon" id="basic-addon1"><?=__("User ID")?></span>
															<input class="form-control"name="data[newmember][id]" aria-describedby="basic-addon1" type="text" id="newmemberId">
														</div>
													</div>
													<div class="col-md-4">
														<?=$this->Form->select('newmember.usertitle', $manageUserRoles, array('class' => 'form-control', 'empty' => __("Select role")))?>
													</div>
												</div>
												<input name="add-member" class="btn btn-default" type="submit" value="<?=__("Add member")?>" style="margin-top: 20px;">
											</form>
										<? } ?>
									</div></div></div>
									<div id="description" class="tab-pane fade">
										<div class="row">
											<div class="col-md-12">
												<? if( $canManage ) { ?>
													<form method="POST" action="<?=$baseurl.'/save-description'?>" id="crew-description-form">
														<div class="clearfix">
															<textarea name="data[Crew][content]" id="CrewContent" class="form-control" style="height: 400px;"><?=$crew['Crew']['content']?></textarea>
															<span class="help-block"><?=__("Help with")?> <a href="http://daringfireball.net/projects/markdown/syntax">syntax</a>?</span>
														</div>
														<div class="clearfix">
															<?=$this->Form->submit(__('Save description'), array('div' => false, 'name' => 'save-description', 'class' => 'btn btn-default primary'))?>
														</div>
													</form>
												<? } ?>
											</div></div>
										</div>
										<div id="settings" class="tab-pane fade">
											<div class="row">
												<div class="col-md-12">
													<? if( $canManage && $isSuperUser ) { ?>
														<form method="post" action="<?=$baseurl.'/save-settings'?>" id="crew-settings-form">
															<?=$this->Form->hidden('Crew.id', array('value' => $crew['Crew']['id']))?>
															<?=$this->Form->hidden('Other.last_parent', array('value' => $crew['Crew']['crew_id']))?>
															<div class="clearfix <? if($this->Form->error('Crew.name')) echo "error"; ?>">
																<div class="input-group">
																	<span class="input-group-addon"><?=__("Name")?></span>
																	<?=$this->Form->input('Crew.name', array('class' => 'form-control', 'div' => false, 'error' => false, 'label' => false, 'value' => $crew['Crew']['name']))?>
																</div>
																<span class="help-block"><?=$this->Form->error('Crew.name')?></span>
															</div>
															<div class="clearfix <? if($this->Form->error('Crew.crew_id')) echo "error"; ?>">
																<div class="input-group">
																	<span class="input-group-addon"><?=__("Parent crew")?></span>
																	<?=$this->Form->select('Crew.crew_id', $crewlist, array('class' => 'form-control', 'empty' => __("None"), 'div' => false, 'error' => false, 'label' => false, 'value' => $crew['Crew']['crew_id']))?>
																	<span class="help-block"><?=$this->Form->error('Crew.crew_id')?></span>
																</div>
															</div>
															<br/>
															<div class="clearfix">
																<ul class="inputs-list">
																	<li>
																		<label>
																			<?=$this->Form->checkbox('Crew.hidden', array('div' => false, 'error' => false, 'label' => false, 'checked' => $crew['Crew']['hidden']?'checked':''))?>
																			<span><?=__("Hide this crew from the crew list")?></span>
																		</label>
																	</li>
																	<li>
																		<label>
																			<?=$this->Form->checkbox('Crew.canapply', array('div' => false, 'error' => false, 'label' => false, 'checked' => $crew['Crew']['canapply']?'checked':''))?>
																			<span><?=__("Open for applications")?></span>
																		</label>
																	</li>
																</ul>
															</div>
															<div class="clearfix <? if($this->Form->error('Crew.sorted_weight')) echo "error"; ?>">
																<div class="input-group">
																	<span class="input-group-addon"><?=__("Position")?></span>
																	<?=$this->Form->input('Crew.sorted_weight', array('class' => 'form-control','type'=>'number', 'div' => false, 'error' => false, 'label' => false, 'value' => $crew['Crew']['sorted_weight']))?>
																</div>
																<span class="help-block"><?=$this->Form->error('Crew.sorted_weight')?></span>
															</div>
															<div class="actions">
																<?=$this->Form->submit(__("Save"), array('div' => false, 'label' => false, 'name' => 'save-settings', 'class' => 'btn btn-default primary'))?>
															</div>
														</form>
													<? } ?>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
<? } else if($subpageset == False) { ?>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-hover">
				<thead>
					<tr>
						<th><b><?=__("Name")?></b></th>
						<th><b><?=__("Application")?></b></th>
						<th><b><?=__("Edit")?></b></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach($crews as $crewa) {
					foreach($crewa as $crew) { ?>
						<tr>
							<td><a href="<?=$this->Wb->eventUrl("/Crew/Edit/{$crew['name']}")?>"><?=$crew['name']?></a></td>
							<td><?=$crew['canapply']?__("Open"):__("Closed")?></td>
							<td><a href="<?=$this->Wb->eventUrl("/Crew/Edit/{$crew['name']}")?>" role="button" class="btn btn-default"><?=__("Edit")?></a></td>
					</tr>
					<?php } }  ?>
				</tbody>
			</table>
		</div>
	</div>
<? } ?>
