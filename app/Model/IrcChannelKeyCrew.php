<?php
/**
 * IrcChannelKeyCrew Model
 *
 */
class IrcChannelKeyCrew extends AppModel {

    /**
     * Delete a crew from a channel
     *
     */
    public function deleteCrew($channel_id, $crew_id) {
        $db = $this->getDataSource();
        return $this->query("DELETE FROM {$db->fullTableName(irc_channel_key_crews)} where irc_channel_key_id={$channel_id} AND crew_id={$crew_id}");
    }
}

?>
