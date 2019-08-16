<form>
<div class="clearfix">
<?php 
$current = false;
foreach ($events as $event):
	if (!$this->Date->isPastDue($event['Event']['end'])): 
		$current = true;
	endif;
endforeach;
if($current): ?>
<label><?=__("Choose event")?></label>
<div class="input">
<ul class="inputs-list">
	<?php foreach ($events as $event) { ?>
		<?php if (!$this->Date->isPastDue($event['Event']['end'])) { ?>
        		<li><a href="/<?=$event['Event']['reference']?>/"><?=$event['Event']['name']?></a></li>
		<?php } ?>
	<? } ?>
</ul></div>
<? else: ?>
<div class="input"><ul><li><?=__("No current events")?></li></ul></div>
<? endif; ?>
</div>
<div class="clearfix">
<label><?=__("Old events")?></label>
<div class="input">
<ul class="inputs-list">
	<?php foreach ($events as $event) { ?>
		<?php if ($this->Date->isPastDue($event['Event']['end'])) { ?>
        		<li><small><a href="/<?=$event['Event']['reference']?>/"><?=$event['Event']['name']?></a></small></li>
		<?php } ?>
	<?php } ?>
</ul>
</div>
</div>
</form>
