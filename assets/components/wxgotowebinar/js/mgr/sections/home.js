Ext.onReady(function() {
    MODx.load({ xtype: 'wxgotowebinar-page-home'});
});

wxGoToWebinar.page.Home = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'wxgotowebinar-panel-home'
            ,renderTo: 'wxgotowebinar-panel-home-div'
        }]
    }); 
    wxGoToWebinar.page.Home.superclass.constructor.call(this,config);
};
Ext.extend(wxGoToWebinar.page.Home,MODx.Component);
Ext.reg('wxgotowebinar-page-home',wxGoToWebinar.page.Home);