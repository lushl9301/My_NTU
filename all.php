<?php session_start(); ?>
<html>
<head>
	<link href="style.css" media="screen" rel="stylesheet" type="text/css">
	<title>all</title>
	<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
	<style type="text/css">
		<!--
			body{background-color:#bbbbbb;}.STYLE{color:#33CC00}
		-->
		#main {color:#666}
		textarea{border:1px solid #7f9db9; font-size:11pt; width:430px; color:#000}.grey{color:#999}
		#msg1,#msg2,#msg3,#msg4{ display:none}
		#ol{position:absolute; z-index:1; padding:0px; margin:0px; border:0px; background:#ecf0f5;width:23px; text-align:left;  }
		#li{background:#ecf0f5; height:160px; overflow:hidden; width:32px; border-right:0; line-height:25px; margin:0px; padding:0px;text-align:center}
		#c2{font-family:Arial, Helvetica, sans-serif; height:160px;  margin:0px;  width:716px; padding:0 672 0 32px; overflow-x: hidden; line-height:25px;}
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
	<br/><br/><br/><br/><br/><br/><br/><br/>
	<p><?php
	require_once 'db.php';
	$con = mysql_connect($db_hostname, $db_username, $db_password);
	mysql_select_db("users",$con);
	$files = scandir("upload");
	for ($i=0;$i<count($files);++$i)
	{
		$file = (string)$files[$i];
		if ($file !='.' and $file !='..')
			{
				echo '<h3>'.$file.'</h3>';
	?>
		<div><table width='100%' border='0' cellspacing='0' cellpadding='0' style='position:relative'>
		<tr><td width='50%'><div id='ol'>
		<textarea cols='2' rows='18' id='li' disabled></textarea></div>
		
		<textarea name='co' cols='100'rows='18' wrap='off' id='c2'  onblur='check('2')' onkeyup='keyUp()' onscroll='G('li').scrollTop = this.scrollTop;' oncontextmenu='return false'  class='black' ><?php
				$fh = fopen("upload/".$file, 'r') or
						die("File cannot open");
				$line=fgets($fh);
				while ($line!='')
					{
						echo $line;
						$line=fgets($fh);
					}
				fclose($fh);
				
				?>
		</textarea>
		</td></tr>
		</table></div>
		<?php
			echo "<input style='width:55px;' value='see all' type='button' onClick=".'"window.open('."'"."upload/$file"."','_blank')".'"/>';
		?>
		<input style='width:50px;' value='delete' type='button' onClick=
		<?php
			$_SESSION['file'] = $file;
			echo '"'."window.open('del.php','_self')".'"';
		?>	/>
		<br/>			
	<?php } ?>
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
	</script><?php
	}
	?>
	</p>
	
</body>
</html>