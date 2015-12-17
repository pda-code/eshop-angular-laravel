appModule.factory('collectionService', ['dataContext', '$rootScope', '$location', function (dataContext, $rootScope, $location) {

    var service = function (fetcher, params) {

        var self = this;

        self.items = [];
        self.inProgress = false;
        self.fetcher=fetcher;

        //steady default parameters
        self.inititalParams= params || {}

        //pager
        self.pager = {
            page_index:1,
            page_size:10,
            page_sizes: [5, 10, 20, 50, 100],
            page_slide: 5,
            total_records:0,
            total_pages:0,
        };

        self.refresh = function () {
            return self.load();
        };

        self.load = function (params) {
            //initial state
            var requestParams = angular.extend({},self.inititalParams,params);

            return self.fetcher(requestParams)
			    .success(function (data) {
			        self.items=data.data;

                    self.pager.total_pages=data.last_page;
                    self.pager.total_records=data.total;
                    self.pager.page_index=data.current_page;
                    self.pager.page_size=data.per_page;
			    })
			    .error(function (data, status, headers, config) {
			        self.pager.total_records = 0;
			    });
        };

        self.pageChanged = function (fromClick) {
            if (!fromClick) return;
            self.load({paging:[self.pager.page_index,self.pager.page_size]});
        };

        self.pageSizeChanged = function () {
            self.load({paging:[self.pager.page_index,self.pager.page_size]});
        };


        /*
        self.sortDirectionChanged = function () {
            self.state.sortDirection = (self.state.sortDirection == "Asc" ? "Desc" : "Asc");
            self.refresh();
        };

        self.sortColumnChanged = function (column) {
            self.state.sortColumn = column;
            self.refresh();
        };

        self.selectedItemChanged = function (item) {
            self.selectedItem = item;
        };
         */
    };

    return {
        createInstance: function (fetcher, params) {
            return new service(fetcher, params);
        }
    };
}]);