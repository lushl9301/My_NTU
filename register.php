<html>
<head><title>Regist</title>
<style type="text/css">
		<!--
			body{background-color:#eeeeff;}.STYLE{color:#ffffcc}
		-->
</style>
<br/>
<h1 align=center>Welcome to register on Paste it</h1>
</head>
<body><h3>
    <form align=center action = "register.php" method = "post">
	   <table align=center border="0">
		 
		 <tr><br/></tr><tr><br/></tr>
		 <tr align=center><b>Only numbers and alphabets are allowed, maximum length:30</b></tr>
	     <tr>
			<th align=center><b><strong>Username</strong></b></th>
			<th><input type = "text" name= "username" /></th>
		 </tr>
		 <tr>
			<th align=center><b><strong>Password</strong></b></th>
			<th><input type = "password" name = "password1"/></th>
		 </tr>
		 <tr>
			<th align=center><b><strong>Confirm Password</strong></b></th>
			<th><input type="password" name = "password2" /></th>
		 </tr>
		</table>
		 <input style="width:50px;" type = "submit" value = "Regist">
		 <input style="width:50px;" type = "reset" value = "Reset">
		 <input style="width:50px;" value="Login" type="button" onClick="window.open('index.php','_self')"/>
		</p>
	</form>
	</h3>
	<?php
	require_once 'db.php';
	if ((@$_POST["username"] != "") and (@$_POST["password1"] != "") and (@$_POST["password1"]==@$_POST["password2"])){
	    $link = mysql_connect($db_hostname, $db_username, $db_password);
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
		if ($name_exist ==true) print("<h2 align=center> the username has already been used, please choose a new name! Thank you! <h2>");
		else {
			$ltimes = 0;
		    mysql_query("INSERT INTO user(ID, ltimes, password) VALUES ('$temp_username', '$ltimes', '$temp_password')");
		    echo "<h2 align=center>you have sucessfully registered! <a href = 'login.php'> click here to login. </a> </h2>";
	    }
	}
	else if (@$_POST["password1"]!= @$_POST["password2"]) echo "<h2 align=center>The two password that you have typed in are not the same!</h2>";
	?>
</body>
</html>
    
	