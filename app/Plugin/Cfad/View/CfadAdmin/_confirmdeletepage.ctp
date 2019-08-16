<form method="post" enctype="multipart/form-data" action="<?=$this->Wb->eventUrl('/cfad/CfadAdmin/deletepage')?>">
	<fieldset>
		<legend><?=__("Delete page “%s”", $page['CfadApplicationPage']['name'])?></legend>
		<div class="input"><?=__("Are you sure you want to delete this page? This action cannot be undone")?></div>
	</fieldset>
	<div class="actions">
		<?=$this->Form->hidden('CfadApplicationPage.id', array('value' => $page['CfadApplicationPage']['id']))?>
		<?=$this->Form->hidden('Otherinfo.confirmed', array('value' => 1))?>
		<?=$this->Form->submit(__("Yes"), array('div' => false, 'label' => false, 'class' => 'btn danger'))?> <a href="<?=$this->Wb->eventUrl('/cfad/CfadAdmin/page')?>" class="btn"><?=__("No")?></a>
	</div>
</form>
