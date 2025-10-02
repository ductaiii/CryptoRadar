# CryptoRadar

CryptoRadar là một ứng dụng web quản lý watchlist coin, phân quyền theo 3 vai trò: **User**, **Admin**, **Superadmin**. Dự án sử dụng Laravel 12, Breeze, Tailwind CSS, PHP 8.2, MySQL.

## Tính năng chính

- Đăng ký, đăng nhập, đổi mật khẩu, cập nhật thông tin cá nhân (chuẩn Breeze)
- Xem top 10 coin vốn hóa lớn (dữ liệu từ CoinGecko)
- Thêm/xóa coin vào Watchlist cá nhân
- Phân quyền rõ ràng:
	- **User**: Quản lý watchlist cá nhân, xem dashboard
	- **Admin**: Xem/sửa thông tin mọi user, xem watchlist của mọi user
	- **Superadmin**: Toàn quyền quản lý user (thêm, sửa, xóa, phân quyền), xem mọi watchlist
- Giao diện hiện đại, responsive, dễ sử dụng

## Cài đặt

### 1. Clone & Cấu hình
```sh
git clone https://github.com/ductaiii/CryptoRadar.git
cd CryptoRadar
cp .env.example .env
```

### 2. Cài đặt Composer & NPM
```sh
composer install
npm install
```

### 3. Tạo database & migrate
- Tạo database `cryptoradar` trong MySQL
- Cấu hình DB trong file `.env`

```env
DB_DATABASE=cryptoradar
DB_USERNAME=your_mysql_user
DB_PASSWORD=your_mysql_password
```

- Chạy migrate & seed:
```sh
php artisan migrate --seed
```

### 4. Build frontend
```sh
npm run build
```

### 5. Khởi động server
```sh
php artisan serve
```

Truy cập: http://127.0.0.1:8000

## Phân quyền & Chức năng

### 1. User
- Đăng nhập, xem dashboard, xem top coin
- Thêm/xóa coin vào Watchlist cá nhân
- Xem/sửa thông tin cá nhân

### 2. Admin
- Đăng nhập, vào trang `/admin/users`
- Xem danh sách toàn bộ user
- Xem watchlist của từng user
- Sửa thông tin user (trừ superadmin)

### 3. Superadmin
- Đăng nhập, vào trang `/superadmin/users`
- Xem, thêm, sửa, xóa mọi user (bao gồm cả admin, superadmin)
- Phân quyền user (user, admin, superadmin)
- Xem watchlist của mọi user

## Một số lệnh hữu ích
- Chạy lại migrate: `php artisan migrate:fresh --seed`
- Build lại frontend: `npm run build`
- Chạy test: `php artisan test`

## Đóng góp
Pull request, issue, góp ý đều được chào đón!

## License
MIT
# CryptoRadar
