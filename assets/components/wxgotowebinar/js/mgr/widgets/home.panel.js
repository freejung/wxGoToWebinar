wxGoToWebinar.panel.Home = function(config) {
    config = config || {};
    Ext.apply(config,{
        border: false
        ,baseCls: 'modx-formpanel'
        ,cls: 'container'
        ,items: [{
            html: '<h2>'+_('wxgotowebinar')+'</h2>'
            ,border: false
            ,cls: 'modx-page-header'
        },{
            xtype: 'modx-tabs'
            ,defaults: { border: false ,autoHeight: true }
            ,border: true
            ,activeItem: 0
            ,hideMode: 'offsets'
            ,items: [{
                title: _('wxgotowebinar.items')
                ,items: [{
                    html: '<p>'+_('wxgotowebinar.intro_msg')+'</p>'
                    ,border: false
                    ,bodyCssClass: 'panel-desc'
                },{
                    xtype: 'wxgotowebinar-grid-items'
                    ,preventRender: true
                    ,cls: 'main-wrapper'
                }]
            }]
        }]
    });
    wxGoToWebinar.panel.Home.superclass.constructor.call(this,config);
};
Ext.extend(wxGoToWebinar.panel.Home,MODx.Panel);
Ext.reg('wxgotowebinar-panel-home',wxGoToWebinar.panel.Home);
