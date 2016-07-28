$(document).ready(function(){
    var caller = null;
    var btnCall = null;

    var laradropSettings = {
        fileHandler : '/laradrop',
        fileDeleteHandler : '/laradrop/0',
        fileSrc : '/laradrop',
        fileCreateHandler : '/laradrop/create',
        fileMoveHandler : '/laradrop/move',
        containersUrl : '/laradrop/containers',
        actionConfirmationText : 'Вы действительно хотите удалить?',
        breadCrumbRootText : 'Главная папка'
    };

    laradropSettings.onInsertCallback = function (src){
        getFullFile(src.id, function(response){
            if(fileFilter(btnCall, response)) {
                setSelected(caller, response.public_resource_url, response.filename, response.type);
                toggleModal();
            } else {
                alert('Вы не можете выбрать этот файл!');
            }
        });
    };
    laradropSettings.onErrorCallback = function(jqXHR,textStatus,errorThrown){
        // if you need an error status indicator, implement here
        alert('An error occured: '+ errorThrown);
    }

    $('#laradropModalArea').laradrop(laradropSettings);

    // events
    $('.select-file-manager').click(function(){
        caller = $(this).parents('.file-manager-caller');
        btnCall = $(this);
    });

    function getFullFile(id, callback)
    {
        $.ajax({
            url: '/sofmanager/getfile/' + id,
            success: function(response){
                callback(response);
            }
        });

    }

    function setSelected(pCaller, url, filename)
    {
        pCaller.find('.file-manager-target').each(function(iter, el){
            el = $(el);
            switch (el.prop('tagName'))
            {
                case 'IMG':
                    el.attr('src', url);
                    break;
                case 'INPUT':
                    el.val(url);
                    break;
                case 'DIV': {
                    el
                        .children('a').attr('href', url)
                        .children('span').text(filename);
                }; break;
            }
        });
    }

    function fileFilter(btn, file)
    {
        switch (btn.attr('data-type'))
        {
            case 'image':
                return isImage(file);
            case 'file':
                return isFile(file);
        }
    }

    var imageFormats = ['png', 'jpg', 'jpeg', 'gif'];

    function isImage(file)
    {
        return $.inArray(file.type, imageFormats) > -1;
    }

    function isFile(file)
    {
        return file.type != '';
    }

    function toggleModal()
    {
        $('#laradropModal').modal('toggle');
    }
});