<?php
	if(count($openandnotdenied) < $settings['CfadApplicationSetting']['choices']) {
		$numberofchoices = count($openandnotdenied);
	} else {
		$numberofchoices = $settings['CfadApplicationSetting']['choices'];
	}
	foreach($this->data['CfadApplicationChoice'] as $choicetemp) {
		if($choicetemp['denied']) $numberofchoices++;
	}
	for ($i=0; $i<$numberofchoices; $i++) { ?>
	<div class="clearfix crew-choices">
		<input type="hidden" name="data[CfadApplicationChoice][<?=$i?>][id]" value="<?=isset($this->data['CfadApplicationChoice'][$i]['id']) ? $this->data['CfadApplicationChoice'][$i]['id'] : ''?>" />
		<label for="data[CfadApplicationChoice][<?=$i?>][crew_id]"><?=$i+1?>.</label>
		<div class="input">
			<select name="data[CfadApplicationChoice][<?=$i?>][crew_id]" class="select-crew">
				<?php 
					if (isset($this->data['CfadApplicationChoice'][$i])) $selectedcrewid = $this->data['CfadApplicationChoice'][$i]['crew_id'];
					if (isset($this->data['CfadApplicationChoice'][$i]) && $this->data['CfadApplicationChoice'][$i]['denied']) {
						printf("<option selected value=\"$selectedcrewid\">$crews[$selectedcrewid] &ndash; %s</option></select></div></div>", __("denied"));
						continue; 
					} 
				?>
                    <option value=""><?=__("Choose")?></option>
                <?php if(isset($this->data['CfadApplicationChoice'][$i])) { 
                    if(in_array($crews[$this->data['CfadApplicationChoice'][$i]['crew_id']], $openandnotdenied)) {
                        foreach ($openandnotdenied as $crew_id => $name) { ?>
                            <option <?php if($this->data['CfadApplicationChoice'][$i]['crew_id'] == $crew_id) { ?>selected<? } ?> value="<?=$crew_id?>"><?=$name?></option>
                    <?php }
                    }
                } else {
                    foreach ($openandnotdenied as $crew_id => $name) { ?>
                            <option value="<?=$crew_id?>"><?=$name?></option>
                    <?php }
                } ?>
			</select>
		</div>
	</div>
<?php } ?>

<script type="text/javascript">
$(document).ready(function() {
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
