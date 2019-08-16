<?php

	class SleepingPlaces extends AppModel {

        public function updateStatus($section, $status) {
            $db = $this->getDataSource();

            $db->query("UPDATE
                            {$db->fullTableName('sleeping_places')}
                        SET
                            {$db->fullTableName('sleeping_places')}.status
                        =
                            '{$status}'
                        WHERE
                            {$db->fullTableName('sleeping_places')}.section
                        =
                            '{$section}'");
        }

	}

?>
