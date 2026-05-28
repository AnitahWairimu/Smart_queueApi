CREATE DATABASE IF NOT EXISTS smart_queue;
USE smart_queue;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'staff') NOT NULL
);

CREATE TABLE IF NOT EXISTS queue (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ticket_no VARCHAR(20) NOT NULL,
    customer_name VARCHAR(120) NOT NULL,
    service_type VARCHAR(50) NOT NULL,
    department VARCHAR(60) NOT NULL DEFAULT 'general',
    priority ENUM('normal', 'emergency') NOT NULL DEFAULT 'normal',
    status ENUM('waiting', 'serving', 'done') NOT NULL DEFAULT 'waiting',
    served_at TIMESTAMP NULL DEFAULT NULL,
    done_at TIMESTAMP NULL DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (name, email, password, role)
VALUES
    ('Admin User', 'admin@smartqueue.local', '$2y$10$0X/dNGQGd2LhvVm4cT3NLu7Jp0kCvnNpGkDl9N7Z0QKdL6DhL5dAu', 'admin'),
    ('Staff User', 'staff@smartqueue.local', '$2y$10$L3s4R0pN5qL5tH7nK2jFkuF8vQ9bP6sM3xL7dN8qK9pM0vL3cR6T', 'staff');
