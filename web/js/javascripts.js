/**
 * Created by mindaugas on 15.11.22.
 */
$(document).ready(function() {
$(".new-product-info").hide();
    $("body").on('click', '.btn-new-product', function(){
        var newProductForm = $(".new-product-form:first");
        var newClone = newProductForm.clone();
        newClone.css('display', 'none');
        $( ".new-product-box" ).append(newClone);
        newClone.fadeIn( "slow", function() {
            // Animation complete
        });
    });

    $("body").on('click','.btn-submit-product',function(){
        var x = $(".form-new-product").serializeArray();
        var productForm = [];
        $.each(x, function(i, field){
            $("#results").append(field.name + ":" + field.value + " ");
            productForm[i] = field.value;
        });
        var newProductForm = $(".new-product-info:first");
        var newClone = newProductForm.clone(productForm);
        newClone.css('display', 'none');
        $( ".new-product-box" ).append(newClone);
        newClone.fadeIn( "slow", function(productForm) {
            // Animation complete
        });
        $(".new-product-form").hide();
    });
    $( "body" ).on('submit', '.form-new-product',function( event ) {
        console.log( $( this ).serializeArray() );
        event.preventDefault();
    });
    $("#add").on('click', 'product-quantity',function( ) {
        count++;
    });
});
    /*$(".btn-submit-product").click(function(){
        var newProduct = $(".new-product-info:first");
        var newClone = newProduct.clone();
        newClone.css('display', 'none');
        $(".new-product-box" ).append(newClone);
        newProduct.fadeIn("slow");
        var newProductForm = $(".new-product-form");
        newProductForm.fadeOut( "slow", function() {
        });
    });*/