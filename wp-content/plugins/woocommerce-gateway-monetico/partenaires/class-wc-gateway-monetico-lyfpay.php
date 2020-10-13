<?php
class WC_Gateway_MoneticoLyfpay extends WC_Gateway_Monetico {	
	public function __construct() { 
        $this->id = 'monetico_lyfpay';
        $this->order_button_text  = __( 'Proceed to lyf pay', 'monetico' ); // Payer par lyf pay
        $this->method_title = 'Monetico lyf pay';
        $this->method_description = sprintf(__( "Accept payments %s, Monetico partner.", 'monetico' ), 'lyf pay'); // Accepter les paiements lyf pay, partenaire Monetico.
        $this->logo = plugins_url('woocommerce-gateway-monetico/logo/lyfpay.png');
        $this->has_fields = false;	
        $this->init_form_fields();
        $this->init_settings();
        $this->icon = apply_filters('woocommerce_monetico_lyfpay_icon', $this->settings['gateway_image']);
        $this->title = $this->settings['title'];
        $this->description =  $this->settings['description'];
        if ( version_compare( WOOCOMMERCE_VERSION, '2.2', '>=' ) ):
            $this->supports = array('products');
        endif;
        add_action('woocommerce_receipt_' . $this->id, array($this, 'receipt_page'));
        add_action('woocommerce_update_options_payment_gateways', array(&$this, 'process_admin_options')); 
        add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
    }
	public function init_form_fields() {
		$this->form_fields = array(
				'enabled' => array(
								'title' => __( "Enable/Disable", 'monetico' ), 
								'type' => 'checkbox', 
								'label' => __( "Check to enable the payment lyf pay.", 'monetico' ), 
								'default' => 'no'
							), 
				'title' => array(
								'title' => __( "Title", 'monetico' ), 
								'type' => 'text', 
								'description' => __( "Title displayed when selecting the method of payment.", 'monetico' ), 
								'default' => __( "lyf pay", 'monetico' ),
								'css' => 'width:150px',
								'desc_tip' => true
							),
				'description' => array(
								'title' => __( "Message client", 'monetico' ), 
								'type' => 'textarea', 
								'description' => __( "Inform the customer of payment by credit card.", 'monetico' ), 
								'default' => __( "By choosing this method of payment, you can make your secure payment with lyf pay.", 'monetico' ),
								'desc_tip' => true
							), 
				'gateway_image' => array(
								'title' => __( "Icon payment", 'monetico' ), 
								'type' => 'text', 
								'description' => __( "Url of the image displayed when selecting the method of payment.", 'monetico' ),
								'default' => plugins_url('woocommerce-gateway-monetico/logo/logo-lyfpay.png'),
								'css' => 'width:90%',
								'desc_tip' => true
							),
				'montants_plafond' => array(
					'title' => __( "Ceiling amounts:", 'monetico' ),
					'type' => 'title'
				),
				'montant_minimum' => array(
								'title' => __( "Minimum amount", 'monetico' ), 
								'type' => 'text', 
								'description' => __( "Minimum amount needed to offer this payment method.", 'monetico' ), 
								'default' => '',
								'css' => 'width:150px',
								'desc_tip' => true
							), 
				'montant_maximum' => array(
								'title' => __( "Maximum amount", 'monetico' ), 
								'type' => 'text', 
								'description' => __( "Maximum amount needed to offer this payment method.", 'monetico' ), 
								'default' => '',
								'css' => 'width:150px',
								'desc_tip' => true
							)
			);
	}
	public function admin_options() {
        ?>
        <p><img src="<?php echo $this->logo; ?>" /></p>
        <h2><?php _e("lyf pay", 'monetico'); echo " — "; _e("Monetico payment", 'monetico'); echo "<sup>".PASSERELLE_MONETICO_VERSION."</sup>"; if(function_exists('wc_back_link')) { wc_back_link( __("Back to payments", 'monetico'), admin_url('admin.php?page=wc-settings&tab=checkout') ); } ?></h2>
        <p><?php printf(__("The %s payment method requires a specific contract. Make sure you activate it only if you have the appropriate contracts. If necessary, contact Monetico and the financial partner.", 'monetico'), 'lyf pay'); // Le moyen de paiement lyf pay nécessite un contrat spécifique. Veillez à ne l'activer que si vous disposez des contrats adaptés. Si besoin renseignez-vous auprès de Monetico et du partenaire financier.?></p>
        <p><?php printf(__("The main Monetico settings, necessary to use the %s payment method, can be accessed on the Monetico Gateway %ssettings page%s.", 'monetico'), 'lyf pay', '<a href="'.admin_url('admin.php?page=wc-settings&tab=checkout&section=monetico').'">', '</a>'); // Les réglages principaux de Monetico, nécessaires à l'utilisation du moyen de paiement lyf pay, sont accessibles sur la page de réglage de la passerelle Monetico. ?></p>
        <table class="form-table">
        <?php
            $this->generate_settings_html();
        ?>
        </table><!--/.form-table-->
        <?php
    }
	public function receipt_page( $order ) {
		global $protocole_monetico;
		$protocole_monetico = 'lyfpay'; // 1euro, 3xcb, 4xcb, paypal ou lyfpay
		parent::receipt_page( $order );
	}
}
if(!is_admin())
	add_filter( 'woocommerce_available_payment_gateways', 'abw_disponibilite_lyfpay' );
function abw_disponibilite_lyfpay( $_available_gateways ) {
	$monetico_lyfpay = isset($_available_gateways['monetico_lyfpay']) ? $_available_gateways['monetico_lyfpay'] : NULL;
	if ( isset( $monetico_lyfpay ) ) {
		$total = WC()->cart->total;
		if (is_wc_endpoint_url( 'order-pay' )) {
			$order_id = (int) get_query_var('order-pay');
			$order = new WC_Order($order_id);
			$total = $order->get_total();
		}
    	if($monetico_lyfpay->settings['montant_minimum']!=''&&
			$monetico_lyfpay->settings['montant_minimum']>$total) {
			unset($monetico_lyfpay);
		}
		if(isset($monetico_lyfpay)&&$monetico_lyfpay->settings['montant_maximum']!=''&&
			$monetico_lyfpay->settings['montant_maximum']<$total) {
			unset($monetico_lyfpay);
		}
  	}
  	return $_available_gateways;
}