<?php if(isset($registered)) { ?>
<h3><?=__("Registration complete")?></h3>
<p><?=__("Any questions regarding you application is to be sent to the press team.")?></p>
<?php } else { ?>
<form method="post">
    <fieldset>
        <legend><?=__("Register application")?></legend>
        <div class="clearfix <? if($this->Form->error('Accreditation.company_name')) echo "error"; ?>">
            <label for="data[Accreditation][company_name]"><?=__("Company name")?> </label>
            <div class="input">
                <?=$this->Form->input('Accreditation.company_name', array('div' => false, 'error' => false, 'label' => false))?>
                <span class="help-block"><?=$this->Form->error('Accreditation.company_name')?></span>
            </div>
        </div>
        <div class="clearfix <? if($this->Form->error('Accreditation.realname')) echo "error"; ?>">
            <label for="data[Accreditation][realname]"><?=__("Real name")?></label>
            <div class="input">
                <?=$this->Form->input('Accreditation.realname', array('div' => false, 'error' => false, 'label' => false))?>
                <span class="help-block"><?=$this->Form->error('Accreditation.realname')?></span>
            </div>
        </div>
        <div class="clearfix <? if($this->Form->error('Accreditation.phonenumber')) echo "error"; ?>">
            <label for="data[Accreditation][phonenumber]"><?=__("Phone number")?></label>
            <div class="input">
                <?=$this->Form->input('Accreditation.phonenumber', array('div' => false, 'error' => false, 'label' => false))?>
                <span class="help-block">
                    <?php if($this->Form->error('Accreditation.phonenumber')):
                        echo $this->Form->error('Accreditation.phonenumber');
                    else:
                        echo __("Phone number must contain country prefix. Example: +4712345678 (without space)");
                    endif;?>
                </span>
            </div>
        </div>
        <div class="clearfix <? if($this->Form->error('Accreditation.email')) echo "error"; ?>">
            <label for="data[Accreditation][email]"><?=__("E-mail")?></label>
            <div class="input">
                <?=$this->Form->input('Accreditation.email', array('div' => false, 'error' => false, 'label' => false))?>
                <span class="help-block"><?=$this->Form->error('Accreditation.email')?></span>
            </div>
        </div>
        <div class="clearfix <? if($this->Form->error('Accreditation.numpersons')) echo "error"; ?>">
            <label for="data[Accreditation][numpersons]"><?=__("Number of persons")?></label>
            <div class="input">
                <?=$this->Form->input('Accreditation.numpersons', array('div' => false, 'error' => false, 'label' => false))?>
                <span class="help-block"><?=$this->Form->error('Accreditation.numpersons')?></span>
            </div>
        </div>
        <div class="clearfix <? if($this->Form->error('Accreditation.arrivaldate')) echo "error"; ?>">
            <label for="data[Accreditation][arrivaldate]"><?=__("Planned arrival")?></label>
            <div class="input">
                <?=$this->Form->input('Accreditation.arrivaldate', array('div' => false, 'error' => false, 'label' => false, 'class' => 'span2'))?>
                <span class="help-block"><?=$this->Form->error('Accreditation.arrivaldate')?></span>
            </div>
        </div>
        <div class="clearfix <? if($this->Form->error('Accreditation.departuredate')) echo "error"; ?>">
            <label for="data[Accreditation][departuredate]"><?=__("Planned departure")?></label>
            <div class="input">
                <?=$this->Form->input('Accreditation.departuredate', array('div' => false, 'error' => false, 'label' => false, 'class' => 'span2'))?>
                <span class="help-block"><?=$this->Form->error('Accreditation.departuredate')?></span>
            </div>
        </div>
    </fieldset>
    <fieldset>
        <legend><?=__("What kind of permissions are you applying for?")?></legend>
		<div class="clearfix">
			<label for="objectList"><?=__("Check all that apply")?></label>
			<div class="input">
				<ul class="inputs-list">
					<li>
						<label>
                            <?=$this->Form->input('Accreditation.pictures', array('type' => 'checkbox', 'div' => false, 'error' => false, 'label' => false))?>
                            <span><?=__("Pictures")?></span>
						</label>
					</li>
					<li>
						<label>
                            <?=$this->Form->input('Accreditation.film', array('type' => 'checkbox', 'div' => false, 'error' => false, 'label' => false))?>
                            <span><?=__("Film")?></span>
						</label>
					</li>
					<li>
						<label>
                            <?=$this->Form->input('Accreditation.tour', array('type' => 'checkbox', 'div' => false, 'error' => false, 'label' => false))?>
                            <span><?=__("Tour")?></span>
						</label>
					</li>
				</ul>
			</div>
		</div>
    </fieldset>
    <fieldset>
        <legend><?=__("Extended info")?></legend>
		<div class="clearfix">
			<label for="objectList"><?=__("Options")?></label>
			<div class="input">
				<ul class="inputs-list">
					<li>
						<label>
                            <?=$this->Form->input('Accreditation.smsalert', array('type' => 'checkbox', 'div' => false, 'error' => false, 'label' => false))?>
                            <span><?=__("SMS alert")?></span>
						</label>
					</li>
				</ul>
			</div>
		</div>
        <div class="clearfix <? if($this->Form->error('Accreditation.extended_info')) echo "error"; ?>">
            <label for="data[Accreditation][extended_info]"><?=__("Extended info")?></label>
            <div class="input">
                <?=$this->Form->input('Accreditation.extended_info', array('div' => false, 'error' => false, 'label' => false, 'class' => 'span8'))?>
                <span class="help-block"><?=$this->Form->error('Accreditation.extended_info')?$this->Form->error('Accreditation.extended_info'):__("If the application is for more than one person, please list the names in the extended information box")?></span>
            </div>
        </div>
    </fieldset>
    <div class="actions">
        <?=$this->Form->submit(__("Register"), array('div' => false, 'label' => false, 'class' => 'btn success'))?>
    </div>
</form>
<?php } ?>
