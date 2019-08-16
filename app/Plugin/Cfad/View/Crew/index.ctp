<?php
    foreach($crews as $index => $crew)
        foreach($cfads as $cfad)
            if($cfad['CfadCrew']['crew_id'] == $index)
                unset($crews[$index]);
?>
<div class="row">
    <div class="span8">
        <form method="POST">
            <fieldset>
                <legend><?=__("Available crews")?></legend>
                <div class="clearfix <? if($this->Form->error('CfadCrew.crew_id')) echo "error"; ?>">
                    <label for="data[CfadCrew][crew_id]"><?=__("Crew")?></label>
                    <div class="input">
                        <?=$this->Form->select('CfadCrew.crew_id', $crews, array('div' => false, 'label' => false, 'empty' => __("Choose")))?>
                        <span class="help-block"><?=($this->Form->error('CfadCrew.crew_id')?$this->Form->error('CfadCrew.crew_id'):__("Select crew to open"))?></span>
                    </div>
                </div>
            </fieldset>
            <div class="actions">
                <?=$this->Form->submit(__("Apply"), array('class' => 'btn success', 'name' => 'save'))?>
            </div>
        </form>
    </div>
    <div class="span8">
		<h3><?=__("Open crews")?></h3>
        <?php if(empty($cfads)): ?>
            <p><?=__("No open crews")?></p>
        <?php else: ?>
            <table class="zebra-striped bordered-table">
                <thead>
                    <tr>
                        <th><?=__("Name")?></th>
                        <th><?=__("Remove")?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($cfads as $cfad) { ?>
                        <tr>
                            <td><a href="<?=$this->Wb->eventUrl("/Crew/View/{$cfad['Crew']['name']}")?>"><?=$cfad['Crew']['name']?></a></td>
                            <td><a href="<?=$this->Wb->eventUrl("/cfad/Crew/remove/{$cfad['CfadCrew']['crew_id']}")?>" class="btn danger"><?=__("Remove")?></a></td>
                        </tr>	
                    <?php } ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>
