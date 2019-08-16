<?php
/* SQL template for application pages */
class ApplicationPageSqlTemplate {
	var $template = array(
		array(
			'ApplicationPage' => array(
				'name' => "Crewvalg",
				'description' => "Her foretar du dine crewvalg. Som standard er disse i uavhengig rekkefølge, noe som betyr at dine valg blir vurdert uanhengig av foregående valg. Hvis du heller ønsker at alle dine valg skal kunne bli vurdert i prioritert rekkefølge, krysser du av i boksen under. Når du er ferdig, velger du «Neste».",
				'position' => 0,
				'type' => "crewchoice",
				'fields' => array(
				)
			)
		),
		array(
			'ApplicationPage' => array(
				'name' => "Søknadstekst",
				'description' => "Her forteller du oss litt om hvem du er og hva du holder på med.",
				'position' => 1,
				'type' => "crewfield",
				'fields' => array(
					array(
						'application_fieldtype_id' => 1,
						'name' => "Hvem er du?",
						'description' => "Fortell litt om din bakgrunn."
					),
					array(
						'application_fieldtype_id' => 5,
						'name' => "Hvorfor søker du",
						'description' => "Her forteller du litt om hvorfor du søker på de crewene du har valgt og hvilket grunnlag du har for å søke."
					)
				)
			)
		)
	);
}
