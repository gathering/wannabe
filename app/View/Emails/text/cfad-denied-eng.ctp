Hei!

<? if($ishandled): ?>
Du mottar denne e-posten fordi din crew for a day-søknad er oppdatert.
Status er nå som følger:

<?
foreach ($document['CfadApplicationChoice'] as $choice): if (!$choice['crew_id']) continue;
    if ($choice['denied']):
                $state = 'Søknad avvist';
    else:
                $state = 'Søknad under behandling';
    endif;

    printf("  %d. valg - %16s - %s\n", $choice['priority']+1, $crews[$choice['crew_id']], $state);
endforeach;
?>

Vi gjør oppmerksom på at du fortsatt kan endre søknaden din. Du kan også søke
deg til alternative crew, forutsatt at andre crew er tilgjengelige. Har du
flere spørsmål til prosessen rundt behandlingen av din søknad, kan du ta
kontakt med crewombudet på adressen cfad@gathering.org.
<? else: ?>
Takk for at du søkte som CFAD for The Gathering. I år har vi dessverre ikke funnet noen
plass til deg, men vi takk for søknaden og håper du søker igjen ved en annen
anledning! Om du lurer på noe, ta kontakt med oss på cfad@gathering.org.

Håper du får en fantastisk påske på The Gathering!
<? endif; ?>
