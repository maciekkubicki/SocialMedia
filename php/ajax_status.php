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

    if (isset($_POST["delete"]) && $_POST["id"] != "" ){
    	$id = $_POST["id"];
        $query = pg_query("DELETE FROM status WHERE idstatus=$id;");
	    
        
    	
    	echo "deleted";
    	exit();
    }


?>