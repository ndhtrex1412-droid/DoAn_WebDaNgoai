<?php
/**
 * Template Name: Front Page Custom
 *
 * Bản mẫu trang chủ chuyên biệt cho Lạng Sơn Camping Store.
 */

// Đảm bảo không bị truy cập trực tiếp
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

get_header(); ?>

<div id="primary" class="content-area camping-home-page">
    <main id="main" class="site-main" role="main">

        <!-- =========================================================
             1. HERO BANNER
             ========================================================= -->
        <section class="camping-hero-banner" style="background-image: url('https://loremflickr.com/1200/600/mountain,camping');">
            <div class="hero-overlay"></div>
            <div class="hero-content">
                <h1 class="hero-title">HÀNH TRANG VỮNG BƯỚC - CHINH PHỤC ĐỈNH CAO</h1>
                <p class="hero-slogan">Cung cấp thiết bị hậu cần và dã ngoại chuyên nghiệp</p>
                <a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="button cta-button hero-cta">Khám phá ngay</a>
            </div>
        </section>

        <!-- =========================================================
             2. FEATURED CATEGORIES (DANH MỤC NỔI BẬT)
             ========================================================= -->
        <section class="camping-featured-categories ast-container">
            <h2 class="section-heading text-center">Trang bị thiết yếu</h2>
            <div class="category-grid">
                <!-- Danh mục 1: Lều trại -->
                <a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) . '?category=leu-trai' ); ?>" class="category-item">
                    <div class="category-icon">⛺</div>
                    <h3 class="category-title">Lều trại</h3>
                </a>
                
                <!-- Danh mục 2: Balo trợ lực -->
                <a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) . '?category=balo' ); ?>" class="category-item">
                    <div class="category-icon">🎒</div>
                    <h3 class="category-title">Balo trợ lực</h3>
                </a>
                
                <!-- Danh mục 3: Đồ sinh tồn -->
                <a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) . '?category=do-sinh-ton' ); ?>" class="category-item">
                    <div class="category-icon">🪓</div>
                    <h3 class="category-title">Đồ sinh tồn</h3>
                </a>
            </div>
        </section>

        <!-- =========================================================
             3. FEATURED PRODUCTS (SẢN PHẨM NỔI BẬT)
             ========================================================= -->
        <section class="camping-featured-products ast-container">
            <div class="section-header text-center">
                <h2 class="section-heading">Sản phẩm nổi bật</h2>
                <p class="section-subheading">Những món đồ nghề không thể thiếu cho chuyến đi của bạn</p>
            </div>
            
            <div class="woocommerce">
                <!-- Gọi WooCommerce Shortcode để hiển thị 8 sản phẩm, chia 4 cột -->
                <?php echo do_shortcode('[products limit="8" columns="4"]'); ?>
            </div>
            
            <div class="text-center view-all-btn-wrap">
                 <a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="button cta-button">Xem tất cả sản phẩm</a>
            </div>
        </section>

        <!-- =========================================================
             4. TRUST INDICATORS (CHỈ DẤU NIỀM TIN)
             ========================================================= -->
        <section class="camping-trust-indicators ast-container">
            <div class="trust-grid">
                <div class="trust-item">
                    <div class="trust-icon">🚚</div>
                    <h4>Giao hàng hỏa tốc</h4>
                    <p>Miễn phí vận chuyển toàn quốc cho đơn từ 1 triệu.</p>
                </div>
                <div class="trust-item">
                    <div class="trust-icon">🛡️</div>
                    <h4>Bảo hành trọn đời</h4>
                    <p>Cam kết 1 đổi 1 trong 30 ngày nếu phát hiện lỗi NSX.</p>
                </div>
                <div class="trust-item">
                    <div class="trust-icon">💳</div>
                    <h4>Thanh toán An toàn</h4>
                    <p>Hỗ trợ VietQR SePay & Thẻ tín dụng bảo mật tuyệt đối.</p>
                </div>
                <div class="trust-item">
                    <div class="trust-icon">🎧</div>
                    <h4>Hỗ trợ 24/7</h4>
                    <p>Chuyên gia kỹ năng sinh tồn luôn sẵn sàng tư vấn.</p>
                </div>
            </div>
        </section>

        <!-- =========================================================
             5. TESTIMONIALS (ĐÁNH GIÁ KHÁCH HÀNG)
             ========================================================= -->
        <section class="camping-testimonials ast-container">
            <h2 class="section-heading text-center">Trekker nói gì về chúng tôi?</h2>
            <div class="testimonial-grid">
                <div class="testimonial-item">
                    <div class="stars">⭐⭐⭐⭐⭐</div>
                    <p class="review-text">"Lều chống nước 4 người chống chịu cực tốt tại Tà Xùa. Gió giật mạnh nhưng khung lều không hề lay chuyển. Giao hàng cực nhanh!"</p>
                    <p class="reviewer-name">- Hoàng Hải (Hà Nội)</p>
                </div>
                <div class="testimonial-item">
                    <div class="stars">⭐⭐⭐⭐⭐</div>
                    <p class="review-text">"Đã test thử túi ngủ và balo trợ lực ở Fansipan. Cực kỳ ấm và nhẹ. Shop tư vấn rất có tâm, hướng dẫn kỹ năng thắt nút dây thừng rất chuẩn."</p>
                    <p class="reviewer-name">- Tiến Dũng (Sơn La)</p>
                </div>
                <div class="testimonial-item">
                    <div class="stars">⭐⭐⭐⭐⭐</div>
                    <p class="review-text">"Hệ thống thanh toán quét mã QR SePay tự động rất mượt. Bộ sơ cứu y tế (First Aid Kit) đầy đủ dụng cụ chuẩn y khoa. Vote 5 sao!"</p>
                    <p class="reviewer-name">- Ngọc Lan (Đà Nẵng)</p>
                </div>
            </div>
        </section>

        <!-- =========================================================
             6. NEWSLETTER (ĐĂNG KÝ NHẬN TIN)
             ========================================================= -->
        <section class="camping-newsletter">
            <div class="ast-container text-center newsletter-content">
                <h2>Nhận ngay Cẩm nang Sinh tồn & Voucher 20%</h2>
                <p>Để lại email để nhận bộ tài liệu kỹ năng dã ngoại hàng tháng và mã giảm giá độc quyền.</p>
                <form class="newsletter-form" action="#" method="post">
                    <input type="email" placeholder="Nhập địa chỉ email của bạn..." required>
                    <button type="submit" class="button cta-button">Đăng ký ngay</button>
                </form>
            </div>
        </section>

        <!-- =========================================================
             7. TIN TỨC (NEWS)
             ========================================================= -->
        <section class="camping-news-section ast-container">
            <div class="section-header text-center">
                <h2 class="section-heading-line"><span>TIN TỨC</span></h2>
            </div>
            <div class="news-grid">
                <?php
                // Truy vấn 3 bài viết mới nhất từ chuyên mục 'cam-nang-da-ngoai'
                $news_args = array(
                    'post_type'      => 'post',
                    'posts_per_page' => 3,
                    'category_name'  => 'cam-nang-da-ngoai'
                );
                $news_query = new WP_Query( $news_args );
                if ( $news_query->have_posts() ) :
                    while ( $news_query->have_posts() ) : $news_query->the_post();
                        // Dùng ảnh ngẫu nhiên nếu chưa có Featured Image
                        $thumb_url = get_the_post_thumbnail_url() ? get_the_post_thumbnail_url() : 'https://loremflickr.com/600/400/camping,forest?random=' . get_the_ID();
                        ?>
                        <div class="news-item">
                            <a href="<?php the_permalink(); ?>" class="news-thumb-link">
                                <img src="<?php echo esc_url($thumb_url); ?>" alt="<?php the_title_attribute(); ?>" class="news-thumb">
                            </a>
                            <div class="news-info">
                                <h3 class="news-title"><a href="<?php the_permalink(); ?>"><?php echo wp_trim_words(get_the_title(), 15, '...'); ?></a></h3>
                            </div>
                        </div>
                        <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                    echo '<p>Chưa có bài viết nào.</p>';
                endif;
                ?>
            </div>
        </section>

        <!-- =========================================================
             8. THƯƠNG HIỆU (BRANDS)
             ========================================================= -->
        <section class="camping-brands-section ast-container">
            <div class="section-header text-center">
                <h2 class="section-heading-line"><span>THƯƠNG HIỆU</span></h2>
            </div>
            <div class="brands-grid">
                <div class="brand-item"><h2>Campingmoon</h2></div>
                <div class="brand-item"><h2>AONIJIE</h2></div>
                <div class="brand-item"><h2>Naturehike</h2></div>
                <div class="brand-item"><h2>GIVI</h2></div>
                <div class="brand-item"><h2>ROCKBROS</h2></div>
            </div>
        </section>

    </main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>
