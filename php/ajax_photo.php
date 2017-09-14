<?php

/**
 * @author Maciek
 * @copyright 2016
 */



?>

<?php 
$dbconn=pg_connect("host=pascal dbname=u3kubicki user=u3kubicki password=3kubicki"); 
    if(!$dbconn){
        echo "Wystąpił błąd\n";
  		exit();
   	}
    //$user = $_SESSION['username'];

    if (isset($_POST["delete"]) && $_POST["f"] != "" && $_POST["u"]!=""){
    	$filename = $_POST["f"];
        $user=$_POST["u"];
    	$query = pg_query("SELECT idphotos FROM photos WHERE owner='$user' AND filename='$filename' LIMIT 1;");
    	$id = pg_fetch_result($query,0,0);
   		$pic = "../user/$user/$filename"; 
        $query = pg_query("DELETE FROM photos WHERE idphotos=$id;");
	    if (file_exists($picurl)) 
        {
  			unlink($pic);
            
   		}
    	
    	echo "deleted";
    	exit();
    }


?>