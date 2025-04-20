# TheBlog

# 📂 Simple Blog System (PHP + MySQL)

This is a simple blog system built with PHP and MySQL. The project features two main database tables: `users` and `posts`, which handle basic user and content management.

## 📋 Features

- User registration and login (authentication system)
- Creating and listing blog posts
- MySQL-based backend with `users` and `posts` tables
- Clean and minimal code structure

## 📁 Project Structure

```bash
/c
  /xampp
    /htdocs
      /blog 
        ├── index.php 
        ├── login.php 
        ├── register.php 
        ├── post.php 
        ├── db.php
        ├── welcome.php
        ├── admin.php
        ├── style.css
        ...
        // and the others

```



> **Note:** The project **does not include** the actual `.sql` database export file.  
> You must manually create the required tables (`users`, `posts` and `comments`) in your MySQL database.

## 🛠️ How to Set Up

1. Clone the repository:

```bash
git clone https://github.com/HamzaGurbuz/TheBlog
```

2. Import the database schema manually (see the next section).

3. Update the database connection info in config.php.

users table

```bash
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL,
  email VARCHAR(100) NOT NULL,
  password VARCHAR(255) NOT NULL
);
```


posts table

```bash
CREATE TABLE posts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  title VARCHAR(255),
  content TEXT,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

comments table

```bash
CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL,
    username VARCHAR(255),
    comment TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

🚧 To-Do / Improvements
Add password hashing ✔️

Improve UI with responsive design

Add comments functionality








