angular.module('app', ['ngRoute']) 
	
	.controller('homeController',function($scope){
		$scope.controllerName = 'homeController';
	})
	.controller('cusController',function($scope, $http){
		$scope.controllerName = 'cusController';
	})
	.controller('cusDetailController',function($scope, $routeParams){
		$scope.controllerName = 'cusDetailController';
	})
	.confic(function($routeProvider){
		$routeProvider
		.when(
				'/',{
					controller:'homeController',
					templateUrl: 'partials/home.html'
				}
			);
	});


    