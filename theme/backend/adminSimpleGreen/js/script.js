var article = {
    init: function() {
        if ($('.img-remove').length != 0) {
            $('.img-remove').click(function(e) {
                e.preventDefault();
                article.removeImage($(this));
            });
        }
        if ($('.add-more-images').length != 0) {
            $('.add-more-images').click(function(e) {
                e.preventDefault();
                article.addMoreImages();
            });
        }
        article.addEditor();
    },
    removeImage: function(_this){
        var imgId = _this.attr('id');
        _this.closest('form').append('<input type="hidden" name="removeimage[]" value="' + imgId + '" />');
        _this.closest('div.image').fadeOut('fast', function() {
            $(this).remove();
            if ($('div.image').length == 0) {
                $('.add-more-images').click();
            }
        });          
    },
    addMoreImages: function() {
        $('.article-images').append('<input name="articleimage[]" class="articleimage" type="file" />');
            
    },
    addEditor: function() {
        if ($('.article-form-body').length != 0) {
            CKEDITOR.replace('body');
        }
    }
}

$(document).ready(function(){
    article.init();
});

