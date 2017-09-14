<?php
/**
 * @author Maciek
 * @copyright 2015
 */
?>

	<?php 
		if(isset($_POST['submit'])){
				$dbconn=pg_connect("host=pascal dbname=u3kubicki user=u3kubicki password=3kubicki"); /*połączenie */
        if(!$dbconn)
        {
		      echo "Wystąpił błąd\n";
		      exit();
	   }
  			
  			$username = pg_escape_string(htmlentities($_POST['usr']));
			$password = pg_escape_string(htmlentities($_POST['password']));
			$password = md5($password);
			
 			error_reporting(E_ALL);
			ini_set('display_errors', 1);
			

			// formularz logowania
			if(empty($_POST['usr'])){  
				$errors[] = "Proszę wpisać login.";
			}
			if(empty($_POST['password'])){
				$errors[] = "Proszę wpisać hasło.";
			}
 
			if(!empty($errors)){
				foreach ($errors as $error) {
					echo "<div class='error'>".$error."</div>";
				}
			}// sprawdzenie z baza danych czy haslo i login istnieją bądź są prawidłowe
			else{
				$query = pg_query("SELECT username, password FROM users WHERE username='$username' AND password='$password'");
				$rows = pg_num_rows($query);
				if($rows < 1){
					echo "<div class='error'>Login lub hasło nieprawidłowe.</div>";
				}
				else{echo 'OK';
					$_SESSION['username'] = $username;
					header("Location:index.php?page=member");
				}
			}
			pg_close($dbconn);
		}
	?> 

<meta charset="UTF-8">
<title>Twarzoksiazka</title>

<link rel="stylesheet" property="stylesheet" href="style/style.css">

<?php include_once("template/template_top.php"); ?>

<div id="pageMiddle">
    <div id="left">
        <div id="Opis">
            <div id="welcome"><h4>Witamy na poratlu Twarzoksiążka!</h4></div>
            <span>Twarzoksiążka pomaga kontaktować się z innymi osobami z całego świata oraz udostępniać im różne informacje i materiały. Jeśli nie masz jeszcze konta dołącz do kilkuset szczęśliwych użytkowników i załóż je za darmo teraz.
            </span>
        </div>
        <div id="im"><img src="images/pep.png"></img></div>
    </div>
    <div id="right">
        <div id="opis">
            <h4>Jeśli posiadasz konto zaloguj się teraz!</h4>
        </div>
        <div id="logform">
       	<form method="POST" action="">
    		<div>Username:</div>
    		<input type="text" name="usr"><br/>
    		<div>Password:</div>
    		<input type="password" name="password"><br/><br/>
    		<input type="submit" value="Zaloguj!" name="submit"><br/>
        </form>
        <div id="status"></div>

	   <a href='index.php?page=register'>Powrót na stronę rejestracji</a>
        </div>
        
    </div>
</div>
<?php include_once("template/template_bottom.php"); ?>
