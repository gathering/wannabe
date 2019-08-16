<form method="post">
<fieldset>

<?php


if($action == 0) {
?>
    <div class="input">
    <h4>Du har valgt: Ønsker ikke medlemskap i KANDU for <?=$year?></h4><br />
    NB! Merk at du ikke vil få tilsendt informasjon om aktivitetstilbud
    utenom det som sendes på crewlista.
    </div>
    <input type="hidden" name="data[KanduMembership][choice]" id="KanduMembershipChoice" value="0" />
<?php

}
else if($action == 1) {
?>
    <div class="input">
    <h4>Du har valgt: Ønsker gratis medlemskap i KANDU for <?=$year?></h4><br />
    <?php if($age < 26) { ?>
    NB! Du er under 26 år, og kan generere statsstøtte som brukes til
    aktiviteter! Vi setter pris på om du vurderer betalt medlemskap for
    50kr, valget nedenfor. Du står naturligvis helt fritt til å velge gratis
    medlemskap dersom du heller ønsker det.<?php } ?>
    <input type="hidden" name="data[KanduMembership][choice]" id="KanduMembershipChoice" value="1" />
    </div>
<?php
}
else if($action == 2) {
?>
    <div class="input">
    <h4>Du har valgt: Ønsker betalt medlemskap i KANDU (støttegenererende, 50kr) for <?=$year?></h4>
       <p> Takk for at du vil støtte KANDU! Du kan betale inn kontingenten på 50kr
        til konto 5081.05.36974. Merk betalinga med navnet ditt. </p>
    <input type="hidden" name="data[KanduMembership][choice]" id="KanduMembershipChoice" value="2" />
<?php
}

?>

</fieldset>
<div class="actions">
    <?=$this->Form->submit(__("Confirm"), array('class' => 'btn success', 'name' => 'save', 'div' => false))?>
    <a href="<?=$this->Wb->eventUrl('/KanduMembership')?>" class="btn"><?=__("Back")?></a>
</form>
