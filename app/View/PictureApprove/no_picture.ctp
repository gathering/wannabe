 <? foreach ( $crews as $crew ) {
        if(!empty($members[$crew['Crew']['id']])) {
         echo "<h3>".$crew['Crew']['name']."</h3>";
         echo "<ul>";
                    foreach ( $members[$crew['Crew']['id']] as $member ) {
                            echo "<li>".$this->Wb->userLink($member)."</li>";
            }
            echo "</ul>";
         }
}