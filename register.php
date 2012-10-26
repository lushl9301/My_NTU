<html>
<head><title>Regist</title>
<h1>Welcome to register on Paste it</h1>
</head>
<body>
    <form action = "register.php" method = "post">
	   <table border="0">
		 <tr><b>Only numbers and alphabets are allowed, maximum length:30</b></tr>
	     <tr>
			<th align=right><b><strong>Username</strong></b></th>
			<th><input type = "text" name= "username" /></th>
		 </tr>
		 <tr>
			<th align=right><b><strong>Password</strong></b></th>
			<th><input type = "password" name = "password1"/></th>
		 </tr>
		 <tr>
			<th align=right><b><strong>Confirm Password</strong></b></th>
			<th><input type="password" name = "password2" /></th>
		 </tr>
		</table>
		 <input style="width:100px;" type = "submit" value = "Go & Register">
		 <input style="width:50px;" type = "reset" value = "Reset">
		</p>
	</form>
	<?php
	if ((@$_POST["username"] != "") and (@$_POST["password1"] != "") and (@$_POST["password1"]==@$_POST["password2"])){
	    $link = mysql_connect("localhost","root","1234");
		mysql_select_db("users",$link);
		$query = "SELECT ID FROM user";
		$result = mysql_query ($query, $link);
		$name_exist = false;
		$temp_username = $_POST["username"];
		$temp_password = $_POST["password1"];
		while ($row = mysql_fetch_array($result)){
		    if ($row["ID"] == $temp_username){
			$name_exist = true;
			break;
			}
		}
		if ($name_exist ==true) print("<h2> the username has already been used, please choose a new name! Thank you! <h2>");
		else {
			$ltimes = 0;
		    mysql_query("INSERT INTO user(ID, ltimes, password) VALUES ('$temp_username', '$ltimes', '$temp_password')");
		    echo "<h2>you have sucessfully registered! <a href = 'login.php'> click here to login. </a> </h2>";
	    }
	}
	else if (@$_POST["password1"]!= @$_POST["password2"]) echo "<h2>The two password that you have typed in are not the same!</h2>";
	else echo "<h2>Both username and password can not be empty!</h2>"
	?>
</body>
</html>
    
	