<div class="logistic-splash">

<div class="row">
    <div class="col-md-6">
        <a class="btn btn-default" href="<?=$this->Wb->eventUrl('/Logistic/Express/checkout')?>">
            <h3> <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> <?=__('Express checkout')?></h3>
            <small><?=__('Quickly check items out of storage')?></small>
        </a>
    </div>
    <div class="col-md-6">
        <a class="btn btn-default" href="<?=$this->Wb->eventUrl('/Logistic/Express/checkin')?>">
            <h3> <span class="glyphicon glyphicon-download" aria-hidden="true"></span> <?=__('Express checkin')?></h3>
            <small><?=__('Check in items that are being delivered back into storage')?></small>
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <a class="btn btn-default" href="<?=$this->Wb->eventUrl('/Logistic/Search/filter')?>">
            <h3> <span class="glyphicon glyphicon-search" aria-hidden="true"></span> <?=__('Filter search')?></h3>
            <small><?=__('Find items by tag, status, location, crew, user or owner')?></small>
        </a>
    </div>
    <div class="col-md-6">
        <a class="btn btn-default" href="<?=$this->Wb->eventUrl('/Logistic/Search/filterMap')?>">
            <h3> <span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span> <?=__('Storage map')?></h3>
            <small><?=__('Find items by their storage location by clicking a map')?></small>
        </a>
    </div>
</div>

<hr />

<form class="form-horizontal" method="get" action="<?=$this->Wb->eventUrl('/logistic/search')?>">
    <div class="form-group">
        <div class="col-sm-5">
    <input type="text" class="form-control" name="query" placeholder="<?=__("Item ID, name, AssetTag or serial number")?>" />
        </div>
        <div class="col-sm-1">
    <button type="submit" class="btn btn-primary">Search</button>
        </div>

    </div>
</form>

<hr />

<div class="row">
    <div class="col-md-3">
        <a class="btn btn-default" href="<?=$this->Wb->eventUrl('/Logistic/Item/create')?>">
            <h4> <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> <?=__('Create new item')?></h4>
        </a>
    </div>
    <div class="col-md-3">
        <a class="btn btn-default" href="<?=$this->Wb->eventUrl('/Logistic/Tag')?>">
            <h4> <span class="glyphicon glyphicon-tag" aria-hidden="true"></span> <?=__('Tags')?></h4>
        </a>
    </div>
    <div class="col-md-3">
        <a class="btn btn-default" href="<?=$this->Wb->eventUrl('/Logistic/Storage')?>">
            <h4> <span class="glyphicon glyphicon-tasks" aria-hidden="true"></span> <?=__('Storage units')?></h4>
        </a>
    </div>
    <div class="col-md-3">
        <a class="btn btn-default" href="<?=$this->Wb->eventUrl('/Logistic/Supplier')?>">
            <h4> <span class="glyphicon glyphicon-briefcase" aria-hidden="true"></span> <?=__('Suppliers')?></h4>
        </a>
    </div>
</div>

</div>

<style type="text/css">
.logistic-splash .row .btn { display: block; margin-bottom: 1em; padding-bottom: 1em; }
</style>
