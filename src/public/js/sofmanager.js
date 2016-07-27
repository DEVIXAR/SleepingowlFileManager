$(document).ready(function(){
    var laradropSettings = {
        fileHandler : '/laradrop',
        fileDeleteHandler : '/laradrop/0',
        fileSrc : '/laradrop',
        fileCreateHandler : '/laradrop/create',
        fileMoveHandler : '/laradrop/move',
        containersUrl : '/laradrop/containers',
        // csrfTokenField : '_token',
        // actionConfirmationText : 'Are you sure?',
        // breadCrumbRootText : 'Root Directory',
        // folderImage : '/vendor/jasekz/laradrop/img/genericThumbs/folder.png',
    };

    laradropSettings.onInsertCallback = function (src){
        // jQuery('#cke_226_textInput').val(src.src.replace('_thumb_', ''));
        // $('#laradropModal').modal('toggle');
        // $('.imageValue').val(src.src.replace('_thumb_', ''));
        // $('.has-value').attr('src', src.src.replace('_thumb_', ''));
    };
    laradropSettings.onErrorCallback = function(jqXHR,textStatus,errorThrown){
        // if you need an error status indicator, implement here
        alert('An error occured: '+ errorThrown);
    }

    $('#laradropModalArea').laradrop(laradropSettings);
});