<?php

	session_start();
		if(isset($_SESSION["username"])){
			header("location: message.php?msg=NO to that weenis");
		    exit();
		}


?>