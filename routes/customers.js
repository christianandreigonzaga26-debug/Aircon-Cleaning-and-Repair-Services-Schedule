const express = require('express');
const router = express.Router();

const sendResponse = (res, status, success, message, data = null) => {
  res.status(status).json({ success, message, data });
};

// In-memory data storage (replace with database in production)
const customers = [
  {
    id: 1,
    name: 'Jane Doe',
    phone: '09123456789',
    address: '123 Main St, Metro Manila',
    email: 'jane@example.com',
    created_at: new Date().toISOString()
  }
];

// Validation helper
const validateCustomer = (data) => {
  const errors = {};
  if (!data.name || typeof data.name !== 'string' || data.name.trim().length === 0) {
    errors.name = 'Name is required and must be a non-empty string';
  }
  if (!data.phone || !/^\d{10,11}$/.test(data.phone.replace(/\D/g, ''))) {
    errors.phone = 'Phone must be a valid format (10-11 digits)';
  }
  if (data.address && typeof data.address !== 'string') {
    errors.address = 'Address must be a string';
  }
  if (data.email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(data.email)) {
    errors.email = 'Email must be valid';
  }
  return Object.keys(errors).length > 0 ? errors : null;
};

// GET all customers
router.get('/', (req, res) => {
  sendResponse(res, 200, true, 'Fetched all customers', customers);
});

// GET one customer by ID
router.get('/:id', (req, res) => {
  const customer = customers.find((c) => c.id === Number(req.params.id));
  if (!customer) {
    return sendResponse(res, 404, false, `Customer ${req.params.id} not found`);
  }
  sendResponse(res, 200, true, `Fetched customer ${req.params.id}`, customer);
});

// POST create customer
router.post('/', (req, res) => {
  const errors = validateCustomer(req.body);
  if (errors) {
    return sendResponse(res, 422, false, 'Validation failed', errors);
  }

  const newCustomer = {
    id: customers.length ? Math.max(...customers.map((c) => c.id)) + 1 : 1,
    name: req.body.name.trim(),
    phone: req.body.phone.replace(/\D/g, ''),
    address: req.body.address || '',
    email: req.body.email || '',
    created_at: new Date().toISOString()
  };

  customers.push(newCustomer);
  sendResponse(res, 201, true, 'Customer created', newCustomer);
});

// PUT update customer
router.put('/:id', (req, res) => {
  const customer = customers.find((c) => c.id === Number(req.params.id));
  if (!customer) {
    return sendResponse(res, 404, false, `Customer ${req.params.id} not found`);
  }

  // Validate only fields that are being updated
  if (req.body.name !== undefined) {
    if (typeof req.body.name !== 'string' || req.body.name.trim().length === 0) {
      return sendResponse(res, 422, false, 'Name must be a non-empty string');
    }
    customer.name = req.body.name.trim();
  }

  if (req.body.phone !== undefined) {
    if (!/^\d{10,11}$/.test(req.body.phone.replace(/\D/g, ''))) {
      return sendResponse(res, 422, false, 'Phone must be a valid format');
    }
    customer.phone = req.body.phone.replace(/\D/g, '');
  }

  if (req.body.address !== undefined) {
    if (typeof req.body.address !== 'string') {
      return sendResponse(res, 422, false, 'Address must be a string');
    }
    customer.address = req.body.address;
  }

  if (req.body.email !== undefined) {
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(req.body.email)) {
      return sendResponse(res, 422, false, 'Email must be valid');
    }
    customer.email = req.body.email;
  }

  sendResponse(res, 200, true, `Updated customer ${req.params.id}`, customer);
});

// DELETE customer
router.delete('/:id', (req, res) => {
  const index = customers.findIndex((c) => c.id === Number(req.params.id));
  if (index === -1) {
    return sendResponse(res, 404, false, `Customer ${req.params.id} not found`);
  }
  const [deletedCustomer] = customers.splice(index, 1);
  sendResponse(res, 200, true, `Deleted customer ${req.params.id}`, deletedCustomer);
});

module.exports = router;
