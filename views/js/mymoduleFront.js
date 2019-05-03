jQuery(document).ready(function(){
    comboChange();
});

function properties() {
    return properties = {
        selectors: {
            combo: (typeof combo !== 'undefined' ? combo : null), 
            resultSelector: (typeof resultSelector !== 'undefined' ? resultSelector : null)
        },
        url: {
            getProduct: (typeof getProduct !== 'undefined' ? getProduct : null)
        }
    };
}

var allProperties = properties();

function comboChange() {
    jQuery(document).on('change', allProperties.selectors.combo, function() {
        var getVal = jQuery(this).val();
        getProductByAjax(getVal);
    });
}

function getProductByAjax(_catId) {
    jQuery.ajax({
        url: allProperties.url.getProduct,
        type: 'post',
        data: {catId: _catId},
        dataType: 'html',
        error: function(_error) {
            console.error(_error);
        },
        success: function(_html) {
            jQuery(allProperties.selectors.resultSelector).hide('slow', function() {
               jQuery(allProperties.selectors.resultSelector).html(_html).show('slow');
            });
           
        }
    });

}
