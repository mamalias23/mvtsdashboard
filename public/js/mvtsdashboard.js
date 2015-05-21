angular.module('mvtsdashboard', ['mwl.calendar', 'ui.bootstrap'])

    .controller('ActivitiesController', function($scope, $rootScope, $modal, $http, moment) {

        $scope.calendarDay = moment();
        $scope.calendarView = 'month';
        $scope.calendarTitle = 'test';
        $scope.events = [];
        var getActivities = function() {
            var activities = $http.get('/backend/activities/lists');
            activities.success(function(response) {
                $scope.events = response;
            });
        };

        getActivities();

        function showModal(action, event) {
            $modal.open({
                templateUrl: 'myModalContent.html',
                controller: function($scope, $modalInstance) {
                    $scope.$modalInstance = $modalInstance;
                    $scope.action = action;
                    $scope.event = event;

                    $scope.cancel = function () {
                        $modalInstance.dismiss('cancel');
                    };
                }
            });
        }

        function showAddModal() {
            var modalInstance = $modal.open({
                templateUrl: 'myAddModalContent.html',

                controller: function($scope, $rootScope, $modalInstance, $http) {
                    $scope.$modalInstance = $modalInstance;

                    $scope.cancel = function () {
                        $modalInstance.dismiss('cancel');
                    };

                    $scope.event = {
                        title:'',
                        type:'info',
                        body:'',
                        startsAt:moment().toDate(),
                        endsAt:moment().toDate()
                    };

                    $scope.submitEvent = function() {
                        var event = $http.post('/backend/activities', $scope.event);
                        event.success(function(response) {
                            $scope.responseData = response;
                            $modalInstance.close($scope);
                        });

                        event.error(function(response) {
                           alert(response.error);
                        });
                    };

                    $scope.toggle = function($event, field, event) {
                        $event.preventDefault();
                        $event.stopPropagation();
                        event[field] = !event[field];
                    };
                }
            });

            modalInstance.result.then(function (result) {
                $scope.events.push(result.responseData);
            });
        }

        $scope.eventClicked = function(event) {
            showModal('Clicked', event);
        };

        $scope.eventEdited = function(event) {
            showModal('Edited', event);
        };

        $scope.eventDeleted = function(event) {
            if(confirm('Are you sure you want to delete?')) {
                var del = $http.delete('/backend/activities/'+event.id);
                for(var i = $scope.events.length - 1; i >= 0; i--) {
                    if($scope.events[i].id == event.id) {
                        $scope.events.splice(i, 1);
                    }
                }
            }
        };

        $scope.addEvent = function() {
            showAddModal();
        }

    })
;