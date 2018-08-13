var app = angular.module('app', ['customerModule','toM']) 
app.controller('login',function($scope){
	$scope.controllerName = 'login';
})

var cus = angular.module('customerModule', [])
cus.controller('customer',function($scope){
	$scope.controllerName = 'customer';
})

var t = angular.module('toM', [])
t.controller('to',function($scope){
	$scope.controllerName = 'to';
})

