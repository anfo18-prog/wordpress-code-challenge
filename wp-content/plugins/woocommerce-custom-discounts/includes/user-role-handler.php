<?php 

namespace WooCommerceCustomDiscounts;

class UserRoleHandler {
    
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
        add_filter( 'woocommerce_package_rates', [ $this , 'check_user_role' ], 10, 1 );
        
        // User init action hook to set new VIP customer role
        add_action( 'init', [ $this , 'add_vip_customer_role' ], 10, 1 );
	}

    /**
     * Checks if user role applies to custom discount
     * @param array
     */
    public function add_vip_customer_role() {
        add_role(
            'VIP_Customer',
            'VIP Customer',
            [
                'read' => true,
                'edit_posts' => false,
                'delete_posts' => false,
                'level_0' => true,
            ]
        );
    }

    /**
     * Checks if user role applies to custom discount
     * @param array
     */
    public function check_user_role( array $rates ) {
        // Gets current user vales
        $user = wp_get_current_user();
        
        if ( $this->_check_if_user_is_VIP_role( $user->roles ) ) {
            return $this->_get_free_shipping_element( $rates );
        } else {
            return $this->_get_rates_without_free_shipping( $rates );
        }

        return $rates;
    }

    /**
     * Checks if it apply for VIP_Customer role
     * @param array
     */
    private function _check_if_user_is_VIP_role(array $roles) : bool {
        return in_array ( 'VIP_Customer', $roles );
    }

    /**
     * Gets free shipping rate
     * @param array
     */
    private function _get_free_shipping_element(array $rates) : object {
        return array_filter ( $rates, function ($rate) {
            return $rate->get_method_id() === 'free_shipping'; 
        });
    }

    /**
     * Gets other rates without free shipping one
     * @param array
     */
    private function _get_rates_without_free_shipping(array $rates) : array {
        return array_filter ( $rates, function ($rate) {
            return $rate->get_method_id() !== 'free_shipping'; 
        });
    }
}

?>