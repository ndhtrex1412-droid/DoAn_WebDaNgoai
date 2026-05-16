<?php
/**
 * Plugin Name: Camper Combo Deal
 * Plugin URI: https://example.com/camper-combo-deal
 * Description: Plugin xử lý logic Upsell/Cross-sell: Mua Lều trại kèm Đèn pin dã ngoại để được giảm 10% giá đèn pin.
 * Version: 1.0
 * Author: dhoan28
 * Author URI: https://example.com
 * License: GPL2
 */

// Ngăn chặn truy cập trực tiếp vào file (Bảo mật cơ bản trong WordPress)
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * ==============================================================================
 * Feature 1: Hiển thị hộp Gợi ý mua kèm (Frontend UI)
 * ==============================================================================
 * Hook: woocommerce_after_single_product_summary
 * Logic: Nếu sản phẩm thuộc danh mục "Lều trại", hiển thị thông báo gợi ý mua kèm.
 */
function camper_combo_deal_display_upsell_notice() {
    global $product;

    // Đảm bảo đang ở trang chi tiết sản phẩm và biến $product tồn tại hợp lệ
    if ( ! is_product() || ! $product ) {
        return;
    }

    // Kiểm tra xem sản phẩm hiện tại có thuộc danh mục "Lều trại" hay không
    // Lưu ý: Các slug 'leu-trai', 'lều trại', 'tents' được dùng để kiểm tra. 
    // Bạn cần đảm bảo slug trên website trùng khớp với một trong các giá trị này.
    if ( has_term( array( 'leu-trai', 'lều trại', 'tents' ), 'product_cat', $product->get_id() ) ) {
        
        // Khai báo Inline CSS cho thẻ div theo đúng yêu cầu:
        // Viền đứt nét màu nâu đất (#8B5A2B), nền màu xanh lá nhạt (#E8F5E9), chữ nổi bật.
        $style = 'border: 2px dashed #8B5A2B; background-color: #E8F5E9; padding: 15px; margin-top: 20px; margin-bottom: 20px; border-radius: 8px; color: #1B4332; font-weight: bold; font-size: 16px; text-align: center;';
        
        // In ra đoạn mã HTML hiển thị thông báo
        echo '<div class="camper-combo-notice" style="' . esc_attr( $style ) . '">';
        echo '🏕️ Gợi ý từ Trạm hậu cần: Mua kèm Đèn pin dã ngoại cùng Lều này để được giảm ngay 10% cho Đèn pin!';
        echo '</div>';
    }
}
// Móc (Hook) function vào vị trí dưới phần tóm tắt chi tiết sản phẩm
add_action( 'woocommerce_after_single_product_summary', 'camper_combo_deal_display_upsell_notice', 5 );


/**
 * ==============================================================================
 * Feature 2: Logic tự động trừ tiền (Backend)
 * ==============================================================================
 * Hook: woocommerce_cart_calculate_fees
 * Logic: Nếu giỏ hàng có Lều trại VÀ Đèn pin, giảm giá 10% cho Đèn pin.
 */
function camper_combo_deal_apply_discount( $cart ) {
    // Bỏ qua nếu đang trong trang quản trị (Admin) và không phải là request AJAX
    if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
        return;
    }

    $has_tent               = false; // Cờ đánh dấu giỏ hàng có Lều chống nước 4 người (TENT-68-01)
    $flashlight_qty         = 0;     // Đếm số lượng Đèn pin siêu sáng (FL-68-01)
    $flashlight_total_price = 0;     // Tổng giá trị của các đèn pin đó

    // Quét toàn bộ các sản phẩm (items) đang có trong giỏ hàng
    foreach ( $cart->get_cart() as $cart_item_key => $cart_item ) {
        $product = $cart_item['data'];
        if ( ! $product ) continue;
        
        $sku = $product->get_sku();

        // Kiểm tra xem sản phẩm có phải là "Lều chống nước 4 người" (SKU: TENT-68-01)
        if ( $sku === 'TENT-68-01' ) {
            $has_tent = true;
        }

        // Kiểm tra xem sản phẩm có phải là "Đèn pin siêu sáng dã ngoại" (SKU: FL-68-01)
        if ( $sku === 'FL-68-01' ) {
            $flashlight_qty += $cart_item['quantity'];
            $flashlight_total_price += (float) $product->get_price() * $cart_item['quantity'];
        }
    }

    // Logic xử lý: Giỏ hàng phải có TENT-68-01 VÀ FL-68-01
    if ( $has_tent && $flashlight_qty > 0 ) {
        
        // Tính toán khoản tiền được giảm: 10% của tổng giá trị đèn pin (FL-68-01)
        $discount_amount = $flashlight_total_price * 0.10;

        // Thêm thẻ HTML inline CSS để biến chữ thành màu đỏ nổi bật
        $fee_name = '<span style="color: #E53E3E; font-weight: bold;">🎁 Ưu đãi Combo Dã Ngoại 68</span>';

        $cart->add_fee( $fee_name, -$discount_amount, true, '' );
    }
}
// Móc (Hook) function vào giỏ hàng để tính toán lại các khoản phí (fees)
add_action( 'woocommerce_cart_calculate_fees', 'camper_combo_deal_apply_discount', 10, 1 );
