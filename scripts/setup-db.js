#!/usr/bin/env node

/**
 * Database Setup Script
 * This script creates the MySQL database and runs migrations
 * 
 * Usage:
 *   node scripts/setup-db.js
 */

require('dotenv').config();
const mysql = require('mysql2/promise');
const fs = require('fs');
const path = require('path');

const config = {
  host: process.env.DB_HOST || 'localhost',
  user: process.env.DB_USER || 'root',
  password: process.env.DB_PASSWORD || '',
  port: process.env.DB_PORT || 3306,
  waitForConnections: true,
  connectionLimit: 10,
  queueLimit: 0
};

const dbName = process.env.DB_NAME || 'aircon_schedule';

async function setupDatabase() {
  let connection;
  
  try {
    console.log('🔄 Connecting to MySQL server...');
    connection = await mysql.createConnection(config);
    console.log('✅ Connected successfully\n');

    // Create database if it doesn't exist
    console.log(`🗂️  Creating database: ${dbName}`);
    await connection.query(`CREATE DATABASE IF NOT EXISTS ${dbName} CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci`);
    console.log(`✅ Database created/verified\n`);

    // Select the database
    await connection.query(`USE ${dbName}`);

    // Read and execute schema file
    console.log('📝 Running schema migrations...');
    const schemaPath = path.join(__dirname, '../database/schema.sql');
    
    if (!fs.existsSync(schemaPath)) {
      throw new Error(`Schema file not found at ${schemaPath}`);
    }

    const schemaSql = fs.readFileSync(schemaPath, 'utf-8');
    
    // Split by semicolons and execute each statement
    const statements = schemaSql
      .split(';')
      .map(statement => statement.trim())
      .filter(statement => statement.length > 0 && !statement.startsWith('--'));

    for (const statement of statements) {
      try {
        await connection.query(statement);
      } catch (err) {
        // Log but continue on some common warnings
        if (err.code !== 'ER_BAD_DB_ERROR' && !err.message.includes('already exists')) {
          console.warn(`⚠️  ${err.message}`);
        }
      }
    }
    console.log('✅ Schema migrations completed\n');

    // Read and execute seeders file (optional)
    const seederPath = path.join(__dirname, '../database/seeders.sql');
    
    if (fs.existsSync(seederPath)) {
      console.log('🌱 Seeding sample data...');
      const seederSql = fs.readFileSync(seederPath, 'utf-8');
      
      const seederStatements = seederSql
        .split(';')
        .map(statement => statement.trim())
        .filter(statement => statement.length > 0 && !statement.startsWith('--'));

      for (const statement of seederStatements) {
        try {
          await connection.query(statement);
        } catch (err) {
          // Skip duplicate entry warnings
          if (!err.message.includes('duplicate')) {
            console.warn(`⚠️  ${err.message}`);
          }
        }
      }
      console.log('✅ Seeding completed\n');
    }

    // Display final status
    console.log('📊 Database Setup Summary:');
    console.log('==========================');
    console.log(`Database Name: ${dbName}`);
    console.log(`Host: ${config.host}:${config.port}`);
    console.log(`User: ${config.user}`);
    
    // Verify tables
    const [tables] = await connection.query(
      `SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA = ?`,
      [dbName]
    );
    console.log(`Tables Created: ${tables.length}`);
    tables.forEach(t => console.log(`  - ${t.TABLE_NAME}`));
    
    console.log('\n✨ Database setup completed successfully!');
    console.log('\nNext steps:');
    console.log('1. Update .env file with your database credentials');
    console.log('2. Start the server: npm start or npm run dev');

  } catch (error) {
    console.error('❌ Database setup failed:');
    console.error(error.message);
    
    if (error.code === 'ENOENT') {
      console.error('\n⚠️  SQL file not found. Make sure database/ directory exists with schema.sql');
    } else if (error.code === 'ER_ACCESS_DENIED_ERROR') {
      console.error('\n⚠️  Access denied. Check your database credentials in .env file');
    } else if (error.code === 'ER_NO_DB_ERROR') {
      console.error('\n⚠️  Database connection failed. Check if MySQL is running');
    }
    
    process.exit(1);

  } finally {
    if (connection) {
      await connection.end();
    }
  }
}

// Run setup
console.log('╔═══════════════════════════════════════╗');
console.log('║   Aircon Scheduling Database Setup    ║');
console.log('╚═══════════════════════════════════════╝\n');

setupDatabase().catch(error => {
  console.error('Fatal error:', error);
  process.exit(1);
});
