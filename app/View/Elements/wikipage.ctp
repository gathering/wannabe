<?php
$wiki = $this->requestAction($wannabe->event->reference.'/Wiki/'.urlencode($page));
if(isset($wiki['Wikipage']['content'])) {
?>
	<p><?=$wiki['Wikipage']['content']?></p>
	<p><small><?=__("Last updated by %s, at %s", "<em>{$this->Wb->userLink($wiki)}</em>", "<em>".date('d.m.Y H:i:s',strtotime($wiki['Wikipage']['created']))."</em>.")?></small></p>
	<p class="pull-right"><a class="btn btn-default primary" href="/<?=$wannabe->event->reference?>/Wiki/<?=$wiki['Wikipage']['title']?>/edit"><?=__("Edit")?></a>
	<a class="btn btn-default" href="/<?=$wannabe->event->reference?>/Wiki/<?=$wiki['Wikipage']['title']?>/history"><?=__("History")?></a></p>
	<p>&nbsp;</p>
<?php
} else {
?>
<p><?=__("This page does not exist… yet. Press the button to the right to create it.")?></p>
<p>&nbsp;<a class="btn primary small pull-right" href="<?=$this->Wb->eventUrl('/Wiki/'.$wiki['Wikipage']['title'].'/edit')?>"><?=__("Create")?></a></p>
<?php
}
?>
