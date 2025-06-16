
# 📝 PHP Blog Application - Task 2 (APEX Internship)

This is a simple blog web application built using **PHP** and **MySQL** as part of **Task 2 of the APEX Internship**. It supports user authentication and basic CRUD operations for blog posts, all styled with clean HTML/CSS.

## 🔧 Features

- 🔐 User Registration & Login (with hashed passwords)
- 🗂️ Create, Read, Update, Delete (CRUD) blog posts
- 🧑‍💻 Dashboard for managing posts
- ✅ Session management & access control
- 🎨 Clean and responsive UI using vanilla CSS

## 📸 Screenshots

| Login Page | Dashboard |
|------------|-----------|
| ![Login](screenshots/login.png) | ![Dashboard](screenshots/dashboard.png) |

> *(Add your screenshots inside a `/screenshots` folder)*

## 🛠️ Technologies Used

- **PHP** (Procedural)
- **MySQL** (XAMPP local server)
- **HTML & CSS**
- **XAMPP** for development and testing

## 📂 Folder Structure

```

crud-app/
├── add\_post.php
├── dashboard.php
├── delete\_post.php
├── edit\_post.php
├── login.php
├── logout.php
├── register.php
└── README.md

```

## 🚀 How to Run Locally

1. Install [XAMPP](https://www.apachefriends.org/index.html)
2. Place the project folder inside `htdocs`:
```

C:\xampp\htdocs\php\crud-app

````
3. Start **Apache** and **MySQL** via XAMPP Control Panel.
4. Import the database:
- Open `http://localhost/phpmyadmin`
- Create a database named `blog`
- Run the following SQL:

```sql
CREATE TABLE users (
id INT AUTO_INCREMENT PRIMARY KEY,
username VARCHAR(100) NOT NULL UNIQUE,
password VARCHAR(255) NOT NULL
);

CREATE TABLE posts (
id INT AUTO_INCREMENT PRIMARY KEY,
title VARCHAR(255) NOT NULL,
content TEXT NOT NULL,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
````

5. Open the app in browser:

   ```
   http://localhost/php/crud-app/register.php
   ```

## 📌 Acknowledgements

* This project was created as part of the **APEX Internship Program - Task 2**
* Inspired by simple blogging systems to learn backend fundamentals

---

### 💻 Author

**Hemalatha Bora**
📧 [hemalathabora9@gmail.com](mailto:hemalathabora9@gmail.com)


