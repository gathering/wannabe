<div class="row">
	<div class="col-md-10">
		<?=$page['Wikipage']['content']?>
	</div>
	<div class="col-md-2">
		<h4><?=__("Actions")?></h4>
		<div class="well">
			<a class="btn btn-info primary" href="/<?=$wannabe->event->reference?>/Wiki/<?=$page['Wikipage']['title']?>/edit"><?=__("Edit")?></a>
			<a class="btn btn-default" href="/<?=$wannabe->event->reference?>/Wiki/<?=$page['Wikipage']['title']?>/history"><?=__("History")?></a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<hr />
		<a class="btn btn-default pull-right" href="#top"><?=__("&#x2191; To top")?></a>
		<p><small><?=__("Last updated by %s, at %s", "<em>{$this->Wb->userLink($page)}</em>", "<em>".date('d.m.Y H:i:s',strtotime($page['Wikipage']['created']))."</em>.")?></small></p>
	</div>
</div>
