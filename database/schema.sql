-- Aircon Cleaning and Repair Services Schedule Database Schema
-- MySQL Version: 8.0+

-- ===========================
-- Drop existing tables (for fresh install)
-- ===========================
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS appointments;
DROP TABLE IF EXISTS technicians;
DROP TABLE IF EXISTS services;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS audit_logs;
SET FOREIGN_KEY_CHECKS = 1;

-- ===========================
-- Users Table
-- ===========================
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) UNIQUE NOT NULL,
  email VARCHAR(100) UNIQUE NOT NULL,
  name VARCHAR(100) NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('admin', 'technician', 'customer') DEFAULT 'customer',
  phone VARCHAR(20),
  address TEXT,
  status ENUM('active', 'inactive', 'suspended') DEFAULT 'active',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  last_login TIMESTAMP NULL,
  INDEX idx_username (username),
  INDEX idx_email (email),
  INDEX idx_role (role),
  INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===========================
-- Services Table
-- ===========================
CREATE TABLE services (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  description TEXT,
  category ENUM('cleaning', 'repair', 'maintenance', 'inspection') NOT NULL,
  base_price DECIMAL(10, 2) NOT NULL,
  estimated_duration INT COMMENT 'Duration in minutes',
  is_active BOOLEAN DEFAULT TRUE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_category (category),
  INDEX idx_is_active (is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===========================
-- Technicians Table
-- ===========================
CREATE TABLE technicians (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL UNIQUE,
  specialty VARCHAR(100),
  license_number VARCHAR(50) UNIQUE,
  certification_date DATE,
  status ENUM('available', 'busy', 'on_leave', 'inactive') DEFAULT 'available',
  rating DECIMAL(3, 2) DEFAULT 0.00,
  total_jobs INT DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  INDEX idx_status (status),
  INDEX idx_rating (rating)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===========================
-- Appointments Table
-- ===========================
CREATE TABLE appointments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  customer_id INT NOT NULL,
  service_id INT NOT NULL,
  tech_id INT,
  appointment_date DATE NOT NULL,
  appointment_time TIME NOT NULL,
  customer_name VARCHAR(100),
  customer_username VARCHAR(50),
  customer_email VARCHAR(100),
  customer_phone VARCHAR(20),
  service VARCHAR(100),
  date VARCHAR(20),
  slot VARCHAR(50),
  address TEXT NOT NULL,
  status ENUM('pending', 'confirmed', 'in_progress', 'completed', 'cancelled', 'no_show') DEFAULT 'pending',
  tech_assigned INT,
  tech_name VARCHAR(100),
  notes TEXT,
  cost DECIMAL(10, 2),
  cancellation_reason TEXT,
  cancelled_at TIMESTAMP NULL,
  completed_at TIMESTAMP NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (customer_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (service_id) REFERENCES services(id) ON DELETE RESTRICT,
  FOREIGN KEY (tech_id) REFERENCES technicians(id) ON DELETE SET NULL,
  INDEX idx_customer_id (customer_id),
  INDEX idx_tech_id (tech_id),
  INDEX idx_status (status),
  INDEX idx_appointment_date (appointment_date),
  INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===========================
-- Audit Logs Table
-- ===========================
CREATE TABLE audit_logs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  action VARCHAR(100) NOT NULL,
  entity_type VARCHAR(50),
  entity_id INT,
  old_value JSON,
  new_value JSON,
  ip_address VARCHAR(45),
  user_agent TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
  INDEX idx_user_id (user_id),
  INDEX idx_action (action),
  INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===========================
-- Create Views for Common Queries
-- ===========================

-- View for Appointment Details
CREATE OR REPLACE VIEW appointment_details AS
SELECT 
  a.id,
  a.customer_id,
  u.name as customer_name,
  u.email as customer_email,
  u.phone as customer_phone,
  s.name as service_name,
  s.category as service_category,
  a.appointment_date,
  a.appointment_time,
  a.address,
  a.status,
  t.id as tech_id,
  tu.name as tech_name,
  a.cost,
  a.notes,
  a.created_at,
  a.updated_at
FROM appointments a
LEFT JOIN users u ON a.customer_id = u.id
LEFT JOIN services s ON a.service_id = s.id
LEFT JOIN technicians t ON a.tech_id = t.id
LEFT JOIN users tu ON t.user_id = tu.id;

-- View for Technician Performance
CREATE OR REPLACE VIEW technician_performance AS
SELECT 
  t.id,
  u.name,
  u.username,
  t.specialty,
  t.status,
  t.rating,
  COUNT(DISTINCT a.id) as total_appointments,
  COUNT(DISTINCT CASE WHEN a.status = 'completed' THEN a.id END) as completed_jobs,
  AVG(CASE WHEN a.cost IS NOT NULL THEN a.cost ELSE 0 END) as avg_job_cost,
  MAX(a.completed_at) as last_completed_job
FROM technicians t
LEFT JOIN users u ON t.user_id = u.id
LEFT JOIN appointments a ON t.id = a.tech_id
GROUP BY t.id, u.name, u.username, t.specialty, t.status, t.rating;
