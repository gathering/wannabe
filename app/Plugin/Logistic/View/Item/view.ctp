<ul class="breadcrumb"><li><a href="<?=$this->Wb->eventUrl('/Logistic')?>"><?=__('Logistics')?></a> <span class="divider"></span></li><li class="active"><?=$title_for_layout?></li></ul>
<? if($item['LogisticItem']['deleted']) { ?>
<div class="panel panel-danger">
    <div class="panel-heading"><strong><?=__("Attention")?>: </strong><?=__("This item has been deleted and cannot be used before it is reactivated.")?></div>
    <div class="panel-body">
        <?=$this->Form->create('LogisticTransaction', array('url' => $this->Wb->eventUrl('/logistic/Transaction/confirm')))?>
            <?=$this->Form->hidden('LogisticTransaction.logistic_item_id', array('value' => $item['LogisticItem']['id']))?>
            <?=$this->Form->hidden('LogisticTransaction.logistic_status_id', array('value' => '9'))?>
            <?=$this->Form->hidden('Redirect.path', array('value' => "/logistic/Item/view/".$item['LogisticItem']['id']))?>
            <?=$this->Form->submit(__("Reactivate"), array('div' => false, 'class' => 'btn btn-primary'));?>
        </form>
    </div>
</div>
<? } ?>
<? if($item['LogisticItem']['logistic_bulk_id']) { ?>

<div class="panel panel-info">
    <div class="panel-heading"><strong><?=__("Attention")?>: </strong><?=__("This item is part of a series. Click the button to view the series.")?></div>
    <div class="panel-body">
        <?=$this->Wb->eventLink(__("View series"),'/logistic/Bulk/view/'.$item['LogisticItem']['logistic_bulk_id'], array('class' => 'btn btn-info'))?>
    </div>
</div>

<? } ?>
<div class="row">
    <div class="col-md-3">
        <h4><?=__("Item details")?></h4>
        <? if($item['LogisticItem']['comment']) { ?>
        <?php if ($item['LogisticItem']['description']): ?>
            <strong><?=__("Description")?></strong>
            <p><?=$item['LogisticItem']['description']?></p>
        <?php endif; ?>
        <strong><?=__("Condition")?></strong>
        <strong><?=__("Comment")?></strong>
            <p><?=$item['LogisticItem']['comment']?></p>
        <? } ?>
        <strong><?=__("AssetTag")?></strong>
        <p><?=$item['LogisticItem']['AssetTag']?></p>
        <? if($item['LogisticItem']['serialnumber']) { ?>
            <strong><?=__("Serial number")?></strong>
            <p><?=$item['LogisticItem']['serialnumber']?></p>
        <? } ?>
        <? if($item['LogisticSupplier']['company']) { ?>
            <strong><?=__("Owner")?></strong>
            <p>
                <?=$item['LogisticSupplier']['company']?>
                <?php if ($item['LogisticSupplier']['email']) { echo '('.$item['LogisticSupplier']['email'].')'; } ?>
            </p>
        <? } ?>
        <? if(isset($item['LogisticItem']['parent'])) { ?>
            <strong><?=__("Parent")?></strong>
            <p>
                <a href="<?=$this->Wb->eventUrl('/logistic/Item/view/'.$parent['LogisticItem']['id']);?>"><?=$parent['LogisticItem']['name']?>  </a>
            </p>
        <? }?>

        <? if(count($children) > 0) { ?>
            <strong><?=__("Children")?></strong>
            <?  foreach($children as $child){?> 
            <?      echo '<li># '.$child['LogisticItem']['id'].' <a href="'.$this->Wb->eventUrl('/logistic/Item/view/'.$child['LogisticItem']['id']).'">'.$child['LogisticItem']['name'].'</a></li>';?>
            <?  } ?>
        <?  } ?>
        <?php if(isset($item['LogisticTag']) && count($item['LogisticTag']) > 0): ?>
            <strong><?=__("Tags")?></strong>
            <ul>
            <? foreach ($item['LogisticTag'] as $tag)
                 echo '<li>'.$this->Wb->eventLink($tag['name'], '/logistic/Search/filter/tag:'.$tag['id']).'</li>';?>
            </ul>
        <?php endif; ?>
        <?php if (isset($unrig_storage)): ?>
            <strong><?=__("Unrig destination")?></strong>
            <p>
                <?=$unrig_storage['LogisticStorage']['name']?>
            </p>
        <?php endif; ?>
    </div>
    <div class="col-md-9 log-history">
        <h4><?=__("Item history")?> <small><a href="#" id="log-toggle-history"><?=__("Toggle last/all")?></a></small></h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th><?=__("Timestamp")?></th>
                    <th><?=__("Status")?></th>
                    <th><?=__("Done by")?></th>
                    <th><?=__("Place")?></th>
                    <th><?=__("User/Crew")?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($item['LogisticTransaction'] as $transaction) { ?>
                    <tr <?=isset($transaction['LogisticTransaction']['deleted'])?'style="text-decoration: line-through;"':''?>>
                        <td><?=$transaction['LogisticTransaction']['created']?></td>
                        <td><?=$status[$transaction['LogisticTransaction']['logistic_status_id'] - 1]['LogisticStatus']['canonicalname']?></td>
                        <td><?=$this->Wb->userLink(array('User' => $transaction['DoneBy']))?></td>
                        <td><?=$this->Wb->eventLink($transaction['LogisticStorage']['name'].($transaction['LogisticTransaction']['storage_comment']?" (".$transaction['LogisticTransaction']['storage_comment'].")":''), '/logistic/Search/filter/storage:'.$transaction['LogisticStorage']['id'])?></td>
                        <?php if($transaction['User']['id'] != NULL) { ?>
                        <td><?=$this->Wb->eventLink($this->Wb->userDisplayName($transaction), '/logistic/Search/filter/user:'.$transaction['User']['id'])?></td>
                        <?php } elseif($transaction['Crew']['id']) { ?>
                        <td><?=$this->Wb->eventLink($transaction['Crew']['name'], '/logistic/Search/filter/crew:'.$transaction['Crew']['id'])?> </td>
                        <?php }else {
                            echo "<td> </td>";
                        } ?>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<hr />
<? if($item['LogisticTransaction'][0]['LogisticTransaction']['logistic_status_id'] == 1 || $item['LogisticTransaction'][0]['LogisticTransaction']['logistic_status_id'] == 3
|| $item['LogisticTransaction'][0]['LogisticTransaction']['logistic_status_id'] == 5 || $item['LogisticTransaction'][0]['LogisticTransaction']['logistic_status_id']
== 7 || $item['LogisticTransaction'][0]['LogisticTransaction']['logistic_status_id'] == 9) { ?>
    <div class="col-md-4">

    <h4><?=_("Hand out")?></h4>
    <p>
        <?=__('Use express checkout to hand out items:')?>
        <a class="btn btn-primary" href="<?=$this->Wb->eventUrl('/Logistic/Express/checkout')?>#<?=$item['LogisticItem']['AssetTag']?>"><?=__('Express Checkout')?></a>
    </p>

    </div>
<? } ?>
<? if($item['LogisticTransaction'][0]['LogisticTransaction']['logistic_status_id'] == 4) { ?>
<div class="col-md-4">
    <h4><?=_("Checkin")?></h4>
    <p>
        <?=__('Use express checkin to check in items:')?>
        <a class="btn btn-primary" href="<?=$this->Wb->eventUrl('/Logistic/Express/checkin')?>#<?=$item['LogisticItem']['AssetTag']?>"><?=__('Express Checkin')?></a>
    </p>
</div>
<? } ?>
<? if($item['LogisticTransaction'][0]['LogisticTransaction']['logistic_status_id'] == 5 || $item['LogisticTransaction'][0]['LogisticTransaction']['logistic_status_id'] == 3) { ?>
<div class="col-md-4">
    <h4><?=__("Move")?></h4>
    <?=$this->Form->create('LogisticTransaction', array('class' => 'form-inline', 'url' => $this->Wb->eventUrl('/logistic/Transaction/confirm')));?>
        <fieldset>
            <?=$this->Form->hidden('LogisticTransaction.logistic_item_id', array('value' => $item['LogisticItem']['id']))?>
            <?=$this->Form->hidden('LogisticTransaction.logistic_status_id', array('value' => '7'))?>
            <?=$this->Form->hidden('Redirect.path', array('value' => "/logistic/Item/view/".$item['LogisticItem']['id']));?>
            <div class="form-group">
                <label for="data[LogisticTransaction][logistic_storage_id]"><?=__("Storage")?></label>
                <div class="input">
                    <?=$this->Form->select('LogisticTransaction.logistic_storage_id', $storagelist, array('label' => false, 'div' => false, 'empty' => __("Choose")))?>
                </div>
            </div>
            <div class="form-group">
                <label for="data[LogisticTransaction][storage_comment]"><?=__("Comment")?></label>
                <div class="input">
                    <?=$this->Form->input('LogisticTransaction.storage_comment', array('label' => false, 'div' => false))?> <?=$this->Form->submit(__("Perform"), array('div' => false, 'class' => 'btn btn-primary'));?>
                </div>
            </div>
        </fieldset>
    </form>
</div>
<? } ?>
<? if($item['LogisticTransaction'][0]['LogisticTransaction']['logistic_status_id'] == 1 || $item['LogisticTransaction'][0]['LogisticTransaction']['logistic_status_id'] == 2 || $item['LogisticTransaction'][0]['LogisticTransaction']['logistic_status_id'] == 9) { ?>
<div class="col-md-6">
    <h4><?=__("Place in stock")?></h4>
    <?=$this->Form->create('LogisticTransaction', array('class' => 'form-inline', 'url' => $this->Wb->eventUrl('/logistic/Transaction/confirm')));?>
        <fieldset>
            <?=$this->Form->hidden('LogisticTransaction.logistic_item_id', array('value' => $item['LogisticItem']['id']))?>
            <?=$this->Form->hidden('LogisticTransaction.logistic_status_id', array('value' => false))?>
            <?=$this->Form->hidden('Redirect.path', array('value' => "/logistic/Item/view/".$item['LogisticItem']['id']));?>
            <div class="form-group">
                <label for="data[LogisticTransaction][logistic_storage_id]"><?=__("Storage")?></label>
                <div class="input">
                    <?=$this->Form->select('LogisticTransaction.logistic_storage_id', $storagelist, array('label' => false, 'div' => false, 'class' => 'form-control', 'empty' => __("Choose")))?>
                </div>
            </div>
            <div class="form-group">
                <label for="data[LogisticTransaction][storage_comment]"><?=__("Comment")?></label>
                <div class="input">
                    <?=$this->Form->input('LogisticTransaction.storage_comment', array('label' => false, 'div' => false, 'class' => 'form-control'))?> <?=$this->Form->submit(__("Perform"), array('div' => false, 'class' => 'btn btn-primary'));?>
                </div>
            </div>
        </fieldset>
    </form>

</div>
<? } ?>
<?
# Disabled in Systems-222
if(0 && ($item['LogisticTransaction'][0]['LogisticTransaction']['logistic_status_id'] == 1 || $item['LogisticTransaction'][0]['LogisticTransaction']['logistic_status_id'] == 9)) { ?>
    <div class="col-md-6">
<h4><?=__("Set in transit")?></h4>
    <?=$this->Form->create('LogisticTransaction', array('class' => 'form-inline', 'url' => $this->Wb->eventUrl('/logistic/Transaction/confirm')));?>
        <fieldset>
            <?=$this->Form->hidden('LogisticTransaction.logistic_item_id', array('value' => $item['LogisticItem']['id']))?>
            <?=$this->Form->hidden('LogisticTransaction.logistic_status_id', array('value' => '2'))?>
            <?=$this->Form->hidden('Redirect.path', array('value' => "/logistic/Item/view/".$item['LogisticItem']['id']));?>
            <div class="form-group">
                <label for="data[LogisticTransaction][donedate]"><?=__("Expected delivered")?></label>
                <div class="input">
                    <?=$this->Form->dateTime('LogisticTransaction.donedate', 'DMY', '24',array('interval' => '10', 'label' => false, 'div' => false, 'class' => 'form-control'))?><?=$this->Form->submit(__("Perform"), array('class' => 'btn btn-primary', 'div' => false));?>
                </div>
            </div>
        </fieldset>
    </form>
    </div>
<? } ?>

<? if ($item['LogisticTransaction'][0]['LogisticTransaction']['logistic_status_id'] != 8) { ?>
        <div class="col-md-12">
    <h4><?=_("Remove")?></h4>
    <?=$this->Form->create('LogisticTransaction', array('class' => 'form-inline', 'url' => $this->Wb->eventUrl('/logistic/Transaction/confirm')))?>
        <fieldset>
            <?=$this->Form->hidden('LogisticTransaction.logistic_item_id', array('value' => $item['LogisticItem']['id']))?>
            <?=$this->Form->hidden('LogisticTransaction.logistic_status_id', array('value' => '8'))?>
            <?=$this->Form->hidden('Redirect.path', array('value' => "/logistic/Item/view/".$item['LogisticItem']['id']))?>
            <div class="form-group">
                <div class="input">
                    <?=$this->Form->submit(__("Remove"), array('div' => false, 'class' => 'btn btn-danger'));?>
                </div>
            </div>
        </fieldset>
    </form>
        </div>
<? } ?>

<?php $this->Html->scriptStart( array('block' => 'bottom')); ?>

<script type="text/javascript">
    $(document).ready(function() {
        $('#log-toggle-history').html("Show all");
        $('.log-history table tr').toggle();
        $('.log-history table tr:first-child').show();  
        $('#log-toggle-history').click(function() {
            $('.log-history table tr').toggle();
            $('.log-history table tr:first-child').show();  
            if($('#log-toggle-history').html() == 'Show all') {
                $('#log-toggle-history').html("Hide all");
            } else {
                $('#log-toggle-history').html("Show all");
            }
        });
    });
</script>

<?php $this->Html->scriptEnd(); ?>
