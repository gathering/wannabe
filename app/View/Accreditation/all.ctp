<div class="row">
    <div class="span16">
        <p class="pull-right"><a href="<?=$this->Wb->eventUrl("/Accreditation")?>" class="btn"><?=__("Overview")?></a></p>
        <h3><?=__("All accreditations")?></h3>

        <table id="sortTable" class="zebra-striped bordered-table">
            <thead>
                <tr>
                    <th><?=__("Badge-ID")?></th>
                    <th><?=__("Name")?></th>
                    <th><?=__("Employer")?></th>
                    <th><?=__("From")?></th>
                    <th><?=__("To")?></th>
                    <th><?=__("Check in")?></th>
                    <th><?=__("Check out")?></th>
                    <th><?=__("Edit")?></th>
                    <th><?=__("Accepted")?></th>
                    <th><?=__("Delete")?></th>
                </tr>
            </thead>
            <tbody>
            <? foreach($all_accreditations as $accreditation) {
                $has_arrived = $accreditation['Accreditation']['actual_arrival'] != '0000-00-00 00:00:00';
                $has_departed = $accreditation['Accreditation']['actual_departure'] != '0000-00-00 00:00:00'; ?>

                <tr>
                    <td> <?= $accreditation['Accreditation']['badge_id'] ?> </td>
                    <td> <?= $accreditation['Accreditation']['realname'] ?> </td>
                    <td> <?= $accreditation['Accreditation']['company_name'] ?> </td>
                    <td> <?=date("l, M j", strtotime($accreditation['Accreditation']['arrivaldate']))?> </td>
                    <td> <?=date("l, M j", strtotime($accreditation['Accreditation']['departuredate']))?> </td>

                <? //Checkin ?>
                <? if($has_arrived) { ?>
                    <td> <?= $accreditation['Accreditation']['actual_arrival']; ?> </td>
                <? } else { ?>
                    <td> <a href="<?=$this->Wb->eventUrl("/Accreditation/Checkin/{$accreditation['Accreditation']['id']}")?>" class="btn success"><?=__("Checkin")?></a> </td>
                <? } ?>

                <? //Checkout ?>
                <?php if($has_arrived && !$has_departed) { ?>
                    <td> <a href="<?=$this->Wb->eventUrl("/Accreditation/Checkout/{$accreditation['Accreditation']['id']}")?>" class="btn success"><?=__("Checkout")?></a> </td>
                <? } elseif(!$has_arrived) { ?>
                    <td> &nbsp; </td>
                <? } else { ?>
                    <td> <?=date("l, M j H:i", strtotime($accreditation['Accreditation']['actual_departure']))?> </td>
                <? } ?>
                    <td> <a href="<?=$this->Wb->eventUrl("/Accreditation/Edit/{$accreditation['Accreditation']['id']}")?>" class="btn"><?=__("Edit")?></a> </td>
                    <td>
                <? if($accreditation['Accreditation']['accepted'] == 0) { echo "<font color='orange'>Not yet</font>"; }
                   else if($accreditation['Accreditation']['accepted'] == 1) { echo "<font color='red'>Declined </font>"; }
                   else { echo "<font color='green'>Yes</font>"; }
                ?>
                    </td>
                    <td> <a href="<?=$this->Wb->eventUrl("/Accreditation/Delete/{$accreditation['Accreditation']['id']}")?>" class="btn danger"><?=__("Delete")?></a> </td>
                </tr>
            <? } ?>
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
    // table sort
    $("#sortTable").tablesorter({sortlist: [[0, 0], [1, 0]]});
});
</script>
