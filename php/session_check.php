<?php

/**
 * @author Maciek
 * @copyright 2015
 */



?>

<?php 
    if(isset($_SESSION['username']))
        $username = $_SESSION['username'];
    else
    {
        header("location: index.php?page=notloggedin");
        exit();
    }
?>