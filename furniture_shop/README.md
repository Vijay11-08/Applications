<div align="center">
  <h1>🛋️ Luxura Furniture Shop ✨</h1>
  <p><strong>Premium E-commerce Platform for High-End Furniture</strong></p>
  
  <p>
    <img src="https://img.shields.io/badge/Frontend-HTML5_|_CSS3_|_Vanilla_JS-E34F26?style=for-the-badge&logo=html5&logoColor=white" alt="Frontend" />
    <img src="https://img.shields.io/badge/Backend-PHP_8.0+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="Backend" />
    <img src="https://img.shields.io/badge/Database-MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="Database" />
  </p>
</div>

> Luxura is a premium e-commerce platform dedicated to high-end furniture. It features a stunning, dynamic user interface crafted with a cohesive **"Gold & Charcoal"** design system. The application offers a seamless shopping experience for customers and a robust administrative backend for inventory and order management.

---

## ✨ Key Features

### 🛍️ Customer Experience
| Feature | Description |
| :--- | :--- |
| **Authentication** | Secure login, registration, and session management. |
| **Product Catalog** | Browse luxurious furniture categorized by Sofas, Beds, Chairs, Tables, and Lighting. |
| **Shopping Cart** | Add, remove, and update quantities of items dynamically. |
| **Wishlist** | Save favorite products to a personalized wishlist for future reference. |
| **Checkout** | Complete orders securely and elegantly with a streamlined process. |

### ⚙️ Administrative Control
| Feature | Description |
| :--- | :--- |
| **Dashboard** | High-level statistics of total sales, products, and user registrations. |
| **User Management** | View customer details, update profiles, toggle `Active`/`Inactive` status, and delete accounts. |
| **Inventory System** | Add new products, update existing details, manage stock levels, and toggle product visibility. |
| **Order Processing** | View detailed order items and seamlessly update order statuses (`Pending`, `Completed`, `Cancelled`). |

---

## 🛠️ Technology Stack

- **Frontend:** Vanilla HTML5, CSS3 *(Custom design system without frameworks)*, Vanilla JavaScript
- **Backend:** PHP *(Core/Procedural)*
- **Database:** MySQL / MariaDB
- **Icons:** FontAwesome 6

---

## 🚀 Installation & Setup Guide

This project is built to run effortlessly on local development servers like **Laragon** or **XAMPP**. Follow the step-by-step instructions below to get the project running.

### 📋 Prerequisites
- **PHP** 8.0 or higher
- **MySQL / MariaDB**
- **XAMPP** or **Laragon** installed on your system

### 📂 Step 1: Clone or Place the Project

<details>
<summary><strong>For XAMPP Users</strong></summary>

1. Move the project folder (`furniture_shop`) into your XAMPP `htdocs` directory, typically: `C:\xampp\htdocs\`
2. Your project path should look like: `C:\xampp\htdocs\furniture_shop`
</details>

<details>
<summary><strong>For Laragon Users</strong></summary>

1. Move the project folder (`furniture_shop`) into your Laragon web root directory, typically: `C:\laragon\www\`
2. Your project path should look like: `C:\laragon\www\furniture_shop`
</details>

### 🖥️ Step 2: Start Your Server
- **XAMPP:** Open XAMPP Control Panel and click **Start** next to both **Apache** and **MySQL**.
- **Laragon:** Open Laragon and click **Start All**.

### 🗄️ Step 3: Setup the Database
The database schema and initial mock data are located in the `database` folder inside the project.
1. Open your web browser and go to `http://localhost/phpmyadmin` *(or click "Database" in Laragon)*.
2. Create a new database named **`furniture_db`**.
3. Import the database files:
   - Go to the **Import** tab.
   - Click **Choose File** and navigate to your project folder: `furniture_shop/database/database.sql`.
   - Click **Go** (or Import) at the bottom to run the file.
   - *(Optional)* If you want to seed more mock products later, you can also import `database/seed_update.sql`.

### 🔗 Step 4: Configure Database Connection (If Needed)
By default, the connection is set up for typical local servers:
- **Host:** `localhost`
- **Username:** `root`
- **Password:** `""` *(Empty string)*
- **Database:** `furniture_db`

> 💡 **Note:** If your local MySQL setup requires a password, please update the credentials inside `includes/db.php`.

---

## 🌟 Detailed Guide for XAMPP Users

If you are new to XAMPP, follow this comprehensive guide:

1. **Download XAMPP:** If you don't have XAMPP installed, download and install it from the Apache Friends website.
2. **Move Project Files:** Copy the `furniture_shop` folder and paste it into your XAMPP `htdocs` directory *(typically `C:\xampp\htdocs\`)*. The final path should be `C:\xampp\htdocs\furniture_shop`.
3. **Start XAMPP Control Panel:** Open the XAMPP Control Panel and click the **Start** button next to both **Apache** and **MySQL**.
4. **Setup Database:**
   - Open your web browser and go to `http://localhost/phpmyadmin`.
   - Click on **New** to create a new database and name it **`furniture_db`**.
   - Select the newly created `furniture_db` database, and go to the **Import** tab.
   - Click **Choose File**, select `furniture_shop/database/database.sql` from your `htdocs` directory, and click **Import** *(or Go)* at the bottom.
5. **Run the Project:** Open your browser and visit `http://localhost/furniture_shop` to view and explore the website.

---

## 🔑 Demo Credentials

To explore the application, you can use the following pre-configured credentials:

### 🛡️ Admin Account
- **Email:** `admin@example.com`
- **Password:** `admin123`

### 👤 Customer Accounts
10 test users have been generated. You can log in using:
- **Emails:** `user1@example.com` through `user10@example.com`
- **Passwords:** `password1` through `password10` *(e.g., Email: `user5@example.com`, Password: `password5`)*

---

## 🌐 How to Run the Project

Once the server is running and the database is imported, open your web browser and visit:

- 🐘 **XAMPP Users:** `http://localhost/furniture_shop`
- 🦄 **Laragon Users:** `http://furniture_shop.test` *(if auto-virtual hosts are enabled)* OR `http://localhost/furniture_shop`

---

<div align="center">
  <i>Enjoy exploring Luxura! ✨ Designed with passion.</i>
</div>
