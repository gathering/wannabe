<p><?=nl2br($campaign['VoteCampaign']['description'])?></p>
<p>&nbsp;</p>
<form method="post" action="<?=$this->Wb->eventUrl('/Vote/RegisterVote')?>">
    <input type="hidden" name="data[VoteVote][campaign_id]" value="<?=$campaign['VoteCampaign']['id']?>" />
    <fieldset>
        <legend>
            <? if($campaignvalid) { ?>
                <?=__("Campaign closes %s", strftime(__("%b %e %G, %H:%M"), strtotime($campaign['VoteCampaign']['ends'])))?>
            <? } else { ?>
                <?=__("Campaign closed")?>
            <? } ?>
        </legend>
        <div class="clearfix">
            <label><?=__("Choices")?></label>
            <? foreach ($campaign['VoteOption'] as $option) { 
                if(isset($vote['VoteVote'])) $selected = $vote['VoteVote']['option_id'] == $option['id'];
                else $selected = null; ?>
                <div class="input">
                    <ul class="inputs-list">
                        <li>
                            <label>
                                <input type="radio" <? if(!$campaignvalid) echo 'disabled="disabled"'; ?><?=($selected==$option['id']?'checked':null)?> name="data[VoteVote][option_id]" value="<?=$option['id']?>" />
                                <span><?=($selected?'<strong class="green">':null)?><?=$option['name']?><?=($selected?'</strong>':null)?></span>
                            </label>
                        </li>
                    </ul>
                    <?php if($option['description'] || $option['url'] || $option['user_id']) { ?>
                        <span class="help-block">
                            <?php if($option['description']) { ?><em><?=$option['description']?></em><?php } ?>
                            <?php if($option['description'] && (($option['url']) || ($option['user_id']))) { ?> &ndash; <?php } ?>
                            <?php if($option['user_id']) { ?><?=($option['user_id']?$this->Wb->link(__("Profile"), $this->Wb->eventUrl('/Profile/View/'.$option['user_id'])):null)?>
                                <?php if($option['url']) { echo " / "; } } ?>
                            <?php if($option['url']) { ?><?=($option['url']?$this->Wb->link(__("Read more…"), $option['url']):null)?><?php } ?>
                        </span>
                    <?php } ?>
                </div>
            <? } ?>
        </div>
        <? if($campaignvalid) { ?>
            <div class="actions">
                <input type="submit" class="btn success" value="<?=__("Choose")?>" />
            </div>
        <? } ?>
    </fieldset>
</form>
