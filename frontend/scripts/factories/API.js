app.factory('API', ['config', '$http', function (config, $http) {

    var factory = {};

    var beer = {};
    var brewery = {};

    beer.getAll = function () {
        return $http({
            method: 'GET',
            url: config.url + '/beers'
        });
    };

    beer.getById = function (id) {
        return $http({
            method: 'GET',
            url: config.url + '/beer/' + id
        });
    };

    beer.create = function (beerData) {
        var data = {
            
        };
        return $http({
            method: 'POST',
            url: config.url + '/beer',
            headers: {
                'Content-Type': 'application/json'
            },
            data: data
        });
    };

    brewery.getAll = function () {
        return $http({
            method: 'GET',
            url: config.url + '/breweries'
        });
    };
    
    brewery.getById = function(brewId) {
        return $http({
            method: 'GET',
            url: config.url + '/brewery/' + brewId
        });
    };

    factory.brewery = brewery;
    factory.beer = beer;
    return factory;

}]);