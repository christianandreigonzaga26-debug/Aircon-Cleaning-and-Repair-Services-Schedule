const express = require('express');
const router = express.Router();

const sendResponse = (res, status, success, message, data = null) => {
  res.status(status).json({ success, message, data });
};

const serviceRecords = [];

const validateServiceRecord = (data) => {
  const errors = {};
  if (!data.appointment_id || isNaN(data.appointment_id)) {
    errors.appointment_id = 'Appointment ID is required and must be a number';
  }
  if (data.final_cost !== undefined && Number(data.final_cost) < 0) {
    errors.final_cost = 'Cost cannot be negative';
  }
  return Object.keys(errors).length > 0 ? errors : null;
};

router.get('/', (req, res) => {
  sendResponse(res, 200, true, 'Fetched all service records', serviceRecords);
});

router.get('/:id', (req, res) => {
  const record = serviceRecords.find((r) => r.id === Number(req.params.id));
  if (!record) {
    return sendResponse(res, 404, false, `Service record ${req.params.id} not found`);
  }
  sendResponse(res, 200, true, `Fetched service record ${req.params.id}`, record);
});

router.post('/', (req, res) => {
  const errors = validateServiceRecord(req.body);
  if (errors) {
    return sendResponse(res, 422, false, 'Validation failed', errors);
  }

  const newRecord = {
    id: serviceRecords.length ? Math.max(...serviceRecords.map((r) => r.id)) + 1 : 1,
    appointment_id: Number(req.body.appointment_id),
    technician_notes: req.body.technician_notes || '',
    final_cost: req.body.final_cost || 0,
    completion_status: req.body.completion_status || 'pending',
    created_at: new Date().toISOString()
  };

  serviceRecords.push(newRecord);
  sendResponse(res, 201, true, 'Service record created', newRecord);
});

router.put('/:id', (req, res) => {
  const record = serviceRecords.find((r) => r.id === Number(req.params.id));
  if (!record) {
    return sendResponse(res, 404, false, `Service record ${req.params.id} not found`);
  }

  if (req.body.final_cost !== undefined && Number(req.body.final_cost) < 0) {
    return sendResponse(res, 422, false, 'Cost cannot be negative');
  }

  if (req.body.technician_notes !== undefined) {
    record.technician_notes = req.body.technician_notes;
  }
  if (req.body.final_cost !== undefined) {
    record.final_cost = Number(req.body.final_cost);
  }
  if (req.body.completion_status !== undefined) {
    record.completion_status = req.body.completion_status;
  }

  sendResponse(res, 200, true, `Updated service record ${req.params.id}`, record);
});

router.delete('/:id', (req, res) => {
  const index = serviceRecords.findIndex((r) => r.id === Number(req.params.id));
  if (index === -1) {
    return sendResponse(res, 404, false, `Service record ${req.params.id} not found`);
  }
  const [deletedRecord] = serviceRecords.splice(index, 1);
  sendResponse(res, 200, true, `Deleted service record ${req.params.id}`, deletedRecord);
});

module.exports = router;
