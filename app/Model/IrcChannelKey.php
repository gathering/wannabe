<?php
/**
 * IrcChannelKey Model
 *
 */
class IrcChannelKey extends AppModel {
    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'channelname';

    public $hasMany = array(
        'IrcChannelKeyCrew' => array(
            'className'     => 'IrcChannelKeyCrew',
            'foreignKey'    => 'irc_channel_key_id',
            'dependent'     => true
        )
    );

    /**
     * Validation rules
     *
     * @var array
     */
    public function beforeValidate() {
        $this->validate = array(
            'event_id' => array(
                'notempty' => array(
                    'rule' => array('notBlank'),
                    'message' => __("Cannot be empty")
                ),
            ),
            'channelname' => array(
                'notempty' => array(
                    'rule' => array('notBlank'),
                    'message' => __("Cannot be empty")
                ),
                'maxlength' => array(
                    'rule' => array('maxlength', 30),
                    'message' => __("Max length is 30")
                ),
                'unique' => array(
                    'rule' => array('isEventUnique'),
                    'message' => __('A channel with that name already exists.')
                )
            ),
        );
     }

    public function getAvailableChannels($user) {

        $db = $this->getDataSource();
        $crew_ids = array();

        foreach($user['Crew'] as $crew) {
            array_push($crew_ids, $crew['id']);
        }

        $keys = $this->query("
                        SELECT
                            IrcChannelKey.channelname,
                            IrcChannelKey.channelkey
                        FROM
                            {$db->fullTableName('irc_channel_keys')} IrcChannelKey
                        WHERE
                            IrcChannelKey.event_id=" . WB::$event->id . "
                        AND
                            IrcChannelKey.channelname
                        IN (
                            SELECT
                                ick.channelname
                            FROM
                                {$db->fullTableName('irc_channel_key_crews')} ickc,
                                {$db->fullTableName('irc_channel_keys')} ick
                            WHERE
                                ickc.crew_id IN (
                                    " . join(',', $crew_ids) . "
                                )
                            AND
                                ickc.irc_channel_key_id = ick.id
                            AND
                                ick.event_id=" . WB::$event->id . "
                            )
                        UNION SELECT
                            IrcChannelKey.channelname, IrcChannelKey.channelkey
                        FROM
                            {$db->fullTableName('irc_channel_keys')} IrcChannelKey
                        WHERE
                            IrcChannelKey.event_id=" . WB::$event->id . "
                        AND
                            IrcChannelKey.id NOT IN (
                            SELECT
                                ickc.irc_channel_key_id
                            FROM
                                {$db->fullTableName('irc_channel_key_crews')} ickc,
                                {$db->fullTableName('irc_channel_keys')} ick
                            WHERE
                                ickc.irc_channel_key_id = ick.id
                            AND
                                ick.event_id=" . WB::$event->id . "
                        )
                    ");
        return $keys;
    }
}

?>
