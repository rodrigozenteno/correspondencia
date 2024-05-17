function dialogoAjax(idContenedor, anchoDialogo, title, data, url, method, preFunction, postFunction, cache, async)
{
  //  alert('1: '+idContenedor+' 2: '+ anchoDialogo+' 3: '+ title+' 4: '+ data+' 5: '+ url+' 6: '+ method+' 7: '+ preFunction+' 8: '+ postFunction+' 9: '+ cache+' 10: '+ async);
    $('#'+idContenedor).html('');

    if((typeof preFunction)=='function')
    {
        preFunction();
    }

    $('#modalLoading').modal('show');
    
    $.ajax(
    {
        url: url,
        type: method,
        data: data,
        cache: cache,
        async: async
    }).done(function(pagina) 
    {
        $('#modalLoading').modal('hide');
        
        var htmlResponse='<div class="modal fade" id="'+idContenedor+'Modal" data-backdrop="static" data-keyboard="false">'
            +'<div class="modal-dialog" '+(anchoDialogo!=null ? 'style="min-width: '+anchoDialogo+'%"' : '')+'>'
                +'<div class="modal-content">'
                    +'<div class="modal-header">'
                        +'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'
                        +'<span aria-hidden="true">&times;</span></button>'
                        +'<h4 class="modal-title">'+title+'</h4>'
                    +'</div>'
                    +'<div class="modal-body">'
                        +pagina
                    +'</div>'
                +'</div>'
            +'</div>'
        +'</div>';
        
        $('#'+idContenedor).html(htmlResponse);

        $('#'+idContenedor+'Modal').modal('show');

        if((typeof postFunction)=='function')
        {
            postFunction();
        }
    }).fail(function()
    {
        $('#modalLoading').modal('hide');
        $('#'+idContenedor).html('<div class="divAlertaRojo">Ocurrió un error inesperado. Por favor reporte esto a la plataforma o al correo "kaaf030191@gmail.com". Pedimos disculpas y damos gracias por su comprensión.</div>');
    });
}

function paginaAjax(idSeccion, data, url, method, preFunction, postFunction, cache, async)
{    
    if((typeof preFunction)=='function')
    {
        preFunction();
    }

    $('#modalLoading').modal('show');
    
    $.ajax(
    {
        url: url,
        type: method,
        data: data,
        cache: cache,
        async: async
    }).done(function(pagina) 
    {
        $('#modalLoading').modal('hide');
        $('#'+idSeccion).html(pagina);

        if((typeof postFunction)=='function')
        {
            postFunction();
        }
    }).fail(function()
    {
        $('#modalLoading').modal('hide');
        $('#'+idSeccion).html('<div class="divAlertaRojo">Ocurrió un error inesperado. Por favor reporte esto a la plataforma o al correo "kaaf030191@gmail.com". Pedimos disculpas y damos gracias por su comprensión.</div>');
    });
}

function paginaAjaxJSON(data, url, method, preFunction, postFunction, cache, async)
{    
    if((typeof preFunction)=='function')
    {
        preFunction();
    }

    $('#modalLoading').modal('show');
    
    $.ajax(
    {
        url: url,
        type: method,
        data: data,
        cache: cache,
        async: async
    }).done(function(objectJSON) 
    {
        $('#modalLoading').modal('hide');

        if((typeof postFunction)=='function')
        {
            postFunction(objectJSON);
        }
    }).fail(function()
    {
        $('#modalLoading').modal('hide');

        var objectJSON=
        {
            error: true,
            mensajeGlobal: 'Ocurrió un error inesperado. Por favor reporte esto a la plataforma o al correo "kaaf030191@gmail.com". Pedimos disculpas y damos gracias por su comprensión.'
        };
        
        if((typeof postFunction)=='function')
        {
            postFunction(objectJSON);
        }
    });
}