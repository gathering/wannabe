<users>
<?php if($users) foreach($users as $user) { ?>
    <?=$this->element('legacy_api_user', array('user' => $user, 'crewnames' => $crewnames, 'teamnames' => $teamnames))?> 
<?php } ?>
</users>
