<?
class DispatchCase extends AppModel
{
    public $name = 'DispatchCase';

    public function getUndelegated($problem_id=null, $order='priority DESC, created DESC')
    {
        return $this->getByCond($problem_id, 'event_id='.(int)WB::$event->id.' AND delegatedtime IS NULL', $order);
    }

    public function getDelegated($problem_id=null, $order='priority DESC, created DESC')
    {
        return $this->getByCond($problem_id, 'event_id='.(int)WB::$event->id." AND (NOT delegatedtime IS NULL AND NOT delegated_user_id IS NULL AND isresolved=false AND (resolvedtime IS NULL OR resolvedtime='0000-00-00 00:00:00'))", $order);
    }

    public function getUsercases($user_id, $problem_id=null, $order='priority DESC, created DESC')
    {
        $user_id = (int)$user_id;

        return $this->getByCond($problem_id, 'event_id='.(int)WB::$event->id." AND delegated_user_id=$user_id", $order );
    }

    public function getUnresolved($problem_id=null, $order='resolvedtime DESC, created DESC')
    {
        return $this->getByCond($problem_id, 'event_id='.(int)WB::$event->id." AND (NOT resolved_user_id IS NULL AND isresolved=false AND (NOT resolvedtime IS NULL AND NOT resolvedtime='0000-00-00 00:00:00'))", $order);
    }

    public function getResolved($problem_id=null, $order='resolvedtime DESC, created DESC')
    {
        return $this->getByCond($problem_id, 'event_id='.(int)WB::$event->id." AND NOT resolved_user_id IS NULL AND isresolved=true AND (NOT resolvedtime IS NULL AND NOT resolvedtime='0000-00-00 00:00:00')", $order);
    }

    public function setDelegated($case_id, $isDelegated, $user_id=null)
    {
        $case_id = (int)$case_id;
        $user_id = (int)$user_id;
        $update = '';


        if($isDelegated)
        {
            $update = "delegated_user_id=$user_id, delegatedtime=NOW()";
        }
        else
        {
            $update = "delegated_user_id=0, delegatedtime=NULL";
        }

        return $this->query("UPDATE dispatch_cases SET $update WHERE id=$case_id AND event_id=".(int)WB::$event->id);
    }

    public function setResolved($case_id, $resolved, $user_id)
    {
        $case_id = (int)$case_id;
        $user_id = (int)$user_id;
        $resolved = $resolved ? 'true' : 'false';
        $update = '';

        if($user_id)
        {
            $update = "resolved_user_id=$user_id, resolvedtime=NOW(), isresolved=$resolved";
        }
        else
        {
            $update = "resolved_user_id=0, resolvedtime=NULL, isresolved=false";
        }

        $this->query("UPDATE dispatch_cases SET $update WHERE id=$case_id AND event_id=".(int)WB::$event->id);
    }

    /**
     * Returns a list of delegates. TODO: this is too static!!!
     */
    public function getDelegatedNames()
    {
        $usernames = array( 0 => 'Ikke deligert' );
        $users = $this->query( "SELECT User.id, IF(User.nickname IS NULL, User.realname, IF(User.nickname='', User.realname, CONCAT(User.realname, CONCAT(' aka ', User.nickname)))) as fullname FROM wb4_users User, wb4_crews_users uc, wb4_crews Crew WHERE User.id=uc.user_id AND Crew.id=uc.crew_id AND Crew.name='Tech:Support' AND Crew.event_id=".WB::$event->id." AND NOT uc.assigned IS NULL");
        if($users) foreach($users as $user)
        {
            $usernames[$user['User']['id']] = $user[0]['fullname'];
        }

        return $usernames;
    }

    public function getPriorities()
    {
        return array(1 => 'lavest', 2 => 'lav', 3 => 'normal', 4 => html_entity_decode('h&oslash;y'), 5 => html_entity_decode('h&oslash;yest'));
    }

    private function getByCond($problem_id, $cond, $order)
    {
        $cond .= ' AND deleted IS NULL';
        $problem_id = (int)$problem_id;

        if($problem_id)
        {
            $cond .= " AND problem_id=$problem_id";
        }

        return $this->query("SELECT DispatchCase.* FROM wb4_dispatch_cases DispatchCase WHERE $cond ORDER BY $order");
    }

}
?>
