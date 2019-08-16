<ul class="breadcrumb"><li><a href="<?=$this->Wb->eventUrl('/Logistic')?>"><?=__('Logistics')?></a> <span class="divider"></span></li><li class="active"><?=$title_for_layout?></li></ul>
<div id="storage-map">
<?=file_get_contents(IMAGES . 'logistics.svg')?>
</div>
<style type="text/css">
#storage-map text:hover {
    font-weight: bold !important;
    cursor: pointer;
}
</style>

<?php $this->Html->scriptStart( array('block' => 'bottom')); ?>

$(function() {
    $('#storage-map').find('text').click(function() {
        var storage_caption = $(this).text();
        document.location = '<?=$this->Wb->eventUrl('/Logistic/Search/filterMap/')?>' + storage_caption;
    });
});

<?php $this->Html->scriptEnd(); ?>