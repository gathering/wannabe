<?php
/* SQL tempate for Enroll */
class EnrollMailSqlTemplate {
	var $template = array(
		array(
			'EnrollMail' => array(
				'subject' => 'Informasjon fra wannabe',
				'type' => 'denied',
				'fields' => array(
					array(
						'name' => 'Hei!',
						'name_as_header' => 0,
						'content' => "Hei!\n\nCrewsøknaden din til <?=WB::\$event->name?> er nå ferdigbehandlet.\n\nVi beklager å måtte meddele at du ikke har blitt tatt opp som crewmedlem for <?=WB::\$event->name?>. Vi takker for \nsøknaden og \nønsker deg velkommen tilbake som crewsøker til neste arrangement!\n\n<? if(\$denialmessage): ?>\nDu har også mottat en personlig melding:\n<?=\$denialmessage?>\n\n<? endif; ?>\nOm du har spørsmål til prosessen rundt behandlingen av din søknad kan du ta kontakt med crewombudet på adressen co@gathering.org\n\nMed vennlig hilsen\nLedergruppen for <?=WB::\$event->name?>",
						'position' => 0
					)
				)
			)
		),
		array(
			'EnrollMail' => array(
				'subject' => 'Oppdatering fra wannabe',
				'type' => 'pending',
				'fields' => array(
					array(
						'name' => 'Hei!',
						'name_as_header' => 0,
						'content' => "Hei!\n\nDu mottar denne e-posten fordi din status i wannabe er endret.\nDin status er nå som følger:\n\n<?\nforeach (\$document['ApplicationChoice'] as \$choice): if (!\$choice['crew_id']) continue;\n\tif (\$choice['denied']):\n\t\t\$state = 'Søknad avvist';\n\telseif (\$choice['waiting']):\n\t\t\$state = 'Søknad satt på venteliste';\n\telse:\n\t\t\$state = 'Søknad under behandling';\n\tendif;\n\n\tprintf(\"  %d. valg - %16s - %s\n\", \$choice['priority']+1, \$crews[\$choice['crew_id']], \$state);\nendforeach;\n?>\n\n<? if(\$denialmessage): ?>\nDu har også mottat en personlig melding:\n<?=\$denialmessage?>\n\n<? endif; ?>\n\nVi gjør oppmerksom på at du fortsatt kan endre søknaden din. Du kan også søke deg til alternative crew, forutsatt at disse ikke er lukket for opptak. Har du flere spørsmål til prosessen rundt behandlingen av din søknad, kan du ta kontakt med crewombudet på adressen co@gathering.org.\n\nMed vennlig hilsen\nLedergruppen for <?=WB::\$event->name?>",
						'position' => 0
                    )
				)
			)
		),
		array(
			'EnrollMail' => array(
				'subject' => 'Du har blitt satt på venteliste!',
				'type' => 'waiting',
				'fields' => array(
					array(
						'name' => 'Hei!',
						'name_as_header' => 0,
						'content' => "Hei!\n\nDu mottar denne e-posten fordi du har blitt satt på venteliste i et crew.\nDin status er nå som følger:\n\n<?\nforeach (\$document['ApplicationChoice'] as \$choice): if (!\$choice['crew_id']) continue;\n\tif (\$choice['denied']):\n\t\t\$state = 'Søknad avvist';\n\telseif (\$choice['waiting']):\n\t\t\$state = 'Søknad satt på venteliste';\n\telse:\n\t\t\$state = 'Søknad under behandling';\n\tendif;\n\n\tprintf(\"  %d. valg - %16s - %s\n\", \$choice['priority']+1, \$crews[\$choice['crew_id']], \$state);\nendforeach;\n?>\n\n<? if(\$message): ?>\nDu har også mottat en personlig melding:\n<?=\$message?>\n\n<? endif; ?>\n\nVi gjør oppmerksom på at du fortsatt kan endre søknaden din. Du kan også søke deg til alternative crew, forutsatt at disse ikke er lukket for opptak. Har du flere spørsmål til prosessen rundt behandlingen av din søknad, kan du ta kontakt med crewombudet på adressen co@gathering.org.\n\nMed vennlig hilsen\nLedergruppen for <?=WB::\$event->name?>",
						'position' => 0
                    )
				)
			)
		),
		array(
			'EnrollMail' => array(
				'subject' => 'Velkommen i crew!',
				'type' => 'accepted',
				'fields' => array(
					array(
						'name' => 'Hei!',
						'name_as_header' => 0,
						'content' => "Hei!\n\nVi har med dette gleden av å informere om at du har blitt tatt opp som crewmedlem i <?=\$crews[\$crew_id]?>.\n\nDersom du er logget inn i Wannabe fra før, må du logge ut og inn igjen for å få tilgang.\n\nDin chief:		<?=(\$chief?\$chief:'ingen').\"\\n\"?>\n<? if(\$chief) { ?>\nE-post:		   <?=\$leaders['Chief']['User']['email'].\"\\n\"?>\nTelefon:		  <?=\$leaders['Chief']['Phone']['number'].\"\\n\"?>\n<? } ?>\n\nDin organizer:	<?=(\$organizer?\$organizer:'ingen').\"\\n\"?>\n<? if(\$organizer) { ?>\nE-post:		   <?=\$leaders['Organizer']['User']['email'].\"\\n\"?>\nTelefon:		  <?=\$leaders['Organizer']['Phone']['number'].\"\\n\"?>\n<? } ?>\n\nInnholdet i denne e-posten:\n\n Diverse\n Crewombudet\n Kort om organisering av crew\n Informasjon fra chief\n Informasjon fra organizer\n E-postlister\n IRC\n Veien videre",
						'position' => 0
					),
					array(
						'name' => 'Diverse',
						'name_as_header' => 1,
						'content' => "Oppmøtet for crew er tirsdag i påskeuka for de fleste crew, tidspunkt kommer senere.\n\nDenne e-posten inneholder mye viktig informasjon, sørg for å les gjennom hele.",
						'position' => 1
					),
					array(
						'name' => 'Crewombudet',
						'name_as_header' => 1,
						'content' => "Hei, og velkommen som crewmedlem for TG13!\n\nMitt navn er Pia Fiskaa Vestby, og fjorårets TG-crew har valgt meg som crewombud. Jobben min er å være der for nettopp deg og å være din og resten av crew sin stemme i ledergruppa.\n\nKort oppsummert går jobben min ut på å gjøre TG13 til en god opplevelse for deg. Jeg er den du komme til om det skulle være noe som helst, ingen sak for liten eller ingen sak for stor. Du kan prate med meg om du er uenig med chiefen din, om katten din døde forrige uke, om du føler deg usynlig i crewet ditt, om du er forelska i hun i Info:Graphics og ikke helt vet hva du skal gjøre med det eller om du bare har lyst til å preike shit.\n\nMed meg på laget har jeg i år Bjørn Erik Gundelsby som assistent, og han vil på lik linje med meg kunne kontaktes om det skulle være noe som helst.\n\nBåde Bjørn Erik og jeg har selvfølgelig taushetsplikt, og denne gjelder ikke kun under TG, men også for all tid etterpå. Du kan derfor stole på at det du forteller oss ikke kommer videre, med mindre du selv ønsker at vi f.eks skal snakke med chiefen din.\n\nJeg gleder meg noe enormt til å treffe deg i påsken, og håper at du får et helt kanonbra TG!\n\nOm du skulle ha spørsmål eller om det er noe du vil ta opp, er jeg alltid tilgjengelig for en prat. Kontaktinformasjon finner du under.\n\n\nKlem fra Pia\n\nPia Fiskaa Vestby\nIRC: Advena\nco@gathering.org\n99 62 36 87",
						'position' => 2
					),
					array(
						'name' => 'Kort om organisering av crewet',
						'name_as_header' => 1,
						'content' => "Crew består av fem ulike seksjoner: Core, Event, Info, Security og Tech.\n\nHver av disse seksjonene ledes av en organizer. I tillegg er det to ombud, ett for deltakerne og ett for crew. Til sammen er disse syv personene ledergruppa for The Gathering og kan kontaktes via <?=WB::\$event->reference?>organizers@gathering.org.\n\nHver organizer har med seg en eller flere mellomledere (cheif) som leder enkeltcrew, som for eksempel Core:Logistics og Info:Desk. I tillegg har enkelte crew skiftledere som tar seg av styringen til enkelte tider av døgnet, eller spesialområder innad i ett crew. \n\nTil slutt kommer medlemmene som utgjør størsteparten av crew. Selv om det høres ut som  medlemmene er lavest på rangstigen, må det sies at TG garantert ikke hadde vært til uten disse. Vi er avhengig av alle for å arrangere The Gathering hvert år :-)",
						'position' => 3
					),
					array(
						'name' => 'Greetings',
						'name_as_header' => 0,
						'content' => "<? if(isset(\$leaders['Chief']['EnrollGreeting']) && (!isset(\$leaders['Organizer']['EnrollGreeting']) || (\$leaders['Chief']['EnrollGreeting']['message'] != \$leaders['Organizer']['EnrollGreeting']['message']))): ?>\n=== Hilsen fra chief ===\n\n<?=\$leaders['Chief']['EnrollGreeting']['message'].\"\\n\"?>\n\n<? endif; ?>\n<? if(isset(\$leaders['Organizer']['EnrollGreeting'])): ?>\n=== Hilsen fra organizer ===\n\n<?=\$leaders['Organizer']['EnrollGreeting']['message'].\"\\n\"?>\n\n<? endif; ?>",
						'position' => 4
					),
					array(
						'name' => 'E-postlister',
						'name_as_header' => 1,
						'content' => "<? \nif(preg_match('/:/', \$crews[\$crew_id])) {\nlist(\$supercrewname, \$crewname) = explode(':', strtolower(\$crews[\$crew_id]));\n} else {\n\$supercrewname = false;\n\$crewname =  \$crews[\$crew_id];\n}\n?>\nNår du nå har blitt tatt opp i crew, blir du automatisk påmeldt følgende e-postlister som blir brukt til å spre informasjon og diskutere ting innad i crew.\n\n  <?=WB::\$event->reference?>crew-announce@gathering.org\n   Obligatorisk medlemsskap, her kommer ALL viktig info.\n   Denne listen er moderert.\n\n  <?=WB::\$event->reference?>crew@gathering.org\n   Frivillig diskusjonsliste for crew. Denne listen kan du melde deg av\n   i wannabe under «ditt nick» -> E-poslister, hvis du ikke ønsker \n   å delta i diskusjonene.\n   Denne listen er ikke moderert.\n\n<? if(!\$supercrewname) { ?>\n  <?=WB::\$event->reference?><?=strtolower(\$crewname)?>@gathering.org\n   Diskusjonsliste innad i ditt eget crew.\n<? } else { ?>\n  <?=WB::\$event->reference?><?=\$supercrewname?>@gathering.org\n   Diskusjonsliste for din hovedseksjon på <?=WB::\$event->name?>.\n\n  <?=WB::\$event->reference?><?=\$supercrewname?>-<?=\$crewname?>@gathering.org\n   Diskusjonsliste innad i ditt eget crew.\n<? } ?>\n\nEnkelte av listene genererer en del trafikk. Vi anbefaler at du benytter deg av filtreringsfunksjonen i din e-postklient, så du ikke blir oversvømt. For å unngå filtreringsproblemer som oppstår når enkelte sender e-post til flere lister samtidig, anbefaler vi at du sorterer TG-e-post etter e-posthodet «List-id».\n\nE-postlistene har opptil 300 brukere. Vi har enkle regler du må følge når du skriver til listene:\nhttp://antibiomatika.net/usenet/quoting.html\n\nKort oppsummert: \n svar under det du svarer på, fjern alt du ikke svarer på\n bruk > som indenteringstegn på det du svarer på \n\nAlle e-postlesere har muligheten til et slikt oppsett. Hvis du har problemer anbefaler vi Mozilla Thunderbird som e-postklient. Den kan du hente gratis fra http://www.mozilla.com/thunderbird/\n\nVi vil også nevne at e-postlistene skal brukes til samarbeid og intern kommunikasjon. Det er derfor viktig å holde en god tone på e-postlistene :-)",
						'position' => 5
					),
					array(
						'name' => 'IRC',
						'name_as_header' => 1,
						'content' => "Hvis du ikke er tilhenger av e-post, eller ønsker mindre formell kontakt med andre medlemmer, har vi en IRC-kanal. \nDenne ligger på EFNet (f.eks irc.homelien.no) og heter #tg-crew. Her har vi satt en tilgangsnøkkel som du må taste inn for å komme inn: \n/join #tg-crew «nøkkel»\nVi ber om at du legger denne kommandoen inn i perform eller lignende i IRC-klienten din slik at nøkkelen ikke kommer på avveie. \nSelve nøkkelen finner du ved å logge inn på din side i Wannabe.\n\nVi minner om at både e-postlistene og ting som dukker opp på IRC-kanalene er kun for medlemmer og må ikke spres til utenforstående.",
						'position' => 6
					),
					array(
						'name' => 'Veien videre',
						'name_as_header' => 1,
						'content' => "Framover vil fokuset være planleggingen av arrangementet. \nEn del crew har en stor jobb i forkant, andre har lite eller ingenting å gjøre før arrangementet. \nDet er ingenting i veien for å spørre om hva andre driver med  og det er absolutt ingenting i veien for at man engasjerer seg på andre områder enn sitt eget, hvis man ønsker å bidra før arrangementet går av stabelen :-)\n\nFram mot TG vil du motta opptil flere informasjons-e-poster fra chief, organizer og crewombud. Det er derfor viktig at du sjekker e-post.\n\nHvis du lurer på noe så kan du spørre din chief. \nDu kan alltids spørre på IRC eller via e-postlistene, men det er chief, organizer eller crewombud som har myndighet til å godkjenne forespørsler som tidlig oppmøte, tidlig avreise, tilrettelegging eller lignende.\n\nSom medlem kan du komme bort i vanskelige situasjoner. Det kan være alt fra personlige problemer, til at din chief ikke tar deg på alvor. Hvis du ønsker hjelp med å løse slike situasjoner, kan du ta kontakt med crewombudet på crewombud@gathering.org.\n\nTil slutt vil vi igjen ønske deg velkommen i crew! :-)\n\nMed vennlig hilsen\nLedergruppen for <?=WB::\$event->name?>",
						'position' => 7
					)
				)
			)
		)
	);
}
