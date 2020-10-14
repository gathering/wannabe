<?php
App::uses('WbSanitize', 'Lib');
if($subpageset == True) {
?>

<div class="row">
	<div class="col-md-6">
		<div class="page-header">
			<h3><?=__("Members")?> <?if ($canManage) {?><?=$this->Wb->eventLink(__("Edit crew"), "/Crew/Edit/{$crew['Crew']['name']}", array('class' => 'btn btn-default'))?><?}?></h3>
		</div>
		<?php
			$usedteams = array();
			if(empty($members)) echo "<p>".__("No members")."</p>";
			foreach ( $members as $member ) {
				if (!isset($usedteams[$member['Team']['id']]) && $member['Team']['id'] > 0) {
					$usedteams[$member['Team']['id']] = true;
					echo '<h4>'.WbSanitize::clean($member['Team']['name']).' <small>'.__("Team").'</small></h4>';
				}
		?>
				<div class="row">
					<div class="col-xs-2"><? if ( $member['User']['image'] ) { ?><img src="/<?=$member['User']['image']?>_50.png" alt="" border="0" /><? } ?></div>
					<div class="col-xs-10">
					<address><?=$this->Wb->userLink($member)?>, <?=$this->Wb->getUsertitleForCrew($member, $crew['Crew']['id'])?><br />
					<strong><?=__("Age")?>:</strong>
					<?php if($wannabe->lang == 'eng') { echo  "&#9;"; } ?>&#9;<?=$member['User']['age']?><br />
					<? if(!empty($member['User']['email'])) {
						?><strong><?=__("Email")?>:</strong>&#9;<a href="mailto:<?=$member['User']['email']?>"><?=$member['User']['email']?></a>
					<? } ?><br />
					<? if(!empty($member['Userphone'] && count($member['Userphone']))) { ?>
						<? foreach( $member['Userphone'] as $phone ) { ?><strong><?=$phonetypes[$phone['phonetype_id']]?></strong>:&#9;<?=$phone['number']?><br /><? } ?>
					<? } ?>
					</address>
					</div>
				</div>
		<?php
			}
		?>
	</div>
	<div class="col-md-6">
		<div class="page-header">
			<h4><?=__("Wiki page")?> <small><?=__("Viewable for crew members only")?></small></h4>
		</div>
		<?=$this->element('wikipage', array('page' => "Crew:{$crew['Crew']['name']}"))?>

		<div class="page-header">
			<h4><?=__("Description")?> <small><?=__("Viewable for crew applicants")?></small></h4>
		</div>
		<p><? if(!preg_match('/^\s+$/', $crew['Crew']['content'])) { echo $crew['Crew']['content']; } else { echo __("This crew has no description"); } ?></p>

	</div>

</div>

<? } else if($subpageset == False) { ?>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-hover">
				<thead>
					<tr>
						<th><b><?=__("Name")?></b></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach($crews as $crew) {?>
						<tr>
							<td><a href="<?=$this->Wb->eventUrl("/Crew/View/{$crew['name']}")?>"><?=$crew['name']?></a></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
<? } ?>
