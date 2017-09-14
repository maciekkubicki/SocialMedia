<?php
/**
 * @author Maciek
 * @copyright 2015
 * Podstron reprezentująca profil innych użytkowników.
 */
?>

<?php 
    if(isset($_SESSION['username']))
        if(isset($_GET['u']))
        {
            $user = preg_replace('#[^a-z0-9]#i', '', $_GET['u']);
            $username = $_SESSION['username'];
            if($user == $_SESSION['username'])
                header("location: index.php?page=member");
        }
        else
        {
            header("location: index.php?page=member");
            exit();
        }
    else
    {
        header("location: index.php?page=notloggedin");
        exit();
    }

?>

 <?php 
    $canIrate = false;
 
    
	$dbconn=pg_connect("host=pascal dbname=u3kubicki user=u3kubicki password=3kubicki");
	if(!$dbconn){
		echo "Wystąpił błąd\n";
		exit();
	}
    $sql = "SELECT * FROM ratings WHERE profile='$user'";
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
        $rating = "Średnia wynosi = $average z $votes ocen.";
    	
    }
    else
        $rating = "Profil nie ma jeszcze ocen.";
        
    $sql = "SELECT * FROM ratings WHERE profile='$user' AND rater='$username'";
    $query = pg_query($dbconn, $sql);
    if(pg_num_rows($query) == 0)
        $canIrate = true;
    pg_close($dbconn);
?>



 <?php 
    $coverpic = "";
	$dbconn=pg_connect("host=pascal dbname=u3kubicki user=u3kubicki password=3kubicki"); 
	if(!$dbconn){
		echo "Wystąpił błąd\n";
		exit();
	}
    $sql = "SELECT filename FROM photos WHERE owner='$user' ORDER BY RANDOM() LIMIT 1";
    $query = pg_query($dbconn, $sql);
    if(pg_num_rows($query) > 0){
    	$filename = pg_fetch_result($query,0,0);
    	$coverpic = '<img src="user/'.$user.'/'.$filename.'" alt="pic" id="top"  >';
    }
    
    $notBlocked = true;
    
    $query = pg_query("SELECT * FROM blocked WHERE blocker='$user' AND blocked='$username';");
    $query2 = pg_query("SELECT * FROM blocked WHERE blocker='$username' AND blocked='$user';");
    if(pg_num_rows($query)>0)
    {
        pg_close($dbconn);
        header("location: index.php?page=blocked&u=$user");
        
    }
    
    if(pg_num_rows($query2)>0)
    {
       $notBlocked = false;
        
    }
    pg_close($dbconn);
?>


<?php 

$isFriend = false; //czy to przyjaciel
$isSent = false;   //czy zaproszenie jest wysłane
$isItMe = false;    // czy to ja wysłałem zapro
$dbconn=pg_connect("host=pascal dbname=u3kubicki user=u3kubicki password=3kubicki"); 
if(!$dbconn)
{
	echo "Wystąpił błąd\n";
	exit();
}

$sql = pg_query("select isaccepted, user1 from friends where (user1='$user' and user2='$username') or (user1='$username' and user2='$user') limit 1;");
$l = pg_num_rows($sql);
if($l > 0)
{
    $r = pg_fetch_result($sql,0,0);
    $us = pg_fetch_result($sql,0,1);

    $isFriend = ($r == 1) ? true : false ;
    $isSent = true;
    $isItMe = ($us == $username) ? true : false;
}
pg_close($dbconn);
?>

  <link rel="stylesheet" property="stylesheet" href="style/style_mem.css">


	<?php include_once("template/template_menu.php"); ?>
            <script>document.getElementById("menu1").innerHTML = "<div><a href='index.php?page=logout'>Logout <?php echo $_SESSION['username']; ?></a></div>";</script>
   
	<div id="pageMiddle">
    
    <div id="left">
    <!--<p>
    Hello <?php
            $pseudo = $user;
            echo $pseudo;
            ?></p>-->
	<?php
	$dbconn=pg_connect("host=pascal dbname=u3kubicki user=u3kubicki password=3kubicki"); 
	if(!$dbconn)
    {
		echo "Wystąpił błąd\n";
		exit();
	}
			$infos = array();  
			$query = pg_query("SELECT * FROM users WHERE username = '$user'");

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
			 // wyswietlanie informacji biezacego uzytkownika
			foreach ($infos as $info) {  
				?>
				                <div id="avatar">
				<a href='index.php?page=avatar'><img src="avatar/<?php echo $info['avatar']; ?>" height='150' width='150' alt='profilowe' title='Edytuj avatar!' ></a>
                </div>
                <div id="gallery"> 
                
                <a href='index.php?page=gallery&u=<?php echo $user; ?>'><img src="images/frame.png"  height='150' width='150' alt='Galeria' title='Otwórz galerie!' id='back' ></a>
                <?php echo $coverpic; ?>
                
                </div>
                <div id="info">
                <p><strong>Imię: </strong><em><?php echo $info['name']; ?></em></p>
                <p><strong>Nazwisko: </strong><em><?php echo $info['surname']; ?></em></p>
				<p><strong>Płeć: </strong><em><?php echo ($info['gender']=='M') ? 'Mężczyzna' : 'Kobieta'; ?></em></p>
                <p><strong>Miasto: </strong><em><?php echo $info['town']; ?></em></p>
                <p><strong>Kraj: </strong><em><?php echo $info['country']; ?></em></p>
                <p><strong>E-mail: </strong><em><?php echo $info['mail']; ?></em></p>
                <p><?php echo $rating ?></p>
                <p><?php if(!$canIrate) echo 'Oddałeś już głos'; else { ?>
                <a href='index.php?page=rate&u=<?php echo $user?>&mark=<?php echo '1';?>'><img src="images/s1.png" ></a>
                <a href='index.php?page=rate&u=<?php echo $user?>&mark=<?php echo '2';?>'><img src="images/s2.png" ></a>
                <a href='index.php?page=rate&u=<?php echo $user?>&mark=<?php echo '3';?>'><img src="images/s3.png" ></a>
                <a href='index.php?page=rate&u=<?php echo $user?>&mark=<?php echo '4';?>'><img src="images/s4.png" ></a>
                <a href='index.php?page=rate&u=<?php echo $user?>&mark=<?php echo '5';?>'><img src="images/s5.png" ></a>
                <?php } ?>
                
                
                </p>
                </div>
                
				<?php 	
			}
			

			pg_close($dbconn);
		?>
        </div>
        <div id="right">
        <?php if($isFriend){ ?>
                <p><h2>To Twój znajomy!</h2></p>   
        <?php } else if(!$isFriend && !$isSent){ ?>
                <a href='index.php?page=send_invitation&u=<?php echo $user?>'><img src="images/add2.png" ></a>
        <?php } else if (!$isFriend && $isSent && !$isItMe ){ ?>
                <a href='index.php?page=accept&u=<?php echo $user?>'><img src="images/accept.png" ></a>
                <a href='index.php?page=delete&u=<?php echo $user?>'><img src="images/cancel.png" ></a>
        <?php } else if (!$isFriend && $isSent && $isItMe){ ?>
                <a href='index.php?page=delete&u=<?php echo $user?>'><img src="images/fold.png" ></a>
        <?php } if ($notBlocked){?>
                <a href='index.php?page=block&u=<?php echo $user?>'><img src="images/block.png" ></a>
        <?php } else { ?> 
                <p><h2>Użytkownik <?php echo $user; ?> został przez Ciebie zablokowany!</h2></p>
        <?php } ?>   
        
        <?php   if($isFriend){ ?>
                <p><a href='index.php?page=message&u=<?php echo $user?>'><img src="images/sent_mes.png" ></a></p>
        <?php } ?>
                            
                
        

		</div>
		
        <div id="wall">
		<h3>Posty użytkownika <?php echo $user; ?>:</h3>
		<?php

$dbconn=pg_connect("host=pascal dbname=u3kubicki user=u3kubicki password=3kubicki"); 
	if(!$dbconn){
		echo "Wystąpił błąd\n";
		exit();
	}

			
			$posts = array();
			
			$sql = pg_query("SELECT description, dating FROM status WHERE owner ='$user' "); 
            $sql2 = pg_query("SELECT gender FROM users WHERE username='$user' ");
            $r=pg_fetch_result($sql2,0,0);
            
            
            $tekst= ($r == 'M') ? 'napisał' : 'napisała';
			while($row = pg_fetch_assoc($sql)){
				$posts[] = $row;
			}  
            $licznik=1;
			if(count($posts)>0){
			     $posts=array_reverse($posts);
				foreach ($posts as $post) { 
				    if($licznik<5){
					?>
						<div class='status'> 
							<p>
							<?php
								echo $user; 
								echo " $tekst "; 
								echo date('d.m.Y  ',strtotime($post['dating']));
                                echo 'o ';
                                echo date('H:i:s',strtotime($post['dating']));
								echo " post:";
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
