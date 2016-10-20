app.controller('NavController', ['$scope', '$state', 'API', '$rootScope', function ($scope, $state, API, $rootScope) {

  $scope.searchText = "";
  this.parsedBeerList = {};

  var onClick = function () {
    $scope.searchText = $('#search').val();
    $scope.apply();
    $scope.performSearch();
  };

  $('#search.autocomplete').autocomplete({
    data: this.parsedBeerList,
    onClick: onClick
  });

  var load = function () {
    $rootScope.loading = true;
    API.beer.getAll()
      .then(function (data) {
        $scope.beerList = data.data.data;
        this.parsedBeerList = API.parser.namesForAutocomplete(data.data.data);
        $('#name.autocomplete').autocomplete({
          data: this.parsedBeerList,
          onClick: onClick
        });
        $rootScope.loading = false;
      }, function (error) {
        $rootScope.modalData = {
          title: 'Error: ' + error.data.status,
          description: error.data.msg
        };
        $('#modal').openModal();
        $rootScope.loading = false;
      });
  }

  $scope.performSearch = function () {
    $('#search').blur();
    console.log("Searching " + $scope.searchText);
  };

}]);