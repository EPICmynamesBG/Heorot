app.controller('CreateController', ['$scope', '$state', 'API', '$rootScope', 'Helper', function ($scope, $state, API, $rootScope, Helper) {

  $scope.beerList = [];
  this.parsedBeerList = {};
  $scope.breweryList = [];
  this.parsedBreweryList = {};
  this.locationList = {};

  $('.tooltipped').tooltip({
    delay: 50
  });

  var onClick = function () {
    $scope.newBeer.name = $('#name').val();
    $scope.newBeer.brewery.name = $('#brew-name').val();
    if ($scope.newBeer.brewery.name.length > 0) {
      var brewery = Helper.breweryInList($scope.newBeer.brewery.name, $scope.breweryList);
      if (brewery != null) {
        $scope.newBeer.brewery.location = brewery.location;
      } else {
        $scope.newBeer.brewery.location = $('#brew-location').val();
      }
    } else {
      $scope.newBeer.brewery.location = $('#brew-location').val();
    }

    $scope.$apply();
  };

  var load = function () {
    $scope.newBeer = {};
    $scope.newBeer.brewery = {};
    $rootScope.loading = true;
    var prom1 = new Promise((resolve, reject) => {
      API.beer.getAll()
        .then(function (data) {
          $scope.beerList = data.data.data;
          this.parsedBeerList = API.parser.namesForAutocomplete(data.data.data);
          $('#name.autocomplete').autocomplete({
            data: this.parsedBeerList,
            onClick: onClick
          });
          resolve(this.parsedBeerList);
        }, function (error) {
          reject(error);
        });
    });
    var prom2 = new Promise((resolve, reject) => {
      API.brewery.getAll()
        .then(function (data) {
          $scope.breweryList = data.data.data;
          this.parsedBreweryList = API.parser.namesForAutocomplete(data.data.data);
          this.locationList = API.parser.brewery.locationsForAutocomplete(data.data.data);
          $('#brew-name.autocomplete').autocomplete({
            data: this.parsedBreweryList,
            onClick: onClick
          });
          $('#brew-location.autocomplete').autocomplete({
            data: this.locationList,
            onClick: onClick
          });
          resolve(this.parsedBreweryList);
        }, function (error) {
          reject(error);
        });
    });

    Promise.all([prom1, prom2])
      .then(value => {
        $rootScope.loading = false;
        $rootScope.$apply();
      }, error => {
        $rootScope.modalData = {
          title: 'Error: ' + error.data.status,
          description: error.data.msg
        };
        $('#modal').openModal();
        $rootScope.loading = false;
        $rootScope.$apply();
      });
  };

  load();

  $scope.submit = function () {
    API.beer.create($scope.newBeer)
      .then(function (data) {
        console.log(data);
        $rootScope.modalData = {
          title: 'Success',
          description: data.data.data.name + ' created'
        };
        $('#modal').openModal();
        $rootScope.loading = false;
        load();
      }, function (error) {
        $rootScope.modalData = {
          title: 'Error: ' + error.data.status,
          description: error.data.msg
        };
        $('#modal').openModal();
        $rootScope.loading = false;
        $rootScope.$apply();
      });
  };

}]);