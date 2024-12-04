# Wordpress Code Challenge

A WordPress 6.7.1 base project with WooCommerce 9.4.2 plugin and a custom plugin designed to enhance WooCommerce functionality adding custom shipping discounts based on total cart values, and free shiping for VIP Customers

## Features (Custom Discounts Plugin)

- Mayor discount: If the cart total is above $100, it applies a 10% discount on the shipping cost.
- Regular discount: If the cart total  is above $150, it applies a 5% discount on the shipping cost.
- Minor discount: If the cart total is above $200, it applies a 2.5% discount on the shipping cost.
- Free shiping: If the user has the custom role called **VIP_Customer** the shipping cost is free.

## Requirements

- PHP 7.4 or higher

## Installation

1. Create a database for WordPress on your web server, as well as a MySQL (or MariaDB) user who has all privileges for accessing and modifying it.
2. Run the WordPress installation script by accessing the URL in a web browser. This should be the URL where you cloned or uploaded this project files
2. Navigate to the WordPress admin panel.
3. Go to **Plugins**.
4. Activate **WooCommerce** and **WooCommerce custom discounts** from the list.