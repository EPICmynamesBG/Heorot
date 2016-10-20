app.directive('beerModal', function () {
  return {
    restrict: 'E',
    scope: {
      data: "="
    },
    templateUrl: './html/directives/beerModal.html'
  }
});