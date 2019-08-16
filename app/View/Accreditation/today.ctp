<div class="row">
    <div class="span16">
        <h3><?=__("Accreditations present now")?></h3>

        <table class="zebra-striped bordered-table">
            <tr>
                <th><?=__("Name")?></th>
                <th><?=__("Employer")?></th>
                <th><?=__("From")?></th>
                <th><?=__("To")?></th>
                <th><?=__("Edit")?></th>
                <th><?=__("Check out")?></th>
                <th><?=__("Accepted")?></th>
                <th><?=__("Delete")?></th>
            </tr>
        
        <? foreach($here_now as $accreditation) {
            
            $has_arrived = $accreditation['Accreditation']['actual_arrival'] != '0000-00-00 00:00:00';
            $has_departed = $accreditation['Accreditation']['actual_departure'] != '0000-00-00 00:00:00'; ?>

            <tr>
                <td> <?= $accreditation['Accreditation']['realname'] ?> </td>
                <td> <?= $accreditation['Accreditation']['company_name'] ?> </td>
                <td> <?=date("l, M j", strtotime($accreditation['Accreditation']['arrivaldate']))?> </td>
                <td> <?=date("l, M j", strtotime($accreditation['Accreditation']['departuredate']))?> </td>
                <td> <a href="<?=$this->Wb->eventUrl("/Accreditation/Edit/{$accreditation['Accreditation']['id']}")?>" class="btn"><?=__("Edit")?></a> </td>
            
            <? //Checkout ?>
            <?php if($has_arrived && !$has_departed) { ?>
                <td> <a href="<?=$this->Wb->eventUrl("/Accreditation/Checkout/{$accreditation['Accreditation']['id']}")?>" class="btn"><?=__("Checkout")?></a> </td>
            <? } elseif(!$has_arrived) { ?>
                <td> &nbsp; </td>
            <? } else { ?>
                <td> <?=date("l, M j H:i", strtotime($accreditation['Accreditation']['actual_departure']))?> </td>
            <? } ?>
                <td>
            <? if($accreditation['Accreditation']['accepted'] == 0) { echo "<font color='orange'>Not yet</font>"; }
               else if($accreditation['Accreditation']['accepted'] == 1) { echo "<font color='red'>Declined </font>"; }
               else { echo "<font color='green'>Yes</font>"; }
            ?>
                </td>
                <td> <a href="<?=$this->Wb->eventUrl("/Accreditation/Delete/{$accreditation['Accreditation']['id']}")?>" class="btn danger"><?=__("Delete")?></a> </td>
            </tr>
        <? } ?>

        </table>
    </div>
</div>

<div class="row">
    <div class="span16">
        <h3><?=__("Accreditations that should be here")?></h3>

        <table class="zebra-striped bordered-table">
            <tr>
                <th><?=__("Name")?></th>
                <th><?=__("Employer")?></th>
                <th><?=__("From")?></th>
                <th><?=__("To")?></th>
                <th><?=__("Edit")?></th>
                <th><?=__("Check out")?></th>
                <th><?=__("Accepted")?></th>
                <th><?=__("Delete")?></th>
            </tr>
        
        <? foreach($should_be_here_now as $accreditation) { 
            
            $has_arrived = $accreditation['Accreditation']['actual_arrival'] != '0000-00-00 00:00:00';
            $has_departed = $accreditation['Accreditation']['actual_departure'] != '0000-00-00 00:00:00'; ?>

            <tr>
                <td> <?= $accreditation['Accreditation']['realname'] ?> </td>
                <td> <?= $accreditation['Accreditation']['company_name'] ?> </td>
                <td> <?=date("l, M j", strtotime($accreditation['Accreditation']['arrivaldate']))?> </td>
                <td> <?=date("l, M j", strtotime($accreditation['Accreditation']['departuredate']))?> </td>
                <td> <a href="<?=$this->Wb->eventUrl("/Accreditation/Edit/{$accreditation['Accreditation']['id']}")?>" class="btn"><?=__("Edit")?></a> </td>
            
            <? //Checkout ?>
            <? if($has_arrived && !$has_departed) { ?>
                <td> <a href="<?=$this->Wb->eventUrl("/Accreditation/Checkout/{$accreditation['Accreditation']['id']}")?>" class="btn"><?=__("Checkout")?></a> </td>
            <? } elseif(!$has_arrived) { ?>
                <td> &nbsp; </td>
            <? } else { ?>
                <td> <?=date("l, M j H:i", strtotime($accreditation['Accreditation']['actual_departure']))?> </td>
            <? } ?>
                <td>
            <? if($accreditation['Accreditation']['accepted'] == 0) { echo "<font color='orange'>Not yet</font>"; }
               else if($accreditation['Accreditation']['accepted'] == 1) { echo "<font color='red'>Declined </font>"; }
               else { echo "<font color='green'>Yes</font>"; }
            ?>
                </td>
                <td> <a href="<?=$this->Wb->eventUrl("/Accreditation/Delete/{$accreditation['Accreditation']['id']}")?>" class="btn danger"><?=__("Delete")?></a> </td>
            </tr>
        <? } ?>

        </table>
    </div>
</div>

<div class="row">
    <div class="span16">
        <h3><?=__("Accreditations that have been here")?></h3>

        <table class="zebra-striped bordered-table">
            <tr>
                <th><?=__("Name")?></th>
                <th><?=__("Employer")?></th>
                <th><?=__("From")?></th>
                <th><?=__("To")?></th>
                <th><?=__("Edit")?></th>
                <th><?=__("Check out")?></th>
                <th><?=__("Accepted")?></th>
                <th><?=__("Delete")?></th>
            </tr>
        
        <? foreach($been_here as $accreditation) { 
            
            $has_arrived = $accreditation['Accreditation']['actual_arrival'] != '0000-00-00 00:00:00';
            $has_departed = $accreditation['Accreditation']['actual_departure'] != '0000-00-00 00:00:00'; ?>

            <tr>
                <td> <?= $accreditation['Accreditation']['realname'] ?> </td>
                <td> <?= $accreditation['Accreditation']['company_name'] ?> </td>
                <td> <?=date("l, M j", strtotime($accreditation['Accreditation']['arrivaldate']))?> </td>
                <td> <?=date("l, M j", strtotime($accreditation['Accreditation']['departuredate']))?> </td>
                <td> <a href="<?=$this->Wb->eventUrl("/Accreditation/Edit/{$accreditation['Accreditation']['id']}")?>" class="btn"><?=__("Edit")?></a> </td>
            
            <? //Checkout ?>
            <? if($has_arrived && !$has_departed) { ?>
                <td> <a href="<?=$this->Wb->eventUrl("/Accreditation/Checkout/{$accreditation['Accreditation']['id']}")?>" class="btn"><?=__("Checkout")?></a> </td>
            <? } elseif(!$has_arrived) { ?>
                <td> &nbsp; </td>
            <? } else { ?>
                <td> <?=date("l, M j H:i", strtotime($accreditation['Accreditation']['actual_departure']))?> </td>
            <? } ?>
                <td>
            <? if($accreditation['Accreditation']['accepted'] == 0) { echo "<font color='orange'>Not yet</font>"; }
               else if($accreditation['Accreditation']['accepted'] == 1) { echo "<font color='red'>Declined </font>"; }
               else { echo "<font color='green'>Yes</font>"; }
            ?>
                </td>
                <td> <a href="<?=$this->Wb->eventUrl("/Accreditation/Delete/{$accreditation['Accreditation']['id']}")?>" class="btn danger"><?=__("Delete")?></a> </td>
            </tr>
        <? } ?>

        </table>
    </div>
</div>
