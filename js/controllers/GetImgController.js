    angular.module('ImGetter').

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

                if (typeof response == 'string'){
                    $('.downloaded').hide();
                    $('.error-message').text(response);
                    $scope.imgIn = [];
                }
                else if(typeof response == 'object'){
                    $('.error-message').text('');
                    $('.downloaded').show();
                    $scope.imgIn = response;
                }
      
            });
        }
    }]);