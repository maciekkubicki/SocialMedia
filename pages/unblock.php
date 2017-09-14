<?php

/**
 * @author Maciek 
 * @copyright 2016
 * skrypt odblokowujący zablokowanych.
 */



?>

<?php include_once("php/session_check.php"); ?>


<?php
$dbconn=pg_connect("host=pascal dbname=u3kubicki user=u3kubicki password=3kubicki"); 
if(!$dbconn)
{
	echo "Wystąpił błąd\n";
	exit();
}

pg_query("DELETE FROM blocked WHERE blocker='$username';");

pg_close($dbconn);

header("location: index.php?page=member");