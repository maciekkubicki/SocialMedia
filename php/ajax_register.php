<?php

if(isset($_POST["u"])){
	
	include_once("db/connection.php");
	
	$u = preg_replace('#[^a-z0-9]#i', '', $_POST['u']);
	$e = pg_escape_string($dbconn4, $_POST['e']);
	$p = $_POST['p'];
	$g =$_POST['g'];
	$c = preg_replace('#[^a-z ]#i', '', $_POST['c']);
    $t = preg_replace('#[^a-z]#i','', $_POST['t']);
    $s = preg_replace('#[^a-z]#i','', $_POST['s']);
    $n = preg_replace('#[^a-z]#i','', $_POST['n']);
    $avatar = ($g=='M') ? 'default.jpg' : 'defaultw.jpg';
	
    $ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));
	
	$sql = "SELECT idUsers FROM users WHERE username='$u' LIMIT 1";
    $query = pg_query($dbconn4, $sql); 
	$u_check = pg_num_rows($query);
	
	$sql = "SELECT idUsers FROM users WHERE mail='$e' LIMIT 1";
    $query = pg_query($dbconn4, $sql); 
	$e_check = pg_num_rows($query);
	
	if($u == "" || $e == "" || $p == "" || $g == "" || $c == ""){
		echo "Nie wype³ni³eœ wszystkich wymaganych pól.";
        exit();
	} else if ($u_check > 0){ 
        echo "Nazwa u¿ytkownika jest zajêta.";
        exit();
	} else if ($e_check > 0){ 
        echo "Adres e-mail jest zajêty!";
        exit();
	} else if (strlen($u) < 3 || strlen($u) > 20) {
        echo "Nazwa u¿ytkownika powinna mieæ od 3 do 20 znaków.";
        exit(); 
    } else if (is_numeric($u[0])) {
        echo 'Nazwa u¿ytkownika nie mo¿e zaczynaæ siê od cyfry';
        exit();
    } else {


		$p_hash = MD5($p);
		
		$sql = "INSERT INTO users (username,password,mail,Name,Surname,town,gender,country,date,ip,avatar)       
		        VALUES('$u','$p_hash','$e','$n','$s','$t','$g','$c',now(),'$ip','$avatar')";
		$query = pg_query($dbconn4, $sql); 
       
		if (!file_exists("user/$u")) {
			mkdir("user/$u", 0777, true);
		}

        
        

        
		echo 'done';
		exit();
        
	}
    pg_close($dbconn4);
	
}

?>