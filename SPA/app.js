   angular.module('scotchApp', ['ngRoute'])

    // create the controller and inject Angular's $scope
    .controller('mainController', function($scope) {
        // create a message to display in our view
        $scope.message = 'Everyone come and see how good I look!';
    })

    .controller('aboutController', function($scope) {
        $scope.message = 'Look! I am an about page.';
    })

    .controller('contactController', function($scope, $http){
    	 $scope.message = 'Look! I am an contact.';
    	 $http.get('partials/contact.json')
    	 .success(function(response){
    	 	console.log('ok');
    	 	$scope.contact = response;
    	 })
    })
    .controller('contactDetailController', function($scope, $routeParams){
    	 $scope.message = 'contactDetailController';
    	 $scope.contactId = $routeParams.contactId;
    })


    .config(function($routeProvider) {
        $routeProvider

            // route for the home page
            .when('/', {
                templateUrl : 'partials/home.html',
                controller  : 'mainController'
            })

            // route for the about page
            .when('/about', {
                templateUrl : 'partials/about.html',
                controller  : 'aboutController'
            })

            // route for the contact page
            .when('/contact', {
                templateUrl : 'partials/contact.html',
                controller  : 'contactController'
            })
            .when('/contact/:contactId', {
                templateUrl : 'partials/contactDetail.html',
                controller  : 'contactDetailController'
            })
           .otherwise({
           		redirectTo:'/'
           });
    });
