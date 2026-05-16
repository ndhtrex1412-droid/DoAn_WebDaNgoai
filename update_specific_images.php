<?php
require_once( 'wp-load.php' );

function attach_local_image( $file_path, $product_id ) {
    if ( ! file_exists( $file_path ) ) {
        echo "File not found: $file_path<br>";
        return;
    }

    require_once( ABSPATH . 'wp-admin/includes/image.php' );
    require_once( ABSPATH . 'wp-admin/includes/file.php' );
    require_once( ABSPATH . 'wp-admin/includes/media.php' );

    $image_data = file_get_contents( $file_path );
    $filename = basename( $file_path );

    $upload = wp_upload_bits( $filename, null, $image_data );
    if ( $upload['error'] ) {
        echo "Upload error: " . $upload['error'] . "<br>";
        return;
    }

    $attachment = array(
        'post_mime_type' => 'image/jpeg',
        'post_title'     => sanitize_file_name( $filename ),
        'post_content'   => '',
        'post_status'    => 'inherit'
    );

    $attach_id = wp_insert_attachment( $attachment, $upload['file'], $product_id );
    if ( ! is_wp_error( $attach_id ) ) {
        $attach_data = wp_generate_attachment_metadata( $attach_id, $upload['file'] );
        wp_update_attachment_metadata( $attach_id, $attach_data );
        delete_post_thumbnail( $product_id );
        set_post_thumbnail( $product_id, $attach_id );
        echo "Attached successfully to Product ID $product_id<br>";
    } else {
        echo "Attach error: " . $attach_id->get_error_message() . "<br>";
    }
}

// 1. Cập nhật La bàn
$compass_id = wc_get_product_id_by_sku( 'COMP-68-01' );
if ( $compass_id ) {
    echo "Updating Compass (ID: $compass_id)...<br>";
    attach_local_image( WP_CONTENT_DIR . '/uploads/camping-mock/compass_new.jpg', $compass_id );
} else {
    echo "Compass product not found by SKU.<br>";
}

// 2. Cập nhật Dây thừng
// Do danh sách 20 sp cũ không có dây thừng, ta sẽ tạo mới nếu chưa có
$args = array(
    'post_type' => 'product',
    's' => 'thừng',
    'posts_per_page' => 1
);
$query = new WP_Query( $args );
if ( $query->have_posts() ) {
    $rope_id = $query->posts[0]->ID;
    echo "Updating Rope (ID: $rope_id)...<br>";
    attach_local_image( WP_CONTENT_DIR . '/uploads/camping-mock/rope_new.jpg', $rope_id );
} else {
    echo "Rope product not found. Creating new Rope product...<br>";
    if ( class_exists( 'WC_Product_Simple' ) ) {
        $product = new WC_Product_Simple();
        $product->set_name( 'Dây thừng Paracord sinh tồn' );
        $product->set_sku( 'ROPE-68-01' );
        $product->set_regular_price( 120000 );
        $product->set_short_description( 'Dây thừng Paracord siêu bền bỉ, lõi 7 sợi chịu lực cao, phù hợp cho việc dựng lều, cứu hộ, thắt nút an toàn trong mọi chuyến dã ngoại.' );
        $rope_id = $product->save();
        wp_set_object_terms( $rope_id, 'Đồ sinh tồn', 'product_cat' );
        attach_local_image( WP_CONTENT_DIR . '/uploads/camping-mock/rope_new.jpg', $rope_id );
        echo "New Rope Product created with ID $rope_id<br>";
    } else {
        echo "WooCommerce is not active.<br>";
    }
}
echo "Done.";
?>
