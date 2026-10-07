const express = require('express');
const path = require('node:path');

const app = express();
const PORT = Number(process.env.PORT) || 3000;

app.use(express.json());

app.get('/', (req, res) => {
  res.sendFile(path.join(__dirname, 'aircon.html'));
});

// Import ALL routes
const customerRoutes = require('./routes/customers');
const appointmentRoutes = require('./routes/appointments');
const technicianRoutes = require('./routes/technicians');
const serviceRoutes = require('./routes/services');
const serviceRecordRoutes = require('./routes/serviceRecords');

// Connect ALL routes
app.use('/customers', customerRoutes);
app.use('/appointments', appointmentRoutes);
app.use('/technicians', technicianRoutes);
app.use('/services', serviceRoutes);
app.use('/service-records', serviceRecordRoutes);

module.exports = app;

if (require.main === module) {
  app.listen(PORT, () => console.log(`Server running on port ${PORT}`));
}
