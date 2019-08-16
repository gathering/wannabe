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

require("../db.lib.php");
$db = new Database();
die("Nothing to see here");
/*$number = mysql_escape_string($_GET['number']);


if(strlen($number) > 0) {
	$res = $db->queryValue("SELECT u.id FROM wb4_users u, wb4_userphones up, wb4_crews_users uc, wb4_crews c WHERE u.id=uc.user_id AND uc.crew_id=c.id AND c.event_id=11 AND u.id=up.user_id and up.phonetype_id=1 AND REPLACE(up.number, ' ', '') LIKE '%{$number}' LIMIT 1");
}

if(is_numeric($res) == false) {
	//Wrong login, sleep abit to avoid haxxorz
	sleep(1);
	die("false");
} else {
	die("true");
}*/