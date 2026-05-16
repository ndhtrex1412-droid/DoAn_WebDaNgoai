# 🏕️ Trạm Dã Ngoại 68 - Hệ thống E-commerce Đồ Cắm Trại

## 📖 Giới thiệu website/hệ thống
**Trạm Dã Ngoại 68** là một hệ thống thương mại điện tử chuyên nghiệp chuyên cung cấp các thiết bị, dụng cụ và phụ kiện dã ngoại, cắm trại. Website được thiết kế với giao diện hiện đại, tối ưu hóa trải nghiệm người dùng (UX/UI) và tích hợp các tính năng bán hàng tự động nâng cao nhằm tối đa hóa tỷ lệ chuyển đổi (Conversion Rate).

## 👥 Danh sách thành viên
| STT | Họ và Tên | MSSV | Phân công nhiệm vụ | Mức độ đóng góp |
|---|---|---|---|---|
| 1 | [Tên của bạn] | [MSSV của bạn] | Quản lý dự án, Thiết kế UI/UX, Lập trình Frontend & Backend (Custom Plugin, Child Theme), Viết báo cáo | 100% |
| 2 | [Thành viên 2 nếu có] | [MSSV] | [Nhiệm vụ] | [%] |

## 🛠️ Công nghệ sử dụng
- **Nền tảng lõi:** WordPress & WooCommerce.
- **Ngôn ngữ lập trình:** PHP 8.x, HTML5, CSS3 (Flexbox/Grid), JavaScript.
- **Cơ sở dữ liệu:** MySQL.
- **Theme & Giao diện:** Astra Theme (Tùy biến sâu qua Child Theme `camping-child-theme`).
- **Thanh toán:** Tích hợp SePay Gateway (Thanh toán tự động qua mã QR ngân hàng).
- **Kiến trúc bổ sung:** Phát triển Custom Plugin `camper-combo-deal` xử lý logic giảm giá chéo tự động.

## ⚙️ Hướng dẫn cài đặt và chạy project

### Yêu cầu hệ thống:
- XAMPP/MAMP hoặc bất kỳ Local Server nào chạy PHP >= 7.4 và MySQL.
- Đã cài đặt WordPress.

### Các bước cài đặt:
1. **Clone repository:**
   ```bash
   git clone https://github.com/[username-cua-ban]/langson-camping-store.git
   ```
2. **Copy mã nguồn:** 
   Copy toàn bộ thư mục plugin `camper-combo-deal` vào `wp-content/plugins/` và thư mục `camping-child-theme` vào `wp-content/themes/`.
3. **Kích hoạt (Activate):**
   - Đăng nhập vào WP Admin.
   - Vào **Giao diện (Appearance) > Giao diện**: Kích hoạt `Camping Store Child`.
   - Vào **Gói mở rộng (Plugins)**: Kích hoạt `Camper Combo Deal`.
4. **Khởi tạo dữ liệu (Auto Setup):**
   - Theme đã được lập trình sẵn kịch bản khởi tạo tự động. Khi bạn tải lại trang (F5) trong WP Admin, hệ thống sẽ tự động tạo dữ liệu mẫu (Sản phẩm, Cẩm nang dã ngoại, Menu, Khối giao diện trang chủ).

## 📸 Hình ảnh minh họa hệ thống
*(Thêm link ảnh hoặc file ảnh vào đây, ví dụ:)*
- **Trang chủ (Giao diện E-commerce nâng cao):** `[Link ảnh]`
- **Khối Tin Tức & Thương Hiệu:** `[Link ảnh]`
- **Mega Footer:** `[Link ảnh]`
- **Giỏ hàng & Khuyến mãi tự động:** `[Link ảnh]`

## 🎥 Link video demo
- **Video Youtube/Google Drive:** `[Chèn link video của bạn tại đây]`

## 🌐 Link online đã deploy (nếu có)
- `[Chèn link website đã deploy, ví dụ: https://tramdangoai68.000webhostapp.com]`

---
*Dự án được thực hiện nhằm mục đích phục vụ Báo cáo Đồ án môn học.*
