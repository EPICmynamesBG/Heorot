app.controller('CreateController', ['$scope', '$state', 'API', '$rootScope', 'Helper', function ($scope, $state, API, $rootScope, Helper) {

    $scope.beerList = [];
    this.parsedBeerList = {};
    $scope.breweryList = [];
    this.parsedBreweryList = {};
    this.locationList = {};
    $scope.styleList = [];
    this.parsedStyleList = {};


    $('.tooltipped').tooltip({
        delay: 50
    });

    var onClick = function () {
        $scope.newBeer.name = $('#name').val();
        $scope.newBeer.brewery.name = $('#brew-name').val();
        $scope.newBeer.style.name = $('#style').val();
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
        var prom3 = new Promise((resolve, reject) => {
            API.style.getAll()
                .then(function (data) {
                    $scope.styleList = data.data.data;
                    this.parsedStyleList = API.parser.namesForAutocomplete(data.data.data);
                    $('#style.autocomplete').autocomplete({
                        data: this.parsedStyleList,
                        onClick: onClick
                    });
                    resolve(this.parsedStyleList);
                }, function (error) {
                    reject(error);
                });
        });

        Promise.all([prom1, prom2, prom3])
            .then(value => {
                $rootScope.loading = false;
                $rootScope.$apply();
            }, error => {
                console.log(error);
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
  
    var idForBrewery = function(brewery) {
        for (var i = 0; i < $scope.breweryList.length; i++){
            var brew = $scope.breweryList[i];
            if (brew.name == brewery){
                return brew.id;
            }
        }
        return undefined;
    };
  
    var idForStyle = function(style) {
        for (var i = 0; i < $scope.styleList.length; i++) {
            var sty = $scope.styleList[i];
            if (sty.name == style) {
                return sty.id;
            }
        }
        return undefined;
    }

    $scope.submit = function () {
        
        //use ID for Style and Brewery, if possible
        $scope.newBeer.brewery.id = idForBrewery($scope.newBeer.brewery.name);
        $scope.newBeer.style.id = idForStyle($scope.newBeer.style.name);
      
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