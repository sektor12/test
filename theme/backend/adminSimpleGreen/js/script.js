var services = {
    parseUrlParams: function (url) {
        var queryStart = url.indexOf("?") + 1,
            queryEnd   = url.indexOf("#") + 1 || url.length + 1,
            query = url.slice(queryStart, queryEnd - 1),
            pairs = query.replace(/\+/g, " ").split("&"),
            parms = {}, i, n, v, nv;

        if (query === url || query === "") return;

        for (i = 0; i < pairs.length; i++) {
            nv = pairs[i].split("=", 2);
            n = decodeURIComponent(nv[0]);
            v = decodeURIComponent(nv[1]);

            if (!parms.hasOwnProperty(n)) parms[n] = [];
            parms[n].push(nv.length === 2 ? v : null);
        }
        return parms;
    }
}
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
var api = {
    init: function() {
        if ($('.filter-by-user .form-submit').length != 0) {
            $('.filter-by-user .form-submit').click(function(e) {
                e.preventDefault();
                api.bindListing();
            });
        }
        api.bindPagination();
        api.bindDeletion();
        api.bindArticleCreation();
        
    },
    bindListing: function() {
        var form = $('.filter-by-user');
        var serializedForm = form.serializeArray();
        
        $.ajax({
            method: "POST",
            url: "/core/Api/Article.php",
            data: serializedForm
        }).done(function( data ) {
            $('.article-list').replaceWith(data.table);
            $('.pagination').replaceWith(data.pagination);
            api.bindPagination();
            api.bindDeletion();
        });
    },
    bindPagination: function() {
        if ($('.pagination').length != 0) {
            $('.pagination a').click(function(e) {
                e.preventDefault();
                var href = window.location.protocol + '//' + window.location.hostname + $(this).attr('href');
                var params = services.parseUrlParams(href);

                var data = {
                    'page': params.page[0],
                    'action': 'pagination',
                    'filterby': $('select[name="filterby"]').val()
                }

                if (params.filter) {
                    data.filter = params.filter;
                }

                $.ajax({
                    method: "POST",
                    url: "/core/Api/Article.php",
                    data: data
                }).done(function( data ) {
                    $('.article-list').replaceWith(data.table);
                    $('.pagination').replaceWith(data.pagination);
                    api.bindPagination();
                    api.bindDeletion();
                });
            });
        }
    },
    bindDeletion: function() {
        if ($('.delete-btn').length != 0) {
            $('.delete-btn').click(function(e) {
                e.preventDefault();
                var _this = $(this);
                var href = window.location.protocol + '//' + window.location.hostname + $(this).attr('href');
                var params = services.parseUrlParams(href);
                $.ajax({
                    method: "POST",
                    url: "/core/Api/Article.php",
                    data: params
                }).done(function( data ) {
                    _this.closest('tr').fadeOut('slow');
                });
            });
        }        
    },
    bindArticleCreation: function() {
        // ... to be done ...
        // Plan was to base64 encode image and transfer it to the api script
        // From there export to files directory and call existing functions for storing article...
    }
}

$(document).ready(function(){
    article.init();
    
    // If you don't want to use Ajax, comment out line below
    api.init();
});

