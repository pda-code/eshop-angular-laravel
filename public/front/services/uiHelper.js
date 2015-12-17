// uiHelper
appModule.service('uiHelper', ['$http',function ($http) {
    var uiHelper = function() {
        this.pageHeader = '';
        this.pageSubHeader = '';

        this.pageTitle = '';
        this.metaDescription = '';
        this.metaKeywords = '';

        //DatePickers
        this.dtOpened = {};
        this.dtOpen = function(id, $event) {
            $event.preventDefault();
            $event.stopPropagation();

            this.dtOpened[id] = true;
        };

        //Collapse/Expand
        this.expanded = {};
        this.setExpanded = function (id) {
            if (this.expanded[id] === true) this.expanded[id] = false;
            else this.expanded[id] = true;
        };

        //Tabs
        this.tabs = {};
        this.setActiveTab = function(id) {
            if (this.collapsed[id] === true) this.collapsed[id] = false;
            else this.collapsed[id] = true;
        };

        //Meta
        this.setMeta=function(pageTitle,metaDescription,metaKeywords)
        {
            this.pageTitle=pageTitle;
            this.metaDescription=metaDescription;
            this.metaKeywords=metaKeywords;
        }

    };

    this.createInstance = function () {
        return new uiHelper();
    };
}]);