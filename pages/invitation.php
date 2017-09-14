<?php
/**
 * @author Maciek
 * @copyright 2015
 */
?>

<?php
    $ilosc = 0;
    include_once("php/session_check.php");
?>

 
      <link rel="stylesheet"  property="stylesheet" href="style/style_mem.css">
      <script src="js/main.js"></script>



	<?php include_once("template/template_menu.php"); ?>
    <script>_("menu1").innerHTML = "<div><a href='index.php?page=logout'>Logout <?php echo $_SESSION['username']; ?></a></div>";</script>	

    <div id="pageMiddle">
    <div id="con">
    <?php
				    $dbconn=pg_connect("host=pascal dbname=u3kubicki user=u3kubicki password=3kubicki"); 
                	if(!$dbconn){
                		echo "Wystąpił błąd\n";
                		exit();
                	}
            		$results = array();
            		$results2 = array();
            		$query = pg_query("select f.user1, u.avatar from friends f, users u where (f.user1=u.username and f.user2='$username' and f.isaccepted='0');");
            		while($row = pg_fetch_assoc($query)){
            			$results[] = $row;
            		}
            		$query = pg_query("select f.user2, u.avatar from friends f, users u where (f.user2=u.username and f.user1='$username' and f.isaccepted='0');");
            		while($row = pg_fetch_assoc($query)){
            			$results2[] = $row;
            		}
                    $licznik=0;
            		if(!empty($results)){?>
                        <script>_("con").innerHTML += "<h3>Otrzymane zaproszenia:</h3>"</script>
            			<?php foreach ($results as $result) {
            				?>
                                
                                
                                <script>
                					_("con").innerHTML += "<p>    <a href='index.php?page=user&u=<?php echo $result['user1']; ?>'><?php echo"\t";echo $result['user1']; ?></a></p>";
                					_("con").innerHTML += "<p><a href='index.php?page=user&u=<?php echo $result['user1']; ?>'><img src='avatar/<?php echo $result['avatar']; ?>' heigt='50' width='50' alt='Profilowe'></a></p>";
                                    _("con").innerHTML += "<a href='index.php?page=accept&u=<?php echo $result['user1']; ?>'><img src='images/accept.png' ></a>"
                                    _("con").innerHTML += "<a href='index.php?page=delete&u=<?php echo $result['user1']; ?>'><img src='images/cancel.png' ></a>"
                                    _("con").innerHTML += "<br></br>"
                                </script> 
                                
            				<?php
            
            			
            		      }
                    }
                    if(!empty($results2)){?>
                        <script>_("con").innerHTML += "<h3>Zaproszenia wysłane przez Ciebie:</h3>"</script>
            		<?php	foreach ($results2 as $result) {
            				?>
                                
                                
                                <script>
                					_("con").innerHTML += "<p>    <a href='index.php?page=user&u=<?php echo $result['user2']; ?>'><?php echo"\t";echo $result['user2']; ?></a></p>";
                					_("con").innerHTML += "<p><a href='index.php?page=user&u=<?php echo $result['user2']; ?>'><img src='avatar/<?php echo $result['avatar']; ?>' heigt='50' width='50' alt='Profilowe'></a></p>";
                                    _("con").innerHTML += "<a href='index.php?page=delete&u=<?php echo $result['user2']; ?>'><img src='images/fold.png' ></a>";
                                    _("con").innerHTML += "<br></br>"
                                </script> 
                                
            				<?php
            
            			
            		      }
                    }
            		else if(empty($results) && empty($results2))
                    {
            			echo "<div class='error'>Nie masz żadnych zaproszeń.</div>";
            		}

		
                    pg_close($dbconn);

	           ?>
    
    </div>
    </div>
     <?php include_once("template/template_bottom.php"); ?>
