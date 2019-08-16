<ul class="breadcrumb"><li><a href="<?=$this->Wb->eventUrl('/Logistic')?>"><?=__('Logistics')?></a> <span class="divider"></span></li><li class="active"><?=$title_for_layout?></li></ul>

<div class="row">
    <form>
        <div class="row">

            <div class="col-md-12">
                <h4><small> 1. </small> Scan badge, enter UserID or select crew</h4>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="express-input-user"><?=__('Badge/UserID')?></label>
                    <input id="express-input-user" class="form-control" type="text" />
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="express-input">Select crew</label>
                    <select class="form-control" name="express-crew-select" id="express-crew-select">
                        <option value="0" selected="selected"></option>
                        <?php
                        foreach ($crews as $crew){
                            ?>
                            <option value="<?= $crew['Crew']['id'] ?>"><?= $crew['Crew']['name'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-md-12">
                <h4><small> 2. </small> Scan AssetTag to add to <?= $mode ?></h4>
            </div>

            <div class="col-md-6">


                <div class="form-group">
                    <label for="express-input"><?=__('AssetTag')?></label>
                    <input id="express-input" class="form-control" type="text" />
                </div>

            </div>
        </div>


        <div class="row">

            <div class="col-md-12">
                <div class="form-group">
                    <legend>
                        <?php if ($mode == 'checkout'): ?>
                            <?=__('Current checkout')?>
                        <?php else: ?>
                            <?=__('Current checkin')?>
                        <?php endif; ?>
                    </legend>
                    <span class="express-user-crew"></span>


                    <div class="form-group">
                        <p>
                            <span class="express-name"></span>
                            <em id="express-name-none"><?=__('None &#8212; scan a badge into the field above to add the user or select a crew')?></em>
                        </p>
                    </div>

                    <div class="table-responsive">

                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th><?=__('AssetTag')?></th>
                                <th><?=__('Item')?></th>
                                <?php if ($mode == 'checkin'): ?>
                                    <th><?=__('Storage')?></th>
                                    <th><?=__('Condition')?></th>
                                <?php endif; ?>
                                <th><?=__('Actions')?></th>
                            </tr>
                            </thead>
                            <tbody id="express-items">
                            <tr id="express-items-none">
                                <td colspan="<?=($mode == 'checkout' ? 3 : 5)?>"><center><em><?=__('None &#8212; scan AssetTag into the field above to add items')?></em></center></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    </div>
                    <div class="actions">
                        <input type="button" id="express-continue" disabled="disabled" class="btn btn-primary" value="<?=($mode == 'checkout' ? __('Checkout') : __('Checkin'))?>" />
                    </div>
                </div>
    </form>

    <?php if ($mode == 'checkin') : ?>
        <select id="express-storages-template" class="hide form-control">
            <option value=""><?=__('Select a storage to check in to')?></option>
            <?php foreach ($storages as $storage_id => $storage_name) : ?>
                <option value="<?=$storage_id?>"><?=h($storage_name)?></option>
            <?php endforeach; ?>
        </select>
        <select id="express-condition-template" class="hide form-control">
            <option value="ok"><?=__('OK')?></option>
            <option value="damaged"><?=__('Damaged')?></option>
            <option value="destroyed"><?=__('Destroyed')?></option>
            <option value="lost"><?=__('Lost')?></option>
        </select>
    <?php endif; ?>


    <div class="modal fade" tabindex="-1" id="express-modal" role="dialog">
        <div class="modal-dialog">
        <div class="modal-content">
        <form method="post" class="form-stacked" action="<?=$this->Wb->eventUrl('/logistic/Express/commit/'.$mode)?>">
            <input type="hidden" id="express-creworuser" name="creworuser" />
            <div class="modal-header">
                <a href="#" class="close">×</a>
                <h3>
                    <?php if ($mode == 'checkout'): ?>
                        <?=__('Confirm Checkout')?>
                    <?php else: ?>
                        <?=__('Confirm Checkin')?>
                    <?php endif; ?>
                </h3>
            </div>
            <div class="modal-body">
                <fieldset class="form-stacked">
                    <b> <span class="express-user-crew-modal"></span>: </b>
                    <p>
                        <span class="express-name"></span>
                        <input type="hidden" id="express-user-id" name="user-id" />
                    </p>
                    <label><b><?=__('Items:')?></label> </b> <br />
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th><?=__('AssetTag')?></th>
                            <th><?=__('Item')?></th>
                            <?php if ($mode == 'checkin'): ?>
                                <th><?=__('Storage')?></th>
                                <th><?=__('Condition')?></th>
                            <?php endif; ?>
                        </tr>
                        </thead>
                        <tbody id="express-items-modal"></tbody>
                    </table>
                </fieldset>
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn success" value="<?=($mode == 'checkout' ? __('Checkout') : __('Checkin'))?>" />
                <a href="#" class="btn secondary" id="express-modal-cancel"><?=__('Cancel')?></a>
            </div>
        </form>
        </div>
        </div>
    </div><!-- /.modal -->


    <div id="express-bulk-modal" class="modal fade" role="dialog" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
        <form id="express-bulk-modal-form" class="form-stacked">
            <div class="modal-header">
                <a href="#" class="close">×</a>
                <h3><?=($mode == 'checkout' ? __('Specify bulk amounts to check out') : __('Specify bulk amounts to check in'))?></h3>
            </div>
            <div class="modal-body">
                <fieldset class="form-stacked">
                    <label><?=__('AssetTag:')?></label>
                    <p>
                        <span id="express-bulk-AssetTag"></span>
                    </p>
                    <label><?=__('Bulk:')?></label>
                    <p>
                        <span id="express-bulk-name"></span>
                    </p>
                    <br />
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th><?=__('Storage')?></th>
                            <th class="number-column"><?=__('Available')?></th>
                            <th class="number-column"><?=($mode == 'checkout' ? __('Check out') : __('Check in'))?></th>
                        </tr>
                        </thead>
                        <tbody id="express-bulk-amounts"></tbody>
                    </table>
                </fieldset>
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn success" value="<?=__('Add')?>" />
                <a href="#" class="btn secondary" id="express-bulk-modal-cancel"><?=__('Cancel')?></a>
            </div>
        </form>
            </div>
        </div>
    </div>


<script>
    var express_mode = '<?=$mode?>';
</script>

<?php $this->Html->script('logistic/express', array('block' => 'bottom')); ?>