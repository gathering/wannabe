<div class="page-header">
	<h1><?=__("Compare “%s”", $pagefirst['Wikipage']['title'])?></h1>
</div>
<div class="row">
	<div class="col-md-10">
		<div class="wikidiff">
			<?=$this->Diff->contents($pagefirst['Wikipage']['content'], $pagesecond['Wikipage']['content']);?>
		</div>
	</div>
	<div class="col-md-2">
		<p class="pull-right"><a class="btn btn-default" href="<?=$this->Wb->eventUrl("/Wiki/{$pagefirst['Wikipage']['title']}/history")?>"><?=__("Back to history")?></a></p>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<hr />
		<p class="pull-right">
			<a class="btn small" href="#top"><?=__("&#x2191; To top")?></a>
			<a class="btn small primary" href="<?=$this->Wb->eventUrl("/Wiki/{$pagefirst['Wikipage']['title']}/history")?>"><?=__("Back to history")?></a>
		</p>
	</div>
</div>
