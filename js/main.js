
function _(x)
{
	return document.getElementById(x);
}

function add_row(a, b, c)
{
    var str = "<div class='lef' id='" + a +"'></div> <div class='cen' id='" + b +"'></div> <div class='rig' id='"+c+"'></div>";
    _('pageMiddle').innerHTML += str;
}

function add_row2(a, b, c)
{
    var str = "<div class='lef' id='" + a +"'></div> <div class='cen' id='" + b +"'></div> <div class='rig' id='"+c+"'></div>";
    _('photos').innerHTML += str;
}



         function deletes(id)
        {
            var conf = confirm("Naci�nij OK, aby skasowa� ten status!");
            if(conf != true){
    		      return false;
            }
            var ajax = ajaxObj("POST", "php/ajax_status.php");
            ajax.onreadystatechange = function() {
            if(ajaxReturn(ajax) == true) {
                    var str=ajax.responseText;
                    if(str !== "" || str !== null){
                        if(str.indexOf("deleted")>-1)
                        {
                            
                            alert("Status zosta� skasowany. Strona jest automatycznie od�wie�ona.");
                            window.location = "index.php?page=member";
                        }
                        else
                        {
                        alert("Wyst�pi� problem.");
                        
                        }
    				}
    	        }
            }
            ajax.send("delete=status&id="+id+"");
        }
        
