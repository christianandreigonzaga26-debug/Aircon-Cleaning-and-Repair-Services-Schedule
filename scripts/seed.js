#!/usr/bin/env node

/**
 * Database Seeder Script
 * Populates the database with sample data for testing and development
 */

require('dotenv').config();
const mysql = require('mysql2/promise');
const path = require('path');

const config = {
  host: process.env.DB_HOST || 'localhost',
  user: process.env.DB_USER || 'root',
  password: process.env.DB_PASSWORD || '',
  database: process.env.DB_NAME || 'aircon_schedule',
  port: process.env.DB_PORT || 3306,
  waitForConnections: true,
  connectionLimit: 10,
  queueLimit: 0
};

async function seedDatabase() {
  let connection;
  
  try {
    console.log('🔄 Connecting to database...');
    connection = await mysql.createConnection(config);
    console.log('✅ Connected\n');

    // Check if data already exists
    const [users] = await connection.query('SELECT COUNT(*) as count FROM users');
    if (users[0].count > 0) {
      console.log('ℹ️  Database already contains data. Skipping seed...');
      console.log('\nTo reset and reseed:');
      console.log('  1. Delete the database or tables');
      console.log('  2. Run: npm run setup');
      return;
    }

    console.log('🌱 Seeding database with sample data...\n');

    // Insert Users
    console.log('Adding users...');
    await connection.query(`
      INSERT INTO users (username, email, name, password_hash, role, phone, status) 
      VALUES 
        ('admin', 'admin@aircon.local', 'Administrator', 
         '$2a$10$nOUIs5kJ7naTuTVk3/N66OPST9/PgBkqquzi.Ss7KIUgO2t0jKMUe', 'admin', '1234567890', 'active'),
        ('tech_john', 'john@techteam.local', 'John Smith', 
         '$2a$10$nOUIs5kJ7naTuTVk3/N66OPST9/PgBkqquzi.Ss7KIUgO2t0jKMUe', 'technician', '0912345001', 'active'),
        ('tech_maria', 'maria@techteam.local', 'Maria Garcia', 
         '$2a$10$nOUIs5kJ7naTuTVk3/N66OPST9/PgBkqquzi.Ss7KIUgO2t0jKMUe', 'technician', '0912345002', 'active'),
        ('tech_robert', 'robert@techteam.local', 'Robert Chen', 
         '$2a$10$nOUIs5kJ7naTuTVk3/N66OPST9/PgBkqquzi.Ss7KIUgO2t0jKMUe', 'technician', '0912345003', 'active'),
        ('customer1', 'customer1@email.local', 'Juan Dela Cruz', 
         '$2a$10$nOUIs5kJ7naTuTVk3/N66OPST9/PgBkqquzi.Ss7KIUgO2t0jKMUe', 'customer', '0912345101', 'active'),
        ('customer2', 'customer2@email.local', 'Maria Santos', 
         '$2a$10$nOUIs5kJ7naTuTVk3/N66OPST9/PgBkqquzi.Ss7KIUgO2t0jKMUe', 'customer', '0912345102', 'active'),
        ('customer3', 'customer3@email.local', 'Antonio Reyes', 
         '$2a$10$nOUIs5kJ7naTuTVk3/N66OPST9/PgBkqquzi.Ss7KIUgO2t0jKMUe', 'customer', '0912345103', 'active')
    `);
    console.log('  ✅ 7 users created\n');

    // Insert Technician Details
    console.log('Adding technician profiles...');
    await connection.query(`
      INSERT INTO technicians (user_id, specialty, license_number, certification_date, status, rating) 
      VALUES 
        (2, 'General Repair', 'LIC-001', '2022-01-15', 'available', 4.8),
        (3, 'Cleaning Specialist', 'LIC-002', '2021-06-20', 'available', 4.9),
        (4, 'Maintenance Expert', 'LIC-003', '2022-03-10', 'available', 4.7)
    `);
    console.log('  ✅ 3 technician profiles created\n');

    // Insert Services
    console.log('Adding services...');
    await connection.query(`
      INSERT INTO services (name, description, category, base_price, estimated_duration, is_active) 
      VALUES 
        ('Window Unit Cleaning', 'Deep cleaning of window-mounted air conditioners', 'cleaning', 1500.00, 60, TRUE),
        ('Split Unit Cleaning', 'Professional cleaning of split-type aircon units', 'cleaning', 2000.00, 90, TRUE),
        ('General Repair', 'Troubleshooting and repair of common aircon issues', 'repair', 3000.00, 120, TRUE),
        ('Refrigerant Refill', 'Refrigerant recharge and system check', 'maintenance', 2500.00, 90, TRUE),
        ('Annual Maintenance', 'Complete system inspection and maintenance', 'maintenance', 4000.00, 150, TRUE),
        ('Installation Service', 'Professional installation of new air conditioning units', 'repair', 5000.00, 180, TRUE),
        ('Compressor Check', 'Detailed inspection and testing of compressor', 'inspection', 1500.00, 60, TRUE),
        ('Electrical System Inspection', 'Full electrical system check and safety verification', 'inspection', 2000.00, 75, TRUE)
    `);
    console.log('  ✅ 8 services created\n');

    // Insert Sample Appointments
    console.log('Adding sample appointments...');
    await connection.query(`
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
         'Annual Maintenance', '123 Main St, Makati City', 'pending', NULL, NULL, 4000.00)
    `);
    console.log('  ✅ 4 sample appointments created\n');

    // Verify seeding
    const [stats] = await connection.query(`
      SELECT 
        (SELECT COUNT(*) FROM users) as users_count,
        (SELECT COUNT(*) FROM technicians) as technicians_count,
        (SELECT COUNT(*) FROM services) as services_count,
        (SELECT COUNT(*) FROM appointments) as appointments_count
    `);

    console.log('📊 Seeding Summary:');
    console.log('==================');
    console.log(`Users: ${stats[0].users_count}`);
    console.log(`Technicians: ${stats[0].technicians_count}`);
    console.log(`Services: ${stats[0].services_count}`);
    console.log(`Appointments: ${stats[0].appointments_count}`);
    
    console.log('\n✨ Database seeding completed successfully!\n');
    
    console.log('Test Credentials:');
    console.log('================');
    console.log('Admin:');
    console.log('  Username: admin');
    console.log('  Email: admin@aircon.local');
    console.log('  Password: password123\n');
    
    console.log('Customer:');
    console.log('  Username: customer1');
    console.log('  Email: customer1@email.local');
    console.log('  Password: password123\n');

  } catch (error) {
    console.error('❌ Seeding failed:', error.message);
    process.exit(1);

  } finally {
    if (connection) {
      await connection.end();
    }
  }
}

// Main
console.log('╔═══════════════════════════════╗');
console.log('║   Database Seeder Script      ║');
console.log('╚═══════════════════════════════╝\n');

seedDatabase().catch(error => {
  console.error('Fatal error:', error);
  process.exit(1);
});
