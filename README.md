# 📌 REST API Inventory Gudang

Sistem REST API untuk manajemen stok barang di gudang dengan fitur CRUD lengkap, validasi input, dan error handling sesuai prinsip RESTful.

---

## ⚡ Quick Start (5 menit)

```bash
# 1. Setup
cd c:\laragon\www\InventoryGudhang
composer install
copy .env.example .env
php artisan key:generate

# 2. Database
php artisan migrate
php artisan db:seed --class=InventorySeeder

# 3. Run
php artisan serve

# 4. Test
# Buka Postman atau browser
# GET http://localhost:8000/api/inventories
```

---

## 📍 API Endpoints

```
GET    /api/inventories              - Lihat semua
POST   /api/inventories              - Buat baru
GET    /api/inventories/{id}         - Lihat detail
PUT    /api/inventories/{id}         - Update
DELETE /api/inventories/{id}         - Hapus
GET    /api/inventories/search?q=... - Cari
```

---

## 🧪 Testing

```bash
php artisan test  # Jalankan 19 unit tests
```

---

## 📚 Dokumentasi

| Baca | Untuk |
|------|-------|
| `WELCOME.md` | Panduan pemula (START HERE) |
| `QUICK_REFERENCE.md` | Referensi cepat |
| `API_DOCUMENTATION.md` | Dokumentasi lengkap API |
| `SETUP_GUIDE.md` | Panduan instalasi detail |
| `TESTING_GUIDE.md` | Panduan testing lengkap |
| `ARCHITECTURE.md` | Arsitektur & design |

---

## ✅ Requirement Checklist

- [x] RESTful API Design
- [x] CRUD Service (Create, Read, Update, Delete)
- [x] Input Validation dengan custom messages
- [x] Error Handling dengan HTTP status codes
- [x] Unit Testing (19 test cases)
- [x] Complete Documentation

---

## 📁 File Structure

```
app/
├── Models/Inventory.php
├── Services/InventoryService.php
├── Http/Controllers/Api/InventoryController.php
├── Http/Requests/{StoreInventoryRequest, UpdateInventoryRequest}.php
└── Http/Resources/InventoryResource.php

database/
├── migrations/create_inventories_table.php
└── seeders/InventorySeeder.php

routes/api.php

tests/Feature/InventoryApiTest.php
```

---

## 🎯 Key Features

✅ CRUD Operations (Create, Read, Update, Delete)  
✅ Input Validation (Required, Unique, Min/Max, Type)  
✅ Error Handling (Proper status codes & messages)  
✅ Search & Filter  
✅ Pagination  
✅ Stock Adjustment  
✅ Reports (Low Stock, Out of Stock)  
✅ Database Seeding  
✅ 19 Unit Tests  
✅ Comprehensive Documentation  

---

## 🔧 Tech Stack

- **Framework:** Laravel 12
- **Language:** PHP 8.2+
- **Database:** SQLite/MySQL
- **Testing:** PHPUnit

---

## 📞 Getting Help

1. **Baca dokumentasi** di file-file .md
2. **Lihat contoh code** di app/ folder
3. **Jalankan tests** untuk lihat expected behavior
4. **Gunakan QUICK_REFERENCE.md** untuk command

---

## 🎓 Learning Path

1. 📖 Baca `WELCOME.md` untuk memahami konsep
2. 💻 Ikuti `SETUP_GUIDE.md` untuk setup
3. 🧪 Jalankan tests dengan `php artisan test`
4. 📍 Coba API endpoints menggunakan Postman
5. 📚 Baca `API_DOCUMENTATION.md` untuk detail
6. 🏗️ Pelajari `ARCHITECTURE.md` untuk design
7. 🧠 Eksperimen dengan code di app/

---

## 🚀 Status

**✅ PRODUCTION READY**

Semua requirement sudah diimplementasikan dan tested.

---

**Created:** 15 December 2025  
**Version:** 1.0.0  
**Total Files:** 16 (code + docs)  
**Test Cases:** 19  
**API Endpoints:** 11  

---

**👉 MULAI DENGAN: Baca file `WELCOME.md` untuk panduan lengkap pemula!**

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
