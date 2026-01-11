# HƯỚNG DẪN CÀI ĐẶT VÀ SỬ DỤNG

## 1. Thông tin đề tài
**Tên đề tài:** XÂY DỰNG WEBSITE BÁN RAU CỦ  
**Loại:** Khóa luận tốt nghiệp  
**Sinh viên thực hiện:** Trần Thái Duy  

Website được xây dựng nhằm cung cấp một hệ thống bán rau củ trực tuyến, hỗ trợ khách hàng xem sản phẩm, đặt hàng và hỗ trợ quản trị viên quản lý sản phẩm, đơn hàng và người dùng.

---

## 2. Công nghệ sử dụng
- Ngôn ngữ lập trình: **PHP 8.3.14**
- Framework: **Laravel 11**
- Mô hình kiến trúc: **MVC (Model – View – Controller)**
- Cơ sở dữ liệu: **MySQL**
- Frontend: HTML, CSS, JavaScript, Blade Template
- Web Server: Apache (XAMPP)
- Công cụ hỗ trợ: Composer, Node.js, npm

---

## 3. Cấu trúc thư mục dự án

```
D:\luanvancuaDuy
├── app
│   ├── Http
│   │   ├── Controllers
│   │   │   ├── Admin        (Xử lý logic trang quản trị)
│   │   │   ├── Auth         (Xử lý đăng nhập/đăng ký)
│   │   │   └── Clients      (Xử lý logic trang người dùng)
│   │   ├── Middleware       (Kiểm soát truy cập)
│   │   └── Requests         (Validation dữ liệu)
│   ├── Mail                 (Cấu hình gửi email)
│   └── Models               (Tương tác CSDL)
├── config                   (Cấu hình hệ thống)
├── database
│   ├── migrations           (Cấu trúc bảng)
│   └── seeders              (Dữ liệu mẫu)
├── public
│   ├── assets               (CSS, JS, hình ảnh)
│   │   ├── admin
│   │   └── user
│   └── storage              (Ảnh upload)
├── resources
│   └── views
│       ├── admin            (Giao diện quản trị)
│       ├── auth             (Đăng nhập/đăng ký)
│       ├── layouts          (Layout dùng chung)
│       └── user             (Giao diện người dùng)
├── routes                   (Định nghĩa route)
├── storage
│   └── app
│       └── public           (Lưu trữ file upload)
├── document                 (Tài liệu khóa luận)
├── node_modules             (Thư viện JS)
└── vendor                   (Thư viện PHP)
```

---

## 4. Yêu cầu môi trường
- PHP >= 8.3
- Composer
- MySQL >= 8.0
- Node.js >= 18
- npm
- Trình duyệt: Google Chrome / Microsoft Edge

---

## 5. Hướng dẫn cài đặt hệ thống

### Bước 1: Clone hoặc sao chép source code
Đặt thư mục dự án vào đường dẫn mong muốn, ví dụ:
```
D:\luanvancuaDuy
```

---

### Bước 2: Cài đặt thư viện PHP
Mở Terminal tại thư mục dự án và chạy:
```
composer install
```

---

### Bước 3: Cấu hình file môi trường (.env)

- Sao chép file `.env.example` thành `.env`
- Cấu hình các thông số môi trường như sau:

```env
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:2AZDGMZx7ggcZ7GXjfNFyArYJ+dJRRYe2PY4EzY1KP4=
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file
PHP_CLI_SERVER_WORKERS=4

LOG_CHANNEL=stack
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nongsan
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=file
SESSION_LIFETIME=120

CACHE_STORE=database
QUEUE_CONNECTION=database

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=mcttduy@gmail.com
MAIL_PASSWORD=********
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="mcttduy@gmail.com"
MAIL_FROM_NAME="${APP_NAME}"

# VNPay Sandbox
VNP_TMN_CODE=KI854KOV
VNP_HASH_SECRET=YTMXX1F3ZMHIK4GT3VLRA3LEXMQXQBU1
VNP_URL=https://sandbox.vnpayment.vn/paymentv2/vpcpay.html
VNP_RETURN_URL=http://127.0.0.1:8000/checkout/vnpay-return

# Gemini API
GOOGLE_GEMINI_API_KEY=********

# Tọa độ cửa hàng
STORE_LAT=10.738096
STORE_LNG=106.678832
SHIPPING_COST_PER_KM=5000
TRACK_ASIA_KEY=********
```

> **Lưu ý:** Các giá trị API Key, mật khẩu email cần được thay thế bằng thông tin phù hợp khi triển khai thực tế.

---

### Bước 4: Import cơ sở dữ liệu

- Mở **phpMyAdmin**
- Tạo database tên: `nongsan`
- Import file:
```
database/nongsan.sql
```

---

### Bước 5: Tạo key ứng dụng
```
php artisan key:generate
```

---

### Bước 6: Tạo liên kết storage
```
php artisan storage:link
```

---

### Bước 7: Cài đặt thư viện frontend
```
npm install
npm run build
```

---

## 6. Chạy chương trình

### Chạy server Laravel
```
php artisan serve
```

Truy cập website tại:
```
http://127.0.0.1:8000
```

---

## 7. Tài khoản đăng nhập hệ thống

### Tài khoản quản trị viên (Admin)
- Email: **admin@example.com**
- Mật khẩu: **123456789**

---

## 8. Hướng dẫn sử dụng

### Đối với khách hàng
- Xem danh sách sản phẩm
- Xem chi tiết sản phẩm
- Thêm sản phẩm vào giỏ hàng
- Đặt hàng

### Đối với quản trị viên
- Đăng nhập hệ thống quản trị
- Quản lý danh mục sản phẩm
- Quản lý sản phẩm
- Quản lý đơn hàng
- Quản lý người dùng

---

## 9. Một số lưu ý
- Cần bật extension PHP: `openssl`, `pdo_mysql`, `mbstring`, `fileinfo`
- Nếu lỗi quyền ghi ảnh, kiểm tra thư mục:
```
storage/app/public
public/storage
```
- Kiểm tra file `.env` khi lỗi kết nối CSDL

---

## 10. Kết luận

Tài liệu này hướng dẫn chi tiết cách cài đặt, cấu hình và sử dụng website bán rau củ được xây dựng bằng Laravel theo mô hình MVC, phục vụ cho mục đích học tập và nghiên cứu trong khóa luận tốt nghiệp.

