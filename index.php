<?php
ob_start();
// jak coś to sprawdzić functions.php i odkomentowac

//global $dbconn; 	// zmienna globalna do połaczenia


//na razie do debugowania
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include('db/connection.php'); 

$page = htmlentities($_GET['page']);
$file = 'pages/'.$page.".php";
if(!file_exists($file) && empty($_SESSION['username']) )
{
	header("Location:index.php?page=login");
	exit();
}
else if(!file_exists($file) && !empty($_SESSION['username']))
{
    header("Location:index.php?page=member");
    exit();
}
?>

<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8"> 
      <script src="js/main.js"></script>
		<title>Twaroksiążka</title>
	</head>

	<body>
		<div id = 'content'>
			<?php
				include($file);
			?>
		</div>
	</body>
</html>
<?php ob_end_flush(); ?>