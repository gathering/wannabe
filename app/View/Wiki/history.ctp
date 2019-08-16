<? if ($canDiff) { ?>
<form method="GET" action="<?=$this->Wb->eventUrl('/Wiki/'.$pages[0]['Wikipage']['title'].'/diff')?>">
<div class="row">
	<div class="span16">
		<p class="pull-right"><input type="submit" class="btn btn-default" value="<?=__("See difference")?>" /></p>
	</div>
</div>
<? } ?>
<div class="row">
	<div class="col-md-12">
	<table class="table table-striped">
		<tr>
		<th><?=__("Title")?></th>
		<th><?=__("Revision")?></th>
		<th><?=__("Date")?></th>
		<th><?=__("By user")?></th>
		<? if ($canDiff) { ?>
		<th>A</th>
		<th>B</th>
		<? } ?>

		</tr>
		<? $a=$b=0; foreach ( $pages as $page ) { ?>
		<tr>
		<td><a href="<?=$this->Wb->eventUrl('/Wiki/'.$page['Wikipage']['title'].'?revision='.$page['Wikipage']['revision'])?>"><?=$page['Wikipage']['title']?></a></td>
		<td><?=$page['Wikipage']['revision']?></td>
		<td><?=$page['Wikipage']['created']?></td>
		<td><?=$this->Wb->userLink($page)?></td>

		<? if ( $canDiff ) { ?>
		<td><input <? if ($a++ == 0) { ?>checked<? } ?> type="radio" name="a" value="<?=$page['Wikipage']['revision']?>"></td>
		<td><input <? if ($b++ == 1) { ?>checked<? } ?> type="radio" name="b" value="<?=$page['Wikipage']['revision']?>"></td>
		<? } ?>

		</tr>
		<? } ?>
	</table>
	</div>
</div>
<? if ($canDiff) { ?>
<div class="row">
	<div class="col-md-12">
		<p class="pull-right"><input type="submit" class="btn btn-default" value="<?=__("See difference")?>" /></p>
	</div>
</div>
</form>
<? } ?>
