var app = angular.module('app', ['ui.router', 'angular-cache']);

var prodURL = 'http://dev.brandongroff.com/Heorot/backend/public';
//var prodURL = 'http://bgroff-pi2.dhcp.bsu.edu/Heorot/backend/public';
var devURL = 'http://localhost:8888/Heorot/backend/public';

app.constant('config', {
  dev: true,
  url: devURL
});

app.run(function ($rootScope, config, $state, $http) {
  /*  Offline app handling */

  $rootScope.offline = navigator.onLine ? false : true;
  $rootScope.$apply();

  if (window.addEventListener) {
    window.addEventListener("online", function () {
      $rootScope.offline = false;
      $rootScope.$apply();
    }, true);
    window.addEventListener("offline", function () {
      $rootScope.offline = true;
      $rootScope.$apply();
    }, true);
  } else {
    document.body.ononline = function () {
      $rootScope.offline = false;
      $rootScope.$apply();
    };
    document.body.onoffline = function () {
      $rootScope.offline = true;
      $rootScope.$apply();
    };
  }



  /* End offline handling */

  $rootScope.config = config;
  $rootScope.$state = $state;
  $rootScope.loading = false;
  $rootScope.modalData = {};
  $rootScope.beerModalData = {};

  $(".button-collapse").sideNav({
    closeOnClick: true
  });
});


/* --- Routing --- */

app.config(function ($stateProvider, $urlRouterProvider, config, CacheFactoryProvider, $locationProvider) {
  angular.extend(CacheFactoryProvider.defaults, {
    maxAge: 3600000,
    deleteOnExpire: 'aggressive',
    onExpire: function (key, value) {
      var _this = this; // "this" is the cache in which the item expired
      angular.injector(['ng']).get('$http').get(key).success(function (data) {
        _this.put(key, data);
      });
    },
    storageMode: 'localStorage',
    storagePrefix: 'heorot'
  });

  $locationProvider.html5Mode({
    enabled: true,
    requireBase: true
  });

  $urlRouterProvider.otherwise("/");

  $stateProvider
    .state('Home', {
      url: '/',
      templateUrl: "html/main.html",
      controller: 'MainController',
      data: {}
    })
    .state('Search', {
      dynamic: true,
      url: "/search?beer&brewery&style&sort",
      templateUrl: "html/search.html",
      controller: 'SearchController',
      data: {
        showModal: false,
        modalBeerId: -1
      }
    })
    .state('Create', {
      url: "/create",
      templateUrl: "html/create.html",
      controller: 'CreateController',
      data: {
        beer: null,
        breweryName: null
      }
    });
});


/* *******************************************************************
      This will inform visitors that the website is done downloading itself
      onto their device, making it safe to go offline.
      ******************************************************************* */

window.applicationCache.addEventListener('cached', function () {
  console.log('Application downloaded. It’s safe to go offline now.');
}, false);

/* *******************************************************************
This will inform visitors that the website has been updated, and it
will ask them to accept or reject the updated resource(s). This
occurs when three things happen:
1. The visitor has downloaded your website in the past
2. You have updated one or more resources AND the cache manifest
3. The visitor accesses the website, again, while they're online
******************************************************************* */

window.addEventListener('load', function () {
  window.applicationCache.addEventListener('updateready', function () {
    if (window.applicationCache.status === window.applicationCache.UPDATEREADY) {
      console.log("Reloading new version");
      window.location.reload();
    }
  }, false);
}, false);