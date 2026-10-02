# Student Registration System

A simple, modern, and beginner-friendly **Student Registration System** built as a college Tiny Project using **HTML, CSS, PHP, and MySQL**.

---

## 📌 Project Overview

The **Student Registration System** is a lightweight web application designed for educational institutions to manage student enrollment records efficiently. It provides a simple dashboard, student registration with form validation, a search-enabled student list, record editing, and secure deletion functionality.

---

## ✨ Features

- 🏠 **Home Dashboard**: Displays quick stats (total student count, course programs) and quick action buttons.
- 📝 **Student Registration**: Form to collect Student Details (ID/Enrollment Number, Full Name, Email, Phone, Course, Semester, and Gender) with server-side validation.
- 📋 **View Students List**: Clean, formatted data table displaying all registered student records.
- 🔍 **Search Functionality**: Search students instantly by **Full Name** or **Enrollment Number**.
- ✏️ **Edit Records**: Pre-filled update form to modify student information.
- 🗑️ **Delete Records**: Safe deletion of records with interactive JavaScript confirmation modals.
- 🛡️ **Security**: Prepared SQL statements (MySQLi) to prevent SQL Injection, plus HTML escaping (`htmlspecialchars`) to protect against Cross-Site Scripting (XSS).

---

## 🛠️ Technologies Used

- **Frontend**: HTML5, CSS3 (Modern Flexbox/Grid, Responsive Design System, Google Fonts)
- **Backend**: Native PHP (PHP 7.x / 8.x)
- **Database**: MySQL / MariaDB
- **Local Web Server**: Apache (via XAMPP) or PHP Built-in Server

---

## 📁 File Structure

```text
student-registration/
│
├── index.php         # Home page & dashboard overview
├── register.php      # Student registration form & validation
├── students.php      # Display all students & search box
├── edit.php          # Edit existing student details
├── delete.php        # Delete student handler
├── db.php            # Database connection configuration
├── style.css         # Main stylesheet for UI design
├── database.sql      # Database schema & sample student records
└── README.md         # Comprehensive project documentation
```

---

## 🗄️ Database Schema

- **Database Name**: `student_registration`
- **Table Name**: `students`

| Field Name      | Data Type                    | Description                     |
| --------------- | ---------------------------- | ------------------------------- |
| `id`            | INT (AUTO_INCREMENT, PRIMARY)| Unique Record ID                |
| `enrollment_no` | VARCHAR(50) (UNIQUE)         | Student Enrollment No / ID      |
| `full_name`     | VARCHAR(100)                 | Student's Full Name             |
| `email`         | VARCHAR(100)                 | Email Address                   |
| `phone`         | VARCHAR(20)                  | Contact Phone Number            |
| `course`        | VARCHAR(50)                  | Enrolled Course/Branch          |
| `semester`      | VARCHAR(20)                  | Current Semester                |
| `gender`        | ENUM('Male','Female','Other')| Gender                          |
| `created_at`    | TIMESTAMP                    | Record creation timestamp       |

---

## 🚀 How to Run Locally using XAMPP (Windows)

1. Download or extract the `student-registration` project folder into `C:\xampp\htdocs\student-registration`.
2. Open **XAMPP Control Panel** and click **Start** for **Apache** and **MySQL**.
3. Open browser and go to `http://localhost/phpmyadmin/`.
4. Import `database.sql` to create the database and sample records.
5. Open browser at `http://localhost/student-registration/`.

---

## ☁️ Hosting in Google Cloud (Compute Engine / Skills Boost)

### Method 1: Hosting on a Windows Server VM (Google Cloud Compute Engine)

1. In GCP Console, go to **Compute Engine** > **VM instances** > **Create Instance**.
2. Name the instance (e.g. `student-app-win-vm`).
3. Under **OS and Storage**, click **Change** and select **Windows Server** (e.g., *Windows Server 2022 Datacenter*).
4. Under **Firewall**, check **Allow HTTP traffic** (Port 80).
5. Click **Create**.
6. Once the VM status is running, click **RDP** > **Set Windows Password** to obtain your login credentials.
7. Connect to the VM via Remote Desktop (RDP).
8. Inside the Windows VM, open Microsoft Edge, download and install **XAMPP for Windows** from `https://www.apachefriends.org/`.
9. Copy your project files to `C:\xampp\htdocs\student-registration`.
10. Open **XAMPP Control Panel** inside the VM and click **Start** for **Apache** and **MySQL**.
11. Open Edge browser inside the VM to `http://localhost/phpmyadmin`, create database `student_registration`, and import `database.sql`.
12. Access your live website from any browser using your VM's **External IP**:
    ```text
    http://<WINDOWS_VM_EXTERNAL_IP>/student-registration/
    ```

---

### Method 2: Hosting on an Ubuntu Linux VM (Google Cloud Compute Engine)

1. In GCP Console, go to **Compute Engine** > **VM instances** > **Create Instance**.
2. Choose **Ubuntu 22.04 LTS** and check **Allow HTTP traffic**.
3. Connect via **SSH** and run:
   ```bash
   sudo apt update && sudo apt install -y apache2 php libapache2-mod-php php-mysqli php-mysql mysql-server git
   sudo service mysql start && sudo service apache2 start
   sudo mysql -e "CREATE DATABASE student_registration;"
   ```
4. Move project files to `/var/www/html/student-registration` and import database:
   ```bash
   sudo mysql student_registration < /var/www/html/student-registration/database.sql
   sudo chown -R www-data:www-data /var/www/html/
   sudo systemctl restart apache2
   ```
5. Access via: `http://<VM_EXTERNAL_IP>/student-registration/`

---

### Method 3: Instant Hosting via Google Cloud Shell & Web Preview

1. Open **Google Cloud Shell** (`>_`) in GCP Console.
2. Install PHP & MySQL:
   ```bash
   sudo apt update && sudo apt install -y php php-mysqli php-mysql mysql-server git
   sudo service mysql start
   sudo mysql -e "CREATE DATABASE student_registration;"
   ```
3. Navigate to project folder and import database:
   ```bash
   cd student-registration
   sudo mysql student_registration < database.sql
   ```
4. Start PHP built-in web server:
   ```bash
   php -S 0.0.0.0:8080
   ```
5. Click **Web Preview** icon > **Preview on port 8080**.

---

## 🔒 Security Features

- **Prepared SQL Statements**: Uses MySQLi prepared queries to eliminate SQL Injection.
- **XSS Protection**: HTML data output is safely sanitized with `htmlspecialchars()`.
- **Server Validation**: Ensures valid email formats, phone numbers, and unique enrollment IDs.
