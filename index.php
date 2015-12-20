<!DOCTYPE html>
<html ng-app="stores">
<head>
	<title></title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/css/bootstrap.min.css" integrity="sha384-y3tfxAZXuh4HwSYylfB+J125MxIs6mR5FOHamPBG064zB+AFeWH94NdvaCBm8qnd" crossorigin="anonymous">
  </head>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"
        type="text/javascript"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	<script type="text/javascript" src="js/angular.js"></script>
	<script type="text/javascript">

	var stores = angular.module('stores', [])

	.controller('StoresController', ['$scope', '$http', function($scope, $http){
		$scope.stores = $http.get('http://www.urbanoutfitters.com/urban/stores/en-uk/api/v2/stores.json').then(function successCallback(response) {
			
			$scope.data = response.data.stores;
     		return $scope.data;

		  }, function errorCallback(response) {

	  	});
	}])

	.controller('ZipController', ['$scope', '$http', function($scope, $http){
		$scope.stores = $http.post('http://hosted.where2getit.com/truevalue/rest/locatorsearch', {app:'asas'}).then(function successCallback(response) {
			
			$scope.data = response.data.stores;
     		return $scope.data;

		  }, function errorCallback(response) {

	  	});
	}]);
	</script>
</head>
<body>

	<div>
		<div class="container" ng-controller="StoresController">
			<table class="table table-striped">
			    <thead>
			      <tr>
			        <th>Id</th>
			        <th>Adress</th>
			        <th>Postal code</th>
			        <th>Country</th>
			        <th>Latitude</th>
			        <th>Longitude</th>
			      </tr>
			    </thead>
			    <tbody ng-repeat="store in data">
			      <tr>
			        <td>{{ store.id }}</td>
			        <td>{{ store.address_1 }}</td>
			        <td>{{ store.postal_code }}</td>
			        <td>{{ store.country_code }}</td>
			        <td>{{ store.latitude }}</td>
			        <td>{{ store.longitude }}</td>
			      </tr>
			    </tbody>
			  </table>
		</div>
	</div>

	<div>
		<div class="container" ng-controller="ZipController">
			{{ data | json }}
		</div>
	</div>

</body>
</html>