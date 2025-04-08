<?php
/**
 * The Template for displaying all single products
 *
 * This template has been customized for Cuevas Western Wear with an Aether-inspired design.
 * Clean, two-column layout with vertical thumbnails, generous whitespace, and elegant typography.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 1.6.4
 */

defined('ABSPATH') || exit;

get_header('shop');

/**
 * Hook: woocommerce_before_main_content.
 */
do_action('woocommerce_before_main_content');

?>
<div class="product-page-wrapper">
    <?php while (have_posts()) : ?>
        <?php the_post(); ?>
        
        <?php
        /**
         * woocommerce_before_single_product hook.
         *
         * @hooked woocommerce_output_all_notices - 10
         */
        do_action('woocommerce_before_single_product');

        if (post_password_required()) {
            echo get_the_password_form(); // WPCS: XSS ok.
            return;
        }
        ?>
        
        <div id="product-<?php the_ID(); ?>" <?php wc_product_class('single-product-container', $product); ?>>
            <div class="product-main-content">
                <div class="product-gallery-column">
                    <?php
                    /**
                     * Hook: woocommerce_before_single_product_summary.
                     *
                     * @hooked woocommerce_show_product_sale_flash - 10
                     * @hooked woocommerce_show_product_images - 20
                     */
                    do_action('woocommerce_before_single_product_summary');
                    ?>
                </div>

                <div class="product-details-column">
                    <div class="summary entry-summary">
                        <?php
                        /**
                         * Hook: woocommerce_single_product_summary.
                         *
                         * @hooked woocommerce_template_single_title - 5
                         * @hooked woocommerce_template_single_rating - 10
                         * @hooked woocommerce_template_single_price - 10
                         * @hooked woocommerce_template_single_excerpt - 20
                         * @hooked woocommerce_template_single_add_to_cart - 30
                         * @hooked woocommerce_template_single_meta - 40
                         * @hooked woocommerce_template_single_sharing - 50
                         * @hooked WC_Structured_Data::generate_product_data() - 60
                         */
                        do_action('woocommerce_single_product_summary');
                        ?>
                        
                        <div class="product-features">
                            <?php
                            // Display product features if they exist
                            $features = get_post_meta($product->get_id(), '_product_features', true);
                            if (!empty($features)) {
                                echo '<h3>' . esc_html__('Features', 'cuevas') . '</h3>';
                                echo '<ul class="features-list">';
                                $features_array = explode("\n", $features);
                                foreach ($features_array as $feature) {
                                    echo '<li><i class="fas fa-check"></i> ' . esc_html(trim($feature)) . '</li>';
                                }
                                echo '</ul>';
                            }
                            ?>
                        </div>
                        
                        <div class="shipping-info">
                            <p><i class="fas fa-truck"></i> <?php esc_html_e('Free shipping on orders over $100', 'cuevas'); ?></p>
                            <p><i class="fas fa-undo"></i> <?php esc_html_e('30-day return policy', 'cuevas'); ?></p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="product-additional-info">
                <?php
                /**
                 * Hook: woocommerce_after_single_product_summary.
                 *
                 * @hooked woocommerce_output_product_data_tabs - 10
                 * @hooked woocommerce_upsell_display - 15
                 * @hooked woocommerce_output_related_products - 20
                 */
                do_action('woocommerce_after_single_product_summary');
                ?>
            </div>
        </div>

        <?php do_action('woocommerce_after_single_product'); ?>
        
    <?php endwhile; // end of the loop. ?>
</div>

<?php
/**
 * Hook: woocommerce_after_main_content.
 */
do_action('woocommerce_after_main_content');

get_footer('shop');
