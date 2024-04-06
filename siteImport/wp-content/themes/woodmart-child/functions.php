<?php
/**
 * Enqueue script and styles for child theme
 */
function woodmart_child_enqueue_styles() {
	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( 'woodmart-style' ), woodmart_get_theme_info( 'Version' ) );
}
add_action( 'wp_enqueue_scripts', 'woodmart_child_enqueue_styles', 10010 );

/**
 * Фильтр поискового запроса для поиска по краткому описанию товаров.
 */
function filter_search_by_dimensions( $query ) {
    if ( ! is_admin() && $query->is_main_query() && isset($_GET['post_type']) && $_GET['post_type'] == 'product' ) {
        $length = isset($_GET['length']) ? sanitize_text_field($_GET['length']) : '';
        $width = isset($_GET['width']) ? sanitize_text_field($_GET['width']) : '';
        $height = isset($_GET['height']) ? sanitize_text_field($_GET['height']) : '';

        $meta_query = []; // Начальное условие для meta_query

        if( $length ) {
            $meta_query[] = [
                'key' => '_length',
                'value' => $length,
                'compare' => 'LIKE'
            ];
        }

        if( $width ) {
            $meta_query[] = [
                'key' => '_width',
                'value' => $width,
                'compare' => 'LIKE'
            ];
        }

        if( $height ) {
            $meta_query[] = [
                'key' => '_height',
                'value' => $height,
                'compare' => 'LIKE'
            ];
        }

        if( ! empty( $meta_query ) ) {
            $meta_query['relation'] = 'AND'; // Если есть хотя бы один критерий, добавляем логическое И
            $query->set('meta_query', $meta_query);
        }
    }
}
add_action( 'pre_get_posts', 'filter_search_by_dimensions' );

function custom_woocommerce_searchform( $atts ) {
    $a = shortcode_atts( array(
        'width' => '',
        'height' => '',
        'length' => '',
    ), $atts );

    $form = '<form role="search" method="get" class="woocommerce-product-search custom-search-form" action="' . esc_url( home_url( '/' ) ) . '">';
    $form .= '<input type="hidden" name="post_type" value="product" />';
    
   
    // Ширина
    $form .= '<div class="custom-search-field">';
    $form .= '<select name="width" class="search-field">';
    $form .= '<option value="">' . esc_html__( 'Ширина', 'woocommerce' ) . '</option>';
    for ( $i = 175; $i <= 315; $i += 10 ) {
        $form .= '<option value="' . $i . '">' . $i . '</option>';
    }
    $form .= '</select>';
    $form .= '</div>';
    
    // Высота
    $form .= '<div class="custom-search-field">';
    $form .= '<select name="height" class="search-field">';
    $form .= '<option value="">' . esc_html__( 'Высота', 'woocommerce' ) . '</option>';
    $heights = array(10.5, 30, 35, 40, 45, 50, 55, 60, 65, 70, 75, 85);
    foreach ( $heights as $height ) {
        $form .= '<option value="' . $height . '">' . $height . '</option>';
    }
    $form .= '</select>';
    $form .= '</div>';
	 // Радиус
    $form .= '<div class="custom-search-field">';
    $form .= '<select name="length" class="search-field">';
    $form .= '<option value="">' . esc_html__( 'Радиус', 'woocommerce' ) . '</option>';
    for ( $i = 14; $i <= 22; $i++ ) {
        if ( $i != 21 ) { // Пропускаем 21
            $form .= '<option value="' . $i . '">' . $i . '</option>';
        }
    }
    $form .= '</select>';
    $form .= '</div>';
    
    
    // Кнопка поиска
    $form .= '<div class="custom-search-button">';
    $form .= '<button type="submit" class="search-button">' . esc_html__( 'Поиск', 'woocommerce' ) . '</button>';
    $form .= '</div>';
    $form .= '</form>';

    return $form;
}
add_shortcode( 'custom_woocommerce_search', 'custom_woocommerce_searchform' );