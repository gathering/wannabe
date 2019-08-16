<?php
/* SQL template for application settings */
class ApplicationSettingSqlTemplate {
	var $template = array(
		array(
			'ApplicationSetting' => array(
				'choices' => 3,
				'privacy' => 0,
				'priority' => 1,
				'crewquestion' => 0,
				'deniedtext' => "Vi beklager å måtte meddele at du ikke har blitt tatt opp som crewmedlem. Vi takker for søknaden og ønsker deg velkommen tilbake som crewsøker til neste arrangement! Om du har spørsmål til prosessen rundt behandlingen av din søknad kan du ta kontakt med co [at] gathering.org.",
				'donestring' => "Din søknad er registrert og vil bli behandlet så fort som mulig. Hvis du har noen spørsmål, ikke nøl med å kontakte vår crewombudsman på co [at] gathering.org. Husk at du kan endre din søknad på hvilket som helst tidspunkt, hvis du ønsker det. Når din søknad har blitt behandlet vil du motta en epost som inneholder resultatet. Du vil også motta denne siden på epost øyeblikkelig.",
				'mailsubject' => "Din søknad er mottatt.",
				'mailstring' => "Din søknad er registrert og vil bli behandlet så fort som mulig.\n\nHvis du har noen spørsmål, ikke nøl med å kontakte vårt crewombud på co@gathering.org\n\nHusk at du kan endre din søknad på hvilket som helst tidspunkt, hvis du ønsker det.\n\nNår din søknad har blitt behandlet vil du motta en epost som inneholder resultatet.\n\nSlik ser din søknad ut:"
			)
		)
	);
}
