const express = require('express');
const router = express.Router();

const sendResponse = (res, status, success, message, data = null) => {
  res.status(status).json({ success, message, data });
};

const services = [
  {
    id: 1,
    name: 'Deep Cleaning',
    description: 'Complete aircon unit cleaning and maintenance',
    price: 1500,
    duration_minutes: 60,
    created_at: new Date().toISOString()
  },
  {
    id: 2,
    name: 'General Repair',
    description: 'Repair of faulty aircon units',
    price: 2000,
    duration_minutes: 90,
    created_at: new Date().toISOString()
  }
];

const validateService = (data) => {
  const errors = {};
  if (!data.name || typeof data.name !== 'string' || data.name.trim().length === 0) {
    errors.name = 'Service name is required';
  }
  if (!data.price || Number(data.price) <= 0) {
    errors.price = 'Price must be a positive number';
  }
  if (data.description && typeof data.description !== 'string') {
    errors.description = 'Description must be a string';
  }
  return Object.keys(errors).length > 0 ? errors : null;
};

router.get('/', (req, res) => {
  sendResponse(res, 200, true, 'Fetched all services', services);
});

router.get('/:id', (req, res) => {
  const service = services.find((s) => s.id === Number(req.params.id));
  if (!service) {
    return sendResponse(res, 404, false, `Service ${req.params.id} not found`);
  }
  sendResponse(res, 200, true, `Fetched service ${req.params.id}`, service);
});

router.post('/', (req, res) => {
  const errors = validateService(req.body);
  if (errors) {
    return sendResponse(res, 422, false, 'Validation failed', errors);
  }

  const newService = {
    id: services.length ? Math.max(...services.map((s) => s.id)) + 1 : 1,
    name: req.body.name.trim(),
    description: req.body.description || '',
    price: Number(req.body.price),
    duration_minutes: req.body.duration_minutes || 60,
    created_at: new Date().toISOString()
  };

  services.push(newService);
  sendResponse(res, 201, true, 'Service created', newService);
});

router.put('/:id', (req, res) => {
  const service = services.find((s) => s.id === Number(req.params.id));
  if (!service) {
    return sendResponse(res, 404, false, `Service ${req.params.id} not found`);
  }

  if (req.body.name !== undefined) {
    if (typeof req.body.name !== 'string' || req.body.name.trim().length === 0) {
      return sendResponse(res, 422, false, 'Service name must be a non-empty string');
    }
    service.name = req.body.name.trim();
  }

  if (req.body.price !== undefined) {
    if (Number(req.body.price) <= 0) {
      return sendResponse(res, 422, false, 'Price must be a positive number');
    }
    service.price = Number(req.body.price);
  }

  if (req.body.description !== undefined) {
    service.description = req.body.description;
  }

  if (req.body.duration_minutes !== undefined) {
    service.duration_minutes = Number(req.body.duration_minutes);
  }

  sendResponse(res, 200, true, `Updated service ${req.params.id}`, service);
});

router.delete('/:id', (req, res) => {
  const index = services.findIndex((s) => s.id === Number(req.params.id));
  if (index === -1) {
    return sendResponse(res, 404, false, `Service ${req.params.id} not found`);
  }
  const [deletedService] = services.splice(index, 1);
  sendResponse(res, 200, true, `Deleted service ${req.params.id}`, deletedService);
});

module.exports = router;
