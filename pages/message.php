<?php

/**
 * @author Maciek
 * @copyright 2016
 */

include_once("php/session_check.php");

if(isset($_GET['u']))
        {
            $user = preg_replace('#[^a-z0-9]#i', '', $_GET['u']);
            $username = $_SESSION['username'];
            if($user == $_SESSION['username'])
                header("location: index.php?page=member");
        }

?>
    <link rel="stylesheet"  property="stylesheet" href="style/style_upload.css">

	<?php include_once("template/template_menu.php"); ?>
            <script>_("menu1").innerHTML = "<div><a href='index.php?page=logout'>Logout <?php echo $_SESSION['username']; ?></a></div>";</script>	

    <div id="pageMiddle">
    	<div class='posts'>
		<?php
        
			
			$dbconn=pg_connect("host=pascal dbname=u3kubicki user=u3kubicki password=3kubicki"); 
        	if(!$dbconn){
        		echo "Wystąpił błąd\n";
        		exit();
        	}
                if(isset($_POST['posts'])){
				$posts =pg_escape_string(htmlentities(trim($_POST['posts'])));
                $sub = htmlentities(trim($_POST['subject']));

				if(empty($posts)){
					?>
						<div class='error'>Wiadomość jest pusta.</div>
					<?php
				}
                else if(empty($sub)){
                    	?>
						<div class='error'>Temat jest pusty.</div>
					<?php }
                
				else{
				    
                    $s1 = pg_query("SELECT * FROM message WHERE subject='$sub' AND (sent = '$username' AND recived = '$user')");
                    $s2 = pg_query("SELECT * FROM message WHERE subject='$sub' AND (sent = '$user' AND recived = '$username')");
                    if (pg_num_rows($s1)>0)
                    {
					   $sql = pg_query("INSERT INTO message (subject,sent,recived,text,dating) VALUES ('$sub','$username','$user','$posts',now())");
                       header("location: index.php?page=conversation&u1=$username&u2=$user&sub=$sub");
                       
                    }
                    else if (pg_num_rows($s2)>0)
                    {
					   $sql = pg_query("INSERT INTO message (subject,sent,recived,text,dating,who) VALUES ('$sub','$user','$username','$posts',now(),'1')");
                       header("location: index.php?page=conversation&u1=$user&u2=$username&sub=$sub");
                    }
                    else
                        $sql = pg_query("INSERT INTO message (subject,sent,recived,text,dating) VALUES ('$sub','$username','$user','$posts',now())");
                        
                    
                    echo "<div class='success'>Utworzono konwersacje!</div>";
                    $_POST['posts']=null;
                    
                    header("location: index.php?page=inbox");
				}

				}	
				pg_close($dbconn);

			
		?>

        <p><h3>Napisz wiadomość do <?php echo $user; ?>.</h3></p>
		<form method='POST' action=''>
			<label form='posts'></label>
			<p><b>Temat:</b></p>
            <input name="subject" type="text"  maxlength="30" >
			<p><b>Wiadomość:</b></p>
            <textarea rows='10' cols='30' name='posts' onfocus="if(this.value==this.defaultValue)this.value=''" onblur="if(this.value=='')this.value=this.defaultValue"></textarea><br/><br/>

            <input type='submit' value='Wyślij!' name='submit'>
		</form>
        </div>
    
    
    </div>
    <?php include_once("template/template_bottom.php"); ?>


