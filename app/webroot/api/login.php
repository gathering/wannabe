<?php

/*
	Authentication script that can be used for authentication over
	HTTP against wannabe.

	Usage:
	/api/login.php?[username=string|&password=string|&e-mail=string|&hash=string]

	(Password)hash can be:
		-nothing
		-md5

	returns true/false

	Author: Tor Henning Ueland
	Created: 22 nov 2009
*/

require("db.lib.php");
$db = new Database();

$email    = mysql_escape_string($_REQUEST['e-mail']);
$username = mysql_escape_string($_REQUEST['username']);
$password = mysql_escape_string($_REQUEST['password']);
$showUserId = mysql_escape_string($_REQUEST['showUserId']);
$hashType = $_REQUEST['hash'];
$isCrewInEvent = mysql_escape_string($_REQUEST['isCrewInEvent']);


//Hash the password
switch($hashType) {
	case 'md5':
	//Do nothing, we can use it with MySQL
	break;

	//Since its not hashed, hash it to md5
	default:
	$password = md5($password);
}

if(strlen($email) > 0) {
	if($isCrewInEvent) {
		$res = $db->queryValue("SELECT u.id FROM wb4_users u, wb4_crews c, wb4_crews_users uc, wb4_events e 
					WHERE u.email='{$email}' AND u.password='{$password}' AND u.id = uc.user_id 
					AND uc.crew_id = c.id AND c.event_id=e.id AND e.reference='{$isCrewInEvent}' LIMIT 1");
	} else {
		$res = $db->queryValue("SELECT id FROM wb4_users WHERE email='{$email}' AND password='{$password}' LIMIT 1");
	}
} else {
	if($isCrewInEvent) {
		$res = $db->queryValue("SELECT u.id FROM wb4_users u, wb4_crews c, wb4_crews_users uc, wb4_events e
                                        WHERE u.username='{$username}' AND u.password='{$password}' AND u.id = uc.user_id
                                        AND uc.crew_id = c.id AND c.event_id=e.id AND e.reference='{$isCrewInEvent}' LIMIT 1");
	} else {
		$res = $db->queryValue("SELECT id FROM wb4_users WHERE username='{$username}' AND password='{$password}' LIMIT 1");
	}
}

if(is_numeric($res) == false) {
	//Wrong login, sleep abit to avoid haxxorz
	sleep(1);
	die("false");
} else {
	if($showUserId) {
		die($res);
	} else {
		die("true");
	}
}
