const express = require('express');
const router = express.Router();

const sendResponse = (res, status, success, message, data = null) => {
  res.status(status).json({ success, message, data });
};

// In-memory data storage (replace with database in production)
const appointments = [
  {
    id: 1,
    customer_id: 1,
    service_id: 1,
    technician_id: 1,
    appointment_date: '2026-10-12',
    appointment_time: '09:00',
    status: 'confirmed',
    notes: 'Monthly maintenance check',
    created_at: new Date().toISOString()
  }
];

const validateAppointment = (data) => {
  const errors = {};
  if (!data.customer_id || isNaN(data.customer_id)) {
    errors.customer_id = 'Customer ID is required and must be a number';
  }
  if (!data.service_id || isNaN(data.service_id)) {
    errors.service_id = 'Service ID is required and must be a number';
  }
  if (!data.appointment_date || !/^\d{4}-\d{2}-\d{2}$/.test(data.appointment_date)) {
    errors.appointment_date = 'Date must be in YYYY-MM-DD format';
  }
  if (!data.appointment_time || !/^\d{2}:\d{2}$/.test(data.appointment_time)) {
    errors.appointment_time = 'Time must be in HH:MM format';
  }
  if (data.status && !['pending', 'confirmed', 'completed', 'cancelled'].includes(data.status)) {
    errors.status = 'Status must be: pending, confirmed, completed, or cancelled';
  }
  return Object.keys(errors).length > 0 ? errors : null;
};

router.get('/', (req, res) => {
  sendResponse(res, 200, true, 'Fetched all appointments', appointments);
});

router.get('/:id', (req, res) => {
  const appointment = appointments.find((a) => a.id === Number(req.params.id));
  if (!appointment) {
    return sendResponse(res, 404, false, `Appointment ${req.params.id} not found`);
  }
  sendResponse(res, 200, true, `Fetched appointment ${req.params.id}`, appointment);
});

router.post('/', (req, res) => {
  const errors = validateAppointment(req.body);
  if (errors) {
    return sendResponse(res, 422, false, 'Validation failed', errors);
  }

  const newAppointment = {
    id: appointments.length ? Math.max(...appointments.map((a) => a.id)) + 1 : 1,
    customer_id: Number(req.body.customer_id),
    service_id: Number(req.body.service_id),
    technician_id: req.body.technician_id ? Number(req.body.technician_id) : null,
    appointment_date: req.body.appointment_date,
    appointment_time: req.body.appointment_time,
    status: req.body.status || 'pending',
    notes: req.body.notes || '',
    created_at: new Date().toISOString()
  };

  appointments.push(newAppointment);
  sendResponse(res, 201, true, 'Appointment created', newAppointment);
});

router.put('/:id', (req, res) => {
  const appointment = appointments.find((a) => a.id === Number(req.params.id));
  if (!appointment) {
    return sendResponse(res, 404, false, `Appointment ${req.params.id} not found`);
  }

  if (req.body.status && !['pending', 'confirmed', 'completed', 'cancelled'].includes(req.body.status)) {
    return sendResponse(res, 422, false, 'Invalid status');
  }

  if (req.body.appointment_date && !/^\d{4}-\d{2}-\d{2}$/.test(req.body.appointment_date)) {
    return sendResponse(res, 422, false, 'Date must be in YYYY-MM-DD format');
  }

  if (req.body.appointment_time && !/^\d{2}:\d{2}$/.test(req.body.appointment_time)) {
    return sendResponse(res, 422, false, 'Time must be in HH:MM format');
  }

  Object.assign(appointment, req.body);
  sendResponse(res, 200, true, `Updated appointment ${req.params.id}`, appointment);
});

router.delete('/:id', (req, res) => {
  const index = appointments.findIndex((a) => a.id === Number(req.params.id));
  if (index === -1) {
    return sendResponse(res, 404, false, `Appointment ${req.params.id} not found`);
  }
  const [deletedAppointment] = appointments.splice(index, 1);
  sendResponse(res, 200, true, `Deleted appointment ${req.params.id}`, deletedAppointment);
});

module.exports = router;
