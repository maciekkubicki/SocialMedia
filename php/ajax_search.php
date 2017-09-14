<?php

/**
 * @author Maciek
 * @copyright 2016
 */
 
 if(isset($_POST["key"])){
			include_once("db/connection.php");

            $key = preg_replace('#[^a-z0-9]#i', '', $_POST['key']);
                    
            	
				    $dbconn=pg_connect("host=pascal dbname=u3kubicki user=u3kubicki password=3kubicki"); 
                	if(!$dbconn){
                		echo "Wyst¹pi³ b³¹d\n";
                		exit();
                	}
            		$results = array();
            		
            		$query = pg_query("SELECT username, avatar FROM users WHERE username!='{$_SESSION['username']}' AND username LIKE '$key%' ORDER BY username");
            		while($row = pg_fetch_assoc($query)){
            			$results[] = $row;
            		}
                    $licznik=0;
            		if(!empty($results)){
                        echo "<script>$(\"#1\").remove();";
            			echo "$(\"#2\").remove();";
                        echo "$(\"#3\").remove();";
      		            echo "add_row(1,2,3);";

                        foreach ($results as $result) {
            				
                                
                                if($licznik % 3 == 0){ 
                                
                                //echo "_(\"1\").innerHTML = \" aaa\"";
                				echo "_(\"1\").innerHTML += \"<a href='index.php?page=user&u={$result['username']}'><img src='avatar/{$result['avatar']}' heigt='100' width='100' alt='Profilowe'></a>\";";
                                echo "_(\"1\").innerHTML += \"<p>    <a href='index.php?page=user&u={$result['username']}'> {$result['username']}</a></p>\";";
                                
                                }
                                if($licznik % 3 == 1){ 
                                
                				echo "_(\"2\").innerHTML += \"<a href='index.php?page=user&u={$result['username']}'><img src='avatar/{$result['avatar']}' heigt='100' width='100' alt='Profilowe'></a>\";";
                                echo "_(\"2\").innerHTML += \"<p>    <a href='index.php?page=user&u={$result['username']}'> {$result['username']}</a></p>\";";
         
                                }
                                if($licznik % 3 == 2)
                                { 
                                
                				echo "_(\"3\").innerHTML += \"<a href='index.php?page=user&u={$result['username']}'><img src='avatar/{$result['avatar']}' heigt='100' width='100' alt='Profilowe'></a>\";";
                                echo "_(\"3\").innerHTML += \"<p>    <a href='index.php?page=user&u={$result['username']}'> {$result['username']}</a></p>\";";
                                
                                } 
                                $licznik++;
            
            			
            		      }
                          echo "</script>";
                    }
            		else
                    {
            			echo "empty";
            		}

		
                    pg_close($dbconn);
  }
	         
            
            



?>