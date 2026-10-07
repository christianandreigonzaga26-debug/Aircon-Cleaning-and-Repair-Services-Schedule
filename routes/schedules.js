const express = require('express');
const router = express.Router();

const schedules = [
  {
    id: 1,
    customer_name: 'Jane Doe',
    phone: '09123456789',
    service_type: 'Deep Cleaning',
    schedule_date: '2026-10-12',
    notes: 'Monthly maintenance check',
    status: 'Scheduled'
  },
  {
    id: 2,
    customer_name: 'John Smith',
    phone: '09987654321',
    service_type: 'General Repair',
    schedule_date: '2026-10-15',
    notes: 'Outdoor unit making noise',
    status: 'In Progress'
  }
];

const sendResponse = (res, status, success, message, data = null) => {
  res.status(status).json({ success, message, data });
};

router.get('/', (req, res) => {
  sendResponse(res, 200, true, 'Fetched all schedules', schedules);
});

router.get('/:id', (req, res) => {
  const schedule = schedules.find((item) => item.id === Number(req.params.id));

  if (!schedule) {
    return sendResponse(res, 404, false, `Schedule ${req.params.id} not found`);
  }

  return sendResponse(res, 200, true, `Fetched schedule ${req.params.id}`, schedule);
});

router.post('/', (req, res) => {
  const payload = req.body || {};
  const nextId = schedules.length ? Math.max(...schedules.map((item) => item.id)) + 1 : 1;
  const newSchedule = {
    id: nextId,
    customer_name: payload.customer_name || payload.customerName || 'Guest',
    phone: payload.phone || '',
    service_type: payload.service_type || payload.service || 'General Service',
    schedule_date: payload.schedule_date || payload.date || new Date().toISOString().slice(0, 10),
    notes: payload.notes || '',
    status: payload.status || 'Scheduled'
  };

  schedules.push(newSchedule);
  return sendResponse(res, 201, true, 'Schedule created', newSchedule);
});

router.put('/:id', (req, res) => {
  const index = schedules.findIndex((item) => item.id === Number(req.params.id));

  if (index === -1) {
    return sendResponse(res, 404, false, `Schedule ${req.params.id} not found`);
  }

  const updatedSchedule = {
    ...schedules[index],
    ...req.body,
    id: Number(req.params.id)
  };

  schedules[index] = updatedSchedule;
  return sendResponse(res, 200, true, `Updated schedule ${req.params.id}`, updatedSchedule);
});

router.delete('/:id', (req, res) => {
  const index = schedules.findIndex((item) => item.id === Number(req.params.id));

  if (index === -1) {
    return sendResponse(res, 404, false, `Schedule ${req.params.id} not found`);
  }

  const [removedSchedule] = schedules.splice(index, 1);
  return sendResponse(res, 200, true, `Deleted schedule ${req.params.id}`, removedSchedule);
});

module.exports = router;
