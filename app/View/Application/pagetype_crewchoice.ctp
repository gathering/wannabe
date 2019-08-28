<?php
	$privacy = $settings['ApplicationSetting']['privacy'];
	$priority = $settings['ApplicationSetting']['priority'];
	$open = 0; // isset($settings['ApplicationSetting']['open']) ? $settings['ApplicationSetting']['open']; : 0;
//	echo "<pre>";var_dump($settings);echo "</pre>";
    if($open):
        $crews[$open] = 'Åpen søknad';
        foreach($this->data['ApplicationChoice'] as $choice):
            if($choice['crew_id'] == $open && $choice['denied']):
                $open = 0;
            endif;
        endforeach;
    endif;
?>
<?php if($priority||$privacy||$open) { ?>
	<div class="clearfix">
		<label id="optionsCheckboxes"><?=__("Options")?></label>
		<div class="input">
			<ul class="inputs-list list-unstyled">
<?php } ?>
<?php if($priority) { ?>
				<li>
					<label>
						<?=$this->Form->checkbox('ApplicationDocument.orderedchoices', array('div' => false, 'disabled' => $readonly, 'checked' => $data['ApplicationDocument']['orderedchoices']?'checked':''))?>
						<span><?=__('My choices are in a prioritized order.')?></span>
					</label>
				</li>
<?php } ?>
<?php if($privacy) { ?>
				<li>
					<label>
						<?=$this->Form->checkbox('ApplicationDocument.enableprivacy', array('disabled' => $readonly, 'checked' => $data['ApplicationDocument']['enableprivacy']?'checked':true))?>
						<span><?=__('My application can only be viewed by the chiefs in my selected choices.')?></span>
					</label>
				</li>
<?php } ?>
<?php if($open) { ?>
				<li>
					<label>
						<?=$this->Form->checkbox('ApplicationDocument.applyingopen', array('disabled' => $readonly, 'checked' => $data['ApplicationDocument']['applyingopen']?'checked':''))?>
						<span><?=__('I do not know what I want to apply for, and want to apply open.')?></span>
					</label>
				</li>
<?php } ?>
<?php if($privacy||$priority||$open) { ?>
			</ul>
		</div>
	</div>
<?php } ?>

<?php
	if(count($openandnotdenied) < $settings['ApplicationSetting']['choices']) {
		$numberofchoices = count($openandnotdenied);
	} else {
		$numberofchoices = $settings['ApplicationSetting']['choices'];
	}
	foreach($this->data['ApplicationChoice'] as $choicetemp) {
		if($choicetemp['denied'] || $choicetemp['waiting']) $numberofchoices++;
        //elseif(!$choicetemp['accepted']) unset($openandnotdenied[$choicetemp['crew_id']]);
	}
	if($readonly) {
		$numberofchoices = count($this->data['ApplicationChoice']);
	}
	for ($i=0; $i<$numberofchoices; $i++) { ?>
		<div class="row" style="padding: 5px;">
	<div class="clearfix crew-choices">
		<div class="col-xs-1">
		<input type="hidden" name="data[ApplicationChoice][<?=$i?>][id]" value="<?=isset($this->data['ApplicationChoice'][$i]['id']) ? $this->data['ApplicationChoice'][$i]['id'] : ''?>" />
		<label class="control-label" for="data[ApplicationChoice][<?=$i?>][crew_id]"><?=$i+1?>.</label> <br/>
	</div><div class="col-xs-6">
		<div class="input">
			<select name="data[ApplicationChoice][<?=$i?>][crew_id]" class="select-crew form-control" <?=$readonly ? 'disabled' : null?>>
				<?php
					if (isset($this->data['ApplicationChoice'][$i])) $selectedcrewid = $this->data['ApplicationChoice'][$i]['crew_id'];
					if (isset($this->data['ApplicationChoice'][$i]) && $this->data['ApplicationChoice'][$i]['denied']) {
						printf("<option selected value=\"$selectedcrewid\">$crews[$selectedcrewid] &ndash; %s</option></select></div></div></div>", __("denied"));
						continue;
					}
					if (isset($this->data['ApplicationChoice'][$i]) && $this->data['ApplicationChoice'][$i]['waiting']) {
						printf("<option selected value=\"$selectedcrewid\">$crews[$selectedcrewid] &ndash; %s</option></select></div></div></div>", __("waiting"));
						continue;
					}
					if (isset($this->data['ApplicationChoice'][$i]) && $this->data['ApplicationChoice'][$i]['accepted']) {
						printf("<option selected value=\"$selectedcrewid\">$crews[$selectedcrewid] &ndash; %s</option></select></div></div></div>", __("accepted"));
						continue;
					}
				?>
                    <option value=""><?=__("Choose")?></option>
                <?php if(isset($this->data['ApplicationChoice'][$i])) {
                    if(in_array($crews[$this->data['ApplicationChoice'][$i]['crew_id']], $openandnotdenied)) {
                        foreach ($openandnotdenied as $crew_id => $name) { ?>
                            <option <?php if($this->data['ApplicationChoice'][$i]['crew_id'] == $crew_id) { ?>selected<? } ?> value="<?=$crew_id?>"><?=$name?></option>
                    <?php }
                    } else {
                        if($this->data['ApplicationChoice'][$i]['crew_id'] != $settings['ApplicationSetting']['open']):
                        ?><option selected value="<?=$this->data['ApplicationChoice'][$i]['crew_id']?>"><?=$crews[$this->data['ApplicationChoice'][$i]['crew_id']]?> &ndash; <?=__("closed")?></option><?
                        endif;
                        foreach ($openandnotdenied as $crew_id => $name) { ?>
                                <option value="<?=$crew_id?>"><?=$name?></option>
                        <?php }
                    }
                } else {
                    foreach ($openandnotdenied as $crew_id => $name) { ?>
                            <option value="<?=$crew_id?>"><?=$name?></option>
                    <?php }
                } ?>
			</select>
		</div></div></div>
	</div>
<?php } ?>

<script type="text/javascript">
$(document).ready(function() {
    if($('#ApplicationDocumentApplyingopen').is(":checked")) {
        $('.crew-choices').hide();
        $('#ApplicationDocumentOrderedchoices').parentsUntil('li').hide();
    }
    $('#ApplicationDocumentApplyingopen').change(function() {
        if($(this).is(":checked")) {
            $('.crew-choices').hide();
            $('#ApplicationDocumentOrderedchoices').parentsUntil('li').hide();
        } else {
            $('.crew-choices').show();
            $('#ApplicationDocumentOrderedchoices').parentsUntil('li').show();
        }
    });
	$('.select-crew').change(function() {
		var changed = this;
		$('.select-crew').each(function() {
			if((changed.name != this.name)&&(changed.selectedIndex == this.selectedIndex)) {
				this.selectedIndex = 0;
			}
		});
    });
});
</script>
