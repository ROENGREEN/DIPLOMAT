<?php 
	print_r($_POST);
	if( $_POST['servername'] != "" && $_POST['id'] != "" && $_POST['pass'] != "" && $_POST['database'] != "" ){
		$contents = "<?";
		$contents .= "\$config = array();";
		$contents .= "\$config['servername'] = '".$_POST['servername']."';";
		$contents .= "\$config['id'] = '".$_POST['id']."';";
		$contents .= "\$config['pass'] = '".$_POST['pass']."';";
		$contents .= "\$config['database'] = '".$_POST['database']."';";
		$contents .= "return \$config;";
		$contents .= "?>";
			
		$RESULT = file_put_contents('./conf/config.php',$contents);
		
		echo $RESULT;
		
		exit;
	}
?>
<html>
	<head>
		
	</head>
	<body>
		<form name="server" method="post">
		servername : <input type="text" name="servername" id="servername"> <br/>
		id : <input type="text" name="id" id="id"> <br/>
		pass : <input type="text" name="pass" id="pass"> <br/>
		database : <input type="text" name="database" id="database"> <br/>		
		<input type="submit" value="확인">
		</form>
	</body>

</html>