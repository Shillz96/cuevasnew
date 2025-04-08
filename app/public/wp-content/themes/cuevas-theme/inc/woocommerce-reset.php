<?php
/**
 * Reset WooCommerce completely
 */
function cuevas_reset_woocommerce() {
    if (!class_exists('WooCommerce')) {
        return;
    }

    // Delete all WooCommerce options
    global $wpdb;
    $wpdb->query("DELETE FROM $wpdb->options WHERE option_name LIKE 'woocommerce_%';");
    
    // Delete all product terms
    $taxonomies = array('product_cat', 'product_tag', 'product_visibility');
    foreach ($taxonomies as $taxonomy) {
        $terms = get_terms(array(
            'taxonomy' => $taxonomy,
            'hide_empty' => false,
        ));
        foreach ($terms as $term) {
            wp_delete_term($term->term_id, $taxonomy);
        }
    }

    // Flush rewrite rules
    flush_rewrite_rules();

    // Force WooCommerce to run its installer
    delete_option('woocommerce_db_version');
    delete_option('woocommerce_version');
    
    // Redirect to prevent multiple executions
    wp_redirect(admin_url('admin.php?page=wc-settings'));
    exit;
}

// Add admin menu item
function cuevas_add_reset_menu() {
    add_submenu_page(
        'woocommerce',
        'Reset WooCommerce',
        'Reset WooCommerce',
        'manage_options',
        'wc-reset',
        'cuevas_reset_page'
    );
}
add_action('admin_menu', 'cuevas_add_reset_menu');

// Create the reset page
function cuevas_reset_page() {
    if (isset($_POST['reset_woocommerce']) && check_admin_referer('reset_woocommerce')) {
        cuevas_reset_woocommerce();
    }
    ?>
    <div class="wrap">
        <h1>Reset WooCommerce</h1>
        <p>This will reset all WooCommerce settings to their defaults.</p>
        <form method="post">
            <?php wp_nonce_field('reset_woocommerce'); ?>
            <input type="submit" name="reset_woocommerce" class="button button-primary" value="Reset WooCommerce" onclick="return confirm('Are you sure you want to reset WooCommerce? This cannot be undone.');">
        </form>
    </div>
    <?php
} 