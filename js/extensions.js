var formatExtensionsState = function(colNumber, row){
    var col = $('td:eq('+colNumber+')', row),
        colvar = col.text();
    colvar = colvar == 'activated_enabled' ? '<span class="label label-success">'+i18n.t('extensions.activated_enabled')+'</span>' :
    colvar = colvar == 'activated_disabled' ? '<span class="label label-danger">'+i18n.t('extensions.activated_disabled')+'</span>' : 
    colvar = colvar == 'terminated_waiting_to_uninstall_on_reboot' ? '<span class="label label-info">'+i18n.t('extensions.terminated_waiting_to_uninstall_on_reboot')+'</span>' : 
    colvar = colvar == 'activated_waiting_for_user' ? '<span class="label label-warning">'+i18n.t('extensions.activated_waiting_for_user')+'</span>' : 
    colvar = colvar == 'waiting_for_approval' ? '<span class="label label-warning">'+i18n.t('extensions.waiting_for_approval')+'</span>' : 
    colvar = (colvar == 'blocked' ? '<span class="label label-danger">'+i18n.t('extensions.blocked')+'</span>' : 
    colvar = colvar)
    col.html(colvar)
}