<?php
/**
 * Plugin Name: Praxiv Wordpress Developer test Plugin.
 * Description: This plugin is an assignment for Praxiv Test.
 * Version:     1.0.0
 * Text Domain: praxiv
 * Domain Path: /languages
 */
defined( 'PRAXIV_FILE' ) || define( 'PRAXIV_FILE', __FILE__ );

include_once plugin_dir_path( PRAXIV_FILE ) . 'includes/class-praxiv.php';
/**
 * Returns the main instance of Praxiv.
 *
 * @return Praxiv
 */
function praxiv() {
    return Praxiv::instance();
}

// Global for backwards compatibility.
$GLOBALS['praxiv'] = praxiv();

// 1. Create a Wordpress plugin that extends the Woocommerce functionality and has the following features:

// Backend:
// 1. While adding/ editing the product from the backend there should be a box in the sidebar asking the user if this product is a “House number product”.
// 2. If the user selects Yes from the option, a text box should be visible to set the price per character.
// 3. 3 other text box will appear to set the extra price of the dimension chosen, like
// - 10cm: $100
// - 20cm- $150
// - 30cm- $200


// Front end:
// The woocommerce product that has the above setting enabled ( set as house number product ), when accessed in the front end ( product details page), should have 3 custom fields to select.
// - a text box to type up to 10 characters.
// - A colour to select from ( red, blue, black, white)
// - Dimension: 10cm, 20cm, 30cm
// Based on the options selected by the user, total price will be calculated using React ( price will keep changing if you add/ remove characters in the text box ).
// Total price would be:
// Product price set in the backend + (number of character x per character price ) + dimension chosen.

// Customers would see the final price in their cart and checkout page.
