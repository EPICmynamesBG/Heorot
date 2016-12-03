app.directive('animateNumberOnChange', function ($timeout) {
  var minDuration = 100;
  var maxDuration = 900;
  return {
    restrict: 'A',
    scope: {
      animateNumberOnChange: '='
    },
    transclude: false,
    link: function (scope, element, attrs) {

      function init() {
        //set initial value
        element.text(scope.animateOnChange);

        scope.$watch('animateNumberOnChange', function (newVal, oldVal) {
          var diff = Math.abs(oldVal - newVal);
          var duration = 20 * diff;

          if (duration < minDuration) {
            duration = 100;
          }
          if (duration > maxDuration) {
            duration = 1000;
          }

          element.text(oldVal);
          //halt prior animation first, then apply
          element.stop(true, true, true)
            .prop('Counter', oldVal)
            .animate({
              Counter: newVal
            }, {
              duration: duration,
              easing: 'swing',
              step: function (now) {
                element.text(Math.ceil(now));
              }
            });
        });
      };

      //timeout to allow for initial variable calculation
      $timeout(init, false);

    }
  }
});