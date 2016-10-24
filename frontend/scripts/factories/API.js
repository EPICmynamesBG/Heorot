app.factory('API', ['config', '$http', function (config, $http) {

    var factory = {};

    var beer = {};
    var brewery = {};
    var parser = {};
    var style = {};
    parser.brewery = {};

    parser.namesForAutocomplete = function (dataArray) {
        var parsed = {};
        if (dataArray.length == 0){
            return parsed;
        }
        dataArray.forEach(function (item) {
            var key = item.name;
            parsed[key] = null;
        });
        return parsed;
    };

    parser.brewery.locationsForAutocomplete = function (dataArray) {
        var parsed = {};
        if (dataArray.length == 0){
            return parsed;
        }
        dataArray.forEach(function (item) {
            var key = item.location;
            parsed[key] = null;
        });
        return parsed;
    };

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
        return $http({
            method: 'POST',
            url: config.url + '/beer',
            headers: {
                'Content-Type': 'application/json'
            },
            data: beerData
        });
    };

    brewery.getAll = function () {
        return $http({
            method: 'GET',
            url: config.url + '/breweries'
        });
    };

    brewery.getById = function (brewId) {
        return $http({
            method: 'GET',
            url: config.url + '/brewery/' + brewId
        });
    };

    style.getAll = function () {
        return $http({
            method: 'GET',
            url: config.url + '/styles'
        });
    };

    factory.style = style;
    factory.parser = parser;
    factory.brewery = brewery;
    factory.beer = beer;
    return factory;

}]);