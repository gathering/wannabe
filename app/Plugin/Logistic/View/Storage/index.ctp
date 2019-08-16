<ul class="breadcrumb"><li><a href="<?=$this->Wb->eventUrl('/Logistic')?>"><?=__('Logistics')?></a> <span class="divider"></span></li><li class="active"><?=$title_for_layout?></li></ul>
<div class="row">
	<div class="col-md-12">
                <p class="pull-right">
                    Filter:
                    <select id="filter-select" class="form-control">
                        <option value="default"><?=__('Normal storage')?></option>
                        <option value="unrig"><?=__('Unrig destination')?></option>
                    </select>
                </p>
		<h3><?=__("Choose storage unit")?></h3>
		<table class="table table-striped">
			<thead>
				<tr>
					<th><?=__("Name")?></th>
					<th><?=__("Edit")?></th>
					<th><?=__("Handout")?></th>
					<th><?=__("Delete")?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($units as $unit) { ?>
					<tr class="unit-<?=$unit['LogisticStorage']['type']?>">
						<td><a href="<?=$this->Wb->eventUrl("/logistic/Search/Filter/0/{$unit['LogisticStorage']['id']}")?>"><?=$unit['LogisticStorage']['name']?></a></td>
						<td><a href="<?=$this->Wb->eventUrl("/logistic/Storage/Edit/{$unit['LogisticStorage']['id']}")?>" class="btn btn-primary"><?=__("Edit")?></a></td>
                        <td>
                            <?=$this->Form->create('LogisticTransaction', array('url' => $this->Wb->eventUrl('/logistic/Transaction/confirmstorage'), 'class'=>'form-inline'))?>
                                <?=$this->Form->hidden('LogisticTransaction.logistic_storage_id', array('value' => $unit['LogisticStorage']['id']))?>
                                <?=$this->Form->hidden('Redirect.path', array('value' => "/logistic/Storage/"))?>
                                <?=$this->Form->text('LogisticTransaction.logistic_user_id', array('label' => false, 'div' => false, 'class' => 'form-control', 'placeholder' => __("User ID")))?>
                            <select class="form-control" name="data[LogisticTransaction][logistic_crew_id]">
                                <option value="0" selected="selected"></option>
                                <?php
                                foreach ($crews as $crew){
                                    ?>
                                    <option value="<?= $crew['Crew']['id'] ?>"><?= $crew['Crew']['name'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                                <?=$this->Form->submit(__("Perform"), array('div' => false, 'class' => 'btn btn-success'));?>
                            </form>
                        </td>
						<td><a href="<?=$this->Wb->eventUrl("/logistic/Storage/Delete/{$unit['LogisticStorage']['id']}")?>" class="btn btn-danger"><?=__("Delete")?></a></td>
					</tr>	
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<a href="<?=$this->Wb->eventUrl("/logistic/Storage/Create")?>" class="btn btn-primary"><?=__("Create new storage unit")?></a>
	</div>
</div>


<?php $this->Html->scriptStart( array('block' => 'bottom')); ?>
$(function() {
    var filter_units_by_type = function(type) {
        $('.unit-default').hide();
        $('.unit-unrig').hide();
        $('.unit-'+type).show();
    };
    $('#filter-select').change(function() { filter_units_by_type($(this).val()); });
    filter_units_by_type('default');
});

<?php $this->Html->scriptEnd(); ?>