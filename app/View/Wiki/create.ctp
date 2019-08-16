<div class="pageheader">
<h1><?=__("Wiki page “%s”", $page['Wikipage']['title'])?></h1>
</div>
<div class="row">
<div class="col-md-12">
<p>
<a class="btn btn-info pull-right" href="<?=$this->Wb->eventUrl('/Wiki/'.$page['Wikipage']['title'].'/edit')?>"><?=__("Create")?></a>
<?=__("This page does not exist… yet. Press the button to the right to create it.")?>
</p>
</div>
</div>
