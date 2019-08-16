<? if($campaignvalid) { ?>
<p><?=__("This campaign is currently active! The results will be published as soon as the campaign closes. (%s)", strftime(__("%b %e %G, %H:%M"), strtotime($campaign['VoteCampaign']['ends'])))?></p>
<p><?=__("Preliminary voter turnout:")?> <strong><? echo round((count($campaign['VoteVote'])/($crewcount/100)),2) ?> %</strong>.</p>
<? } else { ?>
<p>
<?=__("Eligible voters: %s individuals", $crewcount)?><br />
<?=__("Votes: %s individuals", count($campaign['VoteVote']))?><br />
<?=__("Voter turnout: %s", round((count($campaign['VoteVote'])/($crewcount/100)),2))?> %<br />
<ol>
<? foreach($campaign['VoteOption'] as $option) { ?>
<li>
<?=$option['name']?>:
<?
$count = 0;
foreach($campaign['VoteVote'] as $vote) {
        if($vote['option_id'] == $option['id']) $count++;
}
?>
    <?=$count?> <?=__("votes")?> &ndash; <? echo round(($count/(count($campaign['VoteVote'])/100)),2) ?> %.
</li>
<? } ?>
</ol>
</p>
<? } ?>
