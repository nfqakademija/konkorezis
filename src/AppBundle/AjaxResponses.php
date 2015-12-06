<?php
/**
 * Created by PhpStorm.
 * User: jzplius
 * Date: 12/3/15
 * Time: 10:00 PM
 */

namespace AppBundle;


class AjaxResponses
{
    public static $ORDER_NOT_FOUND = "Order not found with this ID!";

    public static $PRODUCT_NOT_FOUND = "Product not found with this ID!";

    public static $ORDER_JOINING_TIME_IS_OVER = "Orders' joining time is over! Unable to add new products / update quantities.";

    public static $ORDER_ = "Order not found with this ID!";

    public static $UNAUTHORIZED = "Unauthorized access! Please login first.";

    public static $OK = "OK";

    public static $WRONG_REQUEST_PARAMETERS = "Wrong request parameters!";
}