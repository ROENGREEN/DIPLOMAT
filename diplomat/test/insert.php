<html>
<html>
	<head> 
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>INSERT TEST</title>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		
		
		<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
	</head>
	<body>
		<div class="container">
			<form class="form form-horizontal" action="/DIPLOMAT/diplomat/receiver.php/CATEGORY" method="POST">
				<div class="col-sm-12" style="text-align:center;color:#cc0000;margin:10px;">
					<span>* 테이블명은 aciton에 'CATEGORY'로 박아두었음</span>
				</div>
				<label class="col-sm-2 control-label">varchar</label>
				<div class="form-group col-sm-10">
					<input type="text" class="form-control" name="title" value=""/>
				</div>
				
				<label class="col-sm-2 control-label">int</label>
				<div class="form-group col-sm-10">
					<input type="number" class="form-control" name="no" value=""/>
				</div>
				
				<label class="col-sm-2 control-label">redirect_url</label>
				<div class="form-group col-sm-10">
					<input type="text" class="form-control" name="redirect_url" value="/DIPLOMAT/diplomat/test/blank.php"/>
				</div>
				
				<input type="submit" value="등록" />
			</form> 
		</div>
	</body>
</html>