<?php
/**
 * Payment form will redirect to this page
 * You must set up a hook in PayTR merchant panel. See hook.php for detailed information
 */

/**
 * This values are not sent by PayTR
 * We just added to the end of the URLs in index.php
 */
$GET_orderId = $_GET["orderId"];
$GET_status = $_GET["status"];

if($GET_status === "success") {
	?><h1>Payment success</h1><?php
} else {
	?><h1>Payment failed</h1><?php
}
?>
<h2>You must set up a hook in PayTR merchant panel</h2>
<p>Maybe you want to use $GET_orderId to show the user's cart or something like that</p>