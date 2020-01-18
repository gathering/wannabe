<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<?php
	$openandnotdenied = array();
	foreach ($open_crews as $current_id => $current) {
		if(!$this->data['ApplicationChoice']) $openandnotdenied[$current_id] = $current;
		foreach($this->data['ApplicationChoice'] as $selected) {
			if($current_id == $selected['crew_id']) {
				if($selected['denied']) continue 2;
                if($selected['waiting']) continue 2;
			}
		}
		$openandnotdenied[$current_id] = $current;
	}
	if(empty($openandnotdenied)) throw new BadRequestException($settings['ApplicationSetting']['deniedtext']);
?>
<div class="row">
	<div class="col-md-12">
		<form method="post" action="<?=$this->Wb->eventUrl('/Application/save?'.rand(10000,99999))?>">
			<fieldset>
				<legend><?=$page['ApplicationPage']['name']?></legend>
				<?=$this->Form->hidden('Application.current_page', array('value'=>$current_page))?>
				<?=$this->Form->hidden('ApplicationDocument.id')?>
				<div class="clearfix">
					<label for="page-description"><?=__("Page description")?></label>
					<div class="input">
						<p name="page-description"><?=$page['ApplicationPage']['description']?></p>
					</div>
				</div>
				<? include dirname(__FILE__) .'/pagetype_'.$page['ApplicationPage']['type'].'.ctp'; ?>
			</fieldset>
			<div class="actions" style="margin-top: 10px;">
				<?php
					foreach ($pages as $currentindex => $tempcurrent) {
						if($tempcurrent['ApplicationPage']['id'] == $page['ApplicationPage']['id']) {
							$currentpage = (int)($currentindex + 1);
							break;
						}
					}
				?>
				<?= $this->Form->submit(__("Previous"), array('class' => 'btn', 'name'=>'data[Application][previous]', 'div' => false))?>
				&nbsp;
				<?=$this->Form->submit(__($totalpages == $currentpage ? "Submit" : "Next"), array('class' => 'btn btn-success', 'name'=>'data[Application][next]', 'div' => false))?>
				<div class="pull-right">
					<?=__("Page %s of %s", $currentpage, $totalpages)?>
				</div>
			</div>
		</form>
	</div>
</div>
