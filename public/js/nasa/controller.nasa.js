(function(window){
    angular.module('nasa')
        .controller('dataController', dataController);

    dataController.$inject = ['$window','dataService'];

    function dataController($window,dataServices) {

        var vm = this;
        var page= 1;

        vm.favorites = [];

        var successLoad = function (resp) {

            for(var i in resp.data){
                vm.favorites.push( resp.data[i]);
            }
            page +=1;

        };

        var failLoad = function (resp) {

        }

        dataServices.getFavorites(page).then(successLoad,failLoad);


        vm.manageFavorites = function (obj) {
            dataServices.manageFavorites(obj.id,obj.img_src)
                .then(manageFavoritesSuccess,manageFavoritesFailed)
        }
        
        var manageFavoritesSuccess = function (resp) {

            for(var i in vm.favorites){
                if( vm.favorites[i].id ==  resp.data.id){

                    vm.favorites[i].status = resp.data.status;
                    console.log(vm.favorites[i])
                    break;

                }
            }
        };
        
        var manageFavoritesFailed = function (resp) {
            
        }

        vm.loadMore = function () {
            dataServices.getFavorites(page).then(successLoad,failLoad);
        }


    }
}(window));
