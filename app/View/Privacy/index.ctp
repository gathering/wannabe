<form method="POST">
<fieldset>
    <div class="clearfix">
        <label id="optionscheckboxes" for="data[UserPrivacy][user_id]"><?=__('Hide…')?></label>
        <div class="input">
            <ul class="inputs-list">
                <?php foreach($privacy['UserPrivacy'] as $name => $item) { 
                    if($name == 'user_id' || $name == 'allow_crew') continue; ?>
                    <li>
                        <label>
                            <?=$this->Form->checkbox('UserPrivacy.'.$name, array('div' => 'false', 'checked' => $item))?>
                            <span><?=$privacyNames[$name]?></span>
                        </label>
                    </li>
                <?php } ?>

                <hr />

                <li>
                    <label>
                        <?=$this->Form->checkbox('UserPrivacy.'.$name, array('div' => 'false', 'checked' => $privacy['UserPrivacy']['allow_crew']))?>
                        <span><?=$privacyNames['allow_crew']?></span>
                    </label>
                </li>
            </ul>
        </div>
    </div>
</fieldset>
<div class="actions">
    <?=$this->Form->submit(__("Save settings"), array('class' => 'btn success','name'=>'save'))?>
</div>
</form>
