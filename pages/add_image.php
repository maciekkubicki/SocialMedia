<?php
/**
 * @author Maciek
 * @copyright 2015
 */
?>
<?php
    
     
include_once("php/session_check.php");

?>

      <link rel="stylesheet"  property="stylesheet" href="style/style_upload.css">

	<?php include_once("template/template_menu.php"); ?>
            <script>_("menu1").innerHTML = "<div><a href='index.php?page=logout'>Logout <?php echo $_SESSION['username']; ?></a></div>";</script>	

    <div id="pageMiddle">

	<h4>Dodaj zdjęcie do galerii:</h4>

	<?php
	
	if(isset($_POST['submit'])){
	   $dbconn=pg_connect("host=pascal dbname=u3kubicki user=u3kubicki password=3kubicki"); /*połączenie */
	   if(!$dbconn){
		  echo "Wystąpił błąd\n";
		  exit();
	}
			if(!$_FILES['avatar']['error']){
				$avatar = $_FILES['avatar']['name'];
				$avatar_tmp = $_FILES['avatar']['tmp_name'];
				if(!empty($avatar)){
					$image_ext = strtolower(end(explode('.', $avatar)));
					
		
					if(in_array($image_ext, array('jpg','jpeg','png','gif'))){
                        $usr=$_SESSION['username'];
   		                if (!file_exists("user/$usr")) {
			                 mkdir("user/$usr", 0777, true);
                        }
						move_uploaded_file($avatar_tmp, "user/$usr/".$avatar);
                        //$doc = new DomDocument;
                        //$doc->load('http://pascal.fis.agh.edu.pl/~3kubicki/root/index.php?page=add_image');
                        //$value=$doc->getElementById("desc").value;
                       	$value=$_POST['desc'];
                        $sql = "INSERT INTO photos (owner, filename,dating,description) VALUES ('{$_SESSION['username']}','$avatar',now(),'$value')";
						$r=pg_query($sql);
                        //echo "<div class='error'>$r</div>";
						header("Location:index.php?page=member");
					}
					else
                    {
						echo "<div class='error'>Wybierz obraz o odpowiednim rozszerzeniu</div>";
					}
				}
			}
			else{
				echo "<div class='error'>Nie udało się wczytać obraz!</div>";
			}

			pg_close($dbconn);
		}

	/*	foreach ($infos as $info) {
			?>
				<img src='avatar/<?php echo $info['avatar']; ?>' height='100' width='100' alt='Profilowe'>
			<?php
		}*/
	?>

	<form action="" method="post" enctype="multipart/form-data">
	<input type="file" name="avatar"><br/><br/>
    <div>Opis:</div>
    		<input type="text" name="desc">
	<div><input type="submit" value = "Potwierdź" name="submit"></div>
	</form>
    </div>
     <?php include_once("template/template_bottom.php"); ?>
