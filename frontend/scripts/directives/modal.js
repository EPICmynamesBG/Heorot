app.directive('modal', function () {
  return {
    restrict: 'E',
    scope: {
      data: "="
    },
    templateUrl: './html/directives/modal.html'
  }
});