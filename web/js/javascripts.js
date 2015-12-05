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
        });
    });

    $(".btn-submit-product").click(function(){
        $(".new-product-form").hide();

        // Send products' creation request and display newly added
        // product (if addition is successful)
        var request = $.ajax({
            url: "/orders/create_product",
            method: "POST",
            data: {
                order_id    : orderId,
                price       : $("#price").val(),
                quantity    : $("#quantity").val(),
                title       : $("#title").val(),
                link        : $("#link").val()
            },
            dataType: "html"
        });

        request.done(function( response ) {
            $( "#order_details" ).append(response);
            newClone.fadeIn( "slow", function() {
            });
        });

        request.fail(function( jqXHR ) {
            // TODO: alert about failed addition in better way
            alert( "Adding new product failed: " + jqXHR.responseText);
        });
    });
    $( ".form-new-product" ).submit(function( event ) {
        console.log( $( this ).serializeArray() );
        event.preventDefault();
    });
});