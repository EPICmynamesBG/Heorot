app.factory('Helper', [ function () {

  var factory = {};
  
  factory.beerInList = function(name, list) {
    for (var i = 0; i < list.length; i++) {
      var beer = list[i];
      if (beer.name == name) {
        return beer;
      }
    }
    return null;
  };
  
  factory.breweryInList = function(name, list) {
    for (var i = 0; i < list.length; i++) {
      var brewery = list[i];
      if (brewery.name == name){
        return brewery;
      }
    }
    return null;
  }
  
  return factory;

}]);