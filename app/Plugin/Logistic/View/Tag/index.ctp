<ul class="breadcrumb"><li><a href="<?=$this->Wb->eventUrl('/Logistic')?>"><?=__('Logistics')?></a> <span class="divider"></span></li><li class="active"><?=$title_for_layout?></li></ul>
<p><?=__("NB! “/” is indicating folder separation, and cannot be used as an alias for “or”. All whitespaces will be replaced with underscore (“_”).")?></p>
<form method="POST" action="/<?=WB::$event->reference?>/logistic/Tag">
    <table class="table">
        <thead>
            <tr>
                <th><?=__("New")?></th>
                <th id="name" class="blue header headerSortDown"><?=__("Name")?></th>
                <th id="comment" class="green header"><?=__("Comment")?></th>
                <th><?=__("Delete")?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($tags as $tag) { ?>
                <tr>
                    <td><?=$this->Form->hidden('LogisticTag.'.$tag['LogisticTag']['id'].'.id', array('value' => $tag['LogisticTag']['id']))?></td>
                    <td><?=$this->Form->input('LogisticTag.'.$tag['LogisticTag']['id'].'.name', array('label' => false, 'div' => 'false', 'error' => false, 'value' => $tag['LogisticTag']['name']))?></td>
                    <td><?=$this->Form->text('LogisticTag.'.$tag['LogisticTag']['id'].'.comment', array('label' => false, 'div' => 'false', 'error' => false, 'value' => $tag['LogisticTag']['comment']))?></td>
                    <td><?=$this->Form->checkbox('LogisticTag.'.$tag['LogisticTag']['id'].'.delete')?></td>
                </tr>
            <?php } ?>
                <tr>
                    <td><?=$this->Form->checkbox('LogisticTag.new.create')?></td>
                    <td><?=$this->Form->input('LogisticTag.new.name', array('label' => false, 'div' => 'false', 'error' => false))?></td>
                    <td><?=$this->Form->text('LogisticTag.new.comment', array('label' => false, 'div' => 'false', 'error' => false))?></td>
                    <td>&nbsp;</td>
                </tr>
        </tbody>
    </table>
    <div class="actions">
        <?=$this->Form->submit('Update', array('class' => 'btn btn-primary', 'div' => false))?>
    </div>
</form>
