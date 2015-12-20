    <!doctype html>
     <html ng-app="ImGetter">
        <head>
            <title>ImGetter</title>
            <meta charset="utf-8">
        </head>
        <link rel="stylesheet" type="text/css" href="css/style.css">
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
                        <!-- <button class="btn btn-info" name="call">get images</button> -->
                        </form>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="row">
                    <div class="loading"><img src="img/loading110.gif"></div>
                    <div class="result">
                        <div class="col-md-3 img-holder" ng-repeat="image in imgIn">
                            <img width="100%" class="img-responsive img-thumbnail" src="{{image}}">
                        </div>
                    </div>
                </div>
            </div>

               
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/css/bootstrap.min.css" integrity="sha384-y3tfxAZXuh4HwSYylfB+J125MxIs6mR5FOHamPBG064zB+AFeWH94NdvaCBm8qnd" crossorigin="anonymous">
            <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"
                type="text/javascript"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
            <script type="text/javascript" src="js/angular.js"></script>

                        <script type="text/javascript">
                    angular.module('ImGetter', []).

                    controller('GetImgController', ['$scope', '$http', function($scope, $http){
                        $scope.url = '';
                        $scope.getImages = function(){
                            $('.loading').fadeIn("slow", function() {
                                // Animation complete
                            });
                            $http({
                                method: "post",
                                url: 'php_script/extract_script.php',
                                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                                data: "url=" + $scope.url
                            }).success(function(response){
                                $('.loading').fadeOut("slow", function() {
                                    // Animation complete
                                });
                                $scope.imgIn = response;
                            });
                        }
                    }]);

            </script>
        </body>
    </html>