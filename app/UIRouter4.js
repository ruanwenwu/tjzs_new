var APP = angular.module('APP', ['ngAnimate','ui.router']);

APP.run(function($animate) {
  $animate.enabled(true);
});

APP.config(function($stateProvider, $urlRouterProvider) {
  $urlRouterProvider.otherwise("/home");
  $stateProvider
    .state('home', {
      url: "/home",
      templateUrl: "tpl4/home.html"
    })
    .state('contact', {
      url: "/contact",
      templateUrl: "tpl4/contact.html",
      controller: function($scope) {
          //$scope.leftorright = false;
      }
    })
    .state('about', {
      url: "/about",
      templateUrl: "tpl4/about.html"
    });
});

APP.controller('MainCtrl', function ($scope) {
    $scope.leftorright = true;
});