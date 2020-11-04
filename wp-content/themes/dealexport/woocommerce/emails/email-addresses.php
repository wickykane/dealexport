<?php
/**
 * Email Addresses
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-addresses.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates/Emails
 * @version 3.5.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$text_align = is_rtl() ? 'right' : 'left';
$address    = $order->get_formatted_billing_address();
$shipping   = $order->get_formatted_shipping_address();
$isShowShipInfo = !$order->has_shipping_method('local_pickup');
?>
<table id="addresses" cellspacing="0" cellpadding="0" style="width: 100%; vertical-align: top; margin-bottom: 40px; padding:0;" border="0">
	<tr>
		<td style="text-align:<?php echo esc_attr( $text_align ); ?>; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; border:0; padding:0;" valign="top" width="50%">
			<h2><?php esc_html_e( 'Billing address', 'woocommerce' ); ?></h2>

			<address class="address">
				<?php echo wp_kses_post( $address ? $address : esc_html__( 'N/A', 'woocommerce' ) ); ?>
				<?php if ( $order->get_billing_phone() ) : ?>
					<br/><?php echo esc_html( $order->get_billing_phone() ); ?>
				<?php endif; ?>
				<?php if ( $order->get_billing_email() ) : ?>
					<br/><?php echo esc_html( $order->get_billing_email() ); ?>
				<?php endif; ?>
			</address>
		</td>
		<?php if ( ! wc_ship_to_billing_address_only() && $order->needs_shipping_address() && $shipping ) : ?>
			<td style="text-align:<?php echo esc_attr( $text_align ); ?>; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; padding:0;" valign="top" width="50%">
				<h2><?php esc_html_e( 'Shipping address', 'woocommerce' ); ?></h2>

				<address class="address"><?php echo wp_kses_post( $shipping ); ?></address>
			</td>
		<?php endif; ?>
	</tr>
</table>
<?php if($isShowShipInfo) : ?>
	<table id="addresses" cellspacing="0" cellpadding="0" style="width: 100%; vertical-align: top; margin-bottom: 40px; padding:0;" border="0">
	<tr>
		<td style="text-align:<?php echo esc_attr( $text_align ); ?>; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; border:0; padding:0;" valign="top" width="50%">
			<h2><?php esc_html_e( 'Livraison de la marchandise', 'woocommerce' ); ?></h2>
			<address class="address">
			Les livraisons seront effectuées le 4 décembre 2020
			<br>
			Le montant de la livraison sera reservé au CHU de Lille
			<br>
			</address>
		</td>
	</tr>
</table>
<?php endif;?>
<table id="addresses" cellspacing="0" cellpadding="0" style="width: 100%; vertical-align: top; margin-bottom: 40px; padding:0;" border="0">
	<tr>
		<td style="text-align:<?php echo esc_attr( $text_align ); ?>; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; border:0; padding:0;" valign="top" width="50%">
			<h2><?php esc_html_e( 'Retrait de la marchandise', 'woocommerce' ); ?></h2>
			<address class="address">
			Wereso Lille
			<br>
			104 Rue Nationale
			<br>
			59800 Lille
			<br><br>
			Du Lundi au vendredi
			<br>
			De 9h00 à 18h00
			<br><br>
			Téléphone: +33 3 62 26 01 10
			<br>
			Contact: M. Lény Hénon
			<br>
			</address>
		</td>
	</tr>
</table>