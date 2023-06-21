(function($){
    $(document).ready(function(){
        $('#upload_image_button').click(function(event){
            event.preventDefault();
            var upload = wp.media({
                title:'Choose Image', //Title for Media Box
                multiple:false //For limiting multiple image
            }).on('select', function(){
                var select = upload.state().get('selection');
                var attach = select.first().toJSON();
                // jQuery('img#preview').attr('src',attach.url);
                var text1 = '<img src="';
                var text2 = '" alt="image preview" width="100px" />';
                var text3 = text1.concat(attach.url,text2);
                $('#upload_image_button').attr('value',translations.change)
                $('#image-preview').html(text3);
                $('#featured_image_id').attr('value',attach.id);
            })
            .open();
        });
        $('#delete_image_button').click(function(event){
            event.preventDefault();
            $('#upload_image_button').attr('value',translations.add);
            $('#image-preview').html('');
            $('#featured_image_id').attr('value','');
            $('#delete_image_button').attr('value',translations.delete);
        });
        $('#submit').click(function(event){
            event.preventDefault();
            if($('#featured_image_id').attr('value')){
                $('#delete_image_button').attr('value',translations.clear);
            }
        });
    })
})(jQuery);