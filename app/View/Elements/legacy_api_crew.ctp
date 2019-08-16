<?php if(isset($crew['Crew']['CrewsUser'])) $crew['CrewsUser'] = $crew['Crew']['CrewsUser']; ?>
<crew>
    <id><?=utf8_encode($crew['Crew']['id'])?></id>
    <name><?=utf8_encode($crewnames[$crew['Crew']['id']])?></name>
    <?php if(isset($crew['CrewsUser'])) { ?>
        <?php $usertitle = $crew['CrewsUser']['title']?$crew['CrewsUser']['title']:$userroles[$crew['CrewsUser']['leader']]; ?>
        <usertitle><?=utf8_encode($usertitle)?></usertitle>
        <?php if($crew['CrewsUser']['team_id']) { ?>
            <team><![CDATA[<?=utf8_encode($teamnames[$crew['CrewsUser']['team_id']])?>]]></team>
        <?php } ?>
    <?php } ?>
</crew>
