<form method="POST">
    <fieldset>
			<label id="optionscheckboxes" for="data[Needs][allergies]"><b><?=__('Do you have any allergies?')?></b></label>
					<?php foreach($allergies as $allergy => $item) { ?>
        <div class="checkbox">
							<label>
								<?=$this->Form->checkbox('Needs.allergies'. $item, array('div' => 'false', 'checked' => $allergiesValues[$item]))?>
								<span><?=__($allergies[$allergy])?></span>
							</label>
        </div>
					<?php } ?>
				<span class="help-block"><?=$this->Form->error('Needs.allergies')?></span>

        <?php if(isset($this->data['Needs'])) {
            $nutritionalneeds = $this->data['Needs']['nutritionalneeds'];
            $medicalneeds = $this->data['Needs']['medicalneeds'];
        } else {
            $nutritionalneeds = '';
            $medicalneeds = '';
        } ?>
            <label for="data[Needs][nutritionalneeds]"><b><?=__("Other nutritional needs")?></b></label>
            <div class="input">
                <?=$this->Form->textarea('Needs.nutritionalneeds', array('rows' => 3, 'value' => $nutritionalneeds, 'class' => 'form-control'))?>
                <span class="help-block"><?=__("Do you have any other needs or allergies that we should know about?")?></span>
            </div>
            <label for="data[Needs][medicalneeds]"><b><?=__("Medical needs")?></b></label>
            <div class="input">
                <?=$this->Form->textarea('Needs.medicalneeds', array('rows' => 3, 'value' => $medicalneeds, 'class' => 'form-control'))?>
                <span class="help-block"><?=__("Please fill in any medical needs you have")?></span>
            </div>
		<p>
			<?=__("consent-walloftext")?>
		</p>

        <label> <?=$this->Form->checkbox('consent', array('type'=>'checkbox'))?> <?=__("consent-disclaimer")?></label>
    </fieldset>
    <br/>
    <div class="actions">
	    <?=$this->Form->submit($savebutton, array('class' => 'btn btn-success', 'name' => 'save'))?>
    </div>
</form>
