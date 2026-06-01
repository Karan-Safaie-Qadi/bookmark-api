# 📌 Bookmark Manager API + Client

<div dir="rtl" align="right">

یک پروژهٔ کامل **REST API** برای مدیریت بوکمارک‌ها با استفاده از **PHP خالص و MySQL**، به‌همراه یک **رابط کاربری مدرن و واکنش‌گرا** (HTML/CSS/JS).

این پروژه به‌صورت **گام‌به‌گام** توسعه داده شده و مناسب برای نمایش مهارت‌های **CRUD، احراز هویت، اعتبارسنجی و طراحی رابط کاربری** است.

</div>

<div align="center">

![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge\&logo=php\&logoColor=white)
![MySQL](https://img.shields.io/badge/mysql-4479A1.svg?style=for-the-badge\&logo=mysql\&logoColor=white)
![JavaScript](https://img.shields.io/badge/javascript-%23323330.svg?style=for-the-badge\&logo=javascript\&logoColor=%23F7DF1E)
![HTML5](https://img.shields.io/badge/html5-%23E34F26.svg?style=for-the-badge\&logo=html5\&logoColor=white)
![CSS3](https://img.shields.io/badge/css3-%231572B6.svg?style=for-the-badge\&logo=css3\&logoColor=white)
![License](https://img.shields.io/badge/license-MIT-green?style=for-the-badge)

</div>

---

# 🇮🇷 مستندات فارسی

<div dir="rtl" align="right">

## ✨ ویژگی‌ها

* ✅ RESTful API با معماری تمیز و پاسخ‌های JSON
* 🔐 احراز هویت مبتنی بر توکن (Token-Based Authentication)
* 📝 عملیات کامل CRUD روی بوکمارک‌ها
* 🔍 جستجو در عنوان‌ها
* ✅ اعتبارسنجی و نرمال‌سازی خودکار URL
* 🎨 رابط کاربری مدرن و شیشه‌ای (Glassmorphism)
* 🌙 پشتیبانی از حالت روشن و تاریک
* 📱 طراحی واکنش‌گرا و مناسب موبایل
* 🔔 اعلان‌های Toast
* 🚀 راه‌اندازی آسان با سرور داخلی PHP
* 🐳 ساختار ماژولار و قابل توسعه

</div>

---

<div dir="rtl" align="right">

## 🚀 پیش‌نمایش

</div>

| صفحه ورود           | داشبورد اصلی      |
| ------------------- | ----------------- |
| *(تصویر صفحه ورود)* | *(تصویر داشبورد)* |



---

<div dir="rtl" align="right">

## 📂 ساختار پروژه

</div>

```text
bookmark-api/
├── api/
│   ├── index.php
│   ├── bookmarks.php
│   ├── auth.php
│   └── helpers.php
│
├── config/
│   └── database.php
│
├── sql/
│   └── schema.sql
│
├── public/
│   ├── index.html
│   ├── css/
│   │   └── style.css
│   └── js/
│       └── app.js
│
├── .gitignore
└── README.md
```

---

<div dir="rtl" align="right">

## ⚙️ تکنولوژی‌ها

### بک‌اند

</div>

* PHP 8.x
* PDO
* Prepared Statements
* REST Architecture

<div dir="rtl" align="right">

### پایگاه داده

</div>

* MySQL
* utf8mb4

<div dir="rtl" align="right">

### فرانت‌اند

</div>

* HTML5
* CSS3
* Vanilla JavaScript
* Fetch API
* Async/Await

<div dir="rtl" align="right">

### امنیت

</div>

* Token-Based Authentication
* Input Validation
* Data Sanitization

---


---



# 🇬🇧 English Documentation

## 📖 Overview

Bookmark Manager is a complete **RESTful API** project built with **Pure PHP** and **MySQL**, accompanied by a modern and responsive frontend built using **HTML, CSS, and Vanilla JavaScript**.

The project demonstrates practical backend development concepts such as **CRUD operations, authentication, validation, API design, and frontend integration**.

---

## ✨ Features

* ✅ RESTful API architecture with JSON responses
* 🔐 Token-based authentication
* 📝 Full CRUD operations for bookmarks
* 🔍 Search functionality
* ✅ Automatic URL validation and normalization
* 🎨 Modern Glassmorphism user interface
* 🌙 Light and Dark theme support
* 📱 Responsive and mobile-friendly design
* 🔔 Toast notifications
* 🚀 Easy setup using PHP built-in server
* 🐳 Modular and scalable project structure

---

## 🚀 Preview

| Login Page           | Main Dashboard                     |
| -------------------- | ---------------------------------- |
| *(Login Screenshot)* | *(Bookmarks Dashboard Screenshot)* |

> Place your screenshots inside the `screenshots/` directory.

---

## 📂 Project Structure

```text
bookmark-api/
├── api/
│   ├── index.php
│   ├── bookmarks.php
│   ├── auth.php
│   └── helpers.php
│
├── config/
│   └── database.php
│
├── sql/
│   └── schema.sql
│
├── public/
│   ├── index.html
│   ├── css/
│   │   └── style.css
│   └── js/
│       └── app.js
│
├── .gitignore
└── README.md
```

---

## ⚙️ Technologies

### Backend

* PHP 8.x
* PDO
* Prepared Statements
* REST Architecture

### Database

* MySQL
* utf8mb4

### Frontend

* HTML5
* CSS3
* Vanilla JavaScript
* Fetch API
* Async/Await

### Security

* Token-Based Authentication
* Input Validation
* Data Sanitization

---

## 🛠️ Installation

### 1. Requirements

* PHP 7.4 or higher
* PDO MySQL Extension
* MySQL or MariaDB
* Modern Web Browser

### 2. Clone the Repository

```bash
git clone <repository-url>
cd bookmark-api
```

### 3. Configure the Database

Import:

```text
sql/schema.sql
```

Then configure your database credentials inside:

```text
config/database.php
```

### 4. Start the Server

```bash
php -S localhost:8000
```

### 5. Open the Application

Frontend:

```text
http://localhost:8000/public/index.html
```

API Base URL:

```text
http://localhost:8000/api/
```

---

## 📡 API Documentation

### 🔐 Generate Token

```http
POST /api/auth
Content-Type: application/json
```

```json
{
  "username": "your_username",
  "password": "your_password"
}
```

Successful Response:

```json
{
  "token": "852dd0ea...",
  "expires_at": "2026-06-01 10:13:46"
}
```

---

### 📋 Get All Bookmarks

```http
GET /api/bookmarks
Authorization: Bearer YOUR_TOKEN
```

---

### 🔍 Search Bookmarks

```http
GET /api/bookmarks?q=google
Authorization: Bearer YOUR_TOKEN
```

---

### ➕ Create Bookmark

```http
POST /api/bookmarks
Authorization: Bearer YOUR_TOKEN
Content-Type: application/json
```

```json
{
  "url": "test.com",
  "title": "Example Title"
}
```

Automatic URL Normalization:

```text
test.com
↓
https://test.com
```

---

### ✏️ Update Bookmark

```http
PUT /api/bookmarks?id=1
Authorization: Bearer YOUR_TOKEN
Content-Type: application/json
```

```json
{
  "url": "https://example.com",
  "title": "Updated Title"
}
```

---

### ❌ Delete Bookmark

```http
DELETE /api/bookmarks?id=1
Authorization: Bearer YOUR_TOKEN
```

---

## 📊 HTTP Status Codes

| Code | Description           |
| ---- | --------------------- |
| 200  | Success               |
| 201  | Created               |
| 400  | Bad Request           |
| 401  | Unauthorized          |
| 404  | Not Found             |
| 500  | Internal Server Error |

---

## 📅 Development Timeline

* Day 1: Database Design + GET /bookmarks
* Day 2: POST /bookmarks + URL Validation
* Day 3: DELETE /bookmarks
* Day 4: PUT /bookmarks
* Day 5: Search Functionality (`q`)
* Next Phase: Token Authentication + Modern Frontend

---

## 📌 Future Enhancements

* [ ] Rate Limiting
* [ ] Swagger / OpenAPI Documentation
* [ ] Docker Support
* [ ] JWT Authentication
* [ ] Categories & Tags
* [ ] Pagination
* [ ] Automated Tests
* [ ] User Management

---

## 🤝 Contributing

Contributions, suggestions, and pull requests are welcome.

If you would like to improve the project, feel free to open an issue or submit a pull request.

---

## 📄 License

This project is licensed under the MIT License.

See the `LICENSE` file for more information.

---
