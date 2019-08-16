<div class="row">
    <div class="span8">
        <h3><?=__("Add new item")?></h3>
        <a href="<?=$this->Wb->eventUrl("/CrewEffectsItems/add")?>" class="btn primary"><?=__("Add new item")?></a>
    </div>
</div>
<br />
<div class="row">
    <div class="span16">
        <h3><?=__("Crew effects items")?></h3>
        <?php if($items) { ?>
            <table>
                <tr>
                    <th><?=__("Title")?></th>
                    <th><?=__("Edit")?></th>
                    <th><?=__("Delete")?></th>
                </tr>
            <?php foreach($items as $id => $item ) { ?>
                <tr>
                    <td><?=$item?></td>
                    <td><a href="<?=$this->Wb->eventUrl("/CrewEffectsItems/edit/{$id}")?>" class="btn"><?=__("Edit")?></a></td>
                    <td><a href="<?=$this->Wb->eventUrl("/CrewEffectsItems/delete/{$id}")?>" class="btn danger"><?=__("Delete")?></a></td>
                </tr>
            <?php } ?>
            
           </table> 
        <?php } else { ?>
            <p>No items to display.</p>
        <?php } ?>
    </div>
</div>
