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
            $mark = preg_replace('#[^a-z0-9]#i', '', $_GET['mark']);
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
	if(!$dbconn){
		echo "Wystąpił błąd\n";
		exit();
	}
    $sql = "INSERT INTO ratings (profile,rater,mark,dating) VALUES ('$user','$username', '$mark', now());";
    
    $query = pg_query($dbconn, $sql);
    
    pg_close($dbconn);
    header("location: index.php?page=user&u=$user");
?>



