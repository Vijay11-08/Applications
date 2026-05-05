# Luxura Furniture Shop 🛋️✨

Luxura is a premium e-commerce platform dedicated to high-end furniture. It features a stunning, dynamic user interface crafted with a cohesive "Gold & Charcoal" design system. The application offers a seamless shopping experience for customers and a robust administrative backend for inventory and order management.

## 🚀 Features

### **Customer Features**
- **User Authentication:** Secure login, registration, and session management.
- **Product Catalog:** Browse luxurious furniture categorized by Sofas, Beds, Chairs, Tables, and Lighting.
- **Shopping Cart:** Add, remove, and update quantities of items dynamically.
- **Wishlist Management:** Save favorite products to a personalized wishlist.
- **Checkout Process:** Complete orders securely and elegantly.

### **Admin Features**
- **Dashboard Overview:** High-level statistics of total sales, products, and users.
- **User Management:** View customer details, update profiles, toggle `Active`/`Inactive` status, or delete accounts.
- **Inventory Management:** Add new products, update existing details, manage stock levels, and toggle product visibility (`Active`/`Inactive`).
- **Order Processing:** View detailed order items and seamlessly update order statuses (`Pending`, `Completed`, `Cancelled`).

---

## 🛠️ Tech Stack
- **Frontend:** Vanilla HTML5, CSS3 (Custom design system without frameworks), Vanilla JavaScript
- **Backend:** PHP (Core/Procedural)
- **Database:** MySQL
- **Icons:** FontAwesome 6

---

## ⚙️ Installation & Setup Guide

This project is built to run effortlessly on local development servers like **Laragon** or **XAMPP**. Follow the step-by-step instructions below to get the project running.

### **Prerequisites**
- PHP 8.0 or higher
- MySQL / MariaDB
- XAMPP or Laragon installed on your system

### **Step 1: Clone or Place the Project**

**For Laragon Users:**
1. Move the project folder (`furniture_shop`) into your Laragon web root directory, typically: `C:\laragon\www\`
2. Your project path should look like: `C:\laragon\www\furniture_shop`

**For XAMPP Users:**
1. Move the project folder (`furniture_shop`) into your XAMPP `htdocs` directory, typically: `C:\xampp\htdocs\`
2. Your project path should look like: `C:\xampp\htdocs\furniture_shop`

### **Step 2: Start Your Server**

- **Laragon:** Open Laragon and click **Start All**.
- **XAMPP:** Open XAMPP Control Panel and click **Start** next to both **Apache** and **MySQL**.

### **Step 3: Setup the Database**

The database schema and initial mock data are located in the `database` folder inside the project.

1. Open your web browser and go to `http://localhost/phpmyadmin` (or click "Database" in Laragon to open HeidiSQL/phpMyAdmin).
2. Create a new database named **`furniture_db`**.
3. Import the database files:
   - Go to the **Import** tab.
   - Click **Choose File** and navigate to your project folder: `furniture_shop/database/database.sql`.
   - Click **Go** (or Import) at the bottom to run the file.
   - *(Optional)* If you want to seed more mock products later, you can also import `database/seed_update.sql`.

### **Step 4: Configure Database Connection (If Needed)**

By default, the connection is set up for typical local servers:
- **Host:** `localhost`
- **Username:** `root`
- **Password:** `""` (Empty string)
- **Database:** `furniture_db`

*If your local MySQL setup requires a password, please update the credentials inside `includes/db.php`.*

---

## 🔑 Demo Credentials

To explore the application, you can use the following pre-configured credentials:

**Admin Account:**
- **Email:** `admin@example.com`
- **Password:** `admin123`

**Customer Accounts:**
10 test users have been generated. You can log in using:
- **Emails:** `user1@example.com` through `user10@example.com`
- **Passwords:** `password1` through `password10` (e.g., Email: `user5@example.com`, Password: `password5`)

---

## 🌐 How to Run the Project

Once the server is running and the database is imported, open your web browser and visit:

**Laragon Users:** 
`http://furniture_shop.test` (if auto-virtual hosts are enabled) 
OR `http://localhost/furniture_shop`

**XAMPP Users:** 
`http://localhost/furniture_shop`

Enjoy exploring Luxura! ✨
