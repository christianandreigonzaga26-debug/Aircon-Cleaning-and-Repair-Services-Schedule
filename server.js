// server.js
require('dotenv').config();
const express = require('express');
const mysql = require('mysql2/promise');
const cors = require('cors');
const path = require('path');

const app = express();
app.use(cors());
app.use(express.json());
app.use(express.static(path.join(__dirname, 'public')));

// MySQL Connection Pool
const pool = mysql.createPool({
  host: process.env.DB_HOST || 'localhost',
  user: process.env.DB_USER || 'root',
  password: process.env.DB_PASSWORD || '',
  database: process.env.DB_NAME || 'aircon_schedule',
  port: process.env.DB_PORT || 3306,
  waitForConnections: true,
  connectionLimit: 10,
  queueLimit: 0
});

// Test database connection on startup
pool.getConnection()
  .then(connection => {
    console.log('✅ MySQL Database Connected Successfully');
    connection.release();
  })
  .catch(err => {
    console.error('❌ MySQL Connection Error:', err.message);
    console.error('Make sure MySQL is running and .env credentials are correct');
    process.exit(1);
  });

// --- AUTH API ---
app.post('/api/login', async (req, res) => {
  const { username, password } = req.body;
  
  if (!username || !password) {
    return res.status(400).json({ error: 'Username and password are required' });
  }

  try {
    const [rows] = await pool.query(
      'SELECT * FROM users WHERE username = ? AND password_hash = ?',
      [username, password]
    );

    if (rows.length > 0) {
      return res.json(rows[0]);
    }

    return res.status(401).json({ error: 'Invalid credentials' });
  } catch (err) {
    console.error('Login error:', err);
    return res.status(500).json({ error: err.message });
  }
});

app.post('/api/register', async (req, res) => {
  const { name, username, email, password } = req.body;

  if (!name || !username || !email || !password) {
    return res.status(400).json({ error: 'All fields are required' });
  }

  try {
    const [result] = await pool.query(
      'INSERT INTO users (name, username, email, password_hash, role) VALUES (?, ?, ?, ?, ?)',
      [name, username, email, password, 'customer']
    );

    return res.json({ success: true, userId: result.insertId });
  } catch (err) {
    if (err.code === 'ER_DUP_ENTRY') {
      return res.status(400).json({ error: 'Username or email already exists' });
    }
    console.error('Register error:', err);
    return res.status(400).json({ error: 'Registration failed' });
  }
});

// --- APPOINTMENTS API ---
app.get('/api/appointments', async (req, res) => {
  try {
    const [rows] = await pool.query(
      'SELECT * FROM appointments ORDER BY appointment_date DESC'
    );
    res.json(rows);
  } catch (err) {
    console.error('Get appointments error:', err);
    res.status(500).json({ error: err.message });
  }
});

app.post('/api/appointments', async (req, res) => {
  const { customer_id, service_id, appointment_date, appointment_time, customer_name, customer_username, customer_email, customer_phone, service, address } = req.body;

  if (!customer_id || !service_id || !appointment_date || !appointment_time || !address) {
    return res.status(400).json({ error: 'Missing required fields' });
  }

  try {
    const [result] = await pool.query(
      `INSERT INTO appointments 
       (customer_id, service_id, appointment_date, appointment_time, customer_name, customer_username, customer_email, customer_phone, service, address, status) 
       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)`,
      [customer_id, service_id, appointment_date, appointment_time, customer_name, customer_username, customer_email, customer_phone, service, address, 'pending']
    );

    res.json({ success: true, appointmentId: result.insertId });
  } catch (err) {
    console.error('Create appointment error:', err);
    res.status(500).json({ error: err.message });
  }
});

app.put('/api/appointments/:id', async (req, res) => {
  const appointmentId = req.params.id;
  const { tech_id, tech_assigned, tech_name, status, cost } = req.body;

  if (!appointmentId) {
    return res.status(400).json({ error: 'Appointment ID is required' });
  }

  try {
    const updates = [];
    const values = [];

    if (tech_id !== undefined) {
      updates.push('tech_id = ?');
      values.push(tech_id);
    }
    if (tech_assigned !== undefined) {
      updates.push('tech_assigned = ?');
      values.push(tech_assigned);
    }
    if (tech_name !== undefined) {
      updates.push('tech_name = ?');
      values.push(tech_name);
    }
    if (status !== undefined) {
      updates.push('status = ?');
      values.push(status);
    }
    if (cost !== undefined) {
      updates.push('cost = ?');
      values.push(cost);
    }

    if (updates.length === 0) {
      return res.status(400).json({ error: 'No fields to update' });
    }

    values.push(appointmentId);

    const query = `UPDATE appointments SET ${updates.join(', ')} WHERE id = ?`;
    await pool.query(query, values);

    res.json({ success: true });
  } catch (err) {
    console.error('Update appointment error:', err);
    res.status(500).json({ error: err.message });
  }
});

app.delete('/api/appointments/:id', async (req, res) => {
  const appointmentId = req.params.id;

  if (!appointmentId) {
    return res.status(400).json({ error: 'Appointment ID is required' });
  }

  try {
    await pool.query('DELETE FROM appointments WHERE id = ?', [appointmentId]);
    res.json({ success: true });
  } catch (err) {
    console.error('Delete appointment error:', err);
    res.status(500).json({ error: err.message });
  }
});

// --- TECHNICIANS API ---
app.get('/api/techs', async (req, res) => {
  try {
    const [rows] = await pool.query(`
      SELECT t.id, t.user_id, t.specialty, t.status, t.rating, u.name, u.username, u.email, u.phone
      FROM technicians t 
      JOIN users u ON t.user_id = u.id
      WHERE t.status = 'available'
      ORDER BY t.rating DESC
    `);
    res.json(rows);
  } catch (err) {
    console.error('Get technicians error:', err);
    res.status(500).json({ error: err.message });
  }
});

app.get('/api/techs/:id', async (req, res) => {
  const techId = req.params.id;

  try {
    const [rows] = await pool.query(`
      SELECT t.id, t.user_id, t.specialty, t.status, t.rating, u.name, u.username, u.email, u.phone
      FROM technicians t 
      JOIN users u ON t.user_id = u.id
      WHERE t.id = ?
    `, [techId]);

    if (rows.length === 0) {
      return res.status(404).json({ error: 'Technician not found' });
    }

    res.json(rows[0]);
  } catch (err) {
    console.error('Get technician error:', err);
    res.status(500).json({ error: err.message });
  }
});

// --- SERVICES API ---
app.get('/api/services', async (req, res) => {
  try {
    const [rows] = await pool.query(
      'SELECT * FROM services WHERE is_active = TRUE ORDER BY category, name'
    );
    res.json(rows);
  } catch (err) {
    console.error('Get services error:', err);
    res.status(500).json({ error: err.message });
  }
});

// --- USERS API ---
app.get('/api/users/:id', async (req, res) => {
  const userId = req.params.id;

  try {
    const [rows] = await pool.query(
      'SELECT id, username, email, name, phone, address, role, status FROM users WHERE id = ?',
      [userId]
    );

    if (rows.length === 0) {
      return res.status(404).json({ error: 'User not found' });
    }

    res.json(rows[0]);
  } catch (err) {
    console.error('Get user error:', err);
    res.status(500).json({ error: err.message });
  }
});

// Health check endpoint
app.get('/api/health', (req, res) => {
  res.json({ status: 'OK', message: 'Server is running', timestamp: new Date().toISOString() });
});

// Serve aircon.html as fallback
app.get('/', (req, res) => {
  res.sendFile(path.join(__dirname, 'public', 'index.html'), (err) => {
    if (err) {
      res.sendFile(path.join(__dirname, 'aircon.html'));
    }
  });
});

// Error handling middleware
app.use((err, req, res, next) => {
  console.error('Error:', err);
  res.status(500).json({ error: 'Internal server error', message: err.message });
});

const PORT = process.env.PORT || 3000;
const server = app.listen(PORT, () => {
  console.log('\n╔════════════════════════════════════════╗');
  console.log('║  Aircon Scheduling System Server       ║');
  console.log('╚════════════════════════════════════════╝\n');
  console.log(`🚀 Server running on http://localhost:${PORT}`);
  console.log(`📊 Database: ${process.env.DB_NAME || 'aircon_schedule'}`);
  console.log(`🌐 Environment: ${process.env.NODE_ENV || 'development'}\n`);
});

// Graceful shutdown
process.on('SIGTERM', () => {
  console.log('SIGTERM signal received: closing HTTP server');
  server.close(() => {
    console.log('HTTP server closed');
    pool.end();
    process.exit(0);
  });
});
