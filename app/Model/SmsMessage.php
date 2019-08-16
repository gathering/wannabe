<?php

class SmsMessage extends AppModel {

    /*
     * Function from old wannabe, needs cleaning
     */

    public function send($uid, $receivers, $message)
    {
        $failed = array();

        if (!is_array($receivers)) {
            return $this->send($uid, array($receivers), $message);
        }

        foreach ($receivers as $index => $receiver)
        {
            // Strip off dashes and spaces
            $receiver = str_replace(array(' ', '-'), null, $receiver);
            $org2 = $receiver ;

            // Strip off +, keep country code
            if( substr( $receiver, 0, 1 ) == '+' )
            {
                $receiver = substr( $receiver, 1, 2 ).(int)substr( $receiver, 3 );
            }
            // Strip off 00, keep country code
            else if( substr( $receiver, 0, 2 ) == '00' )
            {
                $receiver = (int)substr( $receiver, 2 );
            }
            // Add default country code
            else
            {
                $receiver = '47'.( (int)$receiver );
            }

            // Ignore invalid numbers (country code + at least 5 digits)
            if( strlen( $receiver ) < 7 )
            {
                $failed[] = $receivers[$index];

                unset( $receivers[$index ] );

                continue;
            }

            $receivers[ $index ] = $receiver;
        }

        // Remove duplicates
        $receivers = array_unique( $receivers );

        foreach ($receivers as $receiver) {

            $messageObj = array('SmsMessage' => array(
                'number' => $receiver,
                'message' => $message,
                'sent_by_id' => $uid,
                'event_id' => WB::$event->id
            ));

            if (!$this->save($messageObj)) {
                array_push($failed, $receiver);
            }
            $this->id = null;
        }

        return $failed;
    }

}


?>
