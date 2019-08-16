<p class="pull-right"><a href="<?=$this->Wb->eventUrl("/Accreditation")?>" class="btn"><?=__("Overview")?></a></p>
<h3><?=__("All accreditations for group '%s'", $name['AccreditationGroup']['name'])?></h3>

<table class="zebra-striped bordered-table">
    <tr>
        <th><?=__("Name")?></th>
        <th><?=__("Employer")?></th>
        <th><?=__("From")?></th>
        <th><?=__("To")?></th>
        <th><?=__("Check in")?></th>
        <th><?=__("Check out")?></th>
        <th><?=__("Edit")?></th>
        <th><?=__("Accepted")?></th>
    </tr>

<? foreach($accreditations as $accreditation) {
    
    $has_arrived = $accreditation['wb4_accreditations']['actual_arrival'] != '0000-00-00 00:00:00';
    $has_departed = $accreditation['wb4_accreditations']['actual_departure'] != '0000-00-00 00:00:00'; ?>

    <tr>
        <td> <?= $accreditation['wb4_accreditations']['realname'] ?> </td>
        <td> <?= $accreditation['wb4_accreditations']['company_name'] ?> </td>
        <td> <?=date("l, M j", strtotime($accreditation['wb4_accreditations']['arrivaldate']))?> </td>
        <td> <?=date("l, M j", strtotime($accreditation['wb4_accreditations']['departuredate']))?> </td>
    
    <? //Checkin ?>
    <? if($has_arrived) { ?>
        <td> <?= $accreditation['wb4_accreditations']['actual_arrival']; ?> </td>
    <? } else { ?>
        <td> <a href="<?=$this->Wb->eventUrl("/Accreditation/GroupCheckin/{$group_id}/{$accreditation['wb4_accreditations']['id']}")?>" class="btn success"><?=__("Checkin")?></a> </td>
    <? } ?>

    <? //Checkout ?>
    <?php if($has_arrived && !$has_departed) { ?>
        <td> <a href="<?=$this->Wb->eventUrl("/Accreditation/GroupCheckout/{$group_id}/{$accreditation['wb4_accreditations']['id']}")?>" class="btn success"><?=__("Checkout")?></a> </td>
    <? } elseif(!$has_arrived) { ?>
        <td> &nbsp; </td>
    <? } else { ?>
        <td> <?=date("l, M j H:i", strtotime($accreditation['wb4_accreditations']['actual_departure']))?> </td>
    <? } ?>        

        <td> <a href="<?=$this->Wb->eventUrl("/Accreditation/GroupEdit/{$group_id}/{$accreditation['wb4_accreditations']['id']}")?>" class="btn"><?=__("Edit")?></a> </td>
        <td>
    <? if($accreditation['wb4_accreditations']['accepted'] == 0) { echo "<font color='orange'>Not yet</font>"; }
       else if($accreditation['wb4_accreditations']['accepted'] == 1) { echo "<font color='red'>Declined </font>"; }
       else { echo "<font color='green'>Yes</font>"; }
    ?>
        </td>
    </tr>
<? } ?>

</table>
