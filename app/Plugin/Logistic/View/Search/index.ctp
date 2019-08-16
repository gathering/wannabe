<ul class="breadcrumb"><li><a href="<?=$this->Wb->eventUrl('/Logistic')?>"><?=__('Logistics')?></a> <span class="divider"></span></li><li class="active"><?=$title_for_layout?></li></ul>
<form method="GET" action="<?=$this->Wb->eventUrl('/logistic/search')?>">

    <div class="row">
        <div class="col-md-4">
    <fieldset>
        <legend><?=__("Find Object")?></legend>
            <label for="query"><?=__("Search")?></label>
            <div class="form-group">
                <input type="text" class="form-control" name="query" value="<?=$query?>" />
                <span class="help-block"><?=__("You can search on id, name, AssetTag or serial number")?></span>
            </div>
    </fieldset>
        <input type="submit"  value="<?=_("Search")?>"  class="btn btn-primary"/>
    </div>
    </div>
</form>

<? if(isset($items)) { ?>
<? if($items) { ?>
<h2><?=__("Results")?></h2>
<table class="table table-bordered table-hover" id="sort-table">
    <thead>
    <tr>
        <th><?=__("ID")?></th>
        <th><?=__("Name")?></th>
        <th><?=__("AssetTag")?></th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($items as $match){
        echo '<tr>';
        echo '<td>'.$match['LogisticItem']['id'].'</td>';
        if ($match['LogisticItem']['logistic_bulk_id'] && $match['LogisticBulk']['type'] == 'bulk') {
            echo '<td><a href="'.$this->Wb->eventUrl("/logistic/Bulk/view/".$match['LogisticItem']['logistic_bulk_id']).'">'.$match['LogisticItem']['name'].'</a></td>';
        } else {
            echo '<td><a href="'.$this->Wb->eventUrl("/logistic/Item/view/".$match['LogisticItem']['id']).'">'.$match['LogisticItem']['name'].'</a></td>';
        }
        echo '<td>'.$match['LogisticItem']['AssetTag'].'</td>';
        echo '</tr>';
    }
    } else {
        echo "<br>";
        echo __("No results");
    } } ?>
    </tbody>
</table>
