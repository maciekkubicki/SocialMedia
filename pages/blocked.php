<?php

/**
 * @author Maciek
 * @copyright 2016
 */



?>




<?php
    
     
include_once("php/session_check.php");
$user = preg_replace('#[^a-z0-9]#i', '', $_GET['u']);

?>

<?php
$dbconn=pg_connect("host=pascal dbname=u3kubicki user=u3kubicki password=3kubicki"); 
if(!$dbconn)
{
	echo "Wystąpił błąd\n";
	exit();
}

$query = pg_query("SELECT * from blocked WHERE blocker='$username' AND blocked='$user';");
$canBlock = pg_num_rows($query) > 0 ? false : true;
pg_close($dbconn);
?>

      <link rel="stylesheet"  property="stylesheet" href="style/style_upload.css">

	<?php include_once("template/template_menu.php"); ?>
            <script>_("menu1").innerHTML = "<div><a href='index.php?page=logout'>Logout <?php echo $_SESSION['username']; ?></a></div>";</script>	

    <div id="pageMiddle">
    <div style="text-align: center;">Użytkownik <?php echo $user; ?> zablokował Cię. Nie możesz przeglądać Jego profilu.
    <?php if($canBlock){ ?>
        Jeśli nie chcesz, aby <?php echo $user;?> mógł przeglądać Twój profil to:
        <p><a href='index.php?page=block&u=<?php echo $user?>'><img src="images/block.png" ></a></p>
    <?php } ?>
    
    </div>
    </div>
     <?php include_once("template/template_bottom.php"); ?>
