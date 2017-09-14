<?php
/**
 * @author Maciek
 * @copyright 2015
 */
?>

<?php
    
     
include_once("php/session_check.php");

?>
 <?php 
 
    $coverpic = "";
	$dbconn=pg_connect("host=pascal dbname=u3kubicki user=u3kubicki password=3kubicki");
	if(!$dbconn){
		echo "Wystąpił błąd\n";
		exit();
	}
    $sql = "SELECT filename FROM photos WHERE owner='$username' ORDER BY RANDOM() LIMIT 1";
    $query = pg_query($dbconn, $sql);
    if(pg_num_rows($query) > 0){
    	$filename = pg_fetch_result($query,0,0);
    	$coverpic = '<img src="user/'.$username.'/'.$filename.'" alt="pic" id="top"  >';
    }
    pg_close($dbconn);
?>

 <?php 
 
    
	$dbconn=pg_connect("host=pascal dbname=u3kubicki user=u3kubicki password=3kubicki");
	if(!$dbconn){
		echo "Wystąpił błąd\n";
		exit();
	}
    $sql = "SELECT * FROM ratings WHERE profile='$username'";
    $query = pg_query($dbconn, $sql);
    if(pg_num_rows($query) > 0)
    {
        $infos = array();
	    while($row = pg_fetch_assoc($query)){ 
				$infos[] = $row;
			}
        $sum = 0;
        foreach ( $infos as $info )
        {
            
            switch ($info['mark'])
            {
                case '5':
                    $sum+=5;
                    break;
                case '4':
                    $sum+=4;
                    break;
                case '3':
                    $sum+=3;
                    break;
                case '2':
                    $sum+=2;
                    break;
                case '1':
                    $sum+=1;
                    break;
            }
        }
        $average = $sum/pg_num_rows($query);
        $votes = pg_num_rows($query);
        $rating = "Średnia wynosi = $average z $votes ocen.";//+ 
        //$rating += '$sum/pg_num_rows($query)';///pg_num_rows($query) ;//+ " z " + pg_num_rows($query) + " ocen.";
    	
    }
    else
        $rating = "Profil nie ma jeszcze ocen.";
    pg_close($dbconn);
?>


  <link rel="stylesheet"  property='stylesheet' href="style/style_mem.css">
  <script src="js/ajax.js"></script>
  <script>
           function deletes(id)
        {
            var conf = confirm("Naciśnij OK, aby skasować ten status!");
            if(conf != true){
    		      return false;
            }
            var ajax = ajaxObj("POST", "php/ajax_status.php");
            ajax.onreadystatechange = function() {
            if(ajaxReturn(ajax) == true) {
                    var str=ajax.responseText;
                    if(str !== "" || str !== null){
                        if(str.indexOf("deleted")>-1)
                        {
                            
                            alert("Status został skasowany. Strona jest automatycznie odświeżona.");
                            window.location = "index.php?page=member";
                        }
                        else
                        {
                        alert("Wystąpił problem.");
                        
                        }
    				}
    	        }
            }
            ajax.send("delete=status&id="+id+"");
        }
  </script>

	<?php include_once("template/template_menu.php"); ?>
            <script>document.getElementById("menu1").innerHTML = "<div><a href='index.php?page=logout'>Logout <?php echo $_SESSION['username']; ?></a></div>";</script>
   
	<div id="pageMiddle">
    
    <div id="left">

	<?php
	$dbconn=pg_connect("host=pascal dbname=u3kubicki user=u3kubicki password=3kubicki"); /*połączenie */
	if(!$dbconn){
		echo "Wystąpił błąd\n";
		exit();
	}
			$infos = array(); 
		
			$pseudo = pg_escape_string(htmlentities($_SESSION['username']));
			$query = pg_query("SELECT * FROM users WHERE username = '$username'");

			while($row = pg_fetch_assoc($query)){ 
				$infos[] = $row;
			}
			if(isset($_GET['message']))
			{
				switch($_GET['message'])
				{
					case "success_avatar":
						echo "<div class='success'>Udało się zmienić avatar</div>";
						break;
				}
			}
		      
			foreach ($infos as $info) {  
				?>
                <div id="avatar">
				<a href='index.php?page=avatar'><img src="avatar/<?php echo $info['avatar']; ?>" height='150' width='150' alt='profilowe' title='Edytuj avatar!' ></a>
                </div>
                <div id="gallery" onclick="location.href='index.php?page=gallery&u=<?php echo $username; ?>'"> 
                
                <a href='index.php?page=gallery&u=<?php echo $username; ?>'><img src="images/frame.png"  height='150' width='150' alt='Galeria' title='Otwórz galerie!' id='back' ></a>
                <?php echo $coverpic; ?>
                
                </div>
                <div id="info">
                <p><strong>Imię: </strong><em><?php echo $info['name']; ?></em></p>
                <p><strong>Nazwisko: </strong><em><?php echo $info['surname']; ?></em></p>
				<p><strong>Płeć: </strong><em><?php echo ($info['gender']=='M') ? 'Mężczyzna' : 'Kobieta'; ?></em></p>
                <p><strong>Miasto: </strong><em><?php echo $info['town']; ?></em></p>
                <p><strong>Kraj: </strong><em><?php echo $info['country']; ?></em></p>
                <p><strong>E-mail: </strong><em><?php echo $info['mail']; ?></em></p>
                <p><a href="index.php?page=add_image"><img src="images/add.png" alt="Dodaj zdjęcie" title="Dodaj zdjęcie"></a></p>
                <p><?php echo $rating ?></p>
                </div>
				<?php 	
			}
			

			pg_close($dbconn);
		?>
        </div>
        <div id="right">
        
        
        <p><strong>Opublikuj post:</strong></p>

	<div class='posts'>
		<?php
        
			
			$dbconn=pg_connect("host=pascal dbname=u3kubicki user=u3kubicki password=3kubicki"); 
        	if(!$dbconn){
        		echo "Wystąpił błąd\n";
        		exit();
        	}
                if(isset($_POST['posts'])){
				$posts =pg_escape_string(htmlentities(trim($_POST['posts'])));

				if(empty($posts)){
					?>
						<div class='error'>Post jest pusty.</div>
					<?php
				}
				else{
					$sql = pg_query("INSERT INTO status (owner,description,dating) VALUES ('{$_SESSION['username']}','$posts',now())");
					echo "<div class='success'>Dodano post!</div>";
                    $_POST['posts']=null;
				}

				}	
				pg_close($dbconn);

			
		?>


		<form method='POST' action=''>
			<label form='posts'></label>
			<textarea rows='10' cols='40' name='posts' onfocus="if(this.value==this.defaultValue)this.value=''" onblur="if(this.value=='')this.value=this.defaultValue">Napisz co u Ciebie słychać.</textarea><br/><br/>
			<input type='submit' value='Potwierdź' name='submit'>
		</form>
        </div>
		</div>
		
        <div id="wall">
		<h3>Moje posty:</h3>
        

		<?php

$dbconn=pg_connect("host=pascal dbname=u3kubicki user=u3kubicki password=3kubicki"); 
	if(!$dbconn){
		echo "Wystąpił błąd\n";
		exit();
	}

		
			$posts = array();
			
			$sql = pg_query("SELECT idstatus, description, dating FROM status WHERE owner ='{$_SESSION['username']}' "); 
            $sql2 = pg_query("SELECT gender FROM users WHERE username='{$_SESSION['username']}' ");
            $r=pg_fetch_result($sql2,0,0);
            
            
            $tekst= ($r == 'M') ? 'napisał' : 'napisała';
			while($row = pg_fetch_assoc($sql)){
				$posts[] = $row;
			}  
            $licznik=1;
			if(count($posts)>0){
			     $posts=array_reverse($posts);
				foreach ($posts as $post) { 
				    if($licznik<15){
					?>
						<div class='status'> 
                            <div class="delete" onclick="deletes(<?php echo $post['idstatus'];?>)">x</div>
							<p>
							<?php
								echo $_SESSION['username']; 
								echo " $tekst "; 
								echo date('d.m.Y  ',strtotime($post['dating']));
                                echo 'o ';
                                echo date('H:i:s',strtotime($post['dating']));
								echo " :";
							?>
							</p>
							<p>
							<?php
								echo $post['description'];
                                $licznik++;
							?>
							</p>
						</div>
						<br/><br/>
					<?php
                    }
				}
			}
			else{
				?>
					<div class='error'>Brak wiadomości.</div> 
				<?php
			}
			
			pg_close($dbconn);
	?>
	</div> 
	</div> 
    


	
    <?php include_once("template/template_bottom.php"); ?>
