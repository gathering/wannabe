<?php
$cleanmemberlist = array();
foreach ( $members as $crew_id => $crewmembers )
    foreach ( $crewmembers as $member ) $cleanmemberlist[$member['User']['id']] = $member;
?>
<h5><?=__("%s of %s members have approved showup time", sizeof($showups), sizeof($cleanmemberlist))?>.</h5>
<?php
foreach($dates as $date) {
    $count = 0;
    foreach($showups as $member) {
        if(strpos($date, $member['ShowupTime']['date']) !== false) {
            $count++;
        }
    }
    ?><div class="page-header">
        <h4><?=date("l, M j", strtotime($date))?>
            <small><?=__("%s persons will show up this day", $count)?></small>
        </h4>
    </div><?
    foreach($showups as $member) {
        if(strpos($date, $member['ShowupTime']['date']) !== false) {
            ?><p><?=$this->Wb->userLink($member)?>: <?=__("ca. %s:00", $member['ShowupTime']['hour'])?><? if($member['ShowupTime']['approved'] == 2): ?>(<?=__("approved")?>) <? endif; ?></p><? 
        }
    }
}
?>
