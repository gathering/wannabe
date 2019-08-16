<ul class="breadcrumb"><li><a href="<?=$this->Wb->eventUrl('/Logistic')?>"><?=__('Logistics')?></a> <span class="divider"></span></li><li class="active"><?=$title_for_layout?></li></ul>
<p><?=__("Choose supplier")?></p>
<p><ul>
<? foreach ($suppliers as $supplier) : ?>
        <li><a href="<?=$this->Wb->eventUrl('/logistic/Supplier/edit/'.$supplier['LogisticSupplier']['id'])?>"><?=$supplier['LogisticSupplier']['company']?></a></li>
<? endforeach; ?>
</ul></p>
<p><a class="btn btn-primary" href="<?=$this->Wb->eventUrl('/logistic/Supplier/create')?>"><?=__("Create new supplier")?></a></p>
