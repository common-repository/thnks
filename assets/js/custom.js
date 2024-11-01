jQuery(document).ready(function($) {
    console.log('active')

    var enable_thnks = $('#thnks_enable');
    var btn_radio = $('.btn-check');
    btn_radio.on('click', function (){
        var temp_status = '';
        if ($('#active').is(':checked')) {
            temp_status = 'active';
         } else if ($('#desactive').is(':checked')) {
            temp_status = 'desactive';
         }
        enable_thnks.val(temp_status);
        console.log('Nuevo valor '+enable_thnks.val());
    });

    jQuery(document).ready(function($) {
        $('#save-settings-thnks').on('click', function(e) {
            e.preventDefault();
            var data = $('#form-enable').serialize();
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'thnks_save_settings',
                    data: data
                },
                success: function(response) {
                    alert(response.data.message);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error(textStatus, errorThrown);
                }
            });
        });
    });

    // MARCODE
    jQuery(function($){
        var imageUrl = $('.image-url');
        var btnRemove = $('.marcode-rmv');


        // on upload button click
        $('body').on( 'click', '.marcode-upl', function(e){

            e.preventDefault();

            var button = $(this),
                custom_uploader = wp.media({
                    title: 'Insert image',
                    library : {
                        // uploadedTo : wp.media.view.settings.post.id, // attach to the current post?
                        type : 'image'
                    },
                    button: {
                        text: 'Use this image' // button label text
                    },
                    multiple: false
                }).on('select', function() { // it also has "open" and "close" events
                    var attachment = custom_uploader.state().get('selection').first().toJSON();
                    button.html('<img height="300" width="300" src="' + attachment.url + '">');
                    imageUrl.val(attachment.url);
                    button.removeClass('button-upl');
                    btnRemove.show();

                }).open();

        });
        // on remove button click
        $('body').on('click', '.marcode-rmv', function(e){

            e.preventDefault();
            var btnUpload = $('.marcode-upl');

            var button = $(this);
            btnUpload.addClass('button-upl');
            console.log(button);
            button.next().val(''); // emptying the hidden field
            button.hide().prev().html('Upload image');
        });
    });

    //Reset color
    var base_color = $('.reset-color');
    base_color.on('click',function (){
        var field = $(this).attr('data-field');
        var color_default = $(this).attr('data-color');
       $('#'+field).val(color_default);
       console.log(field)
       console.log(color_default)
    });

    //**************************************//
    //******** SELECT PRODUCT   ********//
    //************************************//
    function formatState (state) {
        if (!state.id) {
            return state.text;
        }
        console.log(state);
        var image = state.element.attributes[1].value;
        var $state = $(
            '<span><img src="' + image + '" width="30px" height="30px"/> ' + state.text + '</span>'
        );
        return $state;
    };
    $("#product-thnks").select2({
        templateResult: formatState,
        width: 'resolve'
    });

    //**************************************//
    //******** SELECT PRODUCT   ********//
    //************************************//
});