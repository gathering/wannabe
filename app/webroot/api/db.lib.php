<?php

/*
	Just a simple database library

	Author: Tor Henning Ueland	
*/

//Load needed database info
require("/srv/vhosts/wannabe.gathering.org/wannabe/app/webroot/api/database.php");

class Database {

        var $link;

        function __construct() {
		$dbInfo = new DATABASE_CONFIG();$dbInfo = new DATABASE_CONFIG();
                $this->link = mysql_pconnect($dbInfo->default['host'], $dbInfo->default['login'], $dbInfo->default['password'])
                        or die("");

                mysql_select_db($dbInfo->default['database'])
                        or die("");

                $this->query("SET NAMES 'utf8'");
                $this->query("SET CHARACTER SET 'utf8'");
        }

        function query($sql) {
                //echo "\n\n{$sql}\n\n";
                $result = mysql_query($sql);
                $rows = array();
                if( substr($sql, 0,6) == "SELECT") {
                        while($r = @mysql_fetch_array($result)) {
                                $rows[] = $r;
                        }
                }
                if(mysql_error()) {
                        //die(mysql_error());
                }
                //echo "Q: {$sql}.\n";
                return $rows;
        }

        function queryRow($sql) {
                $tmp = $this->query($sql);
                if(is_array($tmp) && isset($tmp[0]))
                        return $tmp[0];
                else
                        return null;
        }

        function queryValue($sql) {
                $tmp = $this->queryRow($sql);
                return $tmp[0];
        }
}
