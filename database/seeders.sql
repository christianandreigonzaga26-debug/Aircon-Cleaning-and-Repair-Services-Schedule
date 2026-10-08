-- Aircon Services Schedule - Sample Data
-- This file contains sample data for development and testing

-- ===========================
-- Insert Sample Users
-- ===========================

-- Admin User
INSERT INTO users (username, email, name, password_hash, role, phone, status) 
VALUES ('admin', 'admin@aircon.local', 'Administrator', 
        '$2a$10$nOUIs5kJ7naTuTVk3/N66OPST9/PgBkqquzi.Ss7KIUgO2t0jKMUe', 'admin', '1234567890', 'active');

-- Sample Technicians
INSERT INTO users (username, email, name, password_hash, role, phone, status) 
VALUES 
  ('tech_john', 'john@techteam.local', 'John Smith', 
   '$2a$10$nOUIs5kJ7naTuTVk3/N66OPST9/PgBkqquzi.Ss7KIUgO2t0jKMUe', 'technician', '0912345001', 'active'),
  ('tech_maria', 'maria@techteam.local', 'Maria Garcia', 
   '$2a$10$nOUIs5kJ7naTuTVk3/N66OPST9/PgBkqquzi.Ss7KIUgO2t0jKMUe', 'technician', '0912345002', 'active'),
  ('tech_robert', 'robert@techteam.local', 'Robert Chen', 
   '$2a$10$nOUIs5kJ7naTuTVk3/N66OPST9/PgBkqquzi.Ss7KIUgO2t0jKMUe', 'technician', '0912345003', 'active');

-- Sample Customers
INSERT INTO users (username, email, name, password_hash, role, phone, status) 
VALUES 
  ('customer1', 'customer1@email.local', 'Juan Dela Cruz', 
   '$2a$10$nOUIs5kJ7naTuTVk3/N66OPST9/PgBkqquzi.Ss7KIUgO2t0jKMUe', 'customer', '0912345101', 'active'),
  ('customer2', 'customer2@email.local', 'Maria Santos', 
   '$2a$10$nOUIs5kJ7naTuTVk3/N66OPST9/PgBkqquzi.Ss7KIUgO2t0jKMUe', 'customer', '0912345102', 'active'),
  ('customer3', 'customer3@email.local', 'Antonio Reyes', 
   '$2a$10$nOUIs5kJ7naTuTVk3/N66OPST9/PgBkqquzi.Ss7KIUgO2t0jKMUe', 'customer', '0912345103', 'active');

-- ===========================
-- Insert Technician Details
-- ===========================
INSERT INTO technicians (user_id, specialty, license_number, certification_date, status, rating) 
VALUES 
  (2, 'General Repair', 'LIC-001', '2022-01-15', 'available', 4.8),
  (3, 'Cleaning Specialist', 'LIC-002', '2021-06-20', 'available', 4.9),
  (4, 'Maintenance Expert', 'LIC-003', '2022-03-10', 'available', 4.7);

-- ===========================
-- Insert Services
-- ===========================
INSERT INTO services (name, description, category, base_price, estimated_duration, is_active) 
VALUES 
  ('Window Unit Cleaning', 'Deep cleaning of window-mounted air conditioners', 'cleaning', 1500.00, 60, TRUE),
  ('Split Unit Cleaning', 'Professional cleaning of split-type aircon units', 'cleaning', 2000.00, 90, TRUE),
  ('General Repair', 'Troubleshooting and repair of common aircon issues', 'repair', 3000.00, 120, TRUE),
  ('Refrigerant Refill', 'Refrigerant recharge and system check', 'maintenance', 2500.00, 90, TRUE),
  ('Annual Maintenance', 'Complete system inspection and maintenance', 'maintenance', 4000.00, 150, TRUE),
  ('Installation Service', 'Professional installation of new air conditioning units', 'repair', 5000.00, 180, TRUE),
  ('Compressor Check', 'Detailed inspection and testing of compressor', 'inspection', 1500.00, 60, TRUE),
  ('Electrical System Inspection', 'Full electrical system check and safety verification', 'inspection', 2000.00, 75, TRUE);

-- ===========================
-- Insert Sample Appointments
-- ===========================
INSERT INTO appointments (customer_id, service_id, tech_id, appointment_date, appointment_time, 
                         customer_name, customer_username, customer_email, customer_phone, 
                         service, address, status, tech_assigned, tech_name, cost) 
VALUES 
  (5, 1, 1, DATE_ADD(CURDATE(), INTERVAL 1 DAY), '09:00:00', 
   'Juan Dela Cruz', 'customer1', 'customer1@email.local', '0912345101', 
   'Window Unit Cleaning', '123 Main St, Makati City', 'confirmed', 2, 'John Smith', 1500.00),
  
  (6, 2, 2, DATE_ADD(CURDATE(), INTERVAL 2 DAY), '14:00:00', 
   'Maria Santos', 'customer2', 'customer2@email.local', '0912345102', 
   'Split Unit Cleaning', '456 Oak Ave, Quezon City', 'pending', NULL, NULL, 2000.00),
  
  (7, 3, 3, DATE_ADD(CURDATE(), INTERVAL 3 DAY), '10:00:00', 
   'Antonio Reyes', 'customer3', 'customer3@email.local', '0912345103', 
   'General Repair', '789 Pine Rd, Pasig City', 'pending', NULL, NULL, 3000.00),
  
  (5, 5, 1, DATE_ADD(CURDATE(), INTERVAL 5 DAY), '08:00:00', 
   'Juan Dela Cruz', 'customer1', 'customer1@email.local', '0912345101', 
   'Annual Maintenance', '123 Main St, Makati City', 'pending', NULL, NULL, 4000.00);

-- ===========================
-- Insert Sample Audit Logs
-- ===========================
INSERT INTO audit_logs (user_id, action, entity_type, entity_id, new_value, ip_address, created_at) 
VALUES 
  (1, 'LOGIN', 'users', 1, JSON_OBJECT('login_time', NOW()), '127.0.0.1', NOW()),
  (5, 'CREATE_APPOINTMENT', 'appointments', 1, 
   JSON_OBJECT('service', 'Window Unit Cleaning', 'date', DATE_ADD(CURDATE(), INTERVAL 1 DAY)), '192.168.1.1', NOW());

-- ===========================
-- Verify Data Insertion
-- ===========================
SELECT 'Users Count' as data_type, COUNT(*) as total FROM users
UNION ALL
SELECT 'Technicians Count', COUNT(*) FROM technicians
UNION ALL
SELECT 'Services Count', COUNT(*) FROM services
UNION ALL
SELECT 'Appointments Count', COUNT(*) FROM appointments;
