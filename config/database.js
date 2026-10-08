/**
 * Database Configuration Module
 * Handles MySQL connection pooling and database setup
 */

require('dotenv').config();
const mysql = require('mysql2/promise');

// Create connection pool
const pool = mysql.createPool({
  host: process.env.DB_HOST || 'localhost',
  user: process.env.DB_USER || 'root',
  password: process.env.DB_PASSWORD || '',
  database: process.env.DB_NAME || 'aircon_schedule',
  port: process.env.DB_PORT || 3306,
  waitForConnections: true,
  connectionLimit: parseInt(process.env.DB_POOL_LIMIT) || 10,
  queueLimit: parseInt(process.env.DB_QUEUE_LIMIT) || 0,
  enableKeepAlive: true,
  keepAliveInitialDelayMs: 0,
  multipleStatements: false
});

// Test connection
async function testConnection() {
  try {
    const connection = await pool.getConnection();
    const result = await connection.query('SELECT 1 as connected');
    connection.release();
    
    if (result[0][0].connected === 1) {
      console.log('✅ Database connection successful');
      return true;
    }
  } catch (error) {
    console.error('❌ Database connection failed:', error.message);
    return false;
  }
}

// Query wrapper with error handling
async function query(sql, values = []) {
  try {
    const connection = await pool.getConnection();
    const [results] = await connection.query(sql, values);
    connection.release();
    return results;
  } catch (error) {
    console.error('Database query error:', error.message);
    throw error;
  }
}

// Get single row
async function getRow(sql, values = []) {
  const results = await query(sql, values);
  return results.length > 0 ? results[0] : null;
}

// Get single value
async function getValue(sql, values = []) {
  const row = await getRow(sql, values);
  if (!row) return null;
  
  const firstKey = Object.keys(row)[0];
  return row[firstKey];
}

// Execute transaction
async function transaction(callback) {
  let connection;
  try {
    connection = await pool.getConnection();
    await connection.beginTransaction();
    
    const result = await callback(connection);
    
    await connection.commit();
    return result;
  } catch (error) {
    if (connection) {
      await connection.rollback();
    }
    throw error;
  } finally {
    if (connection) {
      connection.release();
    }
  }
}

// Close pool
async function closePool() {
  try {
    await pool.end();
    console.log('✅ Database pool closed');
  } catch (error) {
    console.error('Error closing database pool:', error.message);
  }
}

module.exports = {
  pool,
  query,
  getRow,
  getValue,
  transaction,
  testConnection,
  closePool
};
