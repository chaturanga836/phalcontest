/**
 * Created by LAYOUTindex on 02/12/2018.
 */
(function (window) {

    angular.module('nasa')
        .factory('dataService', dataService);

    function dataService($window,httpService) {


        var getFavorites = function (page) {

            return httpService.get('favorites-get/'+page)
        }

        var manageFavorites = function (id,image) {
            return httpService.post('favorites-manage',{
                'id':id,
                'image':image
            })
        };

        return {
            'getFavorites':getFavorites,
            'manageFavorites':manageFavorites
        }
    }

})(window);