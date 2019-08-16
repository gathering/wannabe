<h1>Parking information</h1>

<form method="POST">
    <fieldset>
        <div class="clearfix">
            <label for="data[Carplate][carplate]"><?=__("Carplate")?></label>
            <div class="input">
				<input class="span3" name="data[Carplate][carplate]" type="text" id="newmemberId" value="<?php echo isset($my_plate) ? $my_plate['Carplate']['carplate'] : ''; ?>">

                <span class="help-block"><?=__("For the security to know what cars they shouldn't remove.")?></span>
            </div>
        </div>
    </fieldset>
    <div class="actions">
	    <?=$this->Form->submit($savebutton, array('class' => 'btn success', 'name' => 'save'))?>
    </div>
</form>

