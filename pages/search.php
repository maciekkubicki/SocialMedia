<?php
/**
 * @author Maciek
 * @copyright 2015
 * podstrona na której można wyszukać znajomych.
 */
?>
<?php
    
     
include_once("php/session_check.php");

?>


      <link rel="stylesheet" property="stylesheet" href="style/style_search.css">
      <script src="js/ajax.js"></script>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
      <script>
      function search()
      {
        var val = _("key").value;
        _("status").innerHTML = "Szukam";
        var ajax = ajaxObj("POST", "php/ajax_search.php");
        ajax.onreadystatechange = function() {
        if(ajaxReturn(ajax) == true) {
                var str=ajax.responseText;
                if(str !== "" || str !== null){
                    if(str.indexOf("empty")>-1)
                    {
                        
                        _("status").innerHTML = "Nikt nie odpowiada parametrom wyszukiwania";
                    }
                    else
                    {
                        //alert(str);
                        _("status").innerHTML = "";
                        _("wynik").innerHTML = "";
                        $("#wynik").html("");
                        $("#wynik").html(str);
                        //eval(document.getElementById("wynik").innerHTML);
                    
                    }
				}
	        }
        }
        ajax.send("key="+val);
    }
      
      </script>

	<?php include_once("template/template_menu.php"); ?>
    <script>document.getElementById("menu1").innerHTML = "<div><a href='index.php?page=logout'>Logout <?php echo $_SESSION['username']; ?></a></div>";</script>
            	

    <div id="pageMiddle">
        
        <div id="search">
        <div><h3>Wyszukaj:</h3></div>
       	<form action="" method="post" enctype="multipart/form-data">
	
        
    		<input type="text" id="key">
            <input type="button" id="but" onclick="search()" value="Wyszukaj">
              
        </form>
        <div id="status">Wyszukaj znajomych!</div>
        </div>
        <div id="wynik"><script>add_row(1,2,3);</script></div>
        
                

    </div>
     <?php include_once("template/template_bottom.php"); ?>
