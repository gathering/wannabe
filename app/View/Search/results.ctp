<div class="row">
	<div class="span16">
		<? if (sizeof($users) == 0) { echo __("No results."); } else { ?>
		<ul class="unstyled">
		<? foreach ( $users as $user ) { ?>
			<li>#<?=$user['User']['id']?> <?=$this->Wb->userLink($user)?> <?=isset($crews[$user['Membership']['crew_id']])?__("of %s", $crews[$user['Membership']['crew_id']]):null?></li>
		<? } ?>
		</ul>
		<? } ?>
	</div>
</div>
<div class="page-header">
	<h1><?=__("Search")?> <small><?=__("Refine your criteria")?></small></h1>
</div>
<? include(dirname(__FILE__).'/index.ctp'); ?>
