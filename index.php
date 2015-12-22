<!doctype html>
<html ng-app="ImGetter">

<head>
	<title>ImGetter</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body ng-controller="GetImgController">
<div class="g-from">
	<div class="container">
		<div class="row">
			<form method="post" class="form-inline">
				<div class="input-group">
					<div class="input-group-addon ins-url">Insert your url right here:</div>
					<input type="text" name="url" ng-model="url" class="form-control" required>
					<div class="input-group-addon" id="send-url" ng-click="getImages()">get images</div>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="loading"><img src="img/loading110.gif"></div>
		<div class="result">
			<h2 class="error-message"></h2>
			<h2 class="downloaded">Downloaded:</h2>
			<div class="col-md-3 img-holder" ng-repeat="image in imgIn track by $index">
				<img height="100%" class="img-responsive img-thumbnail" src="php_script/{{ image }}">
			</div>
		</div>
	</div>
</div>


<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/css/bootstrap.min.css" integrity="sha384-y3tfxAZXuh4HwSYylfB+J125MxIs6mR5FOHamPBG064zB+AFeWH94NdvaCBm8qnd" crossorigin="anonymous">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"
		type="text/javascript"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<script type="text/javascript" src="js/angular.js"></script>
<script type="text/javascript" src="js/imgetter.js"></script>
<script type="text/javascript" src="js/controllers/GetImgController.js"></script>
</body>
</html>