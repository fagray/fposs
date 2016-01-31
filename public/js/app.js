var mod = angular.module('fpossApp',['ngRoute']);



/* Sales Controller */

mod.controller('RegistrarController',function($scope){

	//alert($scope._barcode);
    $scope.find = function(){

    	

        if($scope.barcode.length == 12 ){
        	alert("adsd");
            //auto submit the form
            return false;
        }


    };
});

mod.controller('CategoriesCtrl',function($scope, $http, $location, CategoriesFactory){

	CategoriesFactory.getCategories().success(function(data){

		//alert(data);
		$scope.categories = data;
		//$scope.contactOrders = name;
	});

	/*$scope.remove = function(cat_id){

		var Category = $resource('/categories/:id', { id: cat_id }); 

		category.delete( 
            function() {
                // success
                $location.path('/categories');                     
            },
            function(error) {
                // error
                console.log(error);
            }
        );



	};
*/
	

	/*CategoriesFactory.removeCategory();
		//$scope.categories = data;
		//$scope.contactOrders = name;
	});*/


});



/* Routes Config */

mod.config(function($routeProvider){

	$routeProvider.when('/categories',{

		controller :  'CategoriesCtrl',
		templateUrl : '/partials/settings/categories.html'

	}).when('/categories/:id',{

		controller :  'CategoriesCtrl',
		templateUrl : '/partials/settings/flavors.html'

	}).when('/flavors',{

		//controller :  'CategoriesCtrl',
		templateUrl : '/partials/settings/flavors.html'

	}).when('/coupons',{

		//controller :  'CategoriesCtrl',
		templateUrl : '/partials/settings/coupons.html'

	}).when('/config',{

		//controller :  'CategoriesCtrl',
		templateUrl : '/partials/settings/config.html'

	}).when('/items',{

		controller :  'ItemsCtrl',
		templateUrl : '/partials/items/items.html'

	}).when('/purchase',{

		controller :  'RegistrarController',
		templateUrl : '/partials/registrar/pos.html'

	}).otherwise({

		redirectTo:'/'
	});
});


/* factories */

//categories factory

mod.factory('CategoriesFactory',function($http){

	var factory = {};

	factory.getCategories = function(){

		return $http.get('/categories');
	}

	
	return factory;

});

