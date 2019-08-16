<div class="row">
    <div class="span8">
        <h4><strong><?=__("Congratulations, %s!",$name)?></strong></h4>
        <p class="justify"><?=__("Takk for din søknad com CFAD på The Gathering!")?></p>
        <p class="justify"><?=__("Vi har nå mottatt din søknad som CFAD (crew for a day) og vil gå gjennom disse fortløpende!")?></p>
    </div>
    <div class="span8">
        <h4><?=__("This is what your application looks like")?></h4>
        <dl style="padding: 0;">
        <? foreach($page as $current) { ?>
            <? switch ($current['CfadApplicationPage']['type'])
                {
                    case 'crewchoice':
                        ?><dt><?=$current['CfadApplicationPage']['name']?></dt> <?
                        ?> <dd><ul class="crewoptions">
                        <? foreach ( $document['CfadApplicationChoice'] as $choice ) {
                            if($choice['crew_id'] == 0 ) { continue; }
                            if($choice['denied']) continue; ?>
                            <li style=""><?=$crews[$choice['crew_id']]?></li>
                        <? } ?>
                        </ul></dd> <?
                        break;
                    case 'crewfield':
                        foreach ( $document['CfadApplicationField'] as $custom ) {
                            foreach ( $current['CfadApplicationAvailableField'] as $field ) {
                                if($field['ApplicationFieldType']['name'] == 'textarea' && $custom['application_availablefield_id'] == $field['id']) {
                                    ?>
                                        <dt style="width:350px;"><?=$field['name']?></dt>
                                        <dd class="textarea"><?=nl2br($custom['value'])?></dd>
                                    <?

                                } else {
                                    foreach ( $document['CfadApplicationChoice'] as $fieldchoice ) {
                                        if( $fieldchoice['crew_id'] == $custom['crew_id'] ) {
                                            if($fieldchoice['denied']) break 2;
                                            if($custom['application_availablefield_id'] == $field['id']) { ?>
                                                <dt style="width:350px;"><?=$field['name']?><? if($custom['crew_id'] != 0) { print " ".$crews[$custom['crew_id']]."?"; } ?></dt>
                                                <dd class="textarea"><?=nl2br($custom['value'])?></dd>
                                            <?php }
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
    <div class="span4 offset12">
        <div class="pull-right">
            <a class="btn" href="<?=$this->Wb->eventUrl('/cfad/CfadApplication')?>"><?=__("Edit your application")?></a>
        </div>
    </div>
</div>
