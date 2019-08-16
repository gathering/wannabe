$(document).ready(function(){
    $('input:radio').click(function(){
            i=$(this)
            r=i.val()
            m=i.attr('class').replace(/([a-z-0-9]+\s)|(R$)/g,'')
            t=i.attr('id')+'D'

        if(r == 1){
            $('#'+m+'1F').show()
            $('#'+m+'2D').hide()
        }  else if(r == 2){
            $('#'+m+'1F').hide()
            $('#'+m+'2D').show()
        }
        else {
            $('#'+m+'1F').hide()
            $('#'+m+'2D').hide()
        }
    })

    $('form > ul.media-grid > li > div > img.thumbnail, form > ul.media-grid > li > div > div.thumbnail-overlay').bind('mouseenter mouseleave',function() {
        r=$(this).attr('class').replace(/[a-z-0-9]+\s/g,'')
        m=$('input:radio.'+r+'R:checked').val()
        if(m==2){
            if(m!==undefined){$('#'+r+m+'D,#'+r+m+'F').toggle()}
        }
    })

})