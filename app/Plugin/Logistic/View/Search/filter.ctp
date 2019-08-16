<ul class="breadcrumb"><li><a href="<?=$this->Wb->eventUrl('/Logistic')?>"><?=__('Logistics')?></a> <span class="divider"></span></li><li class="active"><?=$title_for_layout?></li></ul>
<h2><?=__("Filters")?></h2>
<form method="POST" action="<?=$this->Wb->eventUrl('/logistic/Search/filter')?>" class="form-stacked">
    <div class="row">
        <div class="col-md-4">
            <fieldset>
                <div class="clearfix">
                    <label for="data[tag_id"><?=__("Tags")?></label>
                    <div class="form-group">
                        <select name="data[tag_id]" class="form-control">
                            <option value="0"><?=__("Choose")?></option>
                            <? foreach($tags as $tag){
                              if($tag['LogisticTag']['id'] == $query['tag']){
                            ?>
                            <option value="<?=$tag['LogisticTag']['id']?>" selected><?=$tag['LogisticTag']['name']?></option>
                            <?}else{?>
                            <option value="<?=$tag['LogisticTag']['id']?>"><?=$tag['LogisticTag']['name']?></option>
                            <?}}?>
                        </select>
                    </div>
                </div>

                <div class="clearfix">
                    <label for="data[storage_id"><?=__("Storage location")?></label>
                    <div class="form-group">
                        <select name="data[storage_id]" class="form-control">
                            <option value="0"><?=__("Choose")?></option>
                            <? foreach($storages as $storage){
                              $storage_name = $storage['LogisticStorage']['name'];
                              if ($storage['LogisticStorage']['type'] == 'unrig') {
                                $storage_name .= ' '.__('(unrig only)');
                              }
                              if($storage['LogisticStorage']['id'] == $query['storage']){
                            ?>
                            <option value="<?=$storage['LogisticStorage']['id']?>" selected><?=$storage_name?></option>
                            <?}else{?>
                            <option value="<?=$storage['LogisticStorage']['id']?>"><?=$storage_name?></option>
                            <?}}?>
                        </select>
                    </div>
                </div>
            </fieldset>
        </div>

        <div class="col-md-4">
            <fieldset>
                <div class="clearfix">
                    <label for="data[status_id"><?=__("Status")?></label>
                    <div class="form-group">
                        <select name="data[status_id]" class="form-control">
                            <option value="0"><?=__("Choose")?></option>
                            <? foreach($statuses as $status){
                              if($status['LogisticStatus']['id'] == $query['status']){
                            ?>
                            <option value="<?=$status['LogisticStatus']['id']?>" selected><?=$status['LogisticStatus']['canonicalname']?></option>
                            <?}else{?>
                            <option value="<?=$status['LogisticStatus']['id']?>"><?=$status['LogisticStatus']['canonicalname']?></option>
                            <?}}?>
                        </select>
                    </div>
                </div>

                <div class="clearfix">
                    <label for="data[crew_id"><?=__("Crew")?></label>
                    <div class="form-group">
                        <select name="data[crew_id]" class="form-control">
                            <option value="0"><?=__("Choose")?></option>
                            <? foreach($crewlist as $c){
                              if($c['Crew']['id'] == $query['crew']){
                            ?>
                            <option value="<?=$c['Crew']['id']?>" selected><?=$c['Crew']['name']?></option>
                            <?}else{?>
                            <option value="<?=$c['Crew']['id']?>"><?=$c['Crew']['name']?></option>
                            <?}}?>
                        </select>
                    </div>
                </div>
            </fieldset>
        </div>

        <div class="col-md-4">
            <fieldset>
                <div class="clearfix">
                    <label for="data[user_id"><?=__("User ID")?></label>
                    <div class="form-group">
                        <input type="text" class="form-control" name="data[user_id]" value="<?=$query['user']?>" />
                    </div>
                </div>

                    <label for="data[supplier_id"><?=__("Owner")?></label>
                    <div class="form-group">
                        <select name="data[supplier_id]" class="form-control">
                            <option value="0"><?=__("Choose")?></option>
                            <? foreach($supplierlist as $s){
                              if($s['LogisticSupplier']['id'] == $query['supplier']){
                            ?>
                            <option value="<?=$s['LogisticSupplier']['id']?>" selected><?=$s['LogisticSupplier']['company']?></option>
                            <?}else{?>
                            <option value="<?=$s['LogisticSupplier']['id']?>"><?=$s['LogisticSupplier']['company']?></option>
                            <?}}?>
                        </select>
                    </div>
            </fieldset>
        </div>
        <div class="col-md-4">
            <input type="submit" value="<?=__('Search')?>" class="btn btn-primary"/>
        </div>
    </div>
</form>

<? if(isset($matches)) { ?>
<? if($matches) { ?>
<h2><?=__("Results")?></h2>
<table class="table table-bordered table-hover" id="sort-table">
<thead>
<tr>
<th><?=__("ID")?></th>
<th><?=__("Name")?></th>
<th><?=__("AssetTag")?></th>
<th><?=__("Tags")?></th>
<th><?=__("Last Transaction")?></th>
<th><?=__("Timestamp")?></th>
<th><?=__("Location/User")?></th>
</tr>
</thead>
<tbody>
<?php
    foreach ($matches as $match){
        echo '<tr>';
        echo '<td>'.$match['LogisticItem']['id'].'</td>';
        if ($match['LogisticItem']['logistic_bulk_id'] && $match['LogisticBulk']['type'] == 'bulk') {
            echo '<td><a href="'.$this->Wb->eventUrl("/logistic/Bulk/view/".$match['LogisticItem']['logistic_bulk_id']).'">'.$match['LogisticItem']['name'].'</a></td>';
        } else {
            echo '<td><a href="'.$this->Wb->eventUrl("/logistic/Item/view/".$match['LogisticItem']['id']).'">'.$match['LogisticItem']['name'].'</a></td>';
        }
        echo '<td>'.$match['LogisticItem']['AssetTag'].'</td>';
        echo '<td>';
        if (array_key_exists('LogisticTag', $match)) {
            foreach($match['LogisticTag'] as $tag) {
                echo $this->Wb->eventLink($taglist[$tag], '/logistic/Search/filter/tag:'.$tag).' ';
            }
        }
        echo '</td>';

        echo '<td>'.$this->Wb->eventLink($statuslist[$match['LogisticTransaction']['logistic_status_id']],'/logistic/Search/filter/status:'.$match['LogisticTransaction']['logistic_status_id']).'</td>';
        echo '<td>'.$match['LogisticTransaction']['created'].'</td>';
        if($match['LogisticTransaction']['logistic_status_id'] == 3 || $match['LogisticTransaction']['logistic_status_id'] == 5) {
            echo '<td>'.$this->Wb->eventLink($match['LogisticStorage']['name'].($match['LogisticTransaction']['storage_comment']?" (".$match['LogisticTransaction']['storage_comment'].")":''),'/logistic/Search/filter/storage:'.$match['LogisticStorage']['id']).'</td>';
        } else if ($match['LogisticTransaction']['logistic_status_id'] == 4) {
            echo '<td>'.$this->Wb->eventLink($this->Wb->userDisplayName($match),'/logistic/Search/filter/user:'.$match['User']['id']).'</td>';
        } else {
            echo '<td>--</td>';
        }
        echo '</tr>';
    }
} else {
    echo "<br>";
    echo __("No results");
} } ?>
</tbody>
</table>