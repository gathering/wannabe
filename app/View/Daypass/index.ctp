<p>
Jeg vil ha muligheten til å stå
som ansvarlig for personer som kjøper dagspass. Jeg vil bli registrert i
Geekevents som crew på <?=isset($wannabe->event->name)?$wannabe->event->name:''?>                                                                                                                                      
</p><p>
NB: Det vil bli oppretta en bruker for deg i Geekevents, med den
personaliaen du har i Wannabe, dersom vi ikke finner en bruker med din
e-postadresse og/eller mobiltelefonnummer fra før av.
</p>
<form method="POST">
    <?=$this->Form->hidden('Daypass.id')?>
    <fieldset>
		<div class="clearfix">
			<label for="checkOptions"><?=__("Accept export")?></label>
			<div class="input">
				<ul class="inputs-list">
					<li>
						<label>
							<?=$this->Form->radio('Daypass.accepted', array(0 => _("No"),1 => _("Yes")), array('legend' => false))?>
						</label>
					</li>
				</ul>
			</div>
		</div>

    </fieldset>
    <div class="actions">
	    <?=$this->Form->submit($savebutton, array('class' => 'btn success', 'name' => 'save'))?>
    </div>
</form>
