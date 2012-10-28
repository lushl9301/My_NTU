<html>
<head>
<title>login</title>
<style type="text/css">
		<!--
			body{background-color:#eeeeff;}.STYLE{color:#ffffcc}
		-->
</style>
<br/>
<h1 align=center>Welcome to login here! </h1> </head>
<body>
<br/>
<h3 align=center>Wish you a happy journey in Paste it!<h3>
    <form action = "index.php" method = "post" align=center>  
	   <p>
	     <b align=left><strong>Username</strong></b><input type = "text" name= "username" /><br />
		 <b align=left><strong>Password</strong></b><input type = "password" name = "password"/><br />
		 <input style="width:50px;" type = "submit" value = "Login">
		 <input style="width:50px;" value="Regist" type="button" onClick="window.open('register.php','_self')"/>
		 <input style="width:50px;" type = "reset" value = "Reset">
		</p>
    </form>
 <?php
  require_once 'db.php';	#connect database
  $username = trim(@$_POST["username"]);
  $password = trim(@$_POST["password"]);
  if (($username != "")and($password != "")){	#check login information
		$find_user = FALSE;
		$log_in = FALSE;
	    $con = mysql_connect($db_hostname, $db_username, $db_password);
		mysql_select_db("users",$con);
		$result = mysql_query ("SELECT ID, ltimes, password FROM user",$con);
		while ($row = mysql_fetch_array($result)){
		    if ($row["ID"] == $username){
			    if ($row["password"]== $password){
			    $log_in = TRUE;
			    $find_user = TRUE;
				$row["ltimes"] += 1;
				$ltimes = $row["ltimes"];
				mysql_query("UPDATE user SET ltimes = $ltimes WHERE ID = '$username'");
				}
				else $find_user = TRUE;
			    break;
		    }	
		}
        if ($log_in == TRUE)
		{
			#$fd = fopen('temp','w');
			#fwrite($fd,$username);
			#fclose($fd);
			$_SESSION['login'] = $username;#use session for login information
			if ($username == 'Admin')#Admin is superAdmin
			{
				echo "<h2 align=center>Welcome back, Admin</h2>";
				echo "<h2 align=center><a href='paste.php'>Paste it<a></h2>";
				echo "<h2 align=center><a href='all.php'>Show all<a></h2>";
			}
			else{	#normal user
			echo " <h3 align=center> Welcome $username! ";
			if ($ltimes == 1)
			{
				echo "<br/>This is your first time to visit Paste it. <br/>";
				echo "<br/>A warm welcome for you again!<br />";
			}
			else {
			echo "Our old friend! <br />";
			echo "<br />This is your ".$ltimes." times to visit Paste it.<br />";
			}
			echo "</h3>";
			echo "<h2 align=center><a href='paste.php'>Paste it<a></h2>";
			}
		}
		else echo "<h3 align=center> you have keyed in a wrong username or password, please try again. </h3>";
   }
  else if ((($username != "")and($password==""))or(($username=="")and($password!="")))
     echo "<h2 align=center> Both username and password can not be empty ! </h2> ";
?>
</body>
</html>