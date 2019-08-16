<?
App::uses('WbSanitize', 'Lib');
$cleanmemberlist = array();
foreach ( $members as $crew_id => $crewmembers )
    foreach ( $crewmembers as $member ) $cleanmemberlist[$member['User']['id']] = $member;
?>

<div class="row">

  <div class="col-md-3 visible-sm visible-xs" id="crew-list-menu" style="position: relative; top: 0px;">
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
	</div>
	<div class="col-md-9">

    <? foreach ( $crews as $crew ) { ?>
	<div class="anchor-link" id="<?=$crew['Crew']['name']?>"></div>
	<div class="page-header"><h3><?=$this->Wb->crewLink($crew)?><small class="pull-right"><?=$num=sizeof($members[$crew['Crew']['id']])?> <?=$num==1?__("member"):__("members")?><? if ( $crew['Crew']['canapply'] ) {
		echo ", ".__("open for applications.");
	} else {
		//echo ", ".__("closed for applications.");
	} ?></small></h3></div><div class="row"><div class="col-md-12"><dl>
	<?
                $usedteams = array();

	foreach ( $members[$crew['Crew']['id']] as $member ) {
                        if (!isset($usedteams[$member['Team']['id']]) && $member['Team']['id'] > 0) {
                                $usedteams[$member['Team']['id']] = true;
                                echo '<dt><b>'.WbSanitize::clean($member['Team']['name']).'</b> <small>'.__("Team").'</small></dt>';
                        }
            ?><dd style="padding-left: 4px;"><?=$this->Wb->userLink($member)?>, <?=$this->Wb->getUsertitleForCrew($member, $crew['Crew']['id'])?></dd><?
        }

	?></dl></div>
	</div>
    <? } ?>
	</div>
	<div class="col-md-3 hidden-sm hidden-xs" id="crew-list-menu" style="position: relative; top: 0px;">
    <div class="row">
    <div class="col-md-12">
      <div class="pull-right">
        <h1><small><?=__("%s members total", sizeof($cleanmemberlist))?>.</small></h1>
      </div>
    </div>
  </div>
	<h4><?=__("Jump to crew…")?></h4>
		<div class="well" data-spy="affix" data-offset-top="300">
			<ul class="unstyled">
				<? foreach ($crews as $crew) { ?>
					<li><a href="#<?=$crew['Crew']['name']?>"><?=$crew['Crew']['name']?></a></li>
				<? } ?>
			</ul>
      <a class="btn btn-default pull-right" href="#top"><?=__("&#x2191; To top")?></a>
		</div>

	</div>
</div>
