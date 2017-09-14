<?php
/**
 * @author Maciek
 * @copyright 2015
 */
?>

<?php
    
     
include_once("php/session_check.php");

?>



      <link rel="stylesheet" property="stylesheet" href="style/style_search.css">

	<?php include_once("template/template_menu.php"); ?>
    <script>_("menu1").innerHTML = "<div><a href='index.php?page=logout'>Logout <?php echo $_SESSION['username']; ?></a></div>";</script>	

    <div id="pageMiddle">
            <h4>Lista znajomych:</h4>
        <script>add_row(1,2,3);</script>
            	<?php
				    $dbconn=pg_connect("host=pascal dbname=u3kubicki user=u3kubicki password=3kubicki"); 
                	if(!$dbconn){
                		echo "Wyst¹pi³ b³¹d\n";
                		exit();
                	}
            		$results = array();
            		
            		$query = pg_query("select u.username, u.avatar from users u, friends f where (f.user1='$username' and f.user2=u.username and f.isaccepted='1') or (f.user2='$username' and f.user1=u.username and f.isaccepted='1');");
            		while($row = pg_fetch_assoc($query)){
            			$results[] = $row;
            		}
                    $licznik=0;
            		if(!empty($results)){
            			foreach ($results as $result) {
            				?>
                                
                                <?php if($licznik % 3 == 0){ ?>
                                <script>
                					
                					_("1").innerHTML += "<a href='index.php?page=user&u=<?php echo $result['username']; ?>'><img src='avatar/<?php echo $result['avatar']; ?>' heigth='100' width='100' alt='Profilowe'></a>";
                                    _("1").innerHTML += "<p>    <a href='index.php?page=user&u=<?php echo $result['username']; ?>'><?php echo"\t";echo $result['username']; ?></a></p>";
                                  </script> 
                                <?php }if($licznik % 3 == 1){ ?>
                                <script>
                					
                					
                                    _("2").innerHTML += "<a href='index.php?page=user&u=<?php echo $result['username']; ?>'><img src='avatar/<?php echo $result['avatar']; ?>' heigth='100' width='100' alt='Profilowe'></a>";
                                    _("2").innerHTML += "<p>    <a href='index.php?page=user&u=<?php echo $result['username']; ?>'><?php echo"\t";echo $result['username']; ?></a></p>";
                                 </script>
                                <?php }if($licznik % 3 == 2){ ?>
                                <script>
                					
                					_("3").innerHTML += "<a href='index.php?page=user&u=<?php echo $result['username']; ?>'><img src='avatar/<?php echo $result['avatar']; ?>' heigth='100' width='100' alt='Profilowe'></a>";
                                    _("3").innerHTML += "<p>    <a href='index.php?page=user&u=<?php echo $result['username']; ?>'><?php echo"\t";echo $result['username']; ?></a></p>";
                                </script>
                                <?php } $licznik++ ?>
            				<?php
            
            			
            		}
                    }
            		else{
            			echo "<div class='error'>Nie masz jeszcze znajomych.</div>";
            		}

		
                    pg_close($dbconn);

	           ?>
    
    
    </div>
     <?php include_once("template/template_bottom.php"); ?>
