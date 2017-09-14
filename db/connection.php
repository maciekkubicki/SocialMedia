<?php

/**
 * @author 
 * @copyright 2015
 */
//echo "<h3> start </h3>";
ini_set('display_errors', 1);
error_reporting(E_ALL);
$conn_string = "dbname=u3kubicki user=u3kubicki password=3kubicki";
$dbconn4 = pg_connect($conn_string) or die("problem");
$stat=pg_connection_status($dbconn4);
//if ($stat === PGSQL_CONNECTION_OK)
//        echo "<h3>connection ok</h3>";
//else
//    echo "<h3>no ok</h3>";

?>