app.controller('NavController', ['$scope', '$state', 'API', '$rootScope', '$search', function ($scope, $state, API, $rootScope, $search) {

  $scope.searchText = "";
  //  this.parsedBeerList = {};
  $scope.searchResults = null;
  $scope.searchLoading = false;
  $scope.showDropdown = false;

  $scope.setDropdown = function (value) {
    $scope.showDropdown = value;
  };

  $scope.$on('search.results.loaded', function (event, data) {
    $scope.searchResults = data;
    $scope.searchLoading = false;
  });

  $scope.$on('search.error', function (event, error) {
    console.log(error);
    $scope.searchResults = null;
    $scope.searchLoading = false;
  });



  //  var load = function () {
  //    $rootScope.loading = true;
  //    API.beer.getAll()
  //      .then(function (data) {
  //        $scope.beerList = data.data.data;
  //        this.parsedBeerList = API.parser.namesForAutocomplete(data.data.data);
  //        $('#name.autocomplete').autocomplete({
  //          data: this.parsedBeerList,
  //          onClick: onClick
  //        });
  //        $rootScope.loading = false;
  //      }, function (error) {
  //        $rootScope.modalData = {
  //          title: 'Error: ' + error.data.status,
  //          description: error.data.msg
  //        };
  //        $('#modal').openModal();
  //        $rootScope.loading = false;
  //      });
  //  };

  $scope.performSearch = function () {
    $state.go('Search', {
      beer: $scope.searchText,
      brewery: ''
    });
  };

  $scope.changeSearch = function () {
    $scope.searchLoading = true;
    $search.search($scope.searchText, $scope.searchText);
  };

  $scope.searchSelect = function (item) {
    $scope.setDropdown(false);

    if (item.type == 'beer') {
      $scope.searchText = item.beer.name;
      $state.get('Search').data = {
        showModal: true,
        beerId: item.beer.id
      };
      $state.go('Search', {
        beer: item.beer.name,
        brewery: item.beer.brewery.name
      });
    } else {
      $scope.searchText = item.brewery.name;
      $state.go('Search', {
        beer: '',
        brewery: item.brewery.name
      });
    }
  };

}]);