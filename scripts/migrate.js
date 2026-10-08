// scripts/migrate.js
require('dotenv').config();
const { Pool } = require('pg');

const pool = new Pool({ connectionString: process.env.DATABASE_URL });

async function runMigrations() {
  console.log('Running migrations...');
  try {
    await pool.query(`
      DROP TABLE IF EXISTS appointments, technicians, users CASCADE;

      CREATE TABLE users (
          id SERIAL PRIMARY KEY,
          username VARCHAR(50) UNIQUE NOT NULL,
          password_hash VARCHAR(255) NOT NULL,
          name VARCHAR(100) NOT NULL,
          role VARCHAR(20) NOT NULL CHECK (role IN ('admin', 'tech', 'customer'))
      );

      CREATE TABLE technicians (
          id SERIAL PRIMARY KEY,
          username VARCHAR(50) UNIQUE REFERENCES users(username) ON DELETE CASCADE,
          specialty VARCHAR(100) DEFAULT 'General Service',
          status VARCHAR(20) NOT NULL DEFAULT 'Available'
      );

      CREATE TABLE appointments (
          id VARCHAR(10) PRIMARY KEY,
          customer_name VARCHAR(100),
          customer_username VARCHAR(50),
          service VARCHAR(100) NOT NULL,
          date DATE NOT NULL,
          slot VARCHAR(20) NOT NULL,
          address TEXT NOT NULL,
          tech_assigned VARCHAR(50) DEFAULT 'Unassigned',
          tech_name VARCHAR(100) DEFAULT 'Unassigned',
          status VARCHAR(20) NOT NULL DEFAULT 'Pending',
          cost DECIMAL(10, 2) DEFAULT 0.00
      );

      -- Insert Default Users
      INSERT INTO users (username, password_hash, name, role) VALUES 
      ('admin', 'password', 'System Admin', 'admin'),
      ('tech', 'password', 'Tony Stark', 'tech'),
      ('customer', 'password', 'Jane Doe', 'customer');

      -- Insert Default Techs
      INSERT INTO technicians (username, specialty, status) VALUES 
      ('tech', 'Repair', 'Available');
    `);
    console.log('Database migrated and seeded successfully!');
  } catch (error) {
    console.error('Migration failed:', error);
  } finally {
    pool.end();
  }
}

runMigrations();
