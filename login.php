<html>
<head>
<title>login</title>
<h1 align=right>Welcome to login here! </h1> </head>
<h3 align=right>Wish you a happy journey in Paste it!<h3>
    <form action = "login.php" method = "post" align=right>  
	   <p>
	     <b align=right><strong>Username</strong></b><input type = "text" name= "username" /><br />
		 <b align=right><strong>Password</strong></b><input type = "password" name = "password"/><br />
		 <input style="width:50px;" type = "submit" value = "Login">
		 <input style="width:50px;" value="Regist" type="button" onClick="window.open('register.php','_self')"/>
		 <input style="width:50px;" type = "reset" value = "Reset">
		</p>
    </form>
 <?php
  $db_hostname = 'localhost';
  $db_database = 'users';
  $db_username = 'root';
  $db_password = '1234';
  $username = trim(@$_POST["username"]);
  $password = trim(@$_POST["password"]);
  if (($username != "")and($password != "")){
		$find_user = FALSE;
		$log_in = FALSE;
	    $con = mysql_connect("localhost","root","1234");
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
			$fd = fopen('temp','w');
			fwrite($fd,$username);
			fclose($fd);
			echo " <h3 align=right> Welcome $username! ";
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
			require_once 'index.php';
		}
		else echo "<h3 align=right> you have keyed in a wrong username or password, please try again. </h3>";
   }
  else if ((($username != "")and($password==""))or(($username=="")and($password!="")))
     echo "<h2 align=right> Both username and password can not be empty ! </h2> ";
?>
</body>
</html>