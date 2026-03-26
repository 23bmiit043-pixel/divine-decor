# The Divine Decor – E-Commerce Website

![PHP](https://img.shields.io/badge/PHP-7.4%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-5.7%2B-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-4%2F5-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-ES6-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)

> **College Final-Year Project** | Full-Stack PHP/MySQL E-Commerce Web Application

🔗 **GitHub Repository:** [23bmiit043-pixel/divine-decor](https://github.com/23bmiit043-pixel/divine-decor)

---

## Table of Contents

1. [Abstract](#1-abstract)
2. [Introduction](#2-introduction)
3. [System Requirements](#3-system-requirements)
4. [Technologies Used](#4-technologies-used)
5. [Project Modules](#5-project-modules)
   - 5.1 [Customer (User) Module](#51-customer-user-module)
   - 5.2 [Administrator Module](#52-administrator-module)
   - 5.3 [Delivery Person Module](#53-delivery-person-module)
6. [Database Design](#6-database-design)
7. [Folder Structure](#7-folder-structure)
8. [Installation & Setup Guide](#8-installation--setup-guide)
9. [Testing](#9-testing)
10. [Security Features](#10-security-features)
11. [Conclusion](#11-conclusion)
12. [Future Scope](#12-future-scope)
13. [References](#13-references)

---

## 1. Abstract

The Divine Decor is a fully functional, full-stack e-commerce web application developed using PHP and MySQL, designed specifically for a home decoration retail business. The platform enables customers to browse a curated catalog of home decor products, add items to their shopping cart, place orders, and download PDF invoices — all through a seamless and responsive web interface built with Bootstrap. The application solves the problem of managing a physical decor store by bringing the entire shopping experience online, eliminating geographical limitations and providing 24/7 availability to customers.

The project is architected around three distinct user roles: the customer, the administrator, and the delivery personnel. Each role has a dedicated panel with appropriate permissions and functionality. The administrator manages the product catalog, categories, offers, orders, delivery staff, and generates comprehensive sales and order reports. Delivery personnel are assigned orders and can update order and payment statuses through their dedicated portal. This clear separation of concerns ensures a secure and organized workflow from order placement through to delivery.

This project demonstrates the practical application of server-side scripting with PHP, relational database design with MySQL, and front-end development using HTML5, CSS3, Bootstrap, and JavaScript. Additional capabilities include automated email delivery for password resets via PHPMailer, PDF invoice generation using the TCPDF library, and support for a future online payment gateway integration (Razorpay/Stripe). The Divine Decor project represents a comprehensive solution to the real-world challenge of building a multi-role e-commerce platform suitable for small to medium businesses.

---

## 2. Introduction

### 2.1 Background / Problem Statement

In today's digital age, e-commerce has become an essential component of retail business. Physical-only stores face significant challenges including limited reach, fixed business hours, and cumbersome manual order tracking. Home decor businesses, in particular, benefit greatly from an online presence because customers prefer to browse diverse product galleries at their own pace before making purchasing decisions. The Divine Decor project addresses these challenges by providing a complete online shopping platform tailored for a home decor retailer.

The absence of a centralized system for managing products, orders, and delivery logistics forces small businesses to rely on manual record-keeping, which is error-prone and inefficient. This project creates a unified platform where the business owner (admin) can manage the entire product lifecycle, customers can shop conveniently, and delivery staff can track and fulfill orders — all in one integrated system.

### 2.2 Objectives

- To develop a fully functional, multi-role e-commerce web application using PHP and MySQL.
- To implement secure user authentication with session management for customers, administrators, and delivery personnel.
- To provide a complete product management system including categories, sub-categories, offers, and a product gallery.
- To enable customers to manage their shopping cart, place orders, and download PDF invoices for their purchases.
- To allow the administrator to monitor business performance through detailed sales, order, and product reports.
- To facilitate efficient order fulfillment by providing delivery personnel with a dedicated portal for tracking and updating assigned orders.

### 2.3 Scope of the Project

The scope of The Divine Decor covers the complete online retail workflow from product listing to order fulfillment. It includes three fully operational panels (Customer, Admin, Delivery Person), product catalog management with categories and offers, a shopping cart and checkout flow, PDF invoice generation, password reset via email, and reporting. The project is designed as a local-server web application intended for deployment on XAMPP/WAMP and is scalable to a live hosting environment. Payment gateway integration (Razorpay) has been planned and partially prepared but falls within the future enhancement scope.

---

## 3. System Requirements

### 3.1 Hardware Requirements

| Component | Minimum Requirement |
|-----------|---------------------|
| Processor | Intel Core i3 (or equivalent) / 1 GHz+ |
| RAM | 4 GB (8 GB recommended) |
| Storage | 10 GB free disk space |
| Network | Internet connection (for email/SMTP features) |
| Display | 1024 × 768 resolution or higher |

### 3.2 Software Requirements

| Software | Version / Details |
|----------|-------------------|
| PHP | 7.4 or higher (8.x supported) |
| MySQL / MariaDB | 5.7 or higher |
| XAMPP / WAMP | Latest stable release (includes Apache + MySQL) |
| Web Browser | Google Chrome, Mozilla Firefox, Microsoft Edge (latest) |
| Composer | Latest version (for PHPMailer dependency management) |
| phpMyAdmin | Bundled with XAMPP/WAMP — for DB import |
| Text Editor / IDE | Visual Studio Code, Sublime Text, or PHPStorm |

---

## 4. Technologies Used

| Technology | Purpose | Version / Details |
|------------|---------|-------------------|
| PHP | Server-side scripting and business logic | 7.4+ |
| MySQL / MariaDB | Relational database management | 5.7+ |
| HTML5 | Page structure and semantic markup | — |
| CSS3 | Styling and layout | — |
| Bootstrap | Responsive UI framework | 4 / 5 |
| JavaScript / jQuery | Client-side interactivity and DOM manipulation | ES6 / jQuery 3 |
| TCPDF | PDF invoice generation | Bundled in project |
| PHPMailer | Sending password-reset emails via SMTP | Via Composer |
| XAMPP / WAMP | Local development web server (Apache + MySQL) | — |
| Composer | PHP dependency manager | Latest |
| Git / GitHub | Version control and source code hosting | — |

---

## 5. Project Modules

The application is divided into three independent panels, each serving a distinct user role:

### 5.1 Customer (User) Module

The customer-facing panel (`02User-side/`) provides the complete online shopping experience.

#### Authentication & Account Management
- **Registration** (`Reg.php`) — New customers can create an account by providing their name, email address, phone number, and password. Input validation ensures all required fields are completed correctly before the account is saved to the database.
- **Login** (`login.php`) — Registered customers log in using their email and password. Session management ensures the user remains authenticated throughout their browsing and shopping session.
- **Logout** (`logout.php`) — Securely destroys the session and redirects the user to the login page.
- **Forgot Password** (`forgot_password.php`) — Customers who forget their password can enter their registered email address to receive a password-reset link. PHPMailer is used to send the reset email via SMTP.
- **Reset Password** (`reset_password.php`) — The secure, token-based page where customers set a new password after clicking the link in the reset email.

#### Product Browsing
- **Home Page** (`index.php`) — The main landing page showcasing featured products, promotional banners, and category highlights to engage visitors.
- **Shop** (`shop.php`) — Displays the full product catalog with category and sub-category filtering, enabling customers to find products easily.
- **Product Detail** (`product.php`) — Shows detailed information for a selected product including images from the gallery, price, description, stock status, and applicable offers. Customers can add the item directly to their cart from this page.
- **Out of Stock** (`out_of_stock.php`) — Gracefully informs customers when a product is unavailable for purchase.

#### Cart & Checkout
- **Shopping Cart** (`cart.php`) — Allows customers to view all items added to their cart, update quantities, remove items, and see the running total. The cart is persisted in the database, ensuring it is available across sessions.
- **Checkout** (`checkout.php`) — The checkout page collects or confirms the delivery address and displays the final order summary. Currently supports Cash on Delivery (COD) as the payment method.
- **Order Placement** (`order.php`) — Processes the order, saves it to the database, and clears the cart upon successful submission.
- **Thank You Page** (`thankyou.php`) — Confirms successful order placement to the customer with the order details.

#### Order Management
- **Order History** (`orders.php`) — Lists all past and current orders for the logged-in customer, showing order ID, date, status, and total amount.
- **Order Details** (`order_details.php`) — Provides a detailed breakdown of a specific order, including each product ordered, quantities, and prices.
- **PDF Invoice Download** (`generate_invoice.php`) — Generates a professional, downloadable PDF invoice for any completed order using the TCPDF library.

#### Other Pages
- **Feedback** (`feedback.php`) — Allows customers to submit ratings and reviews for products they have purchased.
- **Profile** (`profile.php`) — Displays the customer's account information.
- **Update Profile** (`update_profile.php`) — Allows the customer to update their personal details such as name, phone, and address.
- **Change Password** (`update_pass.php`) — Allows the logged-in customer to change their account password after verifying the current one.
- **About Us** (`about.php`) — Informational page about the Divine Decor business.
- **Terms & Conditions** (`Terms.php`) — Legal terms governing use of the platform.
- **Privacy Policy** (`privacy-policy.php`) — Describes how customer data is collected and used.

---

### 5.2 Administrator Module

The admin panel (`01Admin side/`) gives the business owner full control over all aspects of the e-commerce operation.

#### Authentication & Dashboard
- **Admin Login** (`admin_login.php`) — Secure login page for the administrator using admin credentials stored in the database.
- **Dashboard** (`index.php` / `home.php`) — Provides an at-a-glance overview of business metrics including total products, active orders, registered customers, and recent activity.

#### Product Catalog Management
- **Category Management** (`category.php`, `categoryedit.php`, `category_code.php`) — Create, view, edit, and delete top-level product categories (e.g., "Living Room", "Bedroom", "Kitchen").
- **Sub-Category Management** (`subcategory.php`, `subcategoryedit.php`, `subcategory_code.php`) — Manage sub-categories linked to parent categories, enabling more precise product classification.
- **Product Management** (`product.php`, `productedit.php`, `product_code.php`) — Add new products with name, description, price, stock quantity, category, sub-category, and image. Edit and remove existing products.
- **Offer / Discount Management** (`productoffer.php`, `offer_form.php`, `offer_code.php`, `offeredit.php`) — Create and manage promotional discounts on specific products, including setting discount percentage and validity period.
- **Gallery Management** (`gallery.php`, `gallery_code.php`) — Upload and manage the product image gallery that is displayed to customers.

#### Order & Delivery Management
- **Order Management** (`order.php`, `order_details.php`, `edit_order.php`, `delete_order.php`) — View all customer orders, drill down into individual order details, update order status (Pending, Processing, Shipped, Delivered), and remove orders as needed.
- **Delivery Person Management** (`deliveryperson.php`, `deliverypersonedit.php`, `delivery_code.php`, `update_delivery_person.php`) — Register new delivery personnel, assign them to orders, and update their account details or status.

#### Reports & Analytics
- **Reports Overview** (`report.php`) — Summary dashboard for business performance reports.
- **Sales Report** (`report-sales.php`) — Detailed breakdown of sales revenue over a selected time period.
- **Orders Report** (`report-orders.php`) — Summary of all orders, filterable by date and status.
- **Products Report** (`report-products.php`) — Analysis of product-level sales data showing best-selling and low-performing items.
- **Payment Records** (`payment.php`) — View and manage payment information associated with orders.

#### Other Admin Features
- **Customer Feedback** (`feedback.php`) — View all customer reviews and ratings submitted for products.
- **Registered Customers** (`registerd.php`) — Browse the full list of registered customer accounts.
- **Admin Profile** (`profile.php`, `update_profile_picture.php`) — View and update the administrator's own profile, including uploading a new profile picture.
- **Services** (`services.php`) — Manage additional service offerings displayed on the platform.
- **Layout Components** (`header.php`, `footer.php`, `topbar.php`) — Shared layout partials for the admin panel UI.
- **Configuration** (`config.php`, `connect.php`) — Admin-panel database connection and configuration files.
- **Logout** (`logout.php`) — Ends the admin session securely.

---

### 5.3 Delivery Person Module

The delivery panel (`03Delivery person/`) provides delivery staff with the tools they need to fulfill orders efficiently.

#### Authentication
- **Login** (`login.php`) — Delivery personnel log in using credentials created by the administrator. Access is restricted solely to the delivery panel.
- **Logout** (`logout.php`) — Destroys the delivery person's session and redirects to the login page.

#### Order Management
- **Dashboard** (`index.php`) — A summary view showing the delivery person's assigned orders and current workload.
- **Pending Orders** (`pending-orders.php`) — Lists all orders currently assigned to the logged-in delivery person that are yet to be delivered.
- **Completed Orders** (`completed-orders.php`) — Historical list of all orders that the delivery person has successfully delivered.
- **Update Order Status** (`update_order.php`, `update-order.php`) — Allows the delivery person to mark an assigned order as "Completed" once it has been delivered to the customer.
- **Update Payment Status** (`update_payment.php`) — For Cash on Delivery orders, the delivery person can mark the payment as collected upon delivery.

#### Profile
- **Profile** (`profile.php`) — Displays the delivery person's account information and contact details.
- **Helper** (`code.php`) — Backend processing script supporting profile and order update operations.

---

## 6. Database Design

### 6.1 Database Name

**`customer`** (MySQL / MariaDB)

The database is provided as a full SQL dump at `config/customer.sql` and can be imported directly into phpMyAdmin.

### 6.2 Key Tables

| Table Name | Description |
|------------|-------------|
| `users` | Stores customer registration data including name, email, password (hashed), phone, and address |
| `admin` | Stores administrator login credentials and profile information |
| `delivery_person` | Stores delivery staff accounts including name, contact, and login credentials |
| `products` | Product catalog with name, description, price, stock quantity, category, sub-category, and image path |
| `categories` | Main product categories (e.g., Living Room, Bedroom, Kitchen) |
| `subcategory` | Sub-categories linked to parent categories for finer product classification |
| `cart` | Shopping cart items per user session, storing product ID, quantity, and user ID |
| `orders` | Order header information including user ID, total amount, status, and timestamps |
| `order_details` | Line items per order — each row represents one product in an order with quantity and unit price |
| `feedback` | Customer reviews and ratings submitted for products |
| `gallery` | Product image gallery entries with file paths and associated product IDs |
| `offers` | Discount and promotional offer records including discount percentage and applicable products |
| `payment` | Payment tracking records linking orders to payment status and method |

### 6.3 Database Setup Instructions

1. Open **phpMyAdmin** in your browser (typically at `http://localhost/phpmyadmin`).
2. Click **"New"** in the left sidebar to create a new database.
3. Enter `customer` as the database name and select **utf8_general_ci** as the collation. Click **Create**.
4. With the `customer` database selected, click the **"Import"** tab at the top.
5. Click **"Choose File"** and navigate to `the-divine-door-main/config/customer.sql`.
6. Click **"Go"** to run the import. All tables and sample data will be created automatically.

---

## 7. Folder Structure

```
the-divine-door-main/
├── 01Admin side/
│   ├── index.php                  # Admin dashboard
│   ├── home.php                   # Dashboard home view
│   ├── admin_login.php            # Admin login page
│   ├── admin.php                  # Admin core file
│   ├── adminedit.php              # Edit admin details
│   ├── category.php               # Category management
│   ├── category_code.php          # Category backend processing
│   ├── categoryedit.php           # Edit categories
│   ├── subcategory.php            # Sub-category management
│   ├── subcategory_code.php       # Sub-category backend processing
│   ├── subcategoryedit.php        # Edit sub-categories
│   ├── product.php                # Product listing/management
│   ├── product_code.php           # Product backend processing
│   ├── productedit.php            # Edit products
│   ├── productoffer.php           # Product offer management
│   ├── offer_form.php             # Offer creation form
│   ├── offer_code.php             # Offer backend processing
│   ├── offeredit.php              # Edit offers
│   ├── order.php                  # Order management
│   ├── order_details.php          # Individual order details
│   ├── edit_order.php             # Edit order status
│   ├── delete_order.php           # Delete order
│   ├── deliveryperson.php         # Delivery person management
│   ├── deliverypersonedit.php     # Edit delivery person details
│   ├── delivery_code.php          # Delivery person backend processing
│   ├── update_delivery_person.php # Update delivery person
│   ├── feedback.php               # View customer feedback
│   ├── report.php                 # Reports overview
│   ├── report-sales.php           # Sales report
│   ├── report-orders.php          # Orders report
│   ├── report-products.php        # Products report
│   ├── payment.php                # Payment records
│   ├── gallery.php                # Product gallery management
│   ├── gallery_code.php           # Gallery backend processing
│   ├── profile.php                # Admin profile
│   ├── update_profile_picture.php # Update profile picture
│   ├── services.php               # Services management
│   ├── registerd.php              # Registered customers list
│   ├── header.php                 # Admin panel header
│   ├── footer.php                 # Admin panel footer
│   ├── topbar.php                 # Admin panel topbar
│   ├── logout.php                 # Admin logout
│   ├── config.php                 # Admin-side configuration
│   ├── connect.php                # DB connection (admin panel)
│   └── generate_invoice.php       # Admin invoice generation
│
├── 02User-side/
│   ├── index.php                  # Customer home page
│   ├── shop.php                   # Product listing / shop
│   ├── product.php                # Product detail page
│   ├── cart.php                   # Shopping cart
│   ├── checkout.php               # Checkout process
│   ├── order.php                  # Place order
│   ├── orders.php                 # Order history
│   ├── order_details.php          # Individual order details
│   ├── generate_invoice.php       # PDF invoice download
│   ├── thankyou.php               # Order confirmation page
│   ├── login.php                  # Customer login
│   ├── Reg.php                    # Customer registration
│   ├── logout.php                 # Customer logout
│   ├── forgot_password.php        # Password reset request
│   ├── reset_password.php         # Password reset form
│   ├── feedback.php               # Product feedback / review
│   ├── profile.php                # Customer profile view
│   ├── update_profile.php         # Update profile details
│   ├── update_pass.php            # Change password
│   ├── about.php                  # About us page
│   ├── Terms.php                  # Terms & conditions
│   ├── privacy-policy.php         # Privacy policy
│   ├── out_of_stock.php           # Out-of-stock notice
│   ├── connect.php                # DB connection (user panel)
│   ├── composer.json              # Composer dependency file
│   ├── config/
│   │   └── email_config.php       # SMTP/email configuration
│   ├── functions/                 # Helper function files
│   ├── vendor/                    # Composer dependencies (PHPMailer)
│   └── TCPDF-main/                # TCPDF library (PDF generation)
│
├── 03Delivery person/
│   ├── index.php                  # Delivery person dashboard
│   ├── login.php                  # Delivery person login
│   ├── logout.php                 # Delivery person logout
│   ├── pending-orders.php         # Assigned pending orders
│   ├── completed-orders.php       # Completed order history
│   ├── update_order.php           # Update order status
│   ├── update-order.php           # Update order (alternate handler)
│   ├── update_payment.php         # Update payment status
│   ├── profile.php                # Delivery person profile
│   └── code.php                   # Backend helper script
│
├── config/
│   ├── dbcon.php                  # Global DB connection configuration
│   └── customer.sql               # Full MySQL database dump
│
├── gallery/                       # Uploaded product images
├── TCPDF-main/                    # TCPDF library (root level)
├── README.md                      # Project readme
└── DOCUMENTATION.md               # ← This file
```

---

## 8. Installation & Setup Guide

Follow these steps to set up and run The Divine Decor on your local machine.

### Step 1 — Prerequisites

Ensure the following software is installed on your system:

- **XAMPP** (or WAMP): [https://www.apachefriends.org/](https://www.apachefriends.org/) — Provides Apache, MySQL, and PHP.
- **Composer**: [https://getcomposer.org/](https://getcomposer.org/) — Required for installing PHPMailer.
- **A modern web browser**: Google Chrome, Firefox, or Edge.

### Step 2 — Copy the Project

Copy the entire `the-divine-door-main` folder (or clone the repository) into the XAMPP `htdocs` directory:

```
C:\xampp\htdocs\the-divine-door-main\    (Windows)
/opt/lampp/htdocs/the-divine-door-main/  (Linux)
```

If cloning from GitHub:

```bash
cd C:\xampp\htdocs
git clone https://github.com/23bmiit043-pixel/divine-decor.git
```

The project folder will then be at `htdocs/divine-decor/the-divine-door-main/`. Update all paths and URLs below accordingly, replacing `the-divine-door-main` with `divine-decor/the-divine-door-main`.

### Step 3 — Start Apache and MySQL

1. Open the **XAMPP Control Panel**.
2. Click **Start** next to **Apache**.
3. Click **Start** next to **MySQL**.
4. Both services should show a green status indicator.

### Step 4 — Database Setup

1. Open your browser and navigate to `http://localhost/phpmyadmin`.
2. Click **"New"** in the left panel.
3. Enter `customer` as the database name. Choose **utf8_general_ci** collation. Click **Create**.
4. Select the `customer` database from the left panel.
5. Click the **"Import"** tab.
6. Click **"Choose File"** and select:
   ```
   the-divine-door-main/config/customer.sql
   ```
7. Click **"Go"**. The database tables and default data will be imported successfully.

### Step 5 — Configure Database Connection

Open `the-divine-door-main/config/dbcon.php` and verify (or update) the following settings to match your local MySQL setup:

```php
<?php
$host     = "localhost";
$username = "root";
$password = "";          // Default XAMPP password is empty
$database = "customer";

$conn = mysqli_connect($host, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
```

Also verify `the-divine-door-main/02User-side/connect.php` contains the same correct credentials.

### Step 6 — Configure Email (PHPMailer / SMTP)

Open `the-divine-door-main/02User-side/config/email_config.php` and set your SMTP credentials to enable the forgot-password email feature:

```php
<?php
define('SMTP_HOST',     'smtp.gmail.com');
define('SMTP_USERNAME', 'your-email@gmail.com');
define('SMTP_PASSWORD', 'your-app-password');   // Use a Gmail App Password
define('SMTP_PORT',     587);
define('SMTP_FROM',     'your-email@gmail.com');
define('SMTP_NAME',     'The Divine Decor');
?>
```

> **Note:** For Gmail, generate an **App Password** from your Google Account security settings (requires 2-Step Verification to be enabled).

### Step 7 — Install Composer Dependencies

Open a terminal / command prompt, navigate to the `02User-side` directory, and run:

```bash
cd C:\xampp\htdocs\the-divine-door-main\02User-side
composer install
```

This will install **PHPMailer** and any other declared dependencies into the `vendor/` folder.

### Step 8 — Access the Application

Open your browser and navigate to the appropriate URL for each panel:

| Panel | URL |
|-------|-----|
| **Customer / User** | `http://localhost/the-divine-door-main/02User-side/index.php` |
| **Admin** | `http://localhost/the-divine-door-main/01Admin%20side/admin_login.php` |
| **Delivery Person** | `http://localhost/the-divine-door-main/03Delivery%20person/login.php` |

> **Note for repository clone:** If the project was cloned using git, the path will be:
> `http://localhost/divine-decor/the-divine-door-main/02User-side/index.php`

---

## 9. Testing

The following test cases were performed to validate the functionality of all three modules:

| # | Test Case | Input / Action | Expected Result | Status |
|---|-----------|----------------|-----------------|--------|
| 1 | User Registration | Fill all registration fields and submit `Reg.php` | Account created, user redirected to login page | ✅ Pass |
| 2 | User Login | Enter valid email and password on `login.php` | Session created, user redirected to home page | ✅ Pass |
| 3 | Forgot Password | Enter registered email on `forgot_password.php` | Password reset link sent to the email via PHPMailer | ✅ Pass |
| 4 | Add to Cart | Click "Add to Cart" on a product detail page | Product added to cart, cart count updates in header | ✅ Pass |
| 5 | Cart Quantity Update | Increase or decrease quantity in `cart.php` | Cart subtotal and total recalculate correctly | ✅ Pass |
| 6 | Place Order (COD) | Complete checkout form and submit on `checkout.php` | Order saved to database, user redirected to thank-you page | ✅ Pass |
| 7 | PDF Invoice Download | Click "Download Invoice" on `orders.php` | PDF file generated by TCPDF and downloaded to browser | ✅ Pass |
| 8 | Admin Login | Enter valid admin credentials on `admin_login.php` | Admin session created, dashboard loads successfully | ✅ Pass |
| 9 | Add New Product | Fill product form in admin panel and submit | Product appears in catalog and is browsable by customers | ✅ Pass |
| 10 | Admin Update Order Status | Select new status from dropdown in `edit_order.php` | Order status updated in the database and reflected in customer view | ✅ Pass |
| 11 | Delivery Person Login | Enter valid delivery person credentials on login page | Dashboard loads showing assigned pending orders | ✅ Pass |
| 12 | Mark Order as Completed | Click "Complete" on a pending order in delivery panel | Order moved to completed-orders list, status updated in DB | ✅ Pass |
| 13 | View Sales Report | Navigate to Reports > Sales in admin panel | Sales report generated showing revenue breakdown | ✅ Pass |
| 14 | Category Management | Add a new category via admin panel | New category appears in shop filter and product form | ✅ Pass |
| 15 | Product Offer Application | Create an offer and apply to a product | Discounted price displayed on product page for customers | ✅ Pass |

---

## 10. Security Features

The Divine Decor implements several security measures to protect user data and prevent unauthorized access:

- **Session-Based Authentication** — All three panels (Customer, Admin, Delivery Person) use PHP sessions to authenticate users. Every protected page verifies the session before rendering content; unauthenticated requests are redirected to the respective login page.
- **Password Hashing** — Customer passwords are stored securely using PHP's `password_hash()` function (bcrypt), ensuring that plain-text passwords are never written to the database.
- **Role-Based Access Control** — Each panel is completely isolated. A customer session cannot access admin routes, and a delivery person session cannot access customer or admin pages, preventing privilege escalation.
- **Input Validation and Sanitization** — User inputs are validated on both the client side (JavaScript) and server side (PHP). Database queries use parameterized prepared statements (`mysqli_prepare()` / `PDO`) as the primary defense against SQL injection attacks.
- **Secure Password Reset via Email Token** — The forgot-password flow generates a unique, time-limited token sent via email. The token is verified server-side before allowing a password change, preventing unauthorized resets.
- **File Upload Restrictions** — Product and profile image uploads are restricted by file type and size to prevent the upload of malicious files.
- **`.htaccess` Protection** — The admin directory is protected via Apache `.htaccess` rules to restrict direct access to sensitive configuration and backend files.
- **SMTP Authentication for Emails** — PHPMailer is configured with SMTP authentication (not PHP's `mail()` function), ensuring that email delivery is reliable, authenticated, and less prone to spoofing.

---

## 11. Conclusion

The Divine Decor e-commerce website successfully demonstrates the development of a complete, multi-role web application using PHP and MySQL. All three panels — Customer, Administrator, and Delivery Person — were built and tested to provide a seamless end-to-end shopping and fulfillment experience. The project fulfils all its defined objectives: product catalog management, secure user authentication, cart and checkout processing, order tracking, PDF invoice generation, and business reporting. This project shows that a functional and professional-grade e-commerce solution can be built entirely with open-source technologies.

The development process involved overcoming several technical challenges, most notably implementing session-based multi-role authentication to ensure that each user type could only access their designated panel. Integrating the TCPDF library for dynamic PDF invoice generation required careful study of the library's API, and configuring PHPMailer with Gmail's SMTP for password reset emails involved learning about App Passwords and secure email transmission. Managing the relational database schema — particularly the relationships between orders, order details, products, and users — reinforced the importance of proper database normalization and foreign key design.

Overall, this project was a deeply rewarding learning experience that covered the full stack of web development: database design, server-side business logic, client-side interactivity, third-party library integration, and user interface design. It instilled strong practical skills in PHP, MySQL, Bootstrap, and project organization — skills that are directly applicable to real-world software development roles.

---

## 12. Future Scope

The following enhancements are planned for future development iterations of The Divine Decor:

- **Online Payment Gateway Integration** — Integrate Razorpay or Stripe to support secure online card payments. A `RAZORPAY_SETUP.md` file already exists in `02User-side/`, indicating this was actively planned during development.
- **Mobile Application** — Develop a native Android and/or iOS mobile application using Flutter or React Native, consuming a REST API built on the existing PHP backend.
- **AI-Powered Product Recommendations** — Implement a recommendation engine that suggests products to customers based on browsing history, purchase patterns, and collaborative filtering.
- **Automated Email Order Notifications** — Send automated email confirmations to customers when orders are placed, dispatched, and delivered, improving communication and trust.
- **Multi-Language Support** — Add internationalization (i18n) support to serve customers in multiple languages, expanding the platform's reach.
- **Enhanced Product Rating & Review System** — Allow customers to upload photos with their reviews and implement a verified-purchase badge to increase review authenticity.
- **Stock / Inventory Alert System** — Automatically notify the administrator when product stock falls below a defined threshold, preventing out-of-stock situations and lost sales.
- **Coupon Code System** — Implement a coupon/promo-code feature allowing the admin to create discount codes that customers can apply at checkout.

---

## 13. References

1. **PHP Manual** — Official PHP documentation for all core functions, session management, and database connectivity.
   [https://www.php.net/docs.php](https://www.php.net/docs.php)

2. **MySQL Documentation** — Official reference for MySQL queries, schema design, and administration.
   [https://dev.mysql.com/doc/](https://dev.mysql.com/doc/)

3. **Bootstrap Documentation** — Official Bootstrap framework docs for responsive grid, components, and utilities.
   [https://getbootstrap.com/docs/](https://getbootstrap.com/docs/)

4. **TCPDF Library** — Open-source PHP library for PDF generation used for invoice creation.
   [https://tcpdf.org/](https://tcpdf.org/)

5. **PHPMailer** — The full-featured email sending library for PHP used for password reset emails.
   [https://github.com/PHPMailer/PHPMailer](https://github.com/PHPMailer/PHPMailer)

6. **W3Schools PHP Tutorial** — Beginner-friendly PHP reference and examples.
   [https://www.w3schools.com/php/](https://www.w3schools.com/php/)

7. **XAMPP Documentation** — Apache Friends documentation for the XAMPP local server stack.
   [https://www.apachefriends.org/](https://www.apachefriends.org/)

8. **Composer — Dependency Manager for PHP** — Official Composer documentation for managing PHP packages.
   [https://getcomposer.org/doc/](https://getcomposer.org/doc/)

9. **jQuery Documentation** — Official jQuery library reference for DOM manipulation and AJAX.
   [https://api.jquery.com/](https://api.jquery.com/)

10. **MDN Web Docs** — Mozilla Developer Network reference for HTML5, CSS3, and JavaScript.
    [https://developer.mozilla.org/](https://developer.mozilla.org/)

---

*Documentation prepared for college final-year project submission.*
*Project: The Divine Decor – E-Commerce Website*
