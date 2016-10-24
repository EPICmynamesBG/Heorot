app.controller('SearchController', ['$scope', '$state', 'API', '$rootScope', '$stateParams', function ($scope, $state, API, $rootScope, $stateParams) {

    $scope.filter = {};
    $scope.filter.brewery = {};
    $scope.filter.style = {};
    $scope.filter.name = $stateParams.beer;
    $scope.filter.brewery.name = $stateParams.brewery;
    $scope.filter.style.name = $stateParams.style;

    $scope.beerList = [];
    $scope.beerModalData = {};

    var load = function () {
        $rootScope.loading = true;

        API.beer.getAll()
            .then(function (data) {
                $scope.beerList = data.data.data;
                $rootScope.loading = false;
            }, function (error) {
                $rootScope.modalData = {
                    title: 'Error: ' + error.data.status,
                    description: error.data.msg
                };
                $('#modal').openModal();
                $rootScope.loading = false;
            });
    };

    load();

    $scope.viewBeer = function (beerId) {
        API.beer.getById(beerId)
            .then(function (data) {
                $scope.beerModalData = data.data.data;
                console.log($scope.beerModalData);
                $('#beer-modal').openModal();
                $('.collapsible').collapsible({
                    accordion: false
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
    };

    $scope.applyFilter = function () {
        $state.go('Search', {
            beer: $scope.filter.name,
            brewery: $scope.filter.brewery.name,
            style: $scope.filter.style.name
        }, {
            notify: false,
            location: "replace"
        });
    };

    $scope.clearFilter = function (filterType) {
        if (filterType == 'beer') {
            $scope.filter.name = '';
        } else if (filterType == 'brewery') {
            $scope.filter.brewery.name = '';
        } else {
            $scope.filter.style.name = '';
        }

        $state.go('Search', {
            beer: $scope.filter.name,
            brewery: $scope.filter.brewery.name,
            style: $scope.filter.style.name
        }, {
            notify: false,
            location: "replace"
        });
    }

    //throw the modal from the nav bar
    if ($state.current.data.showModal) {
        $scope.viewBeer($state.current.data.beerId);
        $state.current.data.showModal = false;
        $state.current.data.beerId = -1;
    }

}]);