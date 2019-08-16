<h2><?=__("Campaigns")?></h2>
<ul>
<? foreach ($campaigns as $campaign) { ?>
    <li><?=$this->Wb->eventLink($campaign['VoteCampaign']['name'], '/Vote/View/'.$campaign['VoteCampaign']['id'])?></li>
<? } ?>
</ul>
