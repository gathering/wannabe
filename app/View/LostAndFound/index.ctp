<div class="row"> 
    <div class="span3 offset12 into-header">
        <h4><?=__("Add new item")?></h4>
        <div class="well">
            <a href="<?=$this->Wb->eventUrl("/LostAndFound/Add")?>" class="btn primary"><?=__("Add new")?></a>
        </div>
    </div>
</div>

<div class="row">
    <div class="span16">
        <div class="pull-right">
            <form method="post" action="<?=$this->Wb->eventUrl("/LostAndFound/Search")?>">
                <label><?=__("Search items")?></label>
                <div class="input">
                    <?=$this->Form->input('LostAndFound.query', array('div' => false, 'error' => false, 'label' => false))?>
                </div>
            </form>
        </div>

        <br />
        <h3><?=__("Lost items")?></h3>

        <table class="zebra-striped bordered-table">
            <tr>
                <th><?=__("Name")?></th>
                <th><?=__("Description")?></th>
                <th><?=__("Lost where")?></th>
                <th><?=__("Lost when")?></th>
                <th><?=__("Reported by")?></th>
                <th><?=__("Contact")?></th>
                <th><?=__("Edit")?></th>
                <th><?=__("Resolve")?></th>
                <th><?=__("Delete")?></th>
            </tr>
        
        <? foreach($lost as $item) { ?>
            <tr>
                <td> <?= $item['LostAndFound']['name'] ?> </td>
                <td> <?= $item['LostAndFound']['description'] ?> </td>
                <td> <?= $item['LostAndFound']['found_where'] ?> </td>
                <td> <?= $item['LostAndFound']['found_when'] ?> </td>
                <td> <?= $item['LostAndFound']['reported_by'] ?> </td>
                <td> <?= $item['LostAndFound']['reported_by_contact'] ?> </td>
                <td><a href="<?=$this->Wb->eventUrl("/LostAndFound/Edit/{$item['LostAndFound']['id']}")?>" class="btn primary"><?=__("Edit")?></a> </td>
                <td><a href="<?=$this->Wb->eventUrl("/LostAndFound/Resolve/{$item['LostAndFound']['id']}")?>" class="btn success"><?=__("Resolve")?></a> </td>
                <td><a href="<?=$this->Wb->eventUrl("/LostAndFound/Delete/{$item['LostAndFound']['id']}")?>" class="btn danger"><?=__("Delete")?></a> </td>
            </tr>
        <? } ?>

        </table>
        
        <hr />
        <h3><?=__("Found items")?></h3>
        
        <table class="zebra-striped bordered-table">
            <tr>
                <th><?=__("Name")?></th>
                <th><?=__("Description")?></th>
                <th><?=__("Found where")?></th>
                <th><?=__("Found when")?></th>
                <th><?=__("Reported by")?></th>
                <th><?=__("Contact")?></th>
                <th><?=__("Edit")?></th>
                <th><?=__("Resolve")?></th>
                <th><?=__("Delete")?></th>
            </tr>
        
        <? foreach($found as $item) { ?>
            <tr>
                <td> <?= $item['LostAndFound']['name'] ?> </td>
                <td> <?= $item['LostAndFound']['description'] ?> </td>
                <td> <?= $item['LostAndFound']['found_where'] ?> </td>
                <td> <?= $item['LostAndFound']['found_when'] ?> </td>
                <td> <?= $item['LostAndFound']['reported_by'] ?> </td>
                <td> <?= $item['LostAndFound']['reported_by_contact'] ?> </td>
                <td><a href="<?=$this->Wb->eventUrl("/LostAndFound/Edit/{$item['LostAndFound']['id']}")?>" class="btn primary"><?=__("Edit")?></a> </td>
                <td><a href="<?=$this->Wb->eventUrl("/LostAndFound/Resolve/{$item['LostAndFound']['id']}")?>" class="btn success"><?=__("Resolve")?></a> </td>
                <td><a href="<?=$this->Wb->eventUrl("/LostAndFound/Delete/{$item['LostAndFound']['id']}")?>" class="btn danger"><?=__("Delete")?></a> </td>
            </tr>
        <? } ?>

        </table>
        
        <hr />
        <h3><?=__("Resolved items")?></h3>
        
        <table class="zebra-striped bordered-table">
            <tr>
                <th><?=__("Name")?></th>
                <th><?=__("Description")?></th>
                <th><?=__("Found where")?></th>
                <th><?=__("Found when")?></th>
                <th><?=__("Delivered to")?></th>
                <th><?=__("Delivered to contact")?></th>
                <th><?=__("Delivered when")?></th>
                <th><?=__("View")?></th>
                <th><?=__("Delete")?></th>
            </tr>
        
        <? foreach($resolved as $item) { ?>
            <tr>
                <td> <?= $item['LostAndFound']['name'] ?> </td>
                <td> <?= $item['LostAndFound']['description'] ?> </td>
                <td> <?= $item['LostAndFound']['found_where'] ?> </td>
                <td> <?= $item['LostAndFound']['found_when'] ?> </td>
                <td> <?= $item['LostAndFound']['delivered_to'] ?> </td>
                <td> <?= $item['LostAndFound']['delivered_to_contact'] ?> </td>
                <td> <?= $item['LostAndFound']['resolved'] ?> </td>
                <td><a href="<?=$this->Wb->eventUrl("/LostAndFound/View/{$item['LostAndFound']['id']}")?>" class="btn"><?=__("View")?></a> </td>
                <td><a href="<?=$this->Wb->eventUrl("/LostAndFound/Delete/{$item['LostAndFound']['id']}")?>" class="btn danger"><?=__("Delete")?></a> </td>
            </tr>
        <? } ?>

        </table>
    </div>
</div>

