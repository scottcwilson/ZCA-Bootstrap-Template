<?php
/**
 * Page Template
 * 
 * BOOTSTRAP v1.0.BETA
 *
 * Loaded automatically by index.php?main_page=shopping_cart.<br />
 * Displays shopping-cart contents
 *
 * @package templateSystem
 * @copyright Copyright 2003-2016 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: Author: DrByte  Thu Jan 7 22:38:14 2016 -0500 Modified in v1.5.5 $
 */
?>
<div id="shoppingCartDefault" class="centerColumn">

<?php
  if ($flagHasCartContents) {
?> 
<?php
  if ($_SESSION['cart']->count_contents() > 0) {
?>
<div id="shoppingCartDefault-helpLink" class="helpLink float-right p-3">
<a data-toggle="modal" href="#cartHelpModal"><?php echo TEXT_VISITORS_CART; ?></a>
</div>

<?php require($template->get_template_dir('tpl_info_shopping_cart.php',DIR_WS_TEMPLATE, $current_page_base,'modalboxes'). '/tpl_info_shopping_cart.php'); ?>

<div class="clearfix"></div>
<?php
  }
?>   

<h1 id="shoppingCartDefault-pageHeading" class="pageHeading"><?php echo HEADING_TITLE; ?></h1> 
  
<?php if ($messageStack->size('shopping_cart') > 0) echo $messageStack->output('shopping_cart'); ?>

<?php echo zen_draw_form('cart_quantity', zen_href_link(FILENAME_SHOPPING_CART, 'action=update_product', $request_type), 'post', 'id="shoppingCartForm"'); ?> 
    
<div id="shoppingCartDefault-content" class="content"><?php echo TEXT_INFORMATION; ?></div>

<?php if (!empty($totalsDisplay)) { ?>
<div id="shoppingCartDefault-cartTotalsDisplay" class="cartTotalsDisplay text-center font-weight-bold p-3"><?php echo $totalsDisplay; ?></div>
<?php } ?>   
    
<?php  if ($flagAnyOutOfStock) { ?>
<?php    if (STOCK_ALLOW_CHECKOUT == 'true') {  ?>
<div class="alert alert-danger" role="alert"><?php echo OUT_OF_STOCK_CAN_CHECKOUT; ?></div>
<?php    } else { ?>
<div class="alert alert-danger" role="alert"><?php echo OUT_OF_STOCK_CANT_CHECKOUT; ?></div>
<?php    } //endif STOCK_ALLOW_CHECKOUT ?>
<?php  } //endif flagAnyOutOfStock ?> 

<div class="table-responsive">
<table id="shoppingCartDefault-cartTableDisplay" class="cartTableDisplay table table-bordered">
     <tr>
        <th scope="col" id="cartTableDisplay-qtyHeading"><?php echo TABLE_HEADING_QUANTITY; ?></th>
        <th scope="col" id="cartTableDisplay-qtyUpdateHeading">&nbsp;</th>
        <th scope="col" id="cartTableDisplay-productsHeading"><?php echo TABLE_HEADING_PRODUCTS; ?></th>
        <th scope="col" id="cartTableDisplay-priceHeading"><?php echo TABLE_HEADING_PRICE; ?></th>
        <th scope="col" id="cartTableDisplay-totalsHeading"><?php echo TABLE_HEADING_TOTAL; ?></th>
        <th scope="col" id="cartTableDisplay-removeHeading">&nbsp;</th>
     </tr>
<!-- Loop through all products /-->
<?php
  foreach ($productArray as $product) {
?>
     <tr>
       <td class="qtyCell">
<?php
if ($product['flagShowFixedQuantity']) {
    echo $product['showFixedQuantityAmount'] . '' . $product['flagStockCheck'] . '' . $product['showMinUnits'];
} else {
    echo $product['quantityField'] . '' . $product['flagStockCheck'] . '' . $product['showMinUnits'];
}
?>
       </td>
       <td class="qtyUpdateCell">
<?php
  if ($product['buttonUpdate'] == '') {
    echo '' ;
  } else {
    echo $product['buttonUpdate'];
  }
?>
       </td>
       <td class="productsCell">
<a href="<?php echo $product['linkProductsName']; ?>"><?php echo $product['productsImage']; ?><?php echo $product['productsName'] . '' . $product['flagStockCheck'] . ''; ?></a>

<?php
  echo $product['attributeHiddenField'];
  if (isset($product['attributes']) && is_array($product['attributes'])) {
  echo '<div class="productsCell-attributes">';
  echo '<ul>';
    reset($product['attributes']);
    foreach ($product['attributes'] as $option => $value) {
?>

<li><?php echo $value['products_options_name'] . TEXT_OPTION_DIVIDER . nl2br($value['products_options_values_name']); ?></li>

<?php
    }
  echo '</ul>';
  echo '</div>';
  }
?>
       </td>
       <td class="priceCell"><?php echo $product['productsPriceEach']; ?></td>
       <td class="totalsCell"><?php echo $product['productsPrice']; ?></td>
       <td>
<?php
  if ($product['buttonDelete']) {
?>
           <a href="<?php echo zen_href_link(FILENAME_SHOPPING_CART, 'action=remove_product&product_id=' . $product['id']); ?>"><?php echo zen_image($template->get_template_dir(ICON_IMAGE_TRASH, DIR_WS_TEMPLATE, $current_page_base,'images/icons'). '/' . ICON_IMAGE_TRASH, ICON_TRASH_ALT); ?></a>
<?php
  }
  if ($product['checkBoxDelete'] ) {
    echo zen_draw_checkbox_field('cart_delete[]', $product['id']);
  }
?>
</td>
     </tr>
<?php
  } // end foreach ($productArray as $product)
?>
       <!-- Finished loop through all products /-->
       
<tr>
    <td colspan="1">

<?php
// show update cart button
  if (SHOW_SHOPPING_CART_UPDATE == 2 or SHOW_SHOPPING_CART_UPDATE == 3) {
?>
<div id="cartUpdate" class="text-center">
<?php echo zen_image_submit(ICON_IMAGE_UPDATE, ICON_UPDATE_ALT); ?>
</div>
<?php
  } else { // don't show update button below cart
?>
<?php
  } // show update button
?>
    </td>
    <td colspan="5">
<div id="cartTotal" class="text-right font-weight-bold">
<?php echo SUB_TITLE_SUB_TOTAL; ?> <?php echo $cartShowTotal; ?>
</div>
    </td>
</tr>       
       
      </table>
</div> 

<!--bof shopping cart buttons-->
<div id="shoppingCartDefault-btn-toolbar" class="btn-toolbar justify-content-between my-3" role="toolbar">
<?php echo zen_back_link() . zen_image_button(BUTTON_IMAGE_CONTINUE_SHOPPING, BUTTON_CONTINUE_SHOPPING_ALT) . '</a>'; ?>
<?php echo '<a href="' . zen_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL') . '">' . zen_image_button(BUTTON_IMAGE_CHECKOUT, BUTTON_CHECKOUT_ALT) . '</a>'; ?>
</div>

<!--eof shopping cart buttons-->

<?php
      if (SHOW_SHIPPING_ESTIMATOR_BUTTON == '2') {
/**
 * load the shipping estimator code if needed
 */
?>
      <?php require(DIR_WS_MODULES . zen_get_module_directory('shipping_estimator.php')); ?>

<?php
      }
?>

<?php
    if (SHOW_SHIPPING_ESTIMATOR_BUTTON == '1') {
?>
<div id="shoppingCartDefault-shoppingEstimator-btn-toolbar" class="btn-toolbar my-3" role="toolbar">
<?php echo '<a href="javascript:popupWindow(\'' . zen_href_link(FILENAME_POPUP_SHIPPING_ESTIMATOR) . '\')">' .
 zen_image_button(BUTTON_IMAGE_SHIPPING_ESTIMATOR, BUTTON_SHIPPING_ESTIMATOR_ALT) . '</a>'; ?>
</div>
 

 
<?php
    }
?>   
    
<!-- ** BEGIN PAYPAL EXPRESS CHECKOUT ** -->
<?php  // the tpl_ec_button template only displays EC option if cart contents >0 and value >0
if (defined('MODULE_PAYMENT_PAYPALWPP_STATUS') && MODULE_PAYMENT_PAYPALWPP_STATUS == 'True') {
  include(DIR_FS_CATALOG . DIR_WS_MODULES . 'payment/paypal/tpl_ec_button.php');
}
?>
<!-- ** END PAYPAL EXPRESS CHECKOUT ** -->

<?php
  } else {
?>

<h1 id="shoppingCartDefault-pageHeading" class="pageHeading"><?php echo TEXT_CART_EMPTY; ?></h1> 

<?php
$show_display_shopping_cart_empty = $db->Execute(SQL_SHOW_SHOPPING_CART_EMPTY);

while (!$show_display_shopping_cart_empty->EOF) {
?>

<?php
  if ($show_display_shopping_cart_empty->fields['configuration_key'] == 'SHOW_SHOPPING_CART_EMPTY_FEATURED_PRODUCTS') { ?>
<?php
/**
 * display the Featured Products Center Box
 */
?>
<?php require($template->get_template_dir('tpl_modules_featured_products.php',DIR_WS_TEMPLATE, $current_page_base,'centerboxes'). '/tpl_modules_featured_products.php'); ?>
<?php } ?>

<?php
  if ($show_display_shopping_cart_empty->fields['configuration_key'] == 'SHOW_SHOPPING_CART_EMPTY_SPECIALS_PRODUCTS') { ?>
<?php
/**
 * display the Special Products Center Box
 */
?>
<?php require($template->get_template_dir('tpl_modules_specials_default.php',DIR_WS_TEMPLATE, $current_page_base,'centerboxes'). '/tpl_modules_specials_default.php'); ?>
<?php } ?>

<?php
  if ($show_display_shopping_cart_empty->fields['configuration_key'] == 'SHOW_SHOPPING_CART_EMPTY_NEW_PRODUCTS') { ?>
<?php
/**
 * display the New Products Center Box
 */
?>
<?php require($template->get_template_dir('tpl_modules_whats_new.php',DIR_WS_TEMPLATE, $current_page_base,'centerboxes'). '/tpl_modules_whats_new.php'); ?>
<?php } ?>

<?php
  if ($show_display_shopping_cart_empty->fields['configuration_key'] == 'SHOW_SHOPPING_CART_EMPTY_UPCOMING') {
    include(DIR_WS_MODULES . zen_get_module_directory('centerboxes/' . FILENAME_UPCOMING_PRODUCTS));
  }
?>
<?php
  $show_display_shopping_cart_empty->MoveNext();
} // !EOF
?>

</form>

<?php
  }
?>  

</div>