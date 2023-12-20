<h2 data-i18n="extensions.clienttab"></h2>
<div id="extensions-tab_info"></div>
<div id="extensions-tab"></div>

<script>
$(document).on('appReady', function(){
    $.getJSON(appUrl + '/module/extensions/get_data/' + serialNumber, function(data){
        // Set count of extensions
        $('#extensions-cnt').text(data.length);
        var skipThese = ['name'];
        $.each(data, function(i,d){

            // Generate rows from data
            var rows = ''
            var inforows = ''
            for (var prop in d){
                // Skip skipThese
                if(skipThese.indexOf(prop) == -1){

                    if ((d[prop] == '' || d[prop] == null || d[prop] == "none" || prop == '' || (prop == "extension_policies" && d[prop] == "[]")) && d[prop] !== 0){
                           // Do nothing for empty values to blank them
                    } else if (prop == "boot_uuid"){
                        inforows = inforows + '<tr><th>'+i18n.t('extensions.'+prop)+'</th><td>'+d[prop]+'</td></tr>';
                    } else if (prop == "developer_mode" && d[prop] == 0){
                        inforows = inforows + '<tr><th>'+i18n.t('extensions.'+prop)+'</th><td>'+i18n.t('no')+'</td></tr>';
                    } else if (prop == "developer_mode" && d[prop] == 1){
                        inforows = inforows + '<tr><th>'+i18n.t('extensions.'+prop)+'</th><td><span class="label label-danger">'+i18n.t('yes')+'</span></td></tr>';
                    } else if (prop == "extension_policies" && d[prop] !== "[]"){
                        inforows = inforows + '<tr><th>'+i18n.t('extensions.'+prop)+'</th><td>'+d[prop].replace(/\n      /g,'<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;').replace(/\n     /g,'<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;').replace(/\n    /g,'<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;').replace(/\n   /g,'<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;').replace(/\n  /g,'<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;').replace(/\n /g,'<br>&nbsp;&nbsp;&nbsp;&nbsp;').replace(/\\"/g,'\"')+'</td></tr>';

                    // Label the system extension state to the name
                    } else if (prop == "state" && d[prop] == "activated_enabled"){
                        d.name = d.name + ' — '+'<span class="label label-success">'+i18n.t('extensions.'+d[prop])+'</span>';
                    } else if (prop == "state" && (d[prop] == "activated_disabled" || d[prop] == "blocked")){
                        d.name = d.name + ' — '+'<span class="label label-danger">'+i18n.t('extensions.'+d[prop])+'</span>';
                    } else if (prop == "state" && d[prop] == "terminated_waiting_to_uninstall_on_reboot"){
                        d.name = d.name + ' — '+'<span class="label label-info">'+i18n.t('extensions.'+d[prop])+'</span>';
                    } else if (prop == "state" && (d[prop] == "activated_waiting_for_user" || d[prop] == "waiting_for_approval")){
                        d.name = d.name + ' — '+'<span class="label label-warning">'+i18n.t('extensions.'+d[prop])+'</span>';
                    } else if (prop == "state"){
                        d.name = d.name + ' — '+d[prop];

                    } else {
                        rows = rows + '<tr><th>'+i18n.t('extensions.'+prop)+'</th><td>'+d[prop]+'</td></tr>';
                    }
                }
            }

            $('#extensions-tab')
                .append($('<h4>')
                    .append($('<i>')
                        .addClass('fa fa-puzzle-piece'))
                    .append(' '+d.name))
                .append($('<div style="max-width:1350px;">')
                    .addClass('table-responsive')
                    .append($('<table>')
                        .addClass('table table-striped table-condensed')
                        .append($('<tbody>')
                            .append(rows))))

            // Only show inforows of not empty
            if (inforows !== ""){
                $('#extensions-tab_info')
                    .append($('<div style="max-width:850px;">')
                        .append($('<table>')
                            .addClass('table table-striped table-condensed')
                            .append($('<tbody>')
                                .append(inforows))))
            }
        })
    });
});
</script>
