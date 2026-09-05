const express = require('express');
const router = express.Router();

const sendResponse = (res, status, success, message, data = null) => {
    res.status(status).json({ success, message, data });
};

router.get('/', (req, res) => sendResponse(res, 200, true, "Fetched all customers"));
router.get('/:id', (req, res) => sendResponse(res, 200, true, `Fetched customer ${req.params.id}`));
router.post('/', (req, res) => sendResponse(res, 201, true, "Customer created"));
router.put('/:id', (req, res) => sendResponse(res, 200, true, `Updated customer ${req.params.id}`));
router.delete('/:id', (req, res) => sendResponse(res, 200, true, `Deleted customer ${req.params.id}`));

module.exports = router;
