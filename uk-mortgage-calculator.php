<?php

/*
 * Plugin Name: UK Mortgage Calculator
 * Plugin URI: https://github.com/igfitz/uk-mortgage-calculator
 * Description: A modern UK-specific mortgage and stamp duty calculator for WordPress.
 * Version: 1.4
 * Author: Creatif Digital
 * Author URI: https://creatif.digital
 * GitHub Plugin URI: https://github.com/igfitz/uk-mortgage-calculator
 * Primary Branch: main
 */

defined('ABSPATH') || exit;

// Enqueue styles and scripts
function ukmc_enqueue_assets() {
    wp_enqueue_style('ukmc-style', plugin_dir_url(__FILE__) . 'assets/style.css');
    wp_enqueue_script('ukmc-script', plugin_dir_url(__FILE__) . 'js/script.js', ['jquery'], null, true);
}
add_action('wp_enqueue_scripts', 'ukmc_enqueue_assets');

// Shortcode to display calculator
function ukmc_display_calculator() {
    ob_start();
    include plugin_dir_path(__FILE__) . 'templates/calculator-form.php';
    return ob_get_clean();
}
add_shortcode('uk_mortgage_calculator', 'ukmc_display_calculator');

// Admin menu for plugin settings
function ukmc_add_admin_menu() {
    add_options_page(
        'UK Mortgage Calculator Settings',
        'Mortgage Calculator',
        'manage_options',
        'ukmc-settings',
        'ukmc_settings_page'
    );
}
add_action('admin_menu', 'ukmc_add_admin_menu');

// Register settings
function ukmc_register_settings() {
    register_setting('ukmc_settings_group', 'ukmc_button_color');
    register_setting('ukmc_settings_group', 'ukmc_button_shape');
    register_setting('ukmc_settings_group', 'ukmc_button_radius');
    register_setting('ukmc_settings_group', 'ukmc_font_family');
}
add_action('admin_init', 'ukmc_register_settings');

// Settings page layout
function ukmc_settings_page() {
    ?>
    <div class="wrap">
        <h1>Mortgage Calculator Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields('ukmc_settings_group'); ?>
            <?php do_settings_sections('ukmc_settings_group'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Button Color (Hex)</th>
                    <td><input type="text" name="ukmc_button_color" value="<?php echo esc_attr(get_option('ukmc_button_color', '#0073aa')); ?>" placeholder="#0073aa"/></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Button Shape</th>
                    <td>
                        <select name="ukmc_button_shape">
                            <option value="square" <?php selected(get_option('ukmc_button_shape'), 'square'); ?>>Square</option>
                            <option value="rounded" <?php selected(get_option('ukmc_button_shape'), 'rounded'); ?>>Rounded</option>
                            <option value="pill" <?php selected(get_option('ukmc_button_shape'), 'pill'); ?>>Pill</option>
                        </select>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Button Border Radius (px)</th>
                    <td><input type="number" name="ukmc_button_radius" value="<?php echo esc_attr(get_option('ukmc_button_radius', '8')); ?>" /></td>
                </tr>
            
        <tr valign="top">
            <th scope="row">Font Family</th>
            <td>
                <input type="text" name="ukmc_font_family" value="<?php echo esc_attr(get_option('ukmc_font_family', 'Arial, sans-serif')); ?>" placeholder="e.g. Arial, Roboto, etc." />
            </td>
        </tr>
    </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}
