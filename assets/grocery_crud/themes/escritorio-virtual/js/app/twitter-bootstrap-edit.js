$(function(){

    var save_and_close = false;

    //  Salva as informações e retorna a listagem inicial
    $('#save-and-go-back-button').click(function(){
        save_and_close = true;
        submitCrudForm($('#crudForm'), save_and_close);
    });
    //  Faz as verificações e submete o formulario
    $('.submit-form').on('click', function(){
        submitCrudForm($('#crudForm'), save_and_close);
    });

    $('.return-to-list').on('click', function() {
        goToList(message_alert_edit_form);
        return false;
    });

});

//  Mensagens para a aplicação
var alert_message = function(type_message, text_message){
    $('.modal-message.'+type_message).remove();
    $('#message-box').prepend('<div class="alert '+type_message+' modal-message"><span class="icon"></span><span class="close">x</span>'+text_message+'</div>');
    $('html, body').animate({
        scrollTop:0
    }, 600);
    $("#ajax-loading").fadeOut('fast');
    window.setTimeout( function(){
        $('.modal-message.'+type_message).slideUp();
    }, 7000);
    $("#ajax-loading").removeClass('show loading');
    return false;
};

//  Simula o efeito RESET no formulário de inserção de conteudo
function clearForm()
{
    $('#crudForm').find(':input').each(function() {
        switch(this.type) {
            case 'password':
            case 'select-multiple':
            case 'select-one':
            case 'text':
            case 'textarea':
                $(this).val('');
                break;
            case 'checkbox':
            case 'radio':
                this.checked = false;
        }
    });

    /* Clear upload inputs  */
    $('.open-file, .gc-file-upload, .hidden-upload-input').each(function(){
        $(this).val('');
    });

    $('.upload-success-url').hide();
    $('.fileinput-button').fadeIn("normal");
    /* -------------------- */

    $('.remove-all').each(function(){
        $(this).trigger('click');
    });

    $('.chosen-multiple-select, .chosen-select, .ajax-chosen-select').each(function(){
        $(this).trigger("liszt:updated");
    });
}

//  Submete o formulário para inserir os dados no BD
function submitCrudForm( crud_form, save_and_close ){
    crud_form.ajaxSubmit({
        url: validation_url,
        dataType: 'json',
        cache: 'false',
        beforeSend: function(){
            $("#ajax-loading").fadeIn('fast');
        },
        afterSend: function(){
            $("#ajax-loading").fadeOut('fast');
        },
        success: function(data){
            $("#ajax-loading").fadeOut('fast');
            if(data.success)
            {
                $('#crudForm').ajaxSubmit({
                    dataType: 'text',
                    cache: 'false',
                    beforeSend: function(){
                        $("#ajax-loading").addClass('show loading');
                    },
                    success: function(result){

                        $("#ajax-loading").fadeOut("slow");
                        data = $.parseJSON( result );
                        if(data.success)
                        {
                            if(save_and_close)
                            {
                                window.location = data.success_list_url;
                                return true;
                            }
                            alert_message('sucess', data.success_message);
                        }
                        else
                        {
                            alert_message('error', message_update_error);
                        }
                    },
                    error: function(){
                        alert_message('error', message_update_error);
                    }
                });
            }
            else
            {
                $('.field_error').each(function(){
                    $(this).removeClass('field_error');
                });

                alert_message('error', data.error_message);

                $.each(data.error_fields, function(index,value){
                    $('input[name='+index+']').addClass('field_error');
                });
            }
        },
        error: function(){
            $("#ajax-loading").fadeOut('fast');
            alert_message('error', message_update_error);
        }
    });
    return false;
}

//  Retornar para a tabela de listagem de dados inicial
function goToList(message_text){

    Messenger.options = {
        extraClasses: 'messenger-fixed messenger-on-bottom messenger-on-right',
        theme: 'block'
    }

    msg = Messenger().post({
        message: message_text,
        id: "Only-one-message",
        type: 'info',
        showCloseButton: true,
        actions: {
            não: {
                action: function() {
                    msg.hide()
                }
            },
            sim: {
                action: function(){
                    window.location = list_url
                }
            }
        }
    });

}