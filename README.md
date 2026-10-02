# Student Registration System — AWS Cloud Project

A cloud-hosted **Student Registration System** built using **PHP, MySQL, HTML5, and CSS3**, and deployed on an **AWS EC2 instance** using Apache Web Server.

The application provides a web-based interface for managing student records with registration, search, editing, deletion, validation, and MySQL database integration.

This project was developed as a college **Cloud Computing Tiny Project** to demonstrate both web application development and deployment of an application on cloud infrastructure.

---

## ☁️ Cloud Deployment

The application is hosted on an **Amazon EC2 virtual machine** running a Linux operating system.

### Deployment Architecture

```text
                         INTERNET
                            │
                            │ HTTP
                            ▼
                  ┌────────────────────┐
                  │     AWS EC2        │
                  │   Linux Server     │
                  │                    │
                  │  Public IP / DNS   │
                  └─────────┬──────────┘
                            │
                            ▼
                  ┌────────────────────┐
                  │      Apache        │
                  │    Web Server      │
                  └─────────┬──────────┘
                            │
                            ▼
                  ┌────────────────────┐
                  │       PHP          │
                  │   Application      │
                  └─────────┬──────────┘
                            │
                            │ MySQLi
                            ▼
                  ┌────────────────────┐
                  │       MySQL        │
                  │     Database       │
                  │                    │
                  │ student_registration│
                  └────────────────────┘
```

### Cloud Architecture

The application follows a simple cloud-hosted web architecture:

**Client → Internet → AWS EC2 → Apache → PHP → MySQL**

AWS EC2 provides the compute infrastructure required to run the web application.

---

## 🚀 Features

- Student registration
- Server-side form validation
- Unique enrollment number validation
- Student dashboard
- Student statistics
- View registered students
- Search students by name
- Search students by enrollment number
- Edit student records
- Delete student records
- MySQL database integration
- Prepared SQL statements
- XSS-safe HTML output
- Responsive user interface
- Cloud deployment using AWS EC2

---

## 🛠️ Technology Stack

| Technology | Purpose |
|---|---|
| AWS EC2 | Cloud compute infrastructure |
| Linux | Server operating system |
| Apache | Web server |
| PHP | Backend/application logic |
| MySQL | Relational database |
| MySQLi | PHP-MySQL database connectivity |
| HTML5 | Application structure |
| CSS3 | User interface and responsive design |
| JavaScript | Client-side interaction |
| Git | Version control |
| GitHub | Source code hosting |

---

## ☁️ AWS Services Used

### Amazon EC2

EC2 is used to host the web application.

The EC2 instance runs:

- Linux
- Apache
- PHP
- MySQL
- Student Registration System

### EC2 Security Group

The server requires appropriate inbound rules for web access.

Typical configuration:

| Protocol | Port | Purpose |
|---|---:|---|
| SSH | 22 | Server administration |
| HTTP | 80 | Web application |
| HTTPS | 443 | Secure web access, if configured |

> SSH access should ideally be restricted to trusted IP addresses rather than exposing port 22 to everyone.

---

## 📁 Project Structure

```text
student-registration-system-aws/
│
├── database.sql
├── db.example.php
├── db.php
├── delete.php
├── edit.php
├── index.php
├── register.php
├── students.php
├── style.css
├── .gitignore
└── README.md
```

### File Description

| File | Purpose |
|---|---|
| `index.php` | Dashboard and application home page |
| `register.php` | Student registration form and validation |
| `students.php` | Student listing and search |
| `edit.php` | Edit existing student records |
| `delete.php` | Delete student records |
| `db.php` | Local database connection configuration |
| `db.example.php` | Example database configuration |
| `database.sql` | Database schema and sample data |
| `style.css` | Application styling |
| `.gitignore` | Prevents sensitive/local files from being committed |

---

## 🗄️ Database

The application uses MySQL.

### Database

```text
student_registration
```

### Table

```text
students
```

### Schema

| Column | Type | Description |
|---|---|---|
| `id` | INT | Auto-increment primary key |
| `enrollment_no` | VARCHAR(50) | Unique enrollment number |
| `full_name` | VARCHAR(100) | Student name |
| `email` | VARCHAR(100) | Student email |
| `phone` | VARCHAR(20) | Contact number |
| `course` | VARCHAR(50) | Course/branch |
| `semester` | VARCHAR(20) | Current semester |
| `gender` | ENUM | Student gender |
| `created_at` | TIMESTAMP | Record creation timestamp |

---

# 🖥️ Running the Project Locally

## Requirements

- PHP 7.x or 8.x
- MySQL or MariaDB
- Apache
- Git
- Web browser

---

## 1. Clone the repository

```bash
git clone https://github.com/YOUR-USERNAME/student-registration-system-aws.git
```

```bash
cd student-registration-system-aws
```

---

## 2. Configure the database

Create the local database configuration:

```bash
cp db.example.php db.php
```

Edit `db.php` according to your local MySQL configuration.

---

## 3. Create the database

Import:

```text
database.sql
```

This creates:

```text
student_registration
```

and the:

```text
students
```

table.

---

## 4. Start Apache and MySQL

Start your local Apache and MySQL services.

Then open:

```text
http://localhost/student-registration-system-aws/
```

---

# ☁️ AWS EC2 Deployment

The application was deployed to an AWS EC2 instance.

A typical deployment process is:

## 1. Launch an EC2 instance

Create an EC2 instance with a Linux distribution such as Ubuntu.

Configure the security group to allow web traffic.

Required ports:

```text
22  → SSH
80  → HTTP
```

---

## 2. Connect to EC2

Example:

```bash
ssh -i your-key.pem ubuntu@YOUR_EC2_PUBLIC_IP
```

---

## 3. Update the server

```bash
sudo apt update
sudo apt upgrade -y
```

---

## 4. Install Apache

```bash
sudo apt install apache2 -y
```

Start Apache:

```bash
sudo systemctl enable apache2
sudo systemctl start apache2
```

---

## 5. Install PHP

```bash
sudo apt install php libapache2-mod-php php-mysql -y
```

Verify:

```bash
php -v
```

---

## 6. Install MySQL

```bash
sudo apt install mysql-server -y
```

Start MySQL:

```bash
sudo systemctl enable mysql
sudo systemctl start mysql
```

Verify:

```bash
sudo systemctl status mysql
```

---

## 7. Deploy the application

Copy the project into Apache's web directory:

```text
/var/www/html/
```

For example:

```text
/var/www/html/student-registration-system-aws/
```

---

## 8. Configure the database

Create/import the database using:

```bash
sudo mysql < database.sql
```

Configure the application database connection in:

```text
db.php
```

---

## 9. Set appropriate permissions

Example:

```bash
sudo chown -R www-data:www-data /var/www/html/student-registration-system-aws
```

---

## 10. Access the application

Open:

```text
http://YOUR_EC2_PUBLIC_IP/student-registration-system-aws/
```

The application can then be accessed through the EC2 instance's public IP address.

---

# 🔄 Application Workflow

```text
                    ┌─────────────────┐
                    │     Dashboard   │
                    └────────┬────────┘
                             │
               ┌─────────────┴─────────────┐
               │                           │
               ▼                           ▼
       ┌───────────────┐           ┌───────────────┐
       │ Register      │           │ View Students │
       │ Student       │           │               │
       └───────┬───────┘           └───────┬───────┘
               │                           │
               └─────────────┬─────────────┘
                             ▼
                     ┌───────────────┐
                     │     MySQL     │
                     │    Database   │
                     └───────┬───────┘
                             │
                 ┌───────────┼───────────┐
                 ▼           ▼           ▼
               Search      Edit        Delete
```

---

# 🔐 Security

The project implements several basic security practices.

### Prepared SQL Statements

MySQLi prepared statements are used for database operations to reduce SQL injection risk.

Example:

```php
$stmt = $conn->prepare(
    "SELECT * FROM students WHERE id = ?"
);
```

### HTML Output Escaping

Student data displayed in HTML is escaped using:

```php
htmlspecialchars()
```

This helps reduce XSS risk.

### Server-Side Validation

The application validates:

- Required fields
- Email format
- Phone number
- Enrollment number
- Course
- Semester
- Gender
- Duplicate enrollment numbers

---

# 📊 CRUD Operations

The project demonstrates all four fundamental CRUD operations.

| CRUD | Function |
|---|---|
| Create | Register a student |
| Read | View/search students |
| Update | Edit student information |
| Delete | Delete student records |

---

# 🎓 Learning Objectives

This project was developed to demonstrate practical knowledge of:

- Cloud computing
- AWS EC2
- Linux server administration
- Apache web server
- PHP web development
- MySQL database management
- PHP-MySQL integration
- CRUD operations
- SQL queries
- Prepared statements
- Server-side validation
- Basic web security
- Git and GitHub
- Cloud application deployment

---

# 🔮 Future Improvements

Possible improvements include:

- HTTPS using SSL/TLS
- Custom domain name
- AWS RDS instead of local MySQL
- AWS CloudWatch monitoring
- IAM-based AWS access management
- Automated deployment using GitHub Actions
- Docker containerization
- HTTPS with Let's Encrypt
- Application logging
- Pagination
- Advanced search and filtering
- User authentication
- Admin/student roles
- CSRF protection
- REST API
- AWS architecture using separate application and database tiers

---

# 📌 Project Status

**Completed — Cloud Computing Tiny Project**

The application is deployed on an AWS EC2 instance and can be accessed through the configured EC2 public endpoint.

---

## Author

**Jaydev**

MCA — Cloud Computing

---

## License

This project was developed as an academic/educational project.
