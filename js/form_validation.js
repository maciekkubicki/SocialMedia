function restrict(elem)
{
	var tf = _(elem);
	var rx = new RegExp;
	if(elem == "E-mail"){
		rx = /[' "]/gi;
	} else if(elem == "username"){
		rx = /[^a-z0-9]/gi;
	}
	tf.value = tf.value.replace(rx, "");
}

function emptyElement(x)
{
	_(x).innerHTML = "";
}
function validate_username()
{
	var u = _("username").value;
	if(u != ""){
		_("username_status").innerHTML = 'Sprawdzam ...';
		var ajax = ajaxObj("POST", "index.php?page=register");
        ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
	            _("username_status").innerHTML = ajax.responseText;
	        }
        }
        ajax.send("usernamecheck="+u);
	}
}
function register_account(){
	var u = _("username").value;
	var e = _("E-mail").value;
	var p1 = _("pass").value;
	var p2 = _("pass2").value;
	var c = _("country").value;
	var g = _("sex").value;
    var t = _("town").value;
    var n = _("name").value;
    var s = _("surname").value;
    if(g == 'male')
        g='M';
    else g='F';
	var status = _("status");
	if(u == "" || e == "" || p1 == "" || p2 == "" || c == "" || g == ""){
		status.innerHTML = "Wypełnij wszystkie pola formularza!";
	} else if(p1 != p2){
		status.innerHTML = "Podane hasła się nie zgadzają!";
	} else if( _("terms").style.display == "none"){
		status.innerHTML = "Przeczytaj warunki korzystania z serwisu";
	} else {
		_("signupbutton").style.display = "none";
		status.innerHTML = 'Proszę czekać ...';
		var ajax = ajaxObj("POST", "index.php?page=register");
        ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
                var str=ajax.responseText;
                if(str !== "" || str !== null){
                    if(str.indexOf("done")>-1)
                    {
                       // alert(str);
                        window.scrollTo(0,0);
                        _("register").innerHTML = "OK "+u+", Twoje konto zostało zarejstrowane. Przejdź do strony <a href='index.php?page=login'>logowania</a>.";
                    }
                    else{
					   status.innerHTML = str;
					_("signupbutton").style.display = "block";}
				}
	        }
        }
        ajax.send("u="+u+"&e="+e+"&p="+p1+"&c="+c+"&g="+g+"&t="+t+"&s="+s+"&n="+n);
	}
}
function view(){
	_("terms").style.display = "block";
	emptyElement("status");
}
