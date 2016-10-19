app.controller('NavController', ['$scope', '$state', 'API', function ($scope, $state, API) {
  
  $scope.searchText = "";
  
  $scope.performSearch = function() {
    $('#search').blur();
    console.log("Searching "+ $scope.searchText);
  };

}]);