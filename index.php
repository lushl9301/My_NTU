<html>
<head>
	<link href="style.css" media="screen" rel="stylesheet" type="text/css">
	<title>Paste</title>
	<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
	<style type="text/css">
		<!--
			body{background-color:#bbbbbb;}.STYLE{color:#33CC00}
		-->
		#main {color:#666}
		textarea{border:1px solid #7f9db9; font-size:14pt; width:430px; color:#000}.grey{color:#999}
		#msg1,#msg2,#msg3,#msg4{ display:none}
		#ol{position:absolute; z-index:1; padding:0px; margin:0px; border:0px; background:#ecf0f5;width:23px; text-align:left;  }
		#li{background:#ecf0f5; height:360px; overflow:hidden; width:32px; border-right:0; line-height:25px; margin:0px; padding:0px;text-align:center}
		#c2{font-family:Arial, Helvetica, sans-serif; height:360px;  margin:0px;  width:716px; padding:0 672 0 32px; overflow-x: hidden; line-height:25px;}
	</style>
	<script language="javascript" type="text/javascript">
		String.prototype.trim2 = function()
		{
			return this.replace(/(^\s*)|(\s*$)/g, "");
		}
		function F(objid)
		{
			return document.getElementById(objid).value;
		}
		function G(objid)
		{
			return document.getElementById(objid);
		}
	</script>
</head>

<body>
	<h1 id="to_cluster">Paste it</h1>
	<script type="text/javascript" src="cluster.js"></script>
	<table height="30" align="right" border="0">
	<tr><td align=right>
		<font size="4"color="#556600">
		<?php
			date_default_timezone_set("Asia/Singapore");
			echo longdate(time());
			function longdate($timestamp)
			{
				return("Today is ".date("D F jS Y", $timestamp));
			}
		?>
		</font>
		</td>
	</tr>
	<tr><td align="right">
		<font size="4"color="#556600">
		<?php
			function getRealIp()
			{
				if (!empty($_SERVER['HTTP_CLIENT_IP']))
					//check ip from share internet
					$ip=$_SERVER['HTTP_CLIENT_IP'];
				elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
					//to check ip is pass from proxy
					$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
				else
					$ip=$_SERVER['REMOTE_ADDR'];
				return $ip;
			}
			echo "Your ip is ".getRealIp();
		?>
		</font></td>
	</tr>
	<tr>
		<td align="right">
		<font size="4"color="#556600">
		<?php
			$time_now=date("H");
			if ($time_now<12) echo "Good morning";
			elseif ($time_now>=18) echo "Good evening";
			else echo "Good afternoon";
		?>
		</font></td>
	</tr>
	<tr>
		<td align="right">
		<?php
		require_once 'login.php';
		$db_server = mysql_connect($db_hostname, $db_username, $db_password);
		if (!$db_server) die ("Unable to connect to MySQL: " .mysql_error());
		mysql_select_db($db_database)
			or die ("Unable to select database: " .mysql_error());
		?>
	</tr>
	</table>
	

	<br/><br/><br/><br/>
	<br/><br/><br/><br/>
	<br/><br/><br/><br/>
	
	<form method="post"action="index.php" enctype="multipart/form-data">Select File:
		<input type='file' value="browse" name='file' id='file'/>
		<input type="submit"; name="submit"value="submit" />
	</form>
	
	<div><table width="100%" border="0" cellspacing="0" cellpadding="0" style="position:relative">
		<tr><td width="50%">
			<div id="ol">
				<textarea cols="2" rows="18" id="li" disabled></textarea>
			</div>
			<textarea name="co" cols="100" rows="18" wrap="off" id="c2"  onblur="check('2')" onkeyup="keyUp()" onscroll="G('li').scrollTop = this.scrollTop;" oncontextmenu="return false"  class="black" ><?php
				if ($_FILES)
				{
					$t = $_FILES['file'];
					if ($t['error'] > 0)
					{
						echo "Sorry, but there is a problem with your request.\n";
						switch($t['error'])
						{
							case 1:echo "Error :"."The file is too large (server).";
							break;
							case 2:echo "Error :". "The file is too large (form).";
							break;
							case 3:echo "Error :". "The file was only partially uploaded.";
							break;
							case 4:echo "Error :". "No file was uploaded.";
							break;
							case 5:echo "Error :". "The servers temporary folder is missing.";
							break;
							case 6:echo "Error :". "Failed to write to the temporary folder.";
							break;    
						}
					}
					else
					{
						$name = "upload/".$t['name'];
						move_uploaded_file($t['tmp_name'],$name);
						$fh = fopen($name, 'r') or
						die("File cannot open");
						$fd = fopen('temp','r') or 
						die("Sorry, please login");
						$user = fread($fd, filesize('temp')) or 
						die("Sorry, please login");
						fclose($fd);
						$now = (string)$t['name'];
						$query = "insert into codes(ID, fname) values('$user','$now')";
						$result = mysql_query($query);
						if (!$result) die ("Database access failed: ". mysql_error());
						$line=fgets($fh);
						while ($line!='')
						{
							echo $line;
							$line=fgets($fh);
						}
						fclose($fh);
					}
				}?></textarea>
		</td></tr>
	</table></div>
	<div>
		<input style="width:50px;" value="new" type="button" onClick="window.open('index.php','_self')"/>
		<input style="width:50px;" value="all" type="button" onClick="window.open('all.php','_blank')"/>
	</div>
	
	
	<script language="javascript" type="text/javascript">
		var msgA=["msg1","msg2","msg3","msg4"];
		var c=["c1","c2","c3","c4"];
		var slen=[50,20000,20000,60];
		var num="";
		var isfirst=[0,0,0,0,0,0];
		function isEmpty(strVal)
		{
			if( strVal == "" )
				return true;
			else
				return false;
		}
		function isBlank(testVal)
		{		
			var regVal=/^\s*$/;
			return (regVal.test(testVal))
		}
		function chLen(strVal)
		{
			strVal=strVal.trim2();
			var cArr = strVal.match(/[^\x00-\xff]/ig);
			return strVal.length + (cArr == null ? 0 : cArr.length);
		}
		function check(i)
		{
			var iValue=F("c"+i);
			var iObj=G("msg"+i);
			var n=(chLen(iValue)>slen[i-1]);
			if((isBlank(iValue)==true)||(isEmpty(iValue)==true)||n==true)
			{
				iObj.style.display ="block";
			}
			else
			{
				iObj.style.display ="none";
			}
		}
		function checkAll()
		{
			for(var i=0;i<msgA.length; i++)
			{
				check(i+1);
				if(G(msgA[i]).style.display=="none")
				{
					continue;
				}
				else
				{
					alert("wrong");
					return;
				}
			}
			G("form1").submit();	
		}
		function clearValue(i)
		{
			G(c[i-1]).style.color="#000";
			keyUp();	
			if(isfirst[i]==0)
			{
				G(c[i-1]).value="";
			}
			isfirst[i]=1;
		}
		function keyUp()
		{
			var obj=G("c2");
			var str=obj.value;	
			str=str.replace(/\r/gi,"");
			str=str.split("\n");
			n=str.length;
			line(n);
		}
		function line(n)
		{
			var lineobj=G("li");
			for(var i=1;i<=n;i++)
			{
				if(document.all)
				{
					num+=i+"\r\n";
				}
				else
				{
					num+=i+"\n";
				}
			}
			lineobj.value=num;
			num="";
		}
		function autoScroll()
		{
			var nV = 0;
			if(!document.all)
			{
				nV=G("c2").scrollTop;
				G("li").scrollTop=nV;
				setTimeout("autoScroll()",20);
			}
		}
		if(!document.all)
		{
			window.addEventListener("load",autoScroll,false);
		}
	</script>
</body>
</html>