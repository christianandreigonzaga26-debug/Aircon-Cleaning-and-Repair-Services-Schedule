const express = require('express');
const app = express();

app.use(express.json());

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

app.listen(3000, () => console.log('Server running on port 3000'));
