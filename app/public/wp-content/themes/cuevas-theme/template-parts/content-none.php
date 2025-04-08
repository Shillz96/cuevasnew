<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @package CuevasWesternWear
 */

?>

<section class="no-results not-found">
    <header class="page-header">
        <h1 class="page-title"><?php esc_html_e('Nothing Found', 'cuevas'); ?></h1>
    </header><!-- .page-header -->

    <div class="page-content">
        <?php
        if (is_home() && current_user_can('publish_posts')) :
            printf(
                '<p>' . wp_kses(
                    /* translators: 1: link to WP admin new post page. */
                    __('Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'cuevas'),
                    array(
                        'a' => array(
                            'href' => array(),
                        ),
                    )
                ) . '</p>',
                esc_url(admin_url('post-new.php'))
            );
        elseif (is_search()) :
            ?>
            <p><?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'cuevas'); ?></p>
            <?php
            get_search_form();
        elseif (is_woocommerce_activated() && is_woocommerce()) :
            ?>
            <p><?php esc_html_e('No products were found matching your selection.', 'cuevas'); ?></p>
            <div class="no-products-actions">
                <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="btn"><?php esc_html_e('Return to Shop', 'cuevas'); ?></a>
            </div>
            <?php
        else :
            ?>
            <p><?php esc_html_e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'cuevas'); ?></p>
            <?php
            get_search_form();
        endif;
        ?>
    </div><!-- .page-content -->
</section><!-- .no-results -->

<?php
// Helper function to check if WooCommerce is active
function is_woocommerce_activated() {
    return class_exists('WooCommerce');
} 