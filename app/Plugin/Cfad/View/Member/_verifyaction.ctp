<form method="POST">
	<fieldset>
        <legend><?=$header?></legend>
        <div class="input"><?=$text?></div>
        <div class="actions">
            <?=$this->Form->submit(__('Yes'), array('name'=>'verify-yes', 'class' => 'btn danger small', 'div' => false))?>
            <a href="<?=$this->Wb->eventUrl('/cfad/Member/edit')?>" class='btn small' ><?=__("No")?></a>
        </div>
        <? if(isset($hidden) && count($hidden)) foreach($hidden as $name => $value) { ?>
            <?=$this->Form->hidden($name, array('value' => $value))?>
        <? } ?>
	</fieldset>
</form>
