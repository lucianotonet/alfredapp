/*global beforeEach, afterEach, describe, it, inject, expect, module, spyOn, fullcalendar, angular, $*/
describe('uiCalendar', function () {
    'use strict';

    var scope, $compile, $locale, $controller;

    //Date Objects needed for event
    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();

    beforeEach(module('ui.calendar'));
    beforeEach(inject(function (_$rootScope_, _$compile_, _$locale_,_$controller_) {
        scope = _$rootScope_.$new();
        $compile = _$compile_;
        $locale = _$locale_;
        $controller = _$controller_;

        // create an array of events, to pass into the directive. 
        scope.events = [
          {title: 'All Day Event',start: new Date(y, m, 1),url: 'http://www.angularjs.org'},
          {title: 'Long Event',start: new Date(y, m, d - 5),end: new Date(y, m, d - 2)},
          {id: 999,title: 'Repeating Event',start: new Date(y, m, d - 3, 16, 0),allDay: false},
          {id: 999,title: 'Repeating Event',start: new Date(y, m, d + 4, 16, 0),allDay: true}];

        // create an array of events, to pass into the directive. 
        scope.events2 = [
          {title: 'All Day Event 2',start: new Date(y, m, 1),url: 'http://www.atlantacarlocksmith.com'},
          {title: 'Long Event 2',start: new Date(y, m, d - 5),end: new Date(y, m, d - 2)},
          {id: 998,title: 'Repeating Event 2',start: new Date(y, m, d - 3, 16, 0),allDay: false},
          {id: 998,title: 'Repeating Event 2',start: new Date(y, m, d + 4, 16, 0),allDay: true}];
        //array to test equals occurance
        scope.events3 = [
          {title: 'All Day Event 3',start: new Date(y, m, 1),url: 'http://www.atlantacarlocksmith.com'},
          {title: 'Long Event 3',start: new Date(y, m, d - 5),end: new Date(y, m, d - 2)},
          {id: 998,title: 'Repeating Event 3',start: new Date(y, m, d - 3, 16, 0),allDay: false},
          {id: 998,title: 'Repeating Event 3',start: new Date(y, m, d + 4, 16, 0),allDay: true}];

        scope.calEventsExt = {
           color: '#f00',
           textColor: 'yellow',
           events: [ 
              {type:'party',title: 'Lunch',start: new Date(y, m, d, 12, 0),end: new Date(y, m, d, 14, 0),allDay: false},
              {type:'party',title: 'Lunch 2',start: new Date(y, m, d, 12, 0),end: new Date(y, m, d, 14, 0),allDay: false},
              {type:'party',title: 'Click for Google',start: new Date(y, m, 28),end: new Date(y, m, 29),url: 'http://google.com/'}
            ]
        };

        // create an array of events, to pass into the directive. 
        scope.events4 = [{title: 'All Day Event 3',start: new Date(y, m, 1),url: 'http://www.yoyoyo.com'}];

        //event Sources array  
        scope.eventSources = [scope.events,scope.events2]; //End of Events Array
        
        scope.addSource = function(source) {
          scope.eventSources.push(source);
        };

        scope.addChild = function(array) {
          array.push({
            title: 'Click for Google ' + scope.events.length,
            start: new Date(y, m, 28),
            end: new Date(y, m, 29),
            url: 'http://google.com/'
          });
        };

        scope.remove = function(array,index) {
          array.splice(index,1);
        };

        scope.uiConfig = {
          calendar:{
            height: 200,
            weekends: false,
            defaultView: 'month'
          }
        };
         
    }));

    describe('compiling this directive and checking for events inside the calendar', function () {
        
        beforeEach(function(){
            spyOn($.fn, 'fullCalendar');
            $compile('<div ui-calendar="uiConfig.calendar" ng-model="eventSources"></div>')(scope);
            scope.$apply();
        });

        /* test the calendar's initial setup */
        it('should set up the calendar with the correct options and events', function () {
            expect($.fn.fullCalendar.mostRecentCall.args[0].eventSources[0].length).toBe(4);
            expect($.fn.fullCalendar.mostRecentCall.args[0].eventSources[0][0].title).toBe('All Day Event');
            expect($.fn.fullCalendar.mostRecentCall.args[0].eventSources[0][0].url).toBe('http://www.angularjs.org');
            expect($.fn.fullCalendar.mostRecentCall.args[0].eventSources[1][0].url).toBe('http://www.atlantacarlocksmith.com');
            expect($.fn.fullCalendar.mostRecentCall.args[0].eventSources[0][3].allDay).toNotBe(false);
            expect($.fn.fullCalendar.mostRecentCall.args[0].height).toEqual(200);  
            expect($.fn.fullCalendar.mostRecentCall.args[0].weekends).toEqual(false);
        });
        /* Test to make sure that when an event is added to the calendar everything is updated with the new event. */
        it('should call its renderEvent method', function () {
            expect($.fn.fullCalendar.mostRecentCall.args[0].eventSources[0].length).toEqual(4);
            expect($.fn.fullCalendar.callCount).toEqual(1);
            scope.addChild(scope.events);
            scope.$apply();
            expect($.fn.fullCalendar.callCount).toEqual(2);
            expect($.fn.fullCalendar.mostRecentCall.args[0]).toEqual('renderEvent');
            scope.addChild(scope.events);
            scope.$apply();
            expect($.fn.fullCalendar.callCount).toEqual(3);
            expect($.fn.fullCalendar.mostRecentCall.args[0]).toEqual('renderEvent');
        });
        /* Test to see if calendar is calling removeEvents when an event is removed */
        it('should remove the correct event from the event source.', function () {
            //remove an event from the scope.
            scope.remove(scope.events2,0);
            scope.$apply();
            //events should auto update inside the calendar. 
            var fullCalendarParam = $.fn.fullCalendar.mostRecentCall.args[0];
            var callCount = $.fn.fullCalendar.callCount;
            expect(fullCalendarParam).toEqual('removeEvents');
            expect(callCount).toEqual(2);
            scope.remove(scope.events,0);
            scope.$apply();
            fullCalendarParam = $.fn.fullCalendar.mostRecentCall.args[0];
            callCount = $.fn.fullCalendar.callCount;
            expect(fullCalendarParam).toEqual('removeEvents');
            expect(callCount).toEqual(3);
        });
        /* Test to see if calendar is updating when a new eventSource is added. */
        it('should update the calendar if an eventSource is Added', function () {
            scope.addSource(scope.events4);
            scope.$apply();
            //eventSources should auto update inside the calendar. 
            var fullCalendarParam = $.fn.fullCalendar.mostRecentCall.args[0];
            expect(fullCalendarParam).toEqual('addEventSource');
        });
        /* Test to see if calendar is updating when an eventSource replaces another with an equal length. */
        it('should update the calendar if an eventSource has same length as prior eventSource', function () {
            //replace source with one that has the same length
            scope.eventSources.splice(1,1,scope.events3);
            scope.$apply();
            //eventSources should update inside the calendar
            var callCount =  $.fn.fullCalendar.callCount;
            var fullCalendarParam = $.fn.fullCalendar.mostRecentCall.args[0];
            expect(fullCalendarParam).toEqual('addEventSource');
            //fullcalendar has called 3 of its own events at this time. Remove, Add, and Rerender
            expect(callCount).toEqual(3);
            //remove an event to prove autobinding still works
            scope.remove(scope.events,0);
            scope.$apply();
            fullCalendarParam = $.fn.fullCalendar.mostRecentCall.args[0];
            callCount =  $.fn.fullCalendar.callCount;
            expect(fullCalendarParam).toEqual('removeEvents');
            expect(callCount).toEqual(4);
        });

        it('should work with extended event sources', function () {
            scope.eventSources.push(scope.calEventsExt);
            scope.$apply();
            var fullCalendarParam = $.fn.fullCalendar.mostRecentCall.args[0];
            expect(fullCalendarParam).toEqual('addEventSource');
        });

        it('should make sure that if we just change the title of the event that it updates itself', function () {
            scope.events[0].title = 'change title';
            scope.$apply();
            var fullCalendarParam = $.fn.fullCalendar.mostRecentCall.args[0];
            var fullCalendarParam1  = $.fn.fullCalendar.mostRecentCall.args[1];
            expect(fullCalendarParam).toEqual('updateEvent');
            expect(fullCalendarParam1).toEqual(scope.events[0]);
        });

        it('should make sure that if the calendars options change then the fullcalendar method is called with the new options', function () {
            expect($.fn.fullCalendar.mostRecentCall.args[0].weekends).toEqual(false);
            scope.uiConfig.calendar.weekends = true;
            scope.$apply();
            //3 because we are destroying the calendar as well. 
            expect($.fn.fullCalendar.callCount).toEqual(3);
            expect($.fn.fullCalendar.mostRecentCall.args[0].weekends).toEqual(true);
        });

    });

    describe('calendarCtrl changeWatcher functionality', function(){
        
        var calendar,
            calendarCtrl,
            sourcesChanged;

        function onFnAdd(source) {
            sourcesChanged = 'added';
        }

        function onFnRemove(source) {
            sourcesChanged = 'removed';
        }

        function onFnChanged(source) {
            sourcesChanged = 'changed';
        }

        beforeEach(function(){
          calendarCtrl = $controller('uiCalendarCtrl', {$scope: scope, $element: null});
          sourcesChanged = false;
          scope.$apply();
        });

        it('should make sure changeWatcher is initialized', function () {
          expect(calendarCtrl.changeWatcher).not.toBe(undefined);
        });

        it('should make sure the correct function is called when an event source is added or removed', function () {
          var sourceWatcher = calendarCtrl.changeWatcher(scope.eventSources,calendarCtrl.sourcesFingerprint);
          expect(sourcesChanged).toBe(false);
          sourceWatcher.subscribe(scope);
          sourceWatcher.onAdded = onFnAdd;
          sourceWatcher.onRemoved = onFnRemove;
          scope.$apply();
          scope.eventSources.push(scope.events3);
          scope.$apply();
          expect(sourcesChanged).toBe('added');
          scope.eventSources.splice(0,1);
          scope.$apply();
          expect(sourcesChanged).toBe('removed');
        });

        it('should make sure the correct function is called when a single event is added or removed', function () {
          var eventsWatcher = calendarCtrl.changeWatcher(calendarCtrl.allEvents,calendarCtrl.eventsFingerprint);
          expect(sourcesChanged).toBe(false);
          eventsWatcher.subscribe(scope);
          eventsWatcher.onAdded = onFnAdd;
          eventsWatcher.onRemoved = onFnRemove;
          eventsWatcher.onChanged = onFnChanged;
          scope.$apply();
          scope.events2.push({id: 8,title: 'Repeating Event 2',start: new Date(y, m, d - 3, 16, 0),allDay: false});
          scope.$apply();
          expect(sourcesChanged).toBe('added');
          scope.events2.splice(0,1);
          scope.$apply();
          expect(sourcesChanged).toBe('removed');
          scope.events2[0].title = 'tester :)';
          scope.$apply();
          expect(sourcesChanged).toBe('changed');
        });

        it('should make sure the correct function is called when the calendarWatchEvent function is return variable is altered', function () {
          scope.testX = 0;

          scope.calendarWatchEvent = function(){
            return scope.testX;
          };

          var calendarCtrl2 = $controller('uiCalendarCtrl', {$scope: scope, $element: null});
          scope.$apply();

          var eventsWatcher = calendarCtrl2.changeWatcher(calendarCtrl2.allEvents,calendarCtrl2.eventsFingerprint);
          expect(sourcesChanged).toBe(false);
          eventsWatcher.subscribe(scope);
          eventsWatcher.onAdded = onFnAdd;
          eventsWatcher.onRemoved = onFnRemove;
          eventsWatcher.onChanged = onFnChanged;
          scope.$apply();
          scope.testX++;
          scope.$apply();
          expect(sourcesChanged).toBe('changed');
        });

        it('should make sure that eventSources in extended form are tracked properly', function () {
          scope.testX = 0;
          scope.eventSources.push(scope.calEventsExt);
          var calendarCtrl2 = $controller('uiCalendarCtrl', {$scope: scope, $element: null});
          scope.$apply();
          var eventsWatcher = calendarCtrl2.changeWatcher(calendarCtrl2.allEvents,calendarCtrl2.eventsFingerprint);
          expect(sourcesChanged).toBe(false);
          eventsWatcher.subscribe(scope);
          eventsWatcher.onAdded = onFnAdd;
          eventsWatcher.onRemoved = onFnRemove;
          eventsWatcher.onChanged = onFnChanged;
          scope.$apply();
          scope.calEventsExt.events[0].title = 'Brunch';
          scope.$apply();
          expect(sourcesChanged).toBe('changed');
          scope.calEventsExt.events[0].title = 'Brunch';
          scope.calEventsExt.events.push({type:'party',title: 'Bunch 2',start: new Date(y, m, d, 12, 0),end: new Date(y, m, d, 14, 0),allDay: false});
          scope.$apply();
          expect(sourcesChanged).toBe('added');
          scope.calEventsExt.events[0].title = 'Brunch';
          scope.calEventsExt.events.splice(0,1);
          scope.$apply();
          expect(sourcesChanged).toBe('removed');
        });
    });

    describe('Testing the ability to add calendars to the scope', function(){

         beforeEach(function(){
            spyOn($.fn, 'fullCalendar');
            expect(scope.myCalendar).toBe(undefined);
            $compile('<div ui-calendar="uiConfig.calendar" calendar="myCalendar" ng-model="eventSources"></div>')(scope);
            scope.$apply();
         });

         it('should make sure the calendar sets the myCalendar object to the defining scope', function () {
            expect(scope.myCalendar).not.toBe(undefined);
         });
    });

    describe('Local variable config testing and option overriding', function(){

        it('should set names for $locale by default', function() {
            spyOn($.fn, 'fullCalendar');
            $locale.DATETIME_FORMATS.MONTH[0] = 'enero';
            $compile('<div ui-calendar="uiConfig.calendar" ng-model="eventSources"></div>')(scope);
            scope.$apply();
            expect($.fn.fullCalendar.mostRecentCall.args[0].monthNames[0]).toBe('enero');
        });

        it('should allow overriding names for $locale', function() {
          spyOn($.fn, 'fullCalendar');
          scope.uiConfig.calendar.monthNames = $locale.DATETIME_FORMATS.MONTH.slice();
          scope.uiConfig.calendar.monthNames[0] = 'custom name';
          $compile('<div ui-calendar="uiConfig.calendar" ng-model="eventSources"></div>')(scope);
          scope.$apply();
          expect($.fn.fullCalendar.mostRecentCall.args[0].monthNames[0]).toBe('custom name');
        });

         /* Test to make sure header options can be overwritten */
        it('should overwrite default header options', function () {
            spyOn($.fn, 'fullCalendar');
            scope.uiConfig2 = {
              calendar:{
                header: {center: 'title'} 
             }
            };
            $compile('<div ui-calendar="uiConfig2.calendar" ng-model="eventSources"></div>')(scope);
            scope.$apply();
            expect($.fn.fullCalendar.mostRecentCall.args[0].hasOwnProperty('header')).toEqual(true);
            var header = $.fn.fullCalendar.mostRecentCall.args[0].header;
            expect(header).toEqual({center: 'title'});
        });
    });

    describe('Describing calendarCtrl and its configurations functions', function(){
        
        var calendarCtrl;

        beforeEach(function(){
          calendarCtrl = $controller('uiCalendarCtrl', {$scope: scope, $element: null});
          scope.$apply();
        });

        it('should make sure that all config functions are called in an angular context', inject(function($timeout, $rootScope){
          var functionCount = 0;
          scope.uiConfig = {
            calendar:{
              height: 200,
              weekends: false,
              defaultView: 'month',
              dayClick: function(){},
              eventClick: function(){},
              eventDrop: function(){},
              eventResize: function(){},
              eventMouseover: function(){}
            }
          };

          spyOn($rootScope,'$apply');

          angular.forEach(scope.uiConfig.calendar, function(value,key){
            if (typeof value === 'function'){
              functionCount++;
              spyOn(scope.uiConfig.calendar, key);

              var fullCalendarConfig = calendarCtrl.getFullCalendarConfig(scope.uiConfig.calendar, {});

              fullCalendarConfig[key]();
              $timeout.flush();
              expect($rootScope.$apply.callCount).toBe(functionCount);
              expect(scope.uiConfig.calendar[key]).toHaveBeenCalled();
              $rootScope.$apply.isSpy = false;
            }
          });
        }));

        it('should make sure that any function that already has an apply in it does not break the calendar (backwards compatible)', inject(function($timeout, $rootScope){
          
          var functionCount = 0;
          scope.uiConfig = {
            calendar:{
              height: 200,
              weekends: false,
              defaultView: 'month',
              dayClick: function(){scope.$apply();},
              eventClick: function(){scope.$apply();},
              eventDrop: function(){scope.$apply();},
              eventResize: function(){scope.$apply();},
              eventMouseover: function(){scope.$apply();}
            }
          };
          
          spyOn($rootScope,'$apply');

          angular.forEach(scope.uiConfig.calendar, function(value,key){
            if (typeof value === 'function'){
              functionCount++;
              spyOn(scope.uiConfig.calendar, key);

              var fullCalendarConfig = calendarCtrl.getFullCalendarConfig(scope.uiConfig.calendar, {});

              fullCalendarConfig[key]();
              
              scope.$apply();
              $timeout.flush();
              expect($rootScope.$apply.callCount).toBe(functionCount*2);
              expect(scope.uiConfig.calendar[key]).toHaveBeenCalled();
            }
          });
        }));
    });

});