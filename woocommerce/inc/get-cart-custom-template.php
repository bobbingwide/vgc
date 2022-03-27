<?php do_action( 'woocommerce_before_cart_contents' ); ?>
<?php $cart = WC()->cart->get_cart(); ?>
<?php $total = 0; ?>
<?php $i = 0; ?>
<?php
// If there is anything in the cart
if(count($cart) > 0) { ?>
  <h2 class="w-100 clearfix fw-bold mb-4 text-white text-start" style="font-size: 1.5rem">Order Breakdown</h2>
  <?php
  // Loop through the cart items and display them
  foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
    $_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
    $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
    if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) { ?>
      <?php
      $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
      ?>
      <tr class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
        <div class="clearfix w-100 d-block" style="<?php echo $i > 0 ? "padding-top:30px; border-top:1px solid #FFF;" : "" ?>">
        <td class="product-name text-white" data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>">
        <?php
        if ( ! $product_permalink ) {
          echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
        }
        else {
          echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
        }
        do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );
        echo wc_get_formatted_cart_item_data( $cart_item );
        if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'])) {
          echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>', $product_id ));
        }
        ?>
      </td>
      <!-- The product price -->
      <td class="product-price" data-title="<?php esc_attr_e( 'Price', 'woocommerce' ); ?>">
        <strong><?php echo '£' . number_format($cart_item['custom_price'], 2) ?></strong>
      </td>
    </div>
  </tr>
  <!-- Calculate the totals from the added meta data - custom price -->
  <?php $total += $cart_item['custom_price']; ?>
<?php } $i++; } ?>
<h3 class="pb-2" style="font-size: 1rem">Cart total</h3>
<div class="product-subtotal" data-title="<?php esc_attr_e( 'Total', 'woocommerce' ); ?>">
  <strong><?php echo '£' . number_format($total, 2); ?></strong>
</div>
<?php }
// There is nothing in the cart
else { ?>
  <h3 class="pb-2">Cart</h3>
  <p class="text-white">There is nothing in your cart yet</p>
<?php }
?>
<?php do_action( 'woocommerce_cart_contents' ); ?>
<?php do_action( 'woocommerce_after_cart_contents' ); ?>
