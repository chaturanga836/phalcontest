/**
 * Created by LAYOUTindex on 6/13/2017.
 */
(function(window){
    angular
        .module('httpService',[])
        .constant('baseUrl',window.base_url)
        .service('httpService', httpService);

    function httpService(baseUrl, $http, $q) {

        this.headerObj = {'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest'};
        var headerObj = this.headerObj;

        this.post = function (route, param) {

            return $http({
                method: 'POST',
                url: window.base_url + route,
                headers: headerObj,
                data: param
            });

        };


        this.get = function (route, param) {

            options = {
                method: "GET",
                url: window.base_url + route,
                headers: headerObj
            };


            if (param !== undefined || param !== null) {
                options.params = param;
            }

            return $http(options);

        };
    }




})(window);