<?php App::uses('WbSanitize', 'Lib');
$cleanmemberlist = array();
foreach ( $members as $index => $crewdates )
    foreach ( $crewdates as $crew_id => $crewmembers )
        foreach ( $crewmembers as $member ) $cleanmemberlist[$member['User']['id']] = $member;
?>
<div class="pull-right">
	<h1><small><?=__("%s members total", sizeof($cleanmemberlist))?>.</small></h1>
</div>
<div class="row">
	<div class="span16">
        <?php foreach($dates as $index => $date): ?>
            <?php $num = 0; ?>
            <?php foreach($crews as $crew) $num = $num + sizeof($members[$index][$crew['Crew']['id']]); ?>
            <?php if(!$num) continue; ?>
            <h2><?=$date?><small> <?=$num?> <?=$num==1?__("member"):__("members")?></small></h2>
            <?php foreach($crews as $crew): ?>
                <?php $num = sizeof($members[$index][$crew['Crew']['id']]); ?>
                <?php if(!$num) continue; ?>
                <div class="anchor-link" id="<?=$crew['Crew']['name']?>"></div>
                <div class="page-header">
                    <h3><small class="pull-right"> <?=$num?> <?=$num==1?__("member"):__("members")?></small><?=$this->Wb->crewLink($crew)?></h3>
                </div>
                <div class="row">
                    <div class="span14">
                        <?php foreach ( $members[$index][$crew['Crew']['id']] as $member ): ?>
                            <div class="row">
                                <div class="span1">
                                    <?php if($member['User']['image']): ?>
                                        <img src="/<?=$member['User']['image']?>_50.png" alt="" border="0" />
                                    <?php endif; ?>
                                </div>
                                <div class="span13">
                                    <address><?=$this->Wb->userLink($member)?><br /><strong><?=__("Age")?>:</strong><? if($wannabe->lang == 'eng') { ?>&#9;<? } ?>&#9;<?=$member['User']['age']?><br /><strong><?=__("Email")?>:</strong>&#9;<a href="mailto:<?=$member['User']['email']?>"><?=$member['User']['email']?></a><br /><? if (count($member['Userphone'])) { ?><? foreach( $member['Userphone'] as $phone ) { ?><strong><?=$phonetypes[$phone['phonetype_id']]?></strong>:&#9;<?=$phone['number']?><br /><? } } ?></address>
                                </div>
                            </div>
                        <?php endforeach;?>
                    </div>
                    <div class="span2">
                        <a class="btn small pull-right" href="#top"><?=__("&#x2191; To top")?></a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endforeach; ?>
	</div>
</div>
