<?php
/**
 * @author Maciek
 * @copyright 2015
 */
?>

<?php
    $ilosc = 0;
    if(isset($_SESSION['username']))
    {
    $dbconn=pg_connect("host=pascal dbname=u3kubicki user=u3kubicki password=3kubicki"); 
   	if(!$dbconn){
  		echo "Wystąpił błąd\n";
  		exit();
   	}
       	$username=$_SESSION['username'];
        $query = pg_query("select f.user1, u.avatar from friends f, users u where (f.user1=u.username and f.user2='$username' and f.isaccepted='0');");
        $ilosc=pg_num_rows($query);
    }
?>
    <div id="pageTop">
    <div id="pageTopWrap">
        <div id="logo">
            <a href="index.php?page=member"><img src="images/logo.png" alt="logo" title="Homepage"></a> 
        </div>
        
        <div id="rest">
            <div id="menu1">

            </div>
            <div id="menu2">
                    <div id="m">
                        <a href="index.php?page=member"><img src="images/home.png" alt="home" title="Homepage"></a> 
                        <a href="index.php?page=inbox"><img src="images/inbox.png" alt="Wiadomości" title="Wiadomości"></a>
                        <a href="index.php?page=invitation"><img src="images/<?php if($ilosc==0) echo 'inv2.png'; else echo 'inv3.png'; ?>" alt="Zaproszenia" title="Zaproszenia"></a>
                        <a href="index.php?page=friends">Znajomi</a>
                        <a href="index.php?page=wall">Tablica</a>
                        <a href="index.php?page=search">Szukaj</a>
                        <a href="index.php?page=settings">Ustawienia</a>
                        
            
                </div>

            </div>

    
        </div>

    </div>
  
</div>