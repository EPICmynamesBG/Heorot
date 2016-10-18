var app = angular.module('app', ['ui.router']);

//var prodURL = 'http://bgroff-pi2.dhcp.bsu.edu/backend/public';
var devURL = 'http://localhost:8888/Heorot/backend/public';

app.constant('config', {
    dev: true,
    url: devURL
});

app.run(function($rootScope, config) {
    $rootScope.config = config;
});


/* --- Routing --- */

app.config(function ($stateProvider, $urlRouterProvider) {

    $urlRouterProvider.otherwise("/");

    $stateProvider
        .state('main', {
            url: '/',
            templateUrl: "html/main.html",
            controller: 'MainController',
            data: {}
        })
        .state('search', {
            url: "/search",
            templateUrl: "html/search.html?beer&brewery",
            controller: 'SearchController',
            data: {}
        })
        .state('create', {
            url: "/create",
            templateUrl: "html/create.html",
            controller: 'CreateController',
            data: {
                beer: null,
                breweryName: null
            }
        });
});