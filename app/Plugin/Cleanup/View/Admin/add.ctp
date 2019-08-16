<div class="row">
    <div class="span16">
        <form method="post">
            <fieldset>
                <legend><?=__("Add new cleanup time")?></legend>
                <div class="clearfix">
                    <label><?=__("Description")?></label>
                    <div class="input">
                        <?=$this->Form->input('Cleanup.description', array('div' => false, 'error' => false, 'label' => false))?>
                    </div>
                </div>
                <div class="clearfix">
                    <label><?=__("Maximum positions")?></label>
                    <div class="input">
                        <?=$this->Form->input('Cleanup.maximum', array('div' => false, 'error' => false, 'label' => false))?>
                    </div>
                </div>
                <div class="clearfix">
                    <label><?=__("Time")?></label>
                    <div class="input">
                        <div class="inline-inputs">
                            <?=$this->Form->select('Cleanup.time', $dates, array('empty' => __("Date"), 'class' => 'span3', 'div' => false, 'error' => false, 'label' => false))?>
                            <?=$this->Form->hour('Cleanup', true,  array('empty' => __("Hour"), 'class' => 'span2', 'div' => false, 'error' => false, 'label' => false))?>
                            <?=$this->Form->minute('Cleanup', array('empty' => __("Minute"), 'class' => 'span2', 'div' => false, 'error' => false, 'label' => false))?>
                        </div>        
                    </div>
                </div>
            </fieldset>
            <div class="actions">
                <?=$this->Form->submit(__('Save cleanup time'), array('div' => false, 'class' => 'btn success', 'name'=>'save'))?> 
                <a href="<?=$this->Wb->eventUrl("/Cleanup/Admin")?>" class="btn default"><?=__('Done')?></a>
            </div>
        </form>
    </div>
</div>
