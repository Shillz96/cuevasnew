<?php
/**
 * Custom template tags for Cuevas theme
 *
 * @package CuevasWesternWear
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Prints HTML with meta information for categories, tags and comments.
 */
function cuevas_entry_meta() {
    // Hide category and tag text for pages.
    if ('post' === get_post_type()) {
        /* translators: used between list items, there is a space after the comma */
        $categories_list = get_the_category_list(esc_html__(', ', 'cuevas'));
        if ($categories_list) {
            /* translators: 1: list of categories. */
            printf('<span class="cat-links">' . esc_html__('Posted in %1$s', 'cuevas') . '</span>', $categories_list); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        }

        /* translators: used between list items, there is a space after the comma */
        $tags_list = get_the_tag_list('', esc_html_x(', ', 'list item separator', 'cuevas'));
        if ($tags_list) {
            /* translators: 1: list of tags. */
            printf('<span class="tags-links">' . esc_html__('Tagged %1$s', 'cuevas') . '</span>', $tags_list); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        }
    }

    if (!is_single() && !post_password_required() && (comments_open() || get_comments_number())) {
        echo '<span class="comments-link">';
        comments_popup_link(
            sprintf(
                wp_kses(
                    /* translators: %s: post title */
                    __('Leave a Comment<span class="screen-reader-text"> on %s</span>', 'cuevas'),
                    array(
                        'span' => array(
                            'class' => array(),
                        ),
                    )
                ),
                get_the_title()
            )
        );
        echo '</span>';
    }

    edit_post_link(
        sprintf(
            wp_kses(
                /* translators: %s: Name of current post. Only visible to screen readers */
                __('Edit <span class="screen-reader-text">%s</span>', 'cuevas'),
                array(
                    'span' => array(
                        'class' => array(),
                    ),
                )
            ),
            get_the_title()
        ),
        '<span class="edit-link">',
        '</span>'
    );
}

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function cuevas_categorized_blog() {
    $all_cats = get_transient('cuevas_categories');
    if (false === $all_cats) {
        $all_cats = get_categories(array(
            'fields'     => 'ids',
            'hide_empty' => 1,
        ));
        
        // Count categories that have posts
        $all_cats = count($all_cats);
        
        set_transient('cuevas_categories', $all_cats);
    }
    
    if ($all_cats > 1) {
        return true;
    } else {
        return false;
    }
}

/**
 * Flush out the transients used in cuevas_categorized_blog.
 */
function cuevas_category_transient_flusher() {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    delete_transient('cuevas_categories');
}
add_action('edit_category', 'cuevas_category_transient_flusher');
add_action('save_post', 'cuevas_category_transient_flusher');

/**
 * Display featured image or fallback
 */
function cuevas_post_thumbnail() {
    if (post_password_required() || is_attachment()) {
        return;
    }

    if (has_post_thumbnail()) {
        echo '<div class="post-thumbnail">';
        the_post_thumbnail('large', array('class' => 'featured-image'));
        echo '</div>';
    }
}

/**
 * Display customized pagination
 */
function cuevas_pagination() {
    if (is_singular()) {
        return;
    }

    global $wp_query;
    
    // Don't print empty markup if there's only one page.
    if ($wp_query->max_num_pages < 2) {
        return;
    }
    
    $paged = get_query_var('paged') ? intval(get_query_var('paged')) : 1;
    $total = isset($wp_query->max_num_pages) ? $wp_query->max_num_pages : 1;
    
    echo '<div class="pagination">';
    
    // Prev page link
    if ($paged > 1) {
        echo '<a href="' . esc_url(get_previous_posts_page_link()) . '" class="page-prev"><i class="fas fa-chevron-left"></i></a>';
    } else {
        echo '<span class="page-prev disabled"><i class="fas fa-chevron-left"></i></span>';
    }
    
    // Page numbers
    $total_shown = 5; // Number of page links to show
    $start = max(1, min($paged - floor($total_shown / 2), $total - $total_shown + 1));
    $end = min($total, $start + $total_shown - 1);
    
    // Adjust if we're at the end
    if ($end < $total_shown) {
        $start = 1;
    }
    
    for ($i = $start; $i <= $end; $i++) {
        $active_class = ($i === $paged) ? ' active' : '';
        echo '<a href="' . esc_url(get_pagenum_link($i)) . '" class="page-number' . $active_class . '">' . $i . '</a>';
    }
    
    // Next page link
    if ($paged < $total) {
        echo '<a href="' . esc_url(get_next_posts_page_link()) . '" class="page-next"><i class="fas fa-chevron-right"></i></a>';
    } else {
        echo '<span class="page-next disabled"><i class="fas fa-chevron-right"></i></span>';
    }
    
    echo '</div>';
} 