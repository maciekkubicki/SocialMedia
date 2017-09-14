<?php
/**
 * @author Maciek
 * @copyright 2015
 * Podstrna na której można edytować ustawienia konta.
 */
?>

<?php
    
     
include_once("php/session_check.php");

?>

      <link rel="stylesheet"  property="stylesheet" href="style/style_upload.css">

	<?php include_once("template/template_menu.php"); ?>
            <script>_("menu1").innerHTML = "<div><a href='index.php?page=logout'>Logout <?php echo $_SESSION['username']; ?></a></div>";</script>	

    <div id="pageMiddle">
    
    <?php 
        if(isset($_POST['submit']))
        {
            $dbconn=pg_connect("host=pascal dbname=u3kubicki user=u3kubicki password=3kubicki"); /
            if(!$dbconn){
		          echo "Wystąpił błąd\n";
		          exit();
            } 
            $e = $_POST['email'];  
            $t = $_POST['town'];
            $s = $_POST['surname'];
            $n = $_POST['name'];
            
            $query = pg_query("UPDATE users SET mail='$e', town='$t', surname='$s', name='$n' WHERE username='{$_SESSION['username']}'") or die (pg_result_error());
            echo $query;  
            pg_close($dbconn);      
        }
    ?>

	<h4>Zmiana danych:</h4>

	<?php 
        $dbconn=pg_connect("host=pascal dbname=u3kubicki user=u3kubicki password=3kubicki"); 
        if(!$dbconn)
        {
		  echo "Wystąpił błąd\n";
		  exit();
        }

		$infos = array(); 
		$username = $_SESSION['username'];
		$query = pg_query("SELECT * FROM users WHERE username = '$username'");

		while($row = pg_fetch_assoc($query)){ 
			$infos[] = $row;
		}

		foreach($infos as $info){
		?>
			<form method='POST' action=''>
				
				<label for='email'>E-mail: </label>
				<input type='text' name='email' value='<?php echo $info['mail']; ?>'><br/><br/>
                <label for='name'>Imię: </label>
				<input type='text' name='name' value='<?php echo $info['name']; ?>'><br/><br/>
                <label for='surname'>Nazwisko: </label>
				<input type='text' name='surname' value='<?php echo $info['surname']; ?>'><br/><br/>
                <label for='town'>Miasto: </label>
				<input type='text' name='town' value='<?php echo $info['town']; ?>'><br/><br/>
                <div><a href="index.php?page=unblock">Odblokuj wszystkich zablokowanych.</a></div>
				<div><a href="index.php?page=avatar">Zmień zdjęcie profilowe.</a></div>
				<input type='submit' value='Potwierdź' name='submit'>
			</form>
		<?php
		}
		pg_close($dbconn);
        ?></div>
     <?php include_once("template/template_bottom.php"); ?>
