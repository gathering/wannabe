<?
App::uses('WbSanitize', 'Lib');
$cleanmemberlist = array();
foreach ( $members as $crew_id => $crewmembers )
    foreach ( $crewmembers as $member ) $cleanmemberlist[$member['User']['id']] = $member;
?>

<div class="row">
  <div class="col-md-3 visible-xs" id="crew-list-menu" style="position: relative; top: 0px;">
    <div class="row">
      <div class="col-md-12">
        <div class="pull-right">
          <h1><small><?=__("%s members total", sizeof($cleanmemberlist))?>.</small></h1>
        </div>
      </div>
    </div>
  <h4><?=__("Jump to crew…")?></h4>
    <div class="well">
      <ul class="unstyled">
        <? foreach ($crews as $crew) { ?>
          <li><a href="#<?=$crew['Crew']['name']?>"><?=$crew['Crew']['name']?></a></li>
        <? } ?>
      </ul>
    </div>
            <a class="btn small pull-right" href="#top"><?=__("&#x2191; To top")?></a>
  </div>
	<div class="col-md-9">

    <? foreach ( $crews as $crew ) { ?>
	<div class="anchor-link" id="<?=$crew['Crew']['name']?>"></div>
	<div class="page-header"><h3><?=$this->Wb->crewLink($crew)?><small class="pull-right"><?=$num=sizeof($members[$crew['Crew']['id']])?> <?=$num==1?__("member"):__("members")?><? if ( $crew['Crew']['canapply'] ) {
		echo ", ".__("open for applications.");
	} else {
		//echo ", ".__("closed for applications.");
	} ?></small></h3></div><div class="row"><div class="col-md-12">
	<?
                $usedteams = array();

	foreach ( $members[$crew['Crew']['id']] as $member ) {
		if (!isset($usedteams[$member['Team']['id']]) && $member['Team']['id'] > 0) {
			$usedteams[$member['Team']['id']] = true;
			echo '<h4>'.WbSanitize::clean($member['Team']['name']).' <small>'.__("Team").'</small></h4>';
		}
	?>
	<div class="row">
		<div class="col-xs-2"><? if ( $member['User']['image'] ) { ?><img src="<?=$this->Wb->profilePictureUrl($member, 50)?>" alt="" border="0" /><? } ?></div>
		<div class="col-xs-10">
			<address>
				<?=$this->Wb->userLink($member)?>, <?=$this->Wb->getUsertitleForCrew($member, $crew['Crew']['id'])?><br />
				<strong><?=__("Age")?>:</strong><? if($wannabe->lang == 'eng') { ?>&#9;<? } ?>&#9;<?=$member['User']['age']?><br />
				<? if(!empty($member['User']['email'])) { ?><strong><?=__("Email")?>:</strong>&#9;<a href="mailto:<?=$member['User']['email']?>"><?=$member['User']['email']?></a><? } ?><br />
				<? if(!empty($member['Userphone']) && count($member['Userphone'])) { ?>
					<? foreach( $member['Userphone'] as $phone ) { ?>
					<strong><?=$phonetypes[$phone['phonetype_id']]?></strong>:&#9;<?=$phone['number']?><br />
					<? } ?>
				<? } ?>
			</address>
		</div>
	</div>
<?
        }

	?></div>
	<div class="span2">

	</div>
	</div>
    <? } ?>
	</div>
	<div class="col-md-3 hidden-xs" id="crew-list-menu" style="position: relative; top: 0px;">
    <div class="row">
    <div class="col-md-12">
      <div class="pull-right">
        <h1><small><?=__("%s members total", sizeof($cleanmemberlist))?>.</small></h1>
      </div>
    </div>
  </div>
  <h4><?=__("Jump to crew…")?></h4>
    <div class="well">
      <ul class="unstyled">
        <? foreach ($crews as $crew) { ?>
          <li><a href="#<?=$crew['Crew']['name']?>"><?=$crew['Crew']['name']?></a></li>
        <? } ?>
      </ul>
    </div>
            <a class="btn small pull-right" href="#top"><?=__("&#x2191; To top")?></a>
	</div>
</div>
<script type="text/javascript">
jQuery('#crew-list-menu').containedStickyScroll({unstick: false});
</script>
