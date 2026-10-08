const express = require('express');
const path = require('node:path');

const app = express();
const PORT = Number(process.env.PORT) || 3000;
const NODE_ENV = process.env.NODE_ENV || 'development';
const APP_DEBUG = process.env.APP_DEBUG === 'true';

// Middleware
app.use(express.json({ limit: '10mb' }));
app.use(express.urlencoded({ limit: '10mb', extended: true }));
app.use(express.static('public'));

// Security headers
app.use((req, res, next) => {
  res.setHeader('X-Content-Type-Options', 'nosniff');
  res.setHeader('X-Frame-Options', 'DENY');
  res.setHeader('X-XSS-Protection', '1; mode=block');
  next();
});

// CORS (allow all for now, restrict in production)
app.use((req, res, next) => {
  res.header('Access-Control-Allow-Origin', '*');
  res.header('Access-Control-Allow-Headers', 'Content-Type');
  res.header('Access-Control-Allow-Methods', 'GET,POST,PUT,DELETE,OPTIONS');
  if (req.method === 'OPTIONS') return res.sendStatus(200);
  next();
});

// Health check endpoint
app.get('/health', (req, res) => {
  res.status(200).json({ status: 'ok', environment: NODE_ENV });
});

// Main page
app.get('/', (req, res) => {
  res.sendFile(path.join(__dirname, 'aircon.html'));
});

// Import ALL routes
const customerRoutes = require('./routes/customers');
const appointmentRoutes = require('./routes/appointments');
const technicianRoutes = require('./routes/technicians');
const serviceRoutes = require('./routes/services');
const serviceRecordRoutes = require('./routes/serviceRecords');
const scheduleRoutes = require('./routes/schedules');

// Connect ALL routes
app.use('/customers', customerRoutes);
app.use('/appointments', appointmentRoutes);
app.use('/technicians', technicianRoutes);
app.use('/services', serviceRoutes);
app.use('/service-records', serviceRecordRoutes);
app.use('/schedules', scheduleRoutes);

// Error handling middleware
app.use((err, req, res, next) => {
  if (APP_DEBUG) console.error(err);
  res.status(err.status || 500).json({
    success: false,
    message: APP_DEBUG ? err.message : 'Internal server error',
    ...(APP_DEBUG && { stack: err.stack })
  });
});

// 404 handler
app.use((req, res) => {
  res.status(404).json({
    success: false,
    message: 'Route not found',
    path: req.path
  });
});

module.exports = app;

if (require.main === module) {
  app.listen(PORT, () => {
    console.log(`[${NODE_ENV}] Server running on port ${PORT}`);
    console.log(`Health check: http://localhost:${PORT}/health`);
  });
}
