<?php
/**
 * @author Maciek
 * @copyright 2015
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
$dbconn=pg_connect("host=pascal dbname=u3kubicki user=u3kubicki password=3kubicki"); 
if(!$dbconn)
{
	echo "Wyst¹pi³ b³¹d\n";
	exit();
}

pg_query("DELETE FROM friends WHERE (user2='$username' AND user1='$user');");
pg_query("DELETE FROM friends WHERE (user1='$username' AND user2='$user');");

pg_close($dbconn);

header("location: index.php?page=user&u=$user");

?>