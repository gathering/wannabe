<form method="POST" class="panel panel-primary">
    <div class="panel-heading">
        <?=__('Settings')?>
    </div>
    <div class="panel-body">
        <label id="optionscheckboxes" for="data[UserPrivacy][user_id]"><strong><?=__('Hidden info')?></strong></label>
        <div class="form-group">
            <?php foreach($privacy['UserPrivacy'] as $name => $item) {
                if($name == 'user_id' || $name == 'allow_crew') continue; ?>
                <label class="checkbox-inline">
                    <?=$this->Form->checkbox('UserPrivacy.'.$name, array('class' => 'form-check-input', 'div' => false, 'checked' => $item))?>
                    <?=$privacyNames[$name]?>
                </label>
            <?php } ?>
        </div>
        <label for="data[UserPrivacy][user_id]"><strong><?=__('Exceptions…')?></strong></label>
        <div class="form-group">
            <label class="checkbox-inline">
                <?=$this->Form->checkbox('UserPrivacy.'.$name, array('div' => 'false', 'checked' => $privacy['UserPrivacy']['allow_crew']))?>
                <?=$privacyNames['allow_crew']?>
            </label>
        </div>
        <hr />
        <p><?=__("Administrators, Chiefs and others with special access will always be allowed to access your contact information")?></p>
    </div>
    <div class="panel-footer">
        <?=$this->Form->submit(__("Save settings"), array('class' => 'btn btn-success','name'=>'save'))?>
    </div>
</form>
<?
    if (!empty($privacyPage)) {
?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <?=__('Info')?>
        </div>
        <div class="panel-body">
            <?=$privacyPage['Wikipage']['content']?>
        </div>
    </div>
<?
    }
?>
