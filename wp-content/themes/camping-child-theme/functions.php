<?php
/**
 * Camping Store Child Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Camping Store Child
 * @since 1.0.0
 */

/**
 * Enqueue styles from the parent theme
 */
function camping_child_enqueue_styles() {
    // Parent theme style handle for Astra is usually 'astra-theme-css'
    wp_enqueue_style( 'astra-theme-css', get_template_directory_uri() . '/style.css' );
    
    // Enqueue the child theme stylesheet
    wp_enqueue_style( 'camping-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( 'astra-theme-css' ),
        wp_get_theme()->get('Version')
    );
}
add_action( 'wp_enqueue_scripts', 'camping_child_enqueue_styles' );

/**
 * ==============================================================================
 * Tích hợp Google Fonts (Inter) cho giao diện chuyên nghiệp
 * ==============================================================================
 */
function camping_enqueue_google_fonts() {
    wp_enqueue_style( 'google-fonts-inter', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap', false );
}
add_action( 'wp_enqueue_scripts', 'camping_enqueue_google_fonts' );

/**
 * ==============================================================================
 * Tự động tạo 20 sản phẩm mẫu, danh mục và Sideload ảnh cho Camping Store
 * ==============================================================================
 */

// Hàm phụ trợ tải ảnh từ internet về thư viện Media và gán làm ảnh đại diện
function camping_sideload_image( $url, $product_id ) {
    // Đảm bảo các file cần thiết của WordPress đã được nạp
    require_once( ABSPATH . 'wp-admin/includes/media.php' );
    require_once( ABSPATH . 'wp-admin/includes/file.php' );
    require_once( ABSPATH . 'wp-admin/includes/image.php' );

    // Tải ảnh về server và đính kèm vào sản phẩm
    $attachment_id = media_sideload_image( $url, $product_id, null, 'id' );

    // Nếu tải thành công, set làm ảnh đại diện cho sản phẩm
    if ( ! is_wp_error( $attachment_id ) ) {
        set_post_thumbnail( $product_id, $attachment_id );
    }
}

function camping_store_auto_insert_20_mock_data() {
    // 1. Cơ chế chống lặp tuyệt đối
    if ( get_option( 'camping_data_20_items_68_inserted' ) ) {
        return;
    }

    // Đảm bảo WooCommerce đã được kích hoạt
    if ( ! class_exists( 'WooCommerce' ) ) {
        return;
    }

    // 2. Khởi tạo danh mục
    $categories = array(
        'Lều trại & Đồ ngủ',
        'Đèn pin & Chiếu sáng',
        'Balo chuyên dụng',
        'Đồ sinh tồn & Y tế'
    );

    $category_ids = array();
    foreach ( $categories as $cat_name ) {
        $term = term_exists( $cat_name, 'product_cat' );
        if ( ! $term ) {
            $term = wp_insert_term( $cat_name, 'product_cat' );
        }
        if ( ! is_wp_error( $term ) ) {
            $category_ids[ $cat_name ] = is_array( $term ) ? $term['term_id'] : $term;
        }
    }

    // 3. Mảng 20 sản phẩm với URL ảnh động lấy theo từ khóa
    $mock_products = array(
        array(
            'name'  => 'Lều chống nước 4 người',
            'sku'   => 'TENT-68-01',
            'price' => '1500000',
            'cat'   => 'Lều trại & Đồ ngủ',
            'desc'  => 'Khung nhôm chịu lực, chống chịu tốt gió lùa và sương mù tại Lạng Sơn, Sơn La. Phù hợp cho đội nhóm.',
            'image' => 'https://loremflickr.com/800/800/tent,camping'
        ),
        array(
            'name'  => 'Túi ngủ giữ nhiệt mùa đông',
            'sku'   => 'SLEEP-68-01',
            'price' => '750000',
            'cat'   => 'Lều trại & Đồ ngủ',
            'desc'  => 'Chịu được nhiệt độ -5°C, đảm bảo giữ ấm tuyệt đối khi cắm trại tại các đỉnh núi phía Bắc.',
            'image' => 'https://loremflickr.com/800/800/sleepingbag,camping'
        ),
        array(
            'name'  => 'Đệm hơi dã ngoại tự bơm',
            'sku'   => 'MAT-68-01',
            'price' => '450000',
            'cat'   => 'Lều trại & Đồ ngủ',
            'desc'  => 'Giúp cách ly cơ thể khỏi mặt đất lạnh buốt và gồ ghề. Bơm hơi tự động chỉ trong 3 phút, siêu nhẹ và nhỏ gọn.',
            'image' => 'https://loremflickr.com/800/800/campingmat,camping'
        ),
        array(
            'name'  => 'Lều cá nhân siêu nhẹ',
            'sku'   => 'TENT-68-02',
            'price' => '850000',
            'cat'   => 'Lều trại & Đồ ngủ',
            'desc'  => 'Dành riêng cho phượt thủ độc hành. Trọng lượng chưa tới 1kg, chống thấm nước tuyệt đối.',
            'image' => 'https://loremflickr.com/800/800/tent,outdoor'
        ),
        array(
            'name'  => 'Võng dã ngoại chống muỗi',
            'sku'   => 'HAMM-68-01',
            'price' => '350000',
            'cat'   => 'Lều trại & Đồ ngủ',
            'desc'  => 'Tích hợp mùng chống côn trùng cực kỳ an toàn. Vải dù bền bỉ chịu tải lên tới 200kg.',
            'image' => 'https://loremflickr.com/800/800/hammock,camping'
        ),
        array(
            'name'  => 'Đèn pin siêu sáng dã ngoại',
            'sku'   => 'FL-68-01',
            'price' => '250000',
            'cat'   => 'Đèn pin & Chiếu sáng',
            'desc'  => 'Chiếu xa 500m, chống nước IPX4, pin trâu phù hợp cho các ca trực đêm.',
            'image' => 'https://loremflickr.com/800/800/flashlight,camping'
        ),
        array(
            'name'  => 'Đèn lều năng lượng mặt trời',
            'sku'   => 'FL-68-02',
            'price' => '180000',
            'cat'   => 'Đèn pin & Chiếu sáng',
            'desc'  => 'Tích hợp móc treo và cổng sạc USB dự phòng. Thiết yếu cho khu vực thiếu điện lưới.',
            'image' => 'https://loremflickr.com/800/800/lantern,camping'
        ),
        array(
            'name'  => 'Đèn đeo trán leo núi',
            'sku'   => 'HEAD-68-01',
            'price' => '320000',
            'cat'   => 'Đèn pin & Chiếu sáng',
            'desc'  => 'Giải phóng đôi tay để bám rễ cây hoặc cầm gậy trekking. Có chế độ sáng đỏ chống chói.',
            'image' => 'https://loremflickr.com/800/800/headlamp,camping'
        ),
        array(
            'name'  => 'Đèn măng xông Vintage',
            'sku'   => 'LANT-68-01',
            'price' => '550000',
            'cat'   => 'Đèn pin & Chiếu sáng',
            'desc'  => 'Thiết kế cổ điển tạo không gian chill khi cắm trại. Sử dụng pin sạc dung lượng cao, sáng liên tục 12h.',
            'image' => 'https://loremflickr.com/800/800/vintage,lantern'
        ),
        array(
            'name'  => 'Thanh huỳnh quang sinh tồn (Glow stick)',
            'sku'   => 'GLOW-68-01',
            'price' => '150000',
            'cat'   => 'Đèn pin & Chiếu sáng',
            'desc'  => 'Phát sáng mạnh mẽ trong 24h không cần pin. Sử dụng đánh dấu vị trí trong sương mù đặc quánh.',
            'image' => 'https://loremflickr.com/800/800/glowstick,survival'
        ),
        array(
            'name'  => 'Balo leo núi trợ lực 50L',
            'sku'   => 'BP-68-01',
            'price' => '850000',
            'cat'   => 'Balo chuyên dụng',
            'desc'  => 'Ngăn chứa phân lớp khoa học, tối ưu không gian mang vật tư và lương thực cho chuyến đi dài ngày.',
            'image' => 'https://loremflickr.com/800/800/backpack,camping'
        ),
        array(
            'name'  => 'Balo chiến thuật chống nước 20L',
            'sku'   => 'BP-68-02',
            'price' => '450000',
            'cat'   => 'Balo chuyên dụng',
            'desc'  => 'Nhỏ gọn, cơ động, phù hợp để đựng giấy tờ và đồ dùng cá nhân khi di chuyển giữa các điểm cầu.',
            'image' => 'https://loremflickr.com/800/800/tactical,backpack'
        ),
        array(
            'name'  => 'Túi khô chống nước 15L',
            'sku'   => 'DRY-68-01',
            'price' => '220000',
            'cat'   => 'Balo chuyên dụng',
            'desc'  => 'Cứu cánh tuyệt đối cho các thiết bị điện tử khi lội suối hoặc gặp mưa rừng bất chợt.',
            'image' => 'https://loremflickr.com/800/800/drybag,outdoor'
        ),
        array(
            'name'  => 'Túi đeo hông chạy trail',
            'sku'   => 'WAIST-68-01',
            'price' => '280000',
            'cat'   => 'Balo chuyên dụng',
            'desc'  => 'Ôm sát cơ thể không rung lắc. Đựng vừa điện thoại, chìa khóa và bình nước mềm 500ml.',
            'image' => 'https://loremflickr.com/800/800/waistbag,running'
        ),
        array(
            'name'  => 'Balo nhiếp ảnh dã ngoại',
            'sku'   => 'CAM-68-01',
            'price' => '1250000',
            'cat'   => 'Balo chuyên dụng',
            'desc'  => 'Ngăn kéo chống sốc siêu dày bảo vệ flycam và máy ảnh. Vải trượt nước hoàn toàn.',
            'image' => 'https://loremflickr.com/800/800/camerabag,outdoor'
        ),
        array(
            'name'  => 'Bộ sơ cứu y tế cá nhân (First Aid Kit)',
            'sku'   => 'MED-68-01',
            'price' => '320000',
            'cat'   => 'Đồ sinh tồn & Y tế',
            'desc'  => 'Bao gồm băng gạc, thuốc sát trùng và dụng cụ cơ bản. Bắt buộc phải có trong mọi chuyến đi.',
            'image' => 'https://loremflickr.com/800/800/firstaid,camping'
        ),
        array(
            'name'  => 'Dao găm sinh tồn đa năng',
            'sku'   => 'KNIFE-68-01',
            'price' => '290000',
            'cat'   => 'Đồ sinh tồn & Y tế',
            'desc'  => 'Thép không gỉ sắc bén, tích hợp đánh lửa và phá kính. Công cụ phòng thân thiết yếu.',
            'image' => 'https://loremflickr.com/800/800/knife,survival'
        ),
        array(
            'name'  => 'La bàn quân đội đo tọa độ',
            'sku'   => 'COMP-68-01',
            'price' => '210000',
            'cat'   => 'Đồ sinh tồn & Y tế',
            'desc'  => 'Định vị hướng đi chính xác giữa rừng già không có sóng điện thoại. Thiết kế vỏ kim loại chắc chắn.',
            'image' => 'https://loremflickr.com/800/800/compass,outdoor'
        ),
        array(
            'name'  => 'Bếp dã ngoại mini gấp gọn',
            'sku'   => 'STOVE-68-01',
            'price' => '350000',
            'cat'   => 'Đồ sinh tồn & Y tế',
            'desc'  => 'Công suất mạnh, chống tạt gió cực tốt. Phù hợp nấu ăn nhanh, đun nước pha trà trên đỉnh đèo.',
            'image' => 'https://loremflickr.com/800/800/campstove,camping'
        ),
        array(
            'name'  => 'Áo mưa sinh tồn phản quang',
            'sku'   => 'RAIN-68-01',
            'price' => '160000',
            'cat'   => 'Đồ sinh tồn & Y tế',
            'desc'  => 'Chất liệu tráng nhôm giữ nhiệt cơ thể, chống hạ thân nhiệt đột ngột khi gặp mưa lạnh dài ngày.',
            'image' => 'https://loremflickr.com/800/800/raincoat,survival'
        )
    );

    // 4. Vòng lặp foreach quét qua mảng để tạo sản phẩm
    foreach ( $mock_products as $p_data ) {
        // Kiểm tra cơ chế chống lặp cho từng sản phẩm
        $existing_id = wc_get_product_id_by_sku( $p_data['sku'] );
        
        if ( $existing_id ) {
            continue; // Bỏ qua nếu SKU này đã có trong database
        }

        // Khởi tạo Object Sản phẩm
        $product = new WC_Product_Simple();
        
        $product->set_name( $p_data['name'] );
        $product->set_sku( $p_data['sku'] );
        $product->set_regular_price( $p_data['price'] );
        $product->set_short_description( $p_data['desc'] );
        $product->set_status( 'publish' );
        $product->set_catalog_visibility( 'visible' );

        // Gán danh mục
        if ( isset( $category_ids[ $p_data['cat'] ] ) ) {
            $product->set_category_ids( array( $category_ids[ $p_data['cat'] ] ) );
        }

        // Lưu sản phẩm vào database và lấy ra Product ID
        $product_id = $product->save();

        // 5. Tự động tải ảnh từ internet (Sideload) và set làm ảnh đại diện
        if ( ! empty( $p_data['image'] ) && $product_id ) {
            camping_sideload_image( $p_data['image'], $product_id );
        }
    }

    // 6. Set cờ hoàn thành để không bao giờ chạy lại đoạn code nặng nề này nữa
    update_option( 'camping_data_20_items_68_inserted', true );
}
// Móc (Hook) vào 'admin_init' để khởi chạy ngầm khi vào WP Admin
add_action( 'admin_init', 'camping_store_auto_insert_20_mock_data' );

/**
 * ==============================================================================
 * Bản vá: Sửa ngày xuất bản thành 16/4 và dùng hàm tải ảnh nâng cao chống lỗi
 * ==============================================================================
 */

// Hàm Sideload ảnh viết lại để ép đuôi .jpg vì link loremflickr không có đuôi
function custom_camping_sideload_image( $url, $product_id, $keyword ) {
    // Nếu sản phẩm đã có ảnh đại diện, bỏ qua
    if ( has_post_thumbnail( $product_id ) ) {
        return;
    }

    require_once( ABSPATH . 'wp-admin/includes/image.php' );
    require_once( ABSPATH . 'wp-admin/includes/file.php' );
    require_once( ABSPATH . 'wp-admin/includes/media.php' );

    // Lấy dữ liệu ảnh
    $response = wp_remote_get( $url, array( 'timeout' => 30 ) );
    if ( is_wp_error( $response ) ) return;
    
    $image_data = wp_remote_retrieve_body( $response );
    if ( empty( $image_data ) ) return;

    // Tạo tên file có đuôi .jpg hợp lệ để WP chấp nhận (Ví dụ: camping-tent-123.jpg)
    $filename = 'camping-' . sanitize_title( $keyword ) . '-' . $product_id . '.jpg';

    // Tải vào thư mục uploads
    $upload = wp_upload_bits( $filename, null, $image_data );
    if ( $upload['error'] ) return;

    $file_path = $upload['file'];

    // Tạo thông tin đính kèm
    $attachment = array(
        'post_mime_type' => 'image/jpeg',
        'post_title'     => sanitize_file_name( $filename ),
        'post_content'   => '',
        'post_status'    => 'inherit'
    );

    // Chèn ảnh vào cơ sở dữ liệu
    $attach_id = wp_insert_attachment( $attachment, $file_path, $product_id );

    if ( ! is_wp_error( $attach_id ) ) {
        // Sinh siêu dữ liệu ảnh (các kích thước nhỏ hơn) và cập nhật
        $attach_data = wp_generate_attachment_metadata( $attach_id, $file_path );
        wp_update_attachment_metadata( $attach_id, $attach_data );
        
        // Đặt làm ảnh đại diện
        set_post_thumbnail( $product_id, $attach_id );
    }
}

function camping_fix_products_date_and_images_68() {
    // Cơ chế chống lặp cho bản vá này
    if ( get_option( 'camping_fix_date_images_done_v2' ) ) {
        return;
    }

    if ( ! class_exists( 'WooCommerce' ) ) {
        return;
    }

    // Danh sách mapping SKU với URL ảnh và từ khóa để tạo tên file
    $mock_data = array(
        'TENT-68-01' => array( 'image' => 'https://loremflickr.com/800/800/tent,camping', 'kw' => 'tent' ),
        'SLEEP-68-01' => array( 'image' => 'https://loremflickr.com/800/800/sleepingbag,camping', 'kw' => 'sleepingbag' ),
        'MAT-68-01' => array( 'image' => 'https://loremflickr.com/800/800/campingmat,camping', 'kw' => 'campingmat' ),
        'TENT-68-02' => array( 'image' => 'https://loremflickr.com/800/800/tent,outdoor', 'kw' => 'tent' ),
        'HAMM-68-01' => array( 'image' => 'https://loremflickr.com/800/800/hammock,camping', 'kw' => 'hammock' ),
        'FL-68-01' => array( 'image' => 'https://loremflickr.com/800/800/flashlight,camping', 'kw' => 'flashlight' ),
        'FL-68-02' => array( 'image' => 'https://loremflickr.com/800/800/lantern,camping', 'kw' => 'lantern' ),
        'HEAD-68-01' => array( 'image' => 'https://loremflickr.com/800/800/headlamp,camping', 'kw' => 'headlamp' ),
        'LANT-68-01' => array( 'image' => 'https://loremflickr.com/800/800/vintage,lantern', 'kw' => 'lantern' ),
        'GLOW-68-01' => array( 'image' => 'https://loremflickr.com/800/800/glowstick,survival', 'kw' => 'glowstick' ),
        'BP-68-01' => array( 'image' => 'https://loremflickr.com/800/800/backpack,camping', 'kw' => 'backpack' ),
        'BP-68-02' => array( 'image' => 'https://loremflickr.com/800/800/tactical,backpack', 'kw' => 'tactical' ),
        'DRY-68-01' => array( 'image' => 'https://loremflickr.com/800/800/drybag,outdoor', 'kw' => 'drybag' ),
        'WAIST-68-01' => array( 'image' => 'https://loremflickr.com/800/800/waistbag,running', 'kw' => 'waistbag' ),
        'CAM-68-01' => array( 'image' => 'https://loremflickr.com/800/800/camerabag,outdoor', 'kw' => 'camerabag' ),
        'MED-68-01' => array( 'image' => 'https://loremflickr.com/800/800/firstaid,camping', 'kw' => 'firstaid' ),
        'KNIFE-68-01' => array( 'image' => 'https://loremflickr.com/800/800/knife,survival', 'kw' => 'knife' ),
        'COMP-68-01' => array( 'image' => 'https://loremflickr.com/800/800/compass,outdoor', 'kw' => 'compass' ),
        'STOVE-68-01' => array( 'image' => 'https://loremflickr.com/800/800/campstove,camping', 'kw' => 'campstove' ),
        'RAIN-68-01' => array( 'image' => 'https://loremflickr.com/800/800/raincoat,survival', 'kw' => 'raincoat' ),
    );

    // Lấy tất cả sản phẩm
    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => -1,
        'post_status'    => 'any',
    );
    $products = get_posts( $args );

    foreach ( $products as $post ) {
        $product = wc_get_product( $post->ID );
        if ( ! $product ) continue;
        
        $sku = $product->get_sku();
        
        // Chỉ xử lý các sản phẩm có mã kết thúc bằng -68
        if ( strpos( $sku, '-68' ) !== false ) {
            
            // Sửa ngày xuất bản thành 16/4/2026
            $post_update = array(
                'ID'            => $post->ID,
                'post_date'     => '2026-04-16 08:00:00',
                'post_date_gmt' => '2026-04-16 01:00:00'
            );
            wp_update_post( $post_update );

            // Tải lại ảnh đại diện nếu đang bị trống
            if ( isset( $mock_data[$sku] ) ) {
                custom_camping_sideload_image( $mock_data[$sku]['image'], $post->ID, $mock_data[$sku]['kw'] );
            }
        }
    }

    // Ghi nhận đã hoàn tất bản vá
    update_option( 'camping_fix_date_images_done_v2', true );
}
// Chạy hàm vá lỗi
add_action( 'admin_init', 'camping_fix_products_date_and_images_68' );

/**
 * ==============================================================================
 * Gán 15 ảnh sản phẩm AI duyệt vào WooCommerce
 * ==============================================================================
 */
function custom_camping_attach_local_image( $file_path, $product_id ) {
    if ( ! file_exists( $file_path ) ) return;

    require_once( ABSPATH . 'wp-admin/includes/image.php' );
    require_once( ABSPATH . 'wp-admin/includes/file.php' );
    require_once( ABSPATH . 'wp-admin/includes/media.php' );

    // Đọc file ảnh từ thư mục máy tính
    $image_data = file_get_contents( $file_path );
    $filename = basename( $file_path );

    // Tải vào thư mục uploads của WordPress
    $upload = wp_upload_bits( $filename, null, $image_data );
    if ( $upload['error'] ) return;

    $attachment = array(
        'post_mime_type' => 'image/png',
        'post_title'     => sanitize_file_name( $filename ),
        'post_content'   => '',
        'post_status'    => 'inherit'
    );

    $attach_id = wp_insert_attachment( $attachment, $upload['file'], $product_id );
    if ( ! is_wp_error( $attach_id ) ) {
        $attach_data = wp_generate_attachment_metadata( $attach_id, $upload['file'] );
        wp_update_attachment_metadata( $attach_id, $attach_data );
        
        // Đặt làm ảnh đại diện
        set_post_thumbnail( $product_id, $attach_id );
    }
}

function camping_attach_15_approved_images() {
    if ( get_option( 'camping_attach_local_15_done_v2' ) ) {
        return;
    }

    if ( ! class_exists( 'WooCommerce' ) ) {
        return;
    }

    $base_dir = WP_CONTENT_DIR . '/uploads/camping-mock/';

    $local_images = array(
        'TENT-68-01'   => $base_dir . 'tent_4_person_1778894701615.png',
        'SLEEP-68-01'  => $base_dir . 'sleeping_bag_winter_1778894716786.png',
        'MAT-68-01'    => $base_dir . 'camping_mat_1778894731676.png',
        'TENT-68-02'   => $base_dir . 'tent_1_person_1778894746336.png',
        'HAMM-68-01'   => $base_dir . 'camping_hammock_1778894759275.png',
        'FL-68-01'     => $base_dir . 'flashlight_tactical_1778894772240.png',
        'FL-68-02'     => $base_dir . 'lantern_solar_1778894785187.png',
        'HEAD-68-01'   => $base_dir . 'headlamp_climbing_1778894801987.png',
        'LANT-68-01'   => $base_dir . 'lantern_vintage_1778894816762.png',
        'GLOW-68-01'   => $base_dir . 'glow_sticks_1778894830115.png',
        'BP-68-01'     => $base_dir . 'backpack_50l_1778894847509.png',
        'BP-68-02'     => $base_dir . 'backpack_tactical_20l_1778894864214.png',
        'DRY-68-01'    => $base_dir . 'dry_bag_15l_1778894880497.png',
        'WAIST-68-01'  => $base_dir . 'waist_bag_trail_1778894895138.png',
        'CAM-68-01'    => $base_dir . 'backpack_camera_1778894908504.png',
    );

    foreach ( $local_images as $sku => $path ) {
        $product_id = wc_get_product_id_by_sku( $sku );
        if ( $product_id ) {
            // Xóa ảnh đại diện cũ (nếu có)
            delete_post_thumbnail( $product_id );
            
            // Gán ảnh thiết kế chất lượng cao vào
            custom_camping_attach_local_image( $path, $product_id );
        }
    }

    update_option( 'camping_attach_local_15_done_v2', true );
}
add_action( 'admin_init', 'camping_attach_15_approved_images' );

/**
 * ==============================================================================
 * Gán 5 ảnh Stock tạm thời cho các sản phẩm còn lại
 * ==============================================================================
 */
function camping_attach_5_stock_images() {
    // Chống lặp
    if ( get_option( 'camping_attach_stock_5_done' ) ) {
        return;
    }

    if ( ! class_exists( 'WooCommerce' ) ) {
        return;
    }

    // Sử dụng từ khóa siêu cụ thể để lấy ảnh Stock chính xác nhất có thể
    $stock_data = array(
        'MED-68-01'   => array( 'image' => 'https://loremflickr.com/800/800/firstaidkit,red', 'kw' => 'firstaid' ),
        'KNIFE-68-01' => array( 'image' => 'https://loremflickr.com/800/800/pocketknife,survival', 'kw' => 'knife' ),
        'COMP-68-01'  => array( 'image' => 'https://loremflickr.com/800/800/compass,navigation', 'kw' => 'compass' ),
        'STOVE-68-01' => array( 'image' => 'https://loremflickr.com/800/800/campingstove,cooking', 'kw' => 'stove' ),
        'RAIN-68-01'  => array( 'image' => 'https://loremflickr.com/800/800/raincoat,yellow', 'kw' => 'raincoat' ),
    );

    foreach ( $stock_data as $sku => $data ) {
        $product_id = wc_get_product_id_by_sku( $sku );
        if ( $product_id ) {
            // Xóa ảnh đại diện cũ (nếu có)
            delete_post_thumbnail( $product_id );
            
            // Dùng lại hàm custom_camping_sideload_image đã viết ở trên
            if ( function_exists( 'custom_camping_sideload_image' ) ) {
                custom_camping_sideload_image( $data['image'], $product_id, $data['kw'] );
            }
        }
    }

    update_option( 'camping_attach_stock_5_done', true );
}
add_action( 'admin_init', 'camping_attach_5_stock_images' );

/**
 * ==============================================================================
 * Cập nhật ảnh cụ thể (La bàn và Dây thừng) do người dùng tải lên
 * ==============================================================================
 */
function camping_update_specific_images_from_user() {
    if ( get_option( 'camping_update_user_images_done' ) ) {
        return;
    }
    if ( ! class_exists( 'WooCommerce' ) ) {
        return;
    }

    // 1. Cập nhật La bàn
    $compass_id = wc_get_product_id_by_sku( 'COMP-68-01' );
    if ( $compass_id && function_exists('custom_camping_attach_local_image') ) {
        delete_post_thumbnail( $compass_id );
        custom_camping_attach_local_image( WP_CONTENT_DIR . '/uploads/camping-mock/compass_new.jpg', $compass_id );
    }

    // 2. Cập nhật Dây thừng (Nếu chưa có thì tự động tạo mới sản phẩm Dây thừng)
    $args = array(
        'post_type' => 'product',
        's' => 'thừng',
        'posts_per_page' => 1
    );
    $query = new WP_Query( $args );
    
    if ( $query->have_posts() ) {
        $rope_id = $query->posts[0]->ID;
        delete_post_thumbnail( $rope_id );
        if ( function_exists('custom_camping_attach_local_image') ) {
            custom_camping_attach_local_image( WP_CONTENT_DIR . '/uploads/camping-mock/rope_new.jpg', $rope_id );
        }
    } else {
        // Khởi tạo sản phẩm Dây thừng vì trước đó chưa có trong list
        $product = new WC_Product_Simple();
        $product->set_name( 'Dây thừng Paracord sinh tồn' );
        $product->set_sku( 'ROPE-68-01' );
        $product->set_regular_price( 120000 );
        $product->set_short_description( 'Dây thừng Paracord siêu bền bỉ, lõi 7 sợi chịu lực cao, an toàn tuyệt đối.' );
        $rope_id = $product->save();
        
        // Gán danh mục "Đồ sinh tồn"
        $term = get_term_by('name', 'Đồ sinh tồn', 'product_cat');
        if ($term) {
            wp_set_object_terms( $rope_id, $term->term_id, 'product_cat' );
        }
        
        if ( function_exists('custom_camping_attach_local_image') ) {
            custom_camping_attach_local_image( WP_CONTENT_DIR . '/uploads/camping-mock/rope_new.jpg', $rope_id );
        }
    }

    update_option( 'camping_update_user_images_done', true );
}
add_action( 'admin_init', 'camping_update_specific_images_from_user' );

/**
 * ==============================================================================
 * Tự động đồng bộ dữ liệu với Báo cáo Đồ án (Mục 4.1.9, 4.1.10, 4.1.11, 4.2.3)
 * ==============================================================================
 */
function camping_setup_thesis_demo_data() {
    if ( get_option( 'camping_setup_thesis_demo_done' ) ) {
        return;
    }

    if ( ! function_exists( 'post_exists' ) ) {
        require_once( ABSPATH . 'wp-admin/includes/post.php' );
    }

    // 1. Tạo 3 bài viết Blog (Cẩm nang dã ngoại)
    $category_id = wp_create_category( 'Cẩm nang dã ngoại' );
    
    $posts = array(
        array(
            'title' => 'Hướng dẫn kỹ năng sinh tồn cơ bản nơi hoang dã',
            'content' => 'Trang bị kỹ năng sinh tồn là bước đầu tiên để bạn tự tin khám phá thiên nhiên. Trong bài viết này, chúng tôi sẽ hướng dẫn cách tìm nguồn nước sạch, xác định phương hướng bằng la bàn quân đội và cách tạo lửa khi không có diêm.'
        ),
        array(
            'title' => 'Bí quyết dựng lều an toàn trong thời tiết sương mù và gió lớn',
            'content' => 'Dựng lều trong điều kiện thời tiết xấu đòi hỏi sự khéo léo. Hãy chọn vị trí khuất gió, sử dụng dây thừng Paracord để chằng chống chắc chắn và luôn cắm cọc lều sâu xuống đất một góc 45 độ.'
        ),
        array(
            'title' => 'Cẩm nang chuẩn bị túi y tế (First Aid Kit) khi đi tình nguyện vùng cao',
            'content' => 'Túi y tế cá nhân là vật bất ly thân. Bạn cần chuẩn bị: băng gạc, cồn sát trùng, thuốc giảm đau, nhíp gắp mảnh vụn và thuốc chống côn trùng cắn để đảm bảo an toàn tuyệt đối.'
        )
    );

    foreach ( $posts as $p ) {
        if ( ! post_exists( $p['title'] ) ) {
            wp_insert_post( array(
                'post_title'   => $p['title'],
                'post_content' => $p['content'],
                'post_status'  => 'publish',
                'post_author'  => 1,
                'post_category'=> array( $category_id )
            ) );
        }
    }

    // 2. Tạo trang Liên hệ
    if ( ! post_exists( 'Liên hệ' ) ) {
        $contact_content = '
        <h2>Thông tin liên hệ đặt hàng sỉ</h2>
        <p><strong>Hotline hỗ trợ khẩn cấp:</strong> 1900 6868</p>
        <p><strong>Địa chỉ:</strong> Thành phố Lạng Sơn, Tỉnh Lạng Sơn</p>
        <h3>Bản đồ số</h3>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d118223.3228945763!2d106.68007621458853!3d21.849658514937213!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x314ce7bdfa5cc93b%3A0xc6fbab8383e7c050!2zVHAuIEzhuqFuZyBTxqFuLCBM4bqhbmcgU8ahbiwgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1700000000000!5m2!1svi!2s" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        <h3>Biểu mẫu phản hồi</h3>
        <form action="#" method="post">
            <p><label>Họ và tên:<br> <input type="text" name="name" style="width:100%; padding:10px; border:1px solid #ccc;"></label></p>
            <p><label>Email / Số điện thoại:<br> <input type="text" name="contact" style="width:100%; padding:10px; border:1px solid #ccc;"></label></p>
            <p><label>Nội dung yêu cầu báo giá/hỗ trợ:<br> <textarea name="message" rows="5" style="width:100%; padding:10px; border:1px solid #ccc;"></textarea></label></p>
            <p><button type="button" class="button">Gửi yêu cầu</button></p>
        </form>';

        wp_insert_post( array(
            'post_title'   => 'Liên hệ',
            'post_content' => $contact_content,
            'post_status'  => 'publish',
            'post_type'    => 'page'
        ) );
    }

    // 3. Tạo Menu
    $menu_name = 'Main Menu';
    $menu_exists = wp_get_nav_menu_object( $menu_name );

    if ( ! $menu_exists ) {
        $menu_id = wp_create_nav_menu( $menu_name );

        // Lấy các trang cần thiết
        $front_page_id = get_option('page_on_front');
        $shop_page_id  = get_option('woocommerce_shop_page_id');
        $myaccount_id  = get_option('woocommerce_myaccount_page_id');
        $contact_page  = get_page_by_title( 'Liên hệ' );

        // Thêm Trang chủ
        if ($front_page_id) {
            wp_update_nav_menu_item( $menu_id, 0, array(
                'menu-item-title'  => 'Trang chủ',
                'menu-item-object-id' => $front_page_id,
                'menu-item-object' => 'page',
                'menu-item-type'   => 'post_type',
                'menu-item-status' => 'publish'
            ));
        }

        // Thêm Cửa hàng
        if ($shop_page_id) {
            wp_update_nav_menu_item( $menu_id, 0, array(
                'menu-item-title'  => 'Cửa hàng',
                'menu-item-object-id' => $shop_page_id,
                'menu-item-object' => 'page',
                'menu-item-type'   => 'post_type',
                'menu-item-status' => 'publish'
            ));
        }

        // Thêm Cẩm nang dã ngoại (Archive Blog)
        wp_update_nav_menu_item( $menu_id, 0, array(
            'menu-item-title'  => 'Cẩm nang dã ngoại',
            'menu-item-url'    => site_url('/category/cam-nang-da-ngoai/'),
            'menu-item-type'   => 'custom',
            'menu-item-status' => 'publish'
        ));

        // Thêm Liên hệ
        if ($contact_page) {
            wp_update_nav_menu_item( $menu_id, 0, array(
                'menu-item-title'  => 'Liên hệ',
                'menu-item-object-id' => $contact_page->ID,
                'menu-item-object' => 'page',
                'menu-item-type'   => 'post_type',
                'menu-item-status' => 'publish'
            ));
        }

        // Thêm Tài khoản
        if ($myaccount_id) {
            wp_update_nav_menu_item( $menu_id, 0, array(
                'menu-item-title'  => 'Tài khoản',
                'menu-item-object-id' => $myaccount_id,
                'menu-item-object' => 'page',
                'menu-item-type'   => 'post_type',
                'menu-item-status' => 'publish'
            ));
        }

        // Gán Menu vào vị trí Primary của theme Astra
        $locations = get_theme_mod( 'nav_menu_locations' );
        $locations['primary'] = $menu_id;
        set_theme_mod( 'nav_menu_locations', $locations );
    }

    update_option( 'camping_setup_thesis_demo_done', true );
}
add_action( 'admin_init', 'camping_setup_thesis_demo_data' );

/**
 * ==============================================================================
 * Sửa lỗi 404 trang Cẩm nang (Fix Menu Item Link)
 * ==============================================================================
 */
function camping_fix_blog_menu_404() {
    if ( get_option( 'camping_fix_blog_menu_404_done' ) ) {
        return;
    }

    $menu_name = 'Main Menu';
    $menu_exists = wp_get_nav_menu_object( $menu_name );

    if ( $menu_exists ) {
        $category = get_term_by( 'name', 'Cẩm nang dã ngoại', 'category' );
        
        if ( $category ) {
            // Tìm và xóa menu item cũ (bị lỗi URL cứng)
            $menu_items = wp_get_nav_menu_items( $menu_exists->term_id );
            foreach ( $menu_items as $item ) {
                if ( $item->title === 'Cẩm nang dã ngoại' || $item->url === site_url('/category/cam-nang-da-ngoai/') ) {
                    wp_delete_post( $item->ID, true );
                }
            }

            // Tạo lại menu item chuẩn Taxonomy (Tự động thích ứng với mọi cài đặt Permalink)
            wp_update_nav_menu_item( $menu_exists->term_id, 0, array(
                'menu-item-title'  => 'Cẩm nang dã ngoại',
                'menu-item-object-id' => $category->term_id,
                'menu-item-object' => 'category',
                'menu-item-type'   => 'taxonomy',
                'menu-item-status' => 'publish'
            ));
            
            // Flush rewrite rules để đảm bảo hệ thống nhận đường dẫn mới
            flush_rewrite_rules();
        }
    }

    update_option( 'camping_fix_blog_menu_404_done', true );
}
/**
 * ==============================================================================
 * Cập nhật Logo và Sắp xếp lại Menu (Thêm Icon Giỏ hàng & Tài khoản)
 * ==============================================================================
 */
function camping_update_menu_and_logo_v2() {
    if ( get_option( 'camping_update_menu_logo_v2_done' ) ) {
        return;
    }

    if ( ! function_exists( 'media_handle_sideload' ) ) {
        require_once( ABSPATH . 'wp-admin/includes/file.php' );
        require_once( ABSPATH . 'wp-admin/includes/image.php' );
        require_once( ABSPATH . 'wp-admin/includes/media.php' );
    }

    // 1. Xử lý cài đặt Logo
    $logo_path = 'C:\Users\ACER\.gemini\antigravity\brain\2eb24ac4-0cb8-46fa-b703-83ab595a4104\camping_theme_logo_1778891687058.png';
    if ( file_exists( $logo_path ) ) {
        // Tạo thư mục tạm để sideload
        $upload_dir = wp_upload_dir();
        $temp_file = $upload_dir['path'] . '/camping_theme_logo.png';
        copy( $logo_path, $temp_file );

        $file_array = array(
            'name'     => 'camping_theme_logo.png',
            'tmp_name' => $temp_file
        );

        $attachment_id = media_handle_sideload( $file_array, 0 );
        if ( ! is_wp_error( $attachment_id ) ) {
            set_theme_mod( 'custom_logo', $attachment_id );
        }
    }

    // 2. Tạo lại Menu mới theo đúng thứ tự
    $menu_name = 'Main Menu';
    $menu_exists = wp_get_nav_menu_object( $menu_name );

    if ( $menu_exists ) {
        wp_delete_nav_menu( $menu_name );
    }

    $menu_id = wp_create_nav_menu( $menu_name );

    $shop_page_id  = get_option('woocommerce_shop_page_id');
    $cart_page_id  = get_option('woocommerce_cart_page_id');
    $myaccount_id  = get_option('woocommerce_myaccount_page_id');
    $contact_page  = get_page_by_title( 'Liên hệ' );
    $category      = get_term_by( 'name', 'Cẩm nang dã ngoại', 'category' );

    // 1. Cửa hàng
    if ($shop_page_id) {
        wp_update_nav_menu_item( $menu_id, 0, array(
            'menu-item-title'  => 'Cửa hàng',
            'menu-item-object-id' => $shop_page_id,
            'menu-item-object' => 'page',
            'menu-item-type'   => 'post_type',
            'menu-item-status' => 'publish'
        ));
    }

    // 2. Cẩm nang dã ngoại
    if ($category) {
        wp_update_nav_menu_item( $menu_id, 0, array(
            'menu-item-title'  => 'Cẩm nang dã ngoại',
            'menu-item-object-id' => $category->term_id,
            'menu-item-object' => 'category',
            'menu-item-type'   => 'taxonomy',
            'menu-item-status' => 'publish'
        ));
    }

    // 3. Liên hệ
    if ($contact_page) {
        wp_update_nav_menu_item( $menu_id, 0, array(
            'menu-item-title'  => 'Liên hệ',
            'menu-item-object-id' => $contact_page->ID,
            'menu-item-object' => 'page',
            'menu-item-type'   => 'post_type',
            'menu-item-status' => 'publish'
        ));
    }

    // 4. Giỏ hàng (Có icon)
    if ($cart_page_id) {
        wp_update_nav_menu_item( $menu_id, 0, array(
            'menu-item-title'  => 'Giỏ hàng',
            'menu-item-object-id' => $cart_page_id,
            'menu-item-object' => 'page',
            'menu-item-type'   => 'post_type',
            'menu-item-status' => 'publish',
            'menu-item-classes' => 'menu-item-cart-custom'
        ));
    }

    // 5. Tài khoản (Có icon)
    if ($myaccount_id) {
        wp_update_nav_menu_item( $menu_id, 0, array(
            'menu-item-title'  => 'Tài khoản',
            'menu-item-object-id' => $myaccount_id,
            'menu-item-object' => 'page',
            'menu-item-type'   => 'post_type',
            'menu-item-status' => 'publish',
            'menu-item-classes' => 'menu-item-account-custom'
        ));
    }

    // Gán Menu vào vị trí Primary
    $locations = get_theme_mod( 'nav_menu_locations' );
    $locations['primary'] = $menu_id;
    set_theme_mod( 'nav_menu_locations', $locations );

    update_option( 'camping_update_menu_logo_v2_done', true );
}
add_action( 'admin_init', 'camping_update_menu_and_logo_v2' );

/**
 * ==============================================================================
 * Chèn Mega Footer và Nút Gọi Điện Rung vào cuối trang
 * ==============================================================================
 */
function camping_add_mega_footer_and_floating_button() {
    ?>
    <!-- Widget Nút Gọi Điện Chuyên Nghiệp -->
    <div class="hotline-phone-ring-wrap">
        <div class="hotline-phone-ring">
            <div class="hotline-phone-ring-circle"></div>
            <div class="hotline-phone-ring-circle-fill"></div>
            <div class="hotline-phone-ring-img-circle">
                <a href="tel:0123456789" class="pps-btn-img">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" width="24" height="24"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>
                </a>
            </div>
        </div>
        <div class="hotline-bar">
            <a href="tel:0123456789">
                <span class="text-hotline">0123456789</span>
            </a>
        </div>
    </div>

    <!-- Mega Footer Đa Cột -->
    <footer class="camping-mega-footer">
        <div class="ast-container">
            <div class="mega-footer-grid">
                <div class="footer-col">
                    <h4 class="footer-title">LIÊN HỆ</h4>
                    <p>📍 123 Đường Dã Ngoại, Quận Cắm Trại, Hà Nội (địa chỉ tượng trưng)</p>
                    <p>📞 ĐT: 0123456789</p>
                    <p>✉️ lienhe@tramdangoai68.vn</p>
                </div>
                <div class="footer-col">
                    <h4 class="footer-title">CHÍNH SÁCH HỖ TRỢ</h4>
                    <ul class="footer-links">
                        <li><a href="#">✓ Hướng Dẫn Đặt Hàng</a></li>
                        <li><a href="#">✓ Phương thức thanh toán</a></li>
                        <li><a href="#">✓ Chính Sách Bảo Hành</a></li>
                        <li><a href="#">✓ Quy định đổi/ trả hàng</a></li>
                        <li><a href="#">✓ Chính sách vận chuyển</a></li>
                        <li><a href="#">✓ Bảo mật thông tin</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4 class="footer-title">TẠI SAO CHỌN CHÚNG TÔI</h4>
                    <ul class="footer-links">
                        <li>✓ Hệ thống phân phối phụ kiện du lịch chính hãng trên toàn quốc.</li>
                        <li>✓ Dịch vụ chăm sóc khách hàng chuyên nghiệp 24/7.</li>
                        <li>✓ Không ngừng nâng cao chất lượng sản phẩm và dịch vụ.</li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4 class="footer-title">ĐƠN VỊ CHỦ QUẢN</h4>
                    <p>CÔNG TY TNHH TRẠM DÃ NGOẠI 68</p>
                    <p>Trụ sở: 123 Đường Cắm Trại, Quận Rừng Núi, Hà Nội.</p>
                    <p>MST: 0123456789</p>
                    <p>Ngày ĐKKD: 01/12/2026</p>
                </div>
                <div class="footer-col">
                    <h4 class="footer-title">KẾT NỐI VỚI CHÚNG TÔI</h4>
                    <div class="social-icons" style="color:#aaa;">
                        <span style="border:1px solid #aaa; padding: 5px; border-radius:50%; display:inline-block; margin-right:5px; width:30px; text-align:center;">f</span>
                        <span style="border:1px solid #aaa; padding: 5px; border-radius:50%; display:inline-block; margin-right:5px; width:30px; text-align:center;">t</span>
                        <span style="border:1px solid #aaa; padding: 5px; border-radius:50%; display:inline-block; margin-right:5px; width:30px; text-align:center;">p</span>
                    </div>
                    <div class="trust-badges" style="margin-top: 15px;">
                        <div style="background: linear-gradient(180deg, #555 0%, #000 100%); border: 1px solid #ffcc00; display: inline-block; padding: 4px 8px; color: #ffcc00; font-weight: bold; font-size: 11px; border-radius:3px;">PROTECTED BY DMCA</div>
                        <div style="margin-top: 10px;">
                            <div style="background: #0066cc; border: 2px solid white; display: inline-block; padding: 4px 10px; color: white; font-weight: bold; border-radius: 4px; font-size: 11px;">✔️ ĐÃ THÔNG BÁO BỘ CÔNG THƯƠNG</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mega-footer-bottom">
            <p>TRAMDANGOAI68.VN chuyên cung cấp đồ cắm trại outdoor camping thể thao ngoài trời chính hãng tại Hà Nội và TP HCM</p>
        </div>
    </footer>
    <?php
}
add_action( 'wp_footer', 'camping_add_mega_footer_and_floating_button' );
