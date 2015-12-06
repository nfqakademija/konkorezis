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

        // Send product creation request and display newly added product
        var request = $.ajax({
            url: "/product/create",
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
            // TODO: alert about failed request in better way
            alert( "Adding new product failed: " + jqXHR.responseText);
        });
    });

    $( ".form-new-product" ).submit(function( event ) {
        console.log( $( this ).serializeArray() );
        event.preventDefault();
    });
});

function decreaseQuantity(orderId, productId) {
    // Send product quantity decrease request and return changed quantity
    var request = $.ajax({
        url: "/product/decrease_quantity",
        method: "POST",
        data: {
            order_id    : orderId,
            product_id  : productId
        },
        dataType: "json"
    });

    request.done(function( response ) {
        $("#product_quantity_" + productId).val(response);
    });

    request.fail(function( jqXHR ) {
        // TODO: alert about failed request in better way
        alert( "Decreasing products' counter failed: " + jqXHR.responseText);
    });
}

function increaseQuantity(orderId, productId) {
    // Send product quantity increase request and return changed quantity
    var request = $.ajax({
        url: "/product/increase_quantity",
        method: "POST",
        data: {
            order_id    : orderId,
            product_id  : productId
        },
        dataType: "json"
    });

    request.done(function( response ) {
        $("#product_quantity_" + productId).val(response);
    });

    request.fail(function( jqXHR ) {
        // TODO: alert about failed request in better way
        alert( "Increasing products' counter failed: " + jqXHR.responseText);
    });
}

function changeQuantity(orderId, productId) {
     var quantity = $("#product_quantity_" + productId).val();

    // Send required products quantity and return verified quantity
    var request = $.ajax({
        url: "/product/change_quantity",
        method: "POST",
        data: {
            order_id    : orderId,
            product_id  : productId,
            quantity    : quantity
        },
        dataType: "json"
    });

    request.done(function( response ) {
        $("#product_quantity_" + productId).val(response);
    });

    request.fail(function( jqXHR ) {
        // TODO: alert about failed request in better way
        alert( "Changing products' counter failed: " + jqXHR.responseText);
    });
}