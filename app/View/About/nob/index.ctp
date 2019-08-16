<p>Denne nettsiden er utviklet og forvaltes av  <a href='mailto:wannabe@gathering.orgSPAM'>Core:Systems</a>. Drift av server og e-postsystem er levert av <a href='mailto:drift@gathering.orgSPAM'>driftsgruppen</a>.</p>
<p>Feil rapporteres <em>kun</em> over e-post til <a href='mailto:wannabe@gathering.orgSPAM'>Core:Systems</a>. Problemstillinger vedrørende e-postlister rapporteres til <a href='mailto:drift@gathering.orgSPAM'>driftsgruppen</a>. For alle andre tekniske problemstillinger i forhold til nettsider utviklet eller driftet av The Gathering, vennligst kontakt <a href='mailto:webmaster@gathering.orgSPAM'>webmaster</a>.</p>
<p>Etter at du har logget inn anses all informasjon som strengt konfidensiell og uoffisiell, med mindre annet er beskrevet på <a href="http://www.gathering.org/">gathering.org</a>. Store deler av innholdet er brukergenerert og ikke moderert.</p>
<h4>Nåværende versjon</h4>
<?php if(isset($history['tag'])): ?>
<p>Kjører nåværende versjon <strong><?=$history['tag']?></strong>, utført av <em><?=h($history['author'])?></em> den <?=date("jS F, Y, H:i", strtotime($history['date']))?>.<br />Melding for utførelse:<br /><?=$history['message']?>.</p>
<?php else: ?>
<p>Kjører nåværende revisjon <strong><?=$history['commit']?></strong>, utført av <em><?=h($history['author'])?></em> den <?date("jS F, Y, H:i", strtotime($history['date']))?>.<br />Melding for utførelse:<br /><?=$history['message']?>.</p>
<?php endif; ?>
