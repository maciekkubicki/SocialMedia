<?php

		if(isset($_POST["usernamecheck"])){
			include_once("db/connection.php");

            $username = preg_replace('#[^a-z0-9]#i', '', $_POST['usernamecheck']);
            $sql = "SELECT idUsers FROM users WHERE username='$username' LIMIT 1";
		    $query = pg_query($dbconn4, $sql); 
		    $uname_check = pg_fetch_row($query);
		    if (strlen($username) < 3 || strlen($username) > 20) {
			    echo '<strong style="color:#F00;">Nazwa musi mieć 3 - 20 znaków </strong>';
			    exit();
		    }
			if (is_numeric($username[0])) {
			    echo '<strong style="color:#F00;">Nazwa użytkownika musi zaczynać sie od litery.</strong>';
			    exit();
		    }
		    if ($uname_check < 1) {
			    echo '<strong style="color:#009900;">Login "' . $username . '" jest wolny.</strong>';
			    exit();
		    } else {
			    echo '<strong style="color:#F00;">Login "' . $username . ' " jest zajęty.</strong>';
			    exit();
		    }
		    pg_close($dbconn4);
		}



?>