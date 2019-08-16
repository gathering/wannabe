<?
header('Content-Type: text/html; charset=UTF-8');
require("../../db.lib.php");
$db = new Database();
die("nothing to see here");
/*$key   = mysql_escape_string($_REQUEST['key']);
$query = mysql_escape_string($_REQUEST['query']);
if($key == "") {
	$search = $db->query("SELECT u.realname as name, u.nickname as nick, u.id as id, c.name as crew, uc.leader as leader, uc.title as title from wb4_users u, wb4_crews_users uc, wb4_crews c where u.id=uc.user_id and uc.crew_id=c.id and c.event_id=17 and u.nickname like '%".$query."%' limit 1");
	if(!empty($search)) {
		$search = $search[0];
		switch($search['leader']) {
			case "0":
				$title = 'Crew member';
				break;
			case "1":
				$title = 'Shiftleader';
				break;
			case "2":
				$title = 'Co-chief';
				break;
			case "3":
				$title = 'Chief';
				break;
			case "4":
				$title = 'Organizer';
				break;
		}
		if($search['title'] != "") $title = $search['title'];
		$return = $search['id'].": ".$search['name']." aka ".$search['nick'].". ".$title." i ".$search['crew'].".";
	} else {
		$return = "Ingen treff.";
	}
} else {
	$return =  "Bad key.";
}
echo $return;*/
?>
