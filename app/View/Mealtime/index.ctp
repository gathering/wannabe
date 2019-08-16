<p><?=__("This information is used for food calculations and statistics.")?></p>
<form method="POST">
    <fieldset>
    <div class="clearfix <? if($this->Form->error('Mealtime.mealtime')) echo "error"; ?>">
            <label for="data[Mealtime][mealtime]"><?=__("Meal time")?></label>
            <div class="input">
                <?=$this->Form->select('Mealtime.mealtime', $mealtimes, array('value' => $mealtime['Mealtime']['mealtime'], 'div' => false, 'label' => false, 'empty' => __("Choose")))?>
                <span class="help-block"><?=($this->Form->error('Mealtime.mealtime')?$this->Form->error('Mealtime.mealtime'):__("Please select a meal time"))?></span>
            </div>
        </div>
    </fieldset>
    <div class="actions">
	    <?=$this->Form->submit(__("Save"), array('class' => 'btn success', 'name' => 'save'))?>
    </div>
</form>
