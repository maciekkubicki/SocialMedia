<?php
/**
 * @author Maciek
 * @copyright 2015
 */
?>

<?php
    include_once("php/session_check.php");
?>


      <link rel="stylesheet" property="stylesheet" href="style/style_conv.css">



	<body>
	<?php include_once("template/template_menu.php"); ?>
    <script>_("menu1").innerHTML = "<div><a href='index.php?page=logout'>Logout <?php echo $_SESSION['username']; ?></a></div>";</script>	

    <div id="pageMiddle">
    
    <div id="conversations">
    		<?php
        
			
			$dbconn=pg_connect("host=pascal dbname=u3kubicki user=u3kubicki password=3kubicki"); 
        	if(!$dbconn){
        		echo "Wystąpił błąd\n";
        		exit();
        	}
            $q=pg_query("SELECT DISTINCT subject, sent, recived from message WHERE sent='$username' OR recived='$username';");
            if(pg_num_rows($q)<1){ 
                echo '<div>Nie masz rozpoczętych konwersacji</div>';
            }
            else
            {
                $conversations = array();
                $names=array();
                while($row = pg_fetch_assoc($q)){
				    $names[] = $row;
                }
                $dates = array();
                 foreach ($names as $conv)
                {
                    $q3=pg_query("SELECT max(dating) FROM message WHERE subject='{$conv['subject']}' AND (sent='{$conv['sent']}' and recived='{$conv['recived']}');");
                    $data=pg_fetch_result($q3,0,0);
                    
                    //$conv = $conv + array('dating' => $data);
                    $conv['dating']= $data;
                    $dates[]=$conv;
                    //print_r($conv) ; 
                    
                }
                $names=$dates;
                //error_reporting(E_ALL ^ E_NOTICE);
                usort($names,function ($a, $b)
                { 
                    return strcmp($b['dating'], $a['dating']); 
                });
                //error_reporting(E_ALL);
                foreach ($names as $conv)
                {
                    $q3=pg_query("SELECT max(dating) FROM message WHERE subject='{$conv['subject']}' AND (sent='{$conv['sent']}' and recived='{$conv['recived']}');");
                    $data=pg_fetch_result($q3,0,0);
                    ?> <div class="conversation" onclick="location.href='index.php?page=conversation&u1=<?php echo $conv['sent'];?>&u2=<?php echo $conv['recived'];?>&sub=<?php echo $conv['subject'];?>'">
                    <?php
                    //echo '<div class="conversation" onclick="location.href='{url}'">';
                    //print_r($conv['subject']);
                    echo 'Konwersacja pomiędzy <b>';
                    echo $conv['sent'];
                    echo '</b> oraz <b>';
                    echo $conv['recived'];
                    echo '</b><p> <b>Temat:</b> '; 
                    echo $conv['subject'];
                    echo '</p> <p> Ostatnia wiadomość z: ';
                    echo date('d.m.Y',strtotime($data));
                    echo ' ';
                    echo date('H:i:s',strtotime($data));
                    echo '</p></div>';
                    
                }
            }
				pg_close($dbconn);

			
		?>
        
    
    </div>
    
    
    </div>
     <?php include_once("template/template_bottom.php"); ?>
