<?=__('Congratulations')?> <?=$wannabe->user['User']['realname']?>.

<? print $settings['ApplicationSetting']['mailstring']; ?>
<? print "\n\n"; ?>
<?
foreach($page as $current) {
	switch ($current['ApplicationPage']['type']) {
		case 'crewchoice':
			print $current['ApplicationPage']['name']."\n";
			foreach ( $document['ApplicationChoice'] as $choice ) {
			  if($choice['crew_id'] == 0) { break; }
			  if($document['ApplicationDocument']['orderedchoices']) {
			    print (((int)$choice['priority'] + 1).". ");
			  }
              if($document['ApplicationDocument']['applyingopen']):
                print "Åpen søknad";
              else:
                print $crews[$choice['crew_id']];
              endif;
			  if($choice['denied'] == 1) { print " – denied"; }
			  if($choice['waiting'] == 1) { print " – waiting"; }
			  print "\n";
			}
			print "\n";
			break;
		case 'crewfield':
			foreach ( $document['ApplicationField'] as $custom ) {
			  foreach ( $current['ApplicationAvailableField'] as $field ) {
			    if($field['ApplicationFieldType']['name'] == 'textarea' && $custom['application_availablefield_id'] == $field['id']) {
			      print $field['name'];
			      print "\n".$custom['value']."\n\n";
			    } else {	
			      foreach ( $document['ApplicationChoice'] as $fieldchoice ) {
			        if( $fieldchoice['crew_id'] == $custom['crew_id'] ) {
				  if($fieldchoice['denied']) break 2;
				  if($custom['application_availablefield_id'] == $field['id']) {
                    if($document['ApplicationDocument']['applyingopen']):
                      print "Hvorfor søker du med åpen søknad?"; 
                    else:
				      print $field['name'];
				      if($custom['crew_id'] != 0) { print " ".$crews[$custom['crew_id']]."?"; }
                    endif;
				    print "\n".$custom['value']."\n\n";
				  }
			        }
			      }
			    }
			  }
			}
			break;
		case 'crewquestion':
		    foreach ( $document['ApplicationChoice'] as $fieldchoice ) {
				foreach ( $current['ApplicationAvailableField'] as $field ) {
				      if( $fieldchoice['crew_id'] == $field['crew_id']) {
					if($fieldchoice['denied']) break 1;
					foreach($document['ApplicationField'] as $custom) {
					if($custom['application_availablefield_id'] == $field['id']) {
					  print $crews[$custom['crew_id']].": ".$field['name'];
					  print "\n".$custom['value']."\n\n";
					  break;
					}
				      }
				    }
				  }
				}
		break;
	}
}
?>
