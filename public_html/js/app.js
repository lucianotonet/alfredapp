//var despesasApp  = angular.module('despesasApp', ['mainCtrl', 'despesasService']);

// angular.module('project', ['ngRoute', 'firebase'])
 
// .value('fbURL', 'https://tonet.firebaseio.com/')
 
// .factory('Projects', function($firebase, fbURL) {
//   return $firebase(new Firebase(fbURL)).$asArray();
// })
 
// .config(function($routeProvider) {
//   $routeProvider
//     .when('/', {
//       controller:'ListCtrl',
//       templateUrl:'app/tarefas/views/list.html'
//     })
//     .when('/edit/:projectId', {
//       controller:'EditCtrl',
//       templateUrl:'app/tarefas/views/detail.html'
//     })
//     .when('/new', {
//       controller:'CreateCtrl',
//       templateUrl:'app/tarefas/views/detail.html'
//     })
//     .otherwise({
//       redirectTo:'/'
//     });
// })
 
// .controller('ListCtrl', function($scope, Projects) {
//   $scope.projects = Projects;
// })
 
// .controller('CreateCtrl', function($scope, $location, $timeout, Projects) {
//   $scope.save = function() {
//       Projects.$add($scope.project).then(function(data) {
//           $location.path('/');
//       });
//   };
// })
 
// .controller('EditCtrl',
//   function($scope, $location, $routeParams, Projects) {
//     var projectId = $routeParams.projectId,
//         projectIndex;
 
//     $scope.projects = Projects;
//     projectIndex = $scope.projects.$indexFor(projectId);
//     $scope.project = $scope.projects[projectIndex];
 
//     $scope.destroy = function() {
//         $scope.projects.$remove($scope.project).then(function(data) {
//             $location.path('/');
//         });
//     };
 
//     $scope.save = function() {
//         $scope.projects.$save($scope.project).then(function(data) {
//            $location.path('/');
//         });
//     };
// });