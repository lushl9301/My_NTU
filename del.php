<?php
	$file = $_SESSION['file'];
	require_once 'db.php';
	$con = mysql_connect($db_hostname, $db_username, $db_password);
	mysql_select_db("users",$con);
    $del = "DELETE FROM codes WHERE fname='$file';";
    $res  = mysql_query($del);
    if($res){
        echo "<h2>delete successfully</h2>";
    }else{
        echo "<h2>delete error</h2>";
    }
	$fh="upload/$file";
	$newfh="Recycle Bin/$file";
	copy($fh,$newfh);
	unlink($fh);
	echo "<a href='all.php>back</a>";
?>