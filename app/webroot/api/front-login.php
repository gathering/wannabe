<?php

/*
	Authentication script for LiveFront

	Author: Tor Henning Ueland & Roy Viggo Larsen
	Created: 21 jan 2012
*/

require("db.lib.php");
$db = new Database();

$username = mysql_escape_string($_REQUEST['username']);
$password = mysql_escape_string($_REQUEST['password']);

if($_REQUEST['apikey'] == '13789m8m928ym9g7873xy953ym') {
    $res = $db->query("SELECT id,realname,image,nickname FROM wb4_users WHERE username='{$username}' AND password='{$password}' LIMIT 1");

    if(!isset($res[0]['id'])) {
        //Wrong login, sleep abit to avoid haxxorz
        sleep(1);
        die('{"error":"wrong"}');
    } else {
        die(json_encode($res));
    }
} else {
    die('{"error":"api"}');
}
