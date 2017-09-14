    <?php

/**
 * @author Maciek
 * @copyright 2016
 */


include_once("php/session_check.php");
?>


<?php
    $u1 = preg_replace('#[^a-z0-9]#i', '', $_GET['u1']);
    $u2 = preg_replace('#[^a-z0-9]#i', '', $_GET['u2']);
    $subject = preg_replace('#[^a-z0-9]#i', '', $_GET['sub']);
    if ($username != $u1 && $username != $u2)
        header("location: index.php?page=member");
    $amIu1 = ($u1 == $username) ? true : false;
    
?>

      <link rel="stylesheet" property="stylesheet" href="style/style_conv.css">



	<body>
	<?php include_once("template/template_menu.php"); ?>
    <script>_("menu1").innerHTML = "<div><a href='index.php?page=logout'>Logout <?php echo $_SESSION['username']; ?></a></div>";</script>	

    <div id="pageMiddle">
    <div id="title">
    <p>Konwersacja z <a href="index.php?page=user&u=<?php echo (!$amIu1)? $u1:$u2;?>"><span><?php echo (!$amIu1)? $u1 : $u2; ?></span></a> na temat: <b><?php echo $subject;?></b></p>   
    </div>
    <div id="write">
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
						<div class='error'>Wiadomość jest pusta.</div>
					<?php
				}
                
				else if($amIu1)
                {
					   $sql = pg_query("INSERT INTO message (subject,sent,recived,text,dating) VALUES ('$subject','$u1','$u2','$posts',now())");
					echo "<div class='success'>Wysłano wiadomość!</div>";
                    $_POST['posts']=null;
                    
                    header("location: index.php?page=conversation&u1=$u1&u2=$u2&sub=$subject");
				}
                else
                {
                    $sql = pg_query("INSERT INTO message (subject,sent,recived,text,dating,who) VALUES ('$subject','$u1','$u2','$posts',now(),'1')");
					echo "<div class='success'>Wysłano wiadomość!</div>";
                    $_POST['posts']=null;
                    
                    header("location: index.php?page=conversation&u1=$u1&u2=$u2&sub=$subject");
                    
                }

				}	
				pg_close($dbconn);
                ?>
    <p><h3>Napisz wiadomość:</h3></p>
		<form method='POST' action=''>
			<label form='posts'></label>
            <textarea rows='10' cols='50' name='posts' onfocus="if(this.value==this.defaultValue)this.value=''" onblur="if(this.value=='')this.value=this.defaultValue"></textarea><br/><br/>

            <input type='submit' value='Wyślij!' name='submit'>
		</form>
    
    </div>
    
    <div id="conversations">
    	<?php
        
        function HEorSHE($name,$me)
        {
            $sql=pg_query("SELECT gender FROM users WHERE username='$name' ");
            $r=pg_fetch_result($sql,0,0);
            
            if($me)
                return ($r == 'M') ? ' napisałem ' : ' napisałam ';
            else
                return ($r == 'M') ? ' napisał ' : ' napisała ';
        }
			$dbconn=pg_connect("host=pascal dbname=u3kubicki user=u3kubicki password=3kubicki"); 
        	if(!$dbconn){
        		echo "Wystąpił błąd\n";
        		exit();
        	}
            $q=pg_query("SELECT * from message WHERE sent='$u1' AND recived='$u2' AND subject='$subject';");
            if(pg_num_rows($q)<1){ 
                echo '<div>Konwersacja jest pusta</div>';
            }
            else
            {
                $messages = array();
               
                while($row = pg_fetch_assoc($q)){
				    $messages[] = $row;
                }
                $messages = array_reverse($messages);
                //print_r($messageersations);
                foreach ($messages as $message)
                {
   
                    
                    if($amIu1 && $message['who']=='0')
                    {
                        echo '<div class="me"><b>';
                        //print_r($message['subject']);
                        echo 'Ja</b> ';
                        echo HEorSHE($message['sent'],true);
                        echo ' <b>';
                        echo date('d.m.Y',strtotime($message['dating']));
                        echo ' o ';
                        echo date('H:i:s',strtotime($message['dating']));
                        echo '</b>:<p>';
                        echo $message['text'];
                        echo '</p></div>';
                    }
                    else if ($amIu1 && !($message['who']=='0'))
                    {
                        echo '<div class="notme"><b>';
                        //print_r($message['subject']);
                        echo $message['recived'];
                        echo '</b> ';
                        echo HEorSHE($message['recived'],false);
                        echo ' <b>';
                        echo date('d.m.Y',strtotime($message['dating']));
                        echo ' o ';
                        echo date('H:i:s',strtotime($message['dating']));
                        echo '</b>:<p>';
                        echo $message['text'];
                        echo '</p></div>';

                    }
                    else if (!$amIu1 && !($message['who']=='0'))
                    {
                        echo '<div class="me">';
                        //print_r($message['subject']);
                        echo '<b>Ja</b> ';
                        echo HEorSHE($message['recived'],true);
                        echo ' <b>';
                        echo date('d.m.Y',strtotime($message['dating']));
                        echo ' o ';
                        echo date('H:i:s',strtotime($message['dating']));
                        echo '</b>:<p>';
                        echo $message['text'];
                        echo '</p></div>';
                    }
                    else
                    {
                        
                        echo '<div class="notme"><b>';
                        //print_r($message['subject']);
                        echo $message['sent'];
                        echo '</b> ';
                        echo HEorSHE($message['sent'],false);
                        echo ' <b>';
                        echo date('d.m.Y',strtotime($message['dating']));
                        echo ' o ';
                        echo date('H:i:s',strtotime($message['dating']));
                        echo '</b>:<p>';
                        echo $message['text'];
                        echo '</p></div>';
                    }
                    
                    
                }
            }
				pg_close($dbconn);

			
		?>
        
    
    </div>
    
    
    </div>
     <?php include_once("template/template_bottom.php"); ?>
