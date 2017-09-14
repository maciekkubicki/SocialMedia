<?php

/**
 * @author Maciek 
 * @copyright 2016
 *  Podstrona reprezentująca tzw. Tablice, na której znajdziemy wszystkie statusy nasze i znajomych, a także informacje od dodaniu zdjęć przez nas i znajomych.
 */
 
 Podstrona reprezentująca tzw. Tablice, na której znajdziemy wszystkie 



?>

<?php
    include_once("php/session_check.php");
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
                            window.location = "index.php?page=wall";
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
    
    <div id="write">
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
    
    
    <?php 
        
        $dbconn=pg_connect("host=pascal dbname=u3kubicki user=u3kubicki password=3kubicki"); 
	       if(!$dbconn){
		      echo "Wystąpił błąd\n";
		      exit();
        }
        $query=pg_query("select s.idstatus, s.owner, s.description, s.dating from status s where s.owner in (select f.user1 from friends f where f.user2='$username' and f.isaccepted='1');");
        $query2=pg_query("select s.idstatus, s.owner, s.description, s.dating from status s where s.owner in (select f.user2 from friends f where f.user1='$username' and f.isaccepted='1');");
        $query3=pg_query("select s.idstatus, s.owner, s.description, s.dating from status s where s.owner='$username';");
        $query4=pg_query("select * from photos where owner in (select f.user2 from friends f where f.user1='$username' and f.isaccepted='1');");
        $query5=pg_query("select * from photos where owner in (select f.user1 from friends f where f.user2='$username' and f.isaccepted='1');");
        $query6=pg_query("select * from photos where owner='$username'");
        $posts = array();
        while($row = pg_fetch_assoc($query)){
		  $posts[] = $row;
		}  
        while($row = pg_fetch_assoc($query2)){
		  $posts[] = $row;
		}  
        while($row = pg_fetch_assoc($query3)){
		  $posts[] = $row;
		} 
        while($row = pg_fetch_assoc($query4)){
		  $posts[] = $row;
		} 
        while($row = pg_fetch_assoc($query5)){
		  $posts[] = $row;
		} 
        while($row = pg_fetch_assoc($query6)){
		  $posts[] = $row;
		} 


        usort($posts,function ($a, $b)
         { 
            return strcmp($b['dating'], $a['dating']); 
         });
        
        function HEorSHE($name)
        {
            $sql=pg_query("SELECT gender FROM users WHERE username='$name' ");
            $r=pg_fetch_result($sql,0,0);
            
            
            return ($r == 'M') ? ' napisał ' : ' napisała ';
        }
        
        function HEorSHE2($name)
        {
            $sql=pg_query("SELECT gender FROM users WHERE username='$name' ");
            $r=pg_fetch_result($sql,0,0);
            
            
            return ($r == 'M') ? ' dodał ' : ' dodała ';
        }
       // print_r($posts);
        $licznik = 0;
        
 if(count($posts>0)){
        foreach ($posts as $post) { 
                if($post['owner']==$username && !array_key_exists('filename',$post)){
				   
					?>
						<div class='status'> 
                            <div class="delete" onclick="deletes(<?php echo $post['idstatus'];?>)">x</div>
							<p>
							<?php
								echo $post['owner']; 
								echo HEorSHE($post['owner']); 
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
                    else if(!array_key_exists('filename',$post))
                    {
                        ?>
						<div class='status'> 
                            
							<p>
							<?php
								echo $post['owner']; 
								echo HEorSHE($post['owner']); 
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
                    else if(array_key_exists('filename',$post))
                    {
                    ?>
						<div class='status'> 
                            
							<p>
							<?php
								echo $post['owner']; 
								echo HEorSHE2($post['owner']); 
                                echo "zdjęcie ";
								echo date('d.m.Y  ',strtotime($post['dating']));
                                echo 'o ';
                                echo date('H:i:s',strtotime($post['dating']));
								echo " :";
                                $ow = $post['owner'];
                                echo '<div class="photo"><a href="index.php?page=gallery&u='.$ow.'"><img src="user/'.$post['owner'].'/'.$post['filename'].'" alt="pic" id="top" width=100 height=100 ></a></div>';
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
			} ?>
    
    
    
    </div>
    
    
    
    <?php include_once("template/template_bottom.php"); ?>
    </div>
    
    