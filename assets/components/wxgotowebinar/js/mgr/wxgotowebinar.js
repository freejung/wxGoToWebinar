var wxGoToWebinar = function(config) {
    config = config || {};
    wxGoToWebinar.superclass.constructor.call(this,config);
};
Ext.extend(wxGoToWebinar,Ext.Component,{
    page:{},window:{},grid:{},tree:{},panel:{},combo:{},config: {},view: {}
});
Ext.reg('wxgotowebinar',wxGoToWebinar);

wxGoToWebinar = new wxGoToWebinar();