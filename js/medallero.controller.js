(function () {
    'use strict';
    
     angular.module('app.medallero')
     .controller('IndexCtrl',['$scope','$http',IndexCtrl])
     .controller('InputCtrl',['$scope','$http',InputCtrl]);
     
     function IndexCtrl($scope,$http)
     {
        $scope.create_f = function()
        {
            
        }
        /*$scope.participantes = [{nombre:'bernardo'},{nombre:'danira'}];
        $scope.options = {
            
            dropped: function(scope) {
                
                var group_id     = scope.source.nodeScope.$modelValue.navigation_group_id,
                    model_values = $scope.list[group_id],
                    form_data    = {},
                    order = [] ;
                    
                    
                    
                
               
                angular.forEach(model_values,function(item,index){
                    
                         
                    
                  
                    
                    order[index]=set_node(index,item);
                    
                    
                    
                    
                });
                
               form_data={
                  data  :{group:group_id},
                  order : order
               };
                
                
                
                $http.post(SITE_URL+'admin/navigation/order',form_data);
            }
        };*/
     }
     function InputCtrl($scope,$http)
     {
        $scope.fecha_ini=new Date();
        $scope.fecha_fin=new Date();
     
        
       
        
        
        
        /****datepicker****/
        $scope.openCalendar = function($event) {
            $scope.status.opened = true;
        };
        
        $scope.dateOptions = {
            formatYear: 'yy',
            startingDay: 1
        };
     }
})(); 