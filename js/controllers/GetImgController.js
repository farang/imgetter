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

                    var a=response.indexOf('[');
                    var b=response.length;
                    if (a){
                        var line = response.substr(a, b).replace(/\[|\]/g, "").split(',');
                        $scope.imgIn = [];
                        for (i=0;i<line.length;i++){
                            $scope.imgIn.push(line[i].replace(/\\|"/g, ''));
                        }
                        $('.error-message').text(response.substr(0, a));
                    }
                    else{
                        $('.error-message').text(response);
                        $scope.imgIn = [];
                    }                    
                }
                else if(typeof response == 'object'){
                    $('.error-message').text('');
                    $('.downloaded').show();
                    $scope.imgIn = response;
                }
      
            });
        }
    }]);