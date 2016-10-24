app.service('$search', ['config', '$http', '$rootScope', '$q', function (config, $http, $rootScope, $q) {

  this.canceller = $q.defer();
  this.status = "No Request";
  
//  var parseForAutocomplete = function (data) {
//    var parsed = {};
//    data.beers.forEach(function (item) {
//      var key = item.name;
//      parsed[key] = null;
//    });
//    data.breweries.forEach(function (item) {
//      var key = item.name;
//      parsed[key] = null;
//    });
//    return parsed;
//  };

  var broadcastSearchResults = function (data) {
    $rootScope.$broadcast('search.results.loaded', data.data);
  };

  var broadcastSearchError = function (error) {
    $rootScope.$broadcast('search.error', error);
  };

  this.search = function (beer, brewery, style) {
    
    if ($http.pendingRequests.length <= 0) {
      //If I use get method here, clicking the "Send Request" button will cancel the previous request and start
      //a new request. While for post, it won't work
      $http.get(config.url + '/search?beer=' + beer + '&brewery=' + brewery + '&style=' + style, {
        timeout: this.canceller.promise,
        headers: {
          "Content-Type": "application/json"
        }
      }).success(function (data) {
        broadcastSearchResults(data);
        this.status = "Success";
      }).error(function (error) {
        console.log(error);
        this.status = "No Request";
      });
    } else {

      this.canceller.resolve();
      //Re-initialize the canceller after it is resolved, otherwise it will cancel all the incoming request.
      this.canceller = $q.defer();
      this.status = "Request Cancelled and new request pending";
      //Then start a new request
      //If I use get method here, clicking the "Send Request" button will cancel the previous request and start
      //a new request. While for post, it won't work
      $http.get(config.url + '/search?beer=' + beer + '&brewery=' + brewery + '&style=' + style, {
        timeout: this.canceller.promise,
        headers: {
          "Content-Type": "application/json"
        }
      }).success(function (data) {
        broadcastSearchResults(data);
        this.status = "Success"
      }).error(function (error) {
        console.log(error);
        this.status = "No Request";
      });
      this.status = "Request Pending";
    }
  };
}]);