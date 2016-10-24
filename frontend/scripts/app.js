var app = angular.module('app', ['ui.router']);

var prodURL = 'http://bgroff-pi2.dhcp.bsu.edu/Heorot/backend/public';
var devURL = 'http://localhost:8888/Heorot/backend/public';

app.constant('config', {
  dev: true,
  url: devURL
});

app.run(function ($rootScope, config, $state) {
  $rootScope.config = config;
  $rootScope.$state = $state;
  $rootScope.loading = false;
  $rootScope.modalData = {};
  $(".button-collapse").sideNav({
    closeOnClick: true
  });
});


/* --- Routing --- */

app.config(function ($stateProvider, $urlRouterProvider) {

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