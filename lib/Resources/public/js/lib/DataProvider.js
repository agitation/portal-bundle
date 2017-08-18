ag.ns("ag.portal");

(function(){

var DataProvider = function(area, refreshInterval)
{
    this.data = {};
    this.broker = ag.srv("broker");

    var loadCb = load.bind(this, area);

    loadCb();
    window.setInterval(loadCb, refreshInterval * 1000);
},

load = function(area)
{
    var self = this;

    $.get({
        url          : "/data/" + area,
        dataType     : "json",
        success      : function(result)
        {
            self.data = result;
            self.broker.pub(self.updateEventKey);
        }
    });
};

DataProvider.prototype.updateEventKey = "ag.portal.update";

DataProvider.prototype.getData = function(key)
{
    return this.data[key];
};

ag.portal.DataProvider = DataProvider;

})();
