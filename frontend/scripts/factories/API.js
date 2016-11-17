app.factory('API', ['config', '$http', '$rootScope', 'CacheFactory', function (config, $http, $rootScope, CacheFactory) {

    var factory = {};

    var beer = {};
    var brewery = {};
    var parser = {};
    var style = {};

    if (!CacheFactory.get('beerCache')) {
        CacheFactory.createCache('beerCache', {});
    }
    var beerCache = CacheFactory.get('beerCache');

    if (!CacheFactory.get('breweryCache')) {
        CacheFactory.createCache('breweryCache', {});
    }
    var breweryCache = CacheFactory.get('breweryCache');

    if (!CacheFactory.get('styleCache')) {
        CacheFactory.createCache('styleCache', {});
    }
    var styleCache = CacheFactory.get('styleCache');

    var offlineError = function () {
        return new Promise(function (resolve, reject) {
            reject(new Error("Offline", {
                config: null,
                data: null,
                headers: null,
                status: -1,
                statusText: 'Offline'
            }));
        });
    }

    parser.brewery = {};

    parser.namesForAutocomplete = function (dataArray) {
        var parsed = {};
        if (dataArray.length == 0) {
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
        if (dataArray.length == 0) {
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
            url: config.url + '/beers',
            cache: beerCache
        });
    };

    beer.getById = function (id) {
        return $http({
            method: 'GET',
            url: config.url + '/beer/' + id,
            cache: beerCache
        });
    };

    beer.create = function (beerData) {
        if ($rootScope.offline) {
            return offlineError();
        }

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
            url: config.url + '/breweries',
            cache: breweryCache
        });
    };

    brewery.getById = function (brewId) {
        return $http({
            method: 'GET',
            url: config.url + '/brewery/' + brewId,
            cache: breweryCache
        });
    }

    style.getAll = function () {
        return $http({
            method: 'GET',
            url: config.url + '/styles',
            cache: styleCache
        });
    };

    factory.style = style;
    factory.parser = parser;
    factory.brewery = brewery;
    factory.beer = beer;
    return factory;

}]);