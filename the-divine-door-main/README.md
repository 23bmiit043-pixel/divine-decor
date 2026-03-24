# The Divine Decor - E-commerce Website

This is a full-featured e-commerce website for a home decor store called "The Divine Decor". The project is built using PHP and MySQL and includes separate interfaces for customers, administrators, and delivery personnel.

## Features

### Customer (User-side)
- User registration and login system.
- Secure password reset functionality via email.
- Browse products by categories and sub-categories.
- Add products to the shopping cart.
- Manage items in the cart (increase/decrease quantity, remove items).
- Checkout process with Cash on Delivery (COD) payment option.
- View order history and detailed order information.
- Generate and download PDF invoices for completed orders.
- Update user profile information and password.
- Provide feedback on purchased products.

### Administrator (Admin side)
- Secure admin login.
- Dashboard for an overview of the store.
- Manage product categories and sub-categories.
- Add, edit, and delete products.
- Manage orders (view details, update status).
- Manage delivery personnel accounts.
- View customer feedback.
- Generate sales and product reports.

### Delivery Person
- Secure login for delivery personnel.
- View assigned pending orders.
- View completed orders.
- Update order status (e.g., to '''Completed''').
- Update payment status.

## Technologies Used

- **Frontend:** HTML, CSS, JavaScript, Bootstrap
- **Backend:** PHP
- **Database:** MySQL / MariaDB
- **Libraries:**
    - **TCPDF:** For generating PDF invoices.
    - **PHPMailer:** For sending emails (e.g., password reset).

## Setup and Installation

1.  **Clone the repository:**
    ```bash
    git clone https://github.com/your-username/the-divine-decor.git
    ```

2.  **Database Setup:**
    - Create a new database named `customer` in your MySQL server (e.g., using phpMyAdmin).
    - Import the `02User-side/sql/customer.sql` file into the newly created database.

3.  **Configuration:**
    - **Database Connection:**
        - Edit `config/dbcon.php` and `02User-side/connect.php` with your database credentials (host, username, password, database name).
    - **Email Configuration:**
        - Edit `02User-side/config/email_config.php` with your SMTP server details for sending emails.

4.  **Install Dependencies:**
    - Navigate to the `02User-side` directory.
    - Run `composer install` to install the required PHP libraries (PHPMailer).

5.  **Run the application:**
    - Place the project folder in your web server's root directory (e.g., `htdocs` for XAMPP).
    - Access the application through your web browser.

## Folder Structure

-   `01Admin side/`: Contains all files for the admin panel.
-   `02User-side/`: Contains all files for the customer-facing website.
-   `03Delivery person/`: Contains all files for the delivery person's interface.
-   `config/`: Contains database connection configuration.
-   `gallery/`: Contains uploaded product images.

## License

This project is licensed under the MIT License. See the `LICENSE` file for details.
