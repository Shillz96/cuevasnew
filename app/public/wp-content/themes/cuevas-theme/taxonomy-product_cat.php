<?php
/**
 * The Template for displaying product category archives
 *
 * This template has been customized for Cuevas Western Wear with an Aether-inspired design.
 * It shares the core layout and design principles with the main shop page.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.7.0
 */

defined('ABSPATH') || exit;

get_header('shop');

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action('woocommerce_before_main_content');

// Get the current category
$current_category = get_queried_object();
$category_image_id = get_term_meta($current_category->term_id, 'thumbnail_id', true);
$category_image = $category_image_id ? wp_get_attachment_url($category_image_id) : '';
?>

<div class="category-header">
    <?php if ($category_image) : ?>
        <div class="category-banner" style="background-image: url('<?php echo esc_url($category_image); ?>')">
            <div class="category-banner-overlay"></div>
            <div class="category-banner-content">
                <h1 class="category-title"><?php woocommerce_page_title(); ?></h1>
                <?php if ($current_category->description) : ?>
                    <div class="category-description">
                        <?php echo wp_kses_post($current_category->description); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php else : ?>
        <h1 class="category-title"><?php woocommerce_page_title(); ?></h1>
        <?php if ($current_category->description) : ?>
            <div class="category-description">
                <?php echo wp_kses_post($current_category->description); ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<div class="shop-container">
    <?php if (woocommerce_product_loop()) : ?>
        <div class="shop-filters">
            <button class="filter-toggle">
                <i class="fas fa-sliders-h"></i> <?php esc_html_e('Filter', 'cuevas'); ?>
            </button>
            <?php
            /**
             * Hook: woocommerce_before_shop_loop.
             *
             * @hooked woocommerce_output_all_notices - 10
             * @hooked woocommerce_result_count - 20
             * @hooked woocommerce_catalog_ordering - 30
             */
            do_action('woocommerce_before_shop_loop');
            ?>
        </div>

        <div class="shop-content-wrapper">
            <div class="filter-sidebar">
                <?php do_action('cuevas_before_shop_sidebar'); ?>
                
                <div class="filter-group">
                    <h4><?php esc_html_e('Subcategories', 'cuevas'); ?></h4>
                    <?php
                    $subcategories = get_terms(array(
                        'taxonomy' => 'product_cat',
                        'hide_empty' => true,
                        'parent' => $current_category->term_id,
                    ));
                    
                    if (!empty($subcategories) && !is_wp_error($subcategories)) {
                        echo '<ul class="product-subcategories">';
                        foreach ($subcategories as $subcategory) {
                            echo '<li><a href="' . esc_url(get_term_link($subcategory)) . '">' . esc_html($subcategory->name) . '</a></li>';
                        }
                        echo '</ul>';
                    }
                    ?>
                </div>
                
                <div class="filter-group">
                    <h4><?php esc_html_e('Price', 'cuevas'); ?></h4>
                    <?php
                    the_widget('WC_Widget_Price_Filter');
                    ?>
                </div>
                
                <?php if (function_exists('wc_get_attribute_taxonomies')) : ?>
                    <?php $attribute_taxonomies = wc_get_attribute_taxonomies(); ?>
                    <?php if (!empty($attribute_taxonomies)) : ?>
                        <?php foreach ($attribute_taxonomies as $tax) : ?>
                            <?php $attribute_taxonomy_name = wc_attribute_taxonomy_name($tax->attribute_name); ?>
                            <?php $terms = get_terms($attribute_taxonomy_name); ?>
                            <?php if (!empty($terms)) : ?>
                                <div class="filter-group">
                                    <h4><?php echo esc_html($tax->attribute_label); ?></h4>
                                    <ul class="attribute-options">
                                        <?php foreach ($terms as $term) : ?>
                                            <li>
                                                <a href="<?php echo esc_url(add_query_arg(array('filter_' . $tax->attribute_name => $term->slug), get_term_link($current_category))); ?>">
                                                    <?php echo esc_html($term->name); ?>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                <?php endif; ?>
                
                <?php do_action('cuevas_after_shop_sidebar'); ?>
            </div>

            <div class="products-grid">
                <?php
                woocommerce_product_loop_start();

                if (wc_get_loop_prop('total')) {
                    while (have_posts()) {
                        the_post();

                        /**
                         * Hook: woocommerce_shop_loop.
                         */
                        do_action('woocommerce_shop_loop');

                        wc_get_template_part('content', 'product');
                    }
                }

                woocommerce_product_loop_end();
                ?>
            </div>
        </div>

        <?php
        /**
         * Hook: woocommerce_after_shop_loop.
         *
         * @hooked woocommerce_pagination - 10
         */
        do_action('woocommerce_after_shop_loop');
        ?>

    <?php else : ?>
        <div class="no-products-found">
            <?php
            /**
             * Hook: woocommerce_no_products_found.
             *
             * @hooked wc_no_products_found - 10
             */
            do_action('woocommerce_no_products_found');
            ?>
        </div>
    <?php endif; ?>
</div>

<?php
/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action('woocommerce_after_main_content');

get_footer(); 