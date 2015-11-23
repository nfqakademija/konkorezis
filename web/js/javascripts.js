/**
 * Created by mindaugas on 15.11.22.
 */
$(document).ready(function() {
$(".new-product-info").hide();
    $(".btn-new-product").click(function(){
        var newProductForm = $(".new-product-form:first");
        var newClone = newProductForm.clone();
        newClone.css('display', 'none');
        $( ".new-product-box" ).append(newClone);
        newClone.fadeIn( "slow", function() {
            // Animation complete
        });
    });

    $(".btn-submit-product").click(function(){
        var x = $(".form-new-product").serializeArray();
        var productForm = [];
        $.each(x, function(i, field){
            $("#results").append(field.name + ":" + field.value + " ");
            productForm[i] = field.value;
        });
        var newProductForm = $(".new-product-info:first");
        var newClone = newProductForm.clone();
        newClone.css('display', 'none');
        $( ".new-product-box" ).append(newClone);
        newClone.fadeIn( "slow", function() {
            // Animation complete
        });
        $(".new-product-form").hide();
    });
    $( ".form-new-product" ).submit(function( event ) {
        console.log( $( this ).serializeArray() );
        event.preventDefault();
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