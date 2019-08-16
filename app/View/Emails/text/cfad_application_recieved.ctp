Hei, takk for din søknad som CFAD på The Gathering!

Vi har nå mottatt din søknad som CFAD (crew for a day) og vil gå gjennom disse
fortløpende!

Om du lurer på noe, ta kontakt med oss på cfad@gathering.org.
Slik ser din søknad ut:
<? print "\n\n"; ?>
<?
foreach($page as $current) {
	switch ($current['CfadApplicationPage']['type']) {
		case 'crewchoice':
			print $current['CfadApplicationPage']['name']."\n";
			foreach ( $document['CfadApplicationChoice'] as $choice ) {
			  if($choice['crew_id'] == 0) { break; }
              print $crews[$choice['crew_id']];
			  if($choice['denied'] == 1) { print " – denied"; }
			  print "\n";
			}
			print "\n";
			break;
		case 'crewfield':
			foreach ( $document['CfadApplicationField'] as $custom ) {
			  foreach ( $current['CfadApplicationAvailableField'] as $field ) {
			    if($field['ApplicationFieldType']['name'] == 'textarea' && $custom['application_availablefield_id'] == $field['id']) {
			      print $field['name'];
			      print "\n".$custom['value']."\n\n";
			    } else {
			      foreach ( $document['CfadApplicationChoice'] as $fieldchoice ) {
			        if( $fieldchoice['crew_id'] == $custom['crew_id'] ) {
				  if($fieldchoice['denied']) break 2;
				  if($custom['application_availablefield_id'] == $field['id']) {
				    print $field['name'];
				    if($custom['crew_id'] != 0) { print " ".$crews[$custom['crew_id']]."?"; }
				    print "\n".$custom['value']."\n\n";
				  }
			        }
			      }
			    }
			  }
			}
			break;
	}
}
?>
