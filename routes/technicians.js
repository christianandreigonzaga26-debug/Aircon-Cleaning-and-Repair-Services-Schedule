const express = require('express');
const router = express.Router();

const sendResponse = (res, status, success, message, data = null) => {
  res.status(status).json({ success, message, data });
};

const technicians = [
  {
    id: 1,
    name: 'Juan De Los Santos',
    specialty: 'General Maintenance',
    status: 'Available',
    phone: '09234567890',
    created_at: new Date().toISOString()
  }
];

const validateTechnician = (data) => {
  const errors = {};
  if (!data.name || typeof data.name !== 'string' || data.name.trim().length === 0) {
    errors.name = 'Technician name is required';
  }
  if (!data.specialty || typeof data.specialty !== 'string') {
    errors.specialty = 'Specialty is required';
  }
  if (data.status && !['Available', 'Off-Duty'].includes(data.status)) {
    errors.status = 'Status must be: Available or Off-Duty';
  }
  return Object.keys(errors).length > 0 ? errors : null;
};

router.get('/', (req, res) => {
  sendResponse(res, 200, true, 'Fetched all technicians', technicians);
});

router.get('/:id', (req, res) => {
  const technician = technicians.find((t) => t.id === Number(req.params.id));
  if (!technician) {
    return sendResponse(res, 404, false, `Technician ${req.params.id} not found`);
  }
  sendResponse(res, 200, true, `Fetched technician ${req.params.id}`, technician);
});

router.post('/', (req, res) => {
  const errors = validateTechnician(req.body);
  if (errors) {
    return sendResponse(res, 422, false, 'Validation failed', errors);
  }

  const newTechnician = {
    id: technicians.length ? Math.max(...technicians.map((t) => t.id)) + 1 : 1,
    name: req.body.name.trim(),
    specialty: req.body.specialty.trim(),
    status: req.body.status || 'Available',
    phone: req.body.phone || '',
    created_at: new Date().toISOString()
  };

  technicians.push(newTechnician);
  sendResponse(res, 201, true, 'Technician created', newTechnician);
});

router.put('/:id', (req, res) => {
  const technician = technicians.find((t) => t.id === Number(req.params.id));
  if (!technician) {
    return sendResponse(res, 404, false, `Technician ${req.params.id} not found`);
  }

  if (req.body.status && !['Available', 'Off-Duty'].includes(req.body.status)) {
    return sendResponse(res, 422, false, 'Status must be: Available or Off-Duty');
  }

  if (req.body.name !== undefined) {
    technician.name = req.body.name.trim();
  }
  if (req.body.specialty !== undefined) {
    technician.specialty = req.body.specialty.trim();
  }
  if (req.body.status !== undefined) {
    technician.status = req.body.status;
  }
  if (req.body.phone !== undefined) {
    technician.phone = req.body.phone;
  }

  sendResponse(res, 200, true, `Updated technician ${req.params.id}`, technician);
});

router.delete('/:id', (req, res) => {
  const index = technicians.findIndex((t) => t.id === Number(req.params.id));
  if (index === -1) {
    return sendResponse(res, 404, false, `Technician ${req.params.id} not found`);
  }
  const [deletedTechnician] = technicians.splice(index, 1);
  sendResponse(res, 200, true, `Deleted technician ${req.params.id}`, deletedTechnician);
});

module.exports = router;
