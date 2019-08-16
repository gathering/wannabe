<?php
	$openandnotdenied = array();
	foreach ($open_crews as $current_id => $current) {
		if(!$this->data['CfadApplicationChoice']) $openandnotdenied[$current_id] = $current;
		foreach($this->data['CfadApplicationChoice'] as $selected) {
			if($current_id == $selected['crew_id']) {
				if($selected['denied']) continue 2;
			}
		}
		$openandnotdenied[$current_id] = $current;
	}
	if(empty($openandnotdenied)) throw new BadRequestException(__("No crews are open for applying for crew for a day"));
?>
<div class="row">
	<div class="span16">
		<form method="post" action="<?=$this->Wb->eventUrl('/cfad/CfadApplication/save?'.rand(10000,99999))?>">
			<fieldset>
				<legend><?=$page['CfadApplicationPage']['name']?></legend>
				<?=$this->Form->hidden('CfadApplication.current_page', array('value'=>$current_page))?>
				<?=$this->Form->hidden('CfadApplicationDocument.id')?>
				<div class="clearfix">
					<label for="page-description"><?=__("Page description")?></label>
					<div class="input">
						<p name="page-description"><?=$page['CfadApplicationPage']['description']?></p>
					</div>
				</div>
				<? include dirname(__FILE__) .'/pagetype_'.$page['CfadApplicationPage']['type'].'.ctp'; ?>
			</fieldset>
			<div class="actions">
				<?=$this->Form->submit(__("Previous"), array('class' => 'btn', 'name'=>'data[CfadApplication][previous]', 'div' => false))?>&nbsp;<?=$this->Form->submit(__("Next"), array('class' => 'btn success', 'name'=>'data[CfadApplication][next]', 'div' => false))?>
				<?php
					$totalpages = count($pages);
					foreach ($pages as $currentindex => $tempcurrent) {
						if($tempcurrent['CfadApplicationPage']['id'] == $page['CfadApplicationPage']['id']) { 
							$currentpage = (int)($currentindex + 1);
							break;
						}
					}
				?>
				<div class="pull-right">
					<?=__("Page %s of %s", $currentpage, $totalpages)?>
				</div>
			</div>
		</form>
	</div>
</div>
