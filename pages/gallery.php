<?php

/**
 * @author Maciek
 * @copyright 2016
 */



?>

<?php include_once("php/session_check.php"); ?>

<?php 
    $user = preg_replace('#[^a-z0-9]#i', '', $_GET['u']);
    $isItMe = false;
    if($user == $username)
        $isItMe = true;
    //$isItMe = ($user == $username) ? true : false;
    
    $dbconn=pg_connect("host=pascal dbname=u3kubicki user=u3kubicki password=3kubicki"); 
    if(!$dbconn){
        echo "Wystąpił błąd\n";
  		exit();
   	}
    $results = array();
            		
    $query = pg_query("select filename, description, dating from photos where owner='$user' order by dating;");
    while($row = pg_fetch_assoc($query)){
        $results[] = $row;
    }

?>



	  
    <link rel="stylesheet" property="stylesheet" href="style/style_search.css">
    <script src="js/ajax.js"></script>
    <script>
    function deletePhoto(filename)
    {
        var conf = confirm("Naciśnij OK, aby skasować to zdjęcie!");
        if(conf != true){
		      return false;
        }
        var ajax = ajaxObj("POST", "php/ajax_photo.php");
        ajax.onreadystatechange = function() {
        if(ajaxReturn(ajax) == true) {
                var str=ajax.responseText;
                if(str !== "" || str !== null){
                    if(str.indexOf("deleted")>-1)
                    {
                        
                        alert("Zdjęcie zostało skasowane. Strona jest automatycznie odświeżona.");
                        window.location = "index.php?page=gallery&u=<?php echo $user; ?>";
                    }
                    else
                    {
                    alert("Wystąpił problem.");
                    
                    }
				}
	        }
        }
        ajax.send("delete=photo&f="+filename+"&u="+'<?php echo $username; ?>');
    }
    </script>
	   


	
	<?php include_once("template/template_menu.php"); ?>
    <script>_("menu1").innerHTML = "<div><a href='index.php?page=logout'>Logout <?php echo $_SESSION['username']; ?></a></div>";</script>	

    <div id="pageMiddle">
        <div id="title"><h3>Galeria</h3></div>
        <div id="ster"><?php if($isItMe) echo '<p><a href="index.php?page=add_image"><img src="images/add.png" alt="Dodaj zdjęcie" title="Dodaj zdjęcie"></a></p>';?></div>
        <div id="photos">
        <script>add_row2(1,2,3);</script>
        </div>
        
         <?php
         $licznik=0;
         $results=array_reverse($results);
            		if(!empty($results)){
            			foreach ($results as $result) {
            				?>
                                
                                <?php if($licznik % 3 == 0){ ?>
                                <script>
                                    var pic = '<?php echo $result['filename'];?>';
                					//var str="photo("+"\"<?php echo $result['filename'];?>\""+")";
                                    //var str2=\""+'user/'+'<?php echo $user?>'+'/'+'<?php echo $result['filename']?>';
                                    var strr='<div><img onclick="photo(\''+pic+'\')" src="user/'+'<?php echo $user?>'+'/'+'<?php echo $result['filename']?>'+'"  alt="pic" width="100" height="100"><div>';
                					_("1").innerHTML += strr;
                                    //_("1").innerHTML += '<div><img onclick="photo(\''+<?php echo $result['filename']?>+'\')" src="user/'+'<?php echo $user?>'+'/'+'<?php echo $result['filename']?>'+'" alt="pic" width="100" height="100">';
                                    _("1").innerHTML += '<p><?php echo $result['description'];?></p>';
                                    <?php if($isItMe){ ?>
                                        _("1").innerHTML += '<p><?php echo date('d.m.Y  ',strtotime($result['dating']));echo 'o ';echo date('H:i:s',strtotime($result['dating']));?>'+'  <button onclick="deletePhoto(\''+pic+'\')">x</button></p></div>';
                                    <?php } else {?>
                                         _("1").innerHTML += '<p><?php echo date('d.m.Y  ',strtotime($result['dating']));echo 'o ';echo date('H:i:s',strtotime($result['dating']));?></p></div>';
                                    <?php } ?>
                                  </script> 
                                <?php }if($licznik % 3 == 1){ ?>
                                <script>
                					var pic = '<?php echo $result['filename'];?>';
                					var strr='<div><img onclick="photo(\''+pic+'\')" src="user/'+'<?php echo $user?>'+'/'+'<?php echo $result['filename']?>'+'"  alt="pic" width="100" height="100"><div>';
                					_("2").innerHTML += strr;
                                   // _("2").innerHTML += '<div><img onclick="photo("+'<?php echo "{$result['filename']}"?>'+")" src="user/'+'<?php echo $user?>'+'/'+'<?php echo $result['filename']?>'+'" alt="pic" width="100" height="100">';
                                     _("2").innerHTML += '<p><?php echo $result['description'];?></p>';
                                     <?php if($isItMe){ ?>
                                        _("2").innerHTML += '<p><?php echo date('d.m.Y  ',strtotime($result['dating']));echo 'o ';echo date('H:i:s',strtotime($result['dating']));?>'+'  <button onclick="deletePhoto(\''+pic+'\')">x</button></p></div>';
                                    <?php } else {?>
                                         _("2").innerHTML += '<p><?php echo date('d.m.Y  ',strtotime($result['dating']));echo 'o ';echo date('H:i:s',strtotime($result['dating']));?></p></div>';
                                    <?php } ?>
                                </script>
                                <?php }if($licznik % 3 == 2){ ?>
                                <script>
                					var pic = '<?php echo $result['filename'];?>';
                                    var strr='<div><img onclick="photo(\''+pic+'\')" src="user/'+'<?php echo $user?>'+'/'+'<?php echo $result['filename']?>'+'"  alt="pic" width="100" height="100"><div>';
                					_("3").innerHTML += strr;
                					//_("3").innerHTML += '<div><img onclick="photo("+'<?php echo "{$result['filename']}"?>'+")" src="user/'+'<?php echo $user?>'+'/'+'<?php echo $result['filename']?>'+'" alt="pic" width="100" height="100">';
                                     _("3").innerHTML += '<p><?php echo $result['description'];?></p>';
                                    <?php if($isItMe){ ?>
                                        _("3").innerHTML += '<p><?php echo date('d.m.Y  ',strtotime($result['dating']));echo 'o ';echo date('H:i:s',strtotime($result['dating']));?>'+'  <button onclick="deletePhoto(\''+pic+'\')">x</button></p></div>';
                                    <?php } else {?>
                                         _("3").innerHTML += '<p><?php echo date('d.m.Y  ',strtotime($result['dating']));echo 'o ';echo date('H:i:s',strtotime($result['dating']));?></p></div>';
                                    <?php } ?>
                                <?php } $licznik++ ?>
            				<?php
            
            			
            		}
                    }
            		else{
            			echo "<div class='status'>Użytkownik $user nie ma jeszcze zdjęć.</div>";
            		}?>
                    
                    <div id="photo"></div>
        

        <script>
    
            function photo(pic)
            {
                var picture=pic;
               
                _("photos").style.display = "none";
                _("ster").style.display = "none";
                _("title").style.display = "none";
                _("photo").style.display="block";
                _("photo").style.height="500px";
                _("photo").style.width="600px";
                _("photo").style.marginLeft="200px";
                _("photo").style.marginTop="50px";
                _("photo").style.marginBottom="50px";
                _("photo").style.textAlign="center";     
                _("photo").innerHTML ='<a href="index.php?page=gallery&u=<?php echo $user;?>"><img src="user/<?php echo $user; ?>/'+pic+'" alt="photo" height="500px" width="600px"></a>';
               
            }
            
      
            
       </script>
            
  
    
    
    </div>
     <?php include_once("template/template_bottom.php"); ?>


