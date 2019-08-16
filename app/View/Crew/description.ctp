<? if (isset($wannabe->user['User']['id']) && !$this->Wb->hasMembershipToEvent($wannabe->user, $wannabe->event)) { ?>
	<p><a href="<?=$this->Wb->eventUrl('/Application')?>" class="btn success"><?=__("Click here to apply for crew")?></a></p>
<? } ?>

<div class="row">
	<div class="col-md-12">
<ul class="crewlist">
<? foreach($crews as $crew) {
	if (!preg_match('/^\s+$/', $crew['Crew']['content'])) { ?>
		<dd>
			<h3>
				<a href="<?=$this->Wb->eventUrl('/Crew/Description/'.$crew['Crew']['name'])?>"><?=$crew['Crew']['name']?></a>
				<small><? if ( !$crew['Crew']['canapply'] ) { echo __("Closed for applications"); } ?></small>
			</h3>
			<div class="crew-description<? if(str_word_count($crew['Crew']['content']) >= 100) { ?> <? } ?>"><?=$crew['Crew']['content']?></div>
		</dd>
	<? }
} ?>
</ul>
<?php if(isset($back)) { ?>
<a href="<?=$this->Wb->eventUrl('/Crew/Description')?>" class="btn success"><?=__("Back to descriptions")?></a>
<?php } ?>
</div>
</div>
