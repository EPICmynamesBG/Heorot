app.directive('loading', function () {
  return {
    restrict: 'E',
    scope: {
      size: '='
    },
    templateUrl: './html/directives/loading.html',
    link: function(scope, element, attrs){
      scope.size = attrs.size;
    }
  }
});