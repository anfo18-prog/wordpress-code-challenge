<?php

namespace WooCommerceCustomDiscounts;

class CustomDiscountsHandler {
    
    private static $instance = null;

    /**
     * Singleton pattern to ensure a single instance
     */
    public static function get_instance() {
        if ( self::$instance === null ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
	 * Construct.
	 */
	public function __construct() {
		// Sets filter hook woocommerce_package_rates to modify the shipping rates dynamically 
        add_filter( 'woocommerce_package_rates', [ $this , 'apply_custom_discounts' ], 10, 1 );
	}

    /**
     * Applies custom discounts based on current cart totals
     * @param array
     */
    public function apply_custom_discounts( array $rates ) {
        // Gets current cart vales
        $cart_subtotal = WC()->cart->get_subtotal();
        $discount_percentage = $this->_get_discount_percentage($cart_subtotal);

        // Iterates given rates to process possible discounts
        foreach ( $rates as $key => $rate ) {
            $rates[$key]->cost -= $this->_get_discount_value($discount_percentage, $rates[$key]->cost);
        }

        return $rates;
    }

    /**
     * Checks for custom discount for given rates
     * @param float
     */
    private function _get_discount_percentage(float $cart_subtotal) : float {
        // Sets discount percentage by subtotal
        $discount_percentage = 0;
        if ( $cart_subtotal > 200 ) {
            $discount_percentage = 2.5;
        } elseif ( $cart_subtotal > 150 ) {
            $discount_percentage = 5;
        } elseif ( $cart_subtotal > 100 ) {
            $discount_percentage = 10; 
        }

        return $discount_percentage;
    }

    /**
     * Applies assigned discount
     * @param float
     * @param float
     */
    private function _get_discount_value(float $discount_percentage, float $cost) : float {
        // Checks if applies disconut
        if ( $discount_percentage > 0 ) {
            return ( $cost * $discount_percentage ) / 100;
        } else {
            return 0;
        }
    }
}

?>