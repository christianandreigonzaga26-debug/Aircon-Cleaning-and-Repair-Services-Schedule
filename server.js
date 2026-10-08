// server.js
require('dotenv').config();
const express = require('express');
const { Pool } = require('pg');
const cors = require('cors');
const path = require('path');

const app = express();
app.use(cors());
app.use(express.json());
app.use(express.static('public')); // Place aircon.html inside a 'public' folder as 'index.html'

const pool = new Pool({ connectionString: process.env.DATABASE_URL });

// --- AUTH API ---
app.post('/api/login', async (req, res) => {
  const { username, password } = req.body;
  try {
    const { rows } = await pool.query('SELECT * FROM users WHERE username = $1 AND password_hash = $2', [username, password]);
    if (rows.length > 0) res.json(rows[0]);
    else res.status(401).json({ error: 'Invalid credentials' });
  } catch (err) { res.status(500).json({ error: err.message }); }
});

app.post('/api/register', async (req, res) => {
  const { name, username, password } = req.body;
  try {
    await pool.query('INSERT INTO users (name, username, password_hash, role) VALUES ($1, $2, $3, $4)', [name, username, password, 'customer']);
    res.json({ success: true });
  } catch (err) { res.status(400).json({ error: 'Username taken or invalid data' }); }
});

// --- APPOINTMENTS API ---
app.get('/api/appointments', async (req, res) => {
  const { rows } = await pool.query('SELECT * FROM appointments ORDER BY date DESC');
  res.json(rows);
});

app.post('/api/appointments', async (req, res) => {
  const { id, customerName, customerUsername, service, date, slot, address } = req.body;
  await pool.query(
    'INSERT INTO appointments (id, customer_name, customer_username, service, date, slot, address) VALUES ($1, $2, $3, $4, $5, $6, $7)',
    [id, customerName, customerUsername, service, date, slot, address]
  );
  res.json({ success: true });
});

app.put('/api/appointments/:id', async (req, res) => {
  const { techAssigned, techName, status, cost } = req.body;
  const updates = [];
  const values = [];
  let index = 1;

  if (techAssigned) { updates.push(`tech_assigned = $${index++}`); values.push(techAssigned); }
  if (techName) { updates.push(`tech_name = $${index++}`); values.push(techName); }
  if (status) { updates.push(`status = $${index++}`); values.push(status); }
  if (cost !== undefined) { updates.push(`cost = $${index++}`); values.push(cost); }
  
  values.push(req.params.id);
  await pool.query(`UPDATE appointments SET ${updates.join(', ')} WHERE id = $${index}`, values);
  res.json({ success: true });
});

app.delete('/api/appointments/:id', async (req, res) => {
  await pool.query('DELETE FROM appointments WHERE id = $1', [req.params.id]);
  res.json({ success: true });
});

// --- TECHNICIANS API ---
app.get('/api/techs', async (req, res) => {
  const { rows } = await pool.query(`
    SELECT t.username, t.specialty, t.status, u.name 
    FROM technicians t JOIN users u ON t.username = u.username
  `);
  res.json(rows);
});

const PORT = process.env.PORT || 3000;
app.listen(PORT, () => console.log(`Server running on http://localhost:${PORT}`));
