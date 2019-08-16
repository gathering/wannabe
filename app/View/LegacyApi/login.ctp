<?php
if($user && $session) { 
    ?><sessionkey><?=$session['ApiSession']['sessionkey']?></sessionkey>
    <?=$this->element('legacy_api_user', array('user' => $user, 'crewnames' => $crewnames, 'teamnames' => $teamnames, 'userroles' => $userroles))?><? 
} ?>
