const express = require('express');
const router = express.Router();

const sendResponse = (res, status, success, message, data = null) => {
    res.status(status).json({ success, message, data });
};

router.get('/', (req, res) => sendResponse(res, 200, true, "Fetched all services"));
router.get('/:id', (req, res) => sendResponse(res, 200, true, `Fetched service ${req.params.id}`));
router.post('/', (req, res) => sendResponse(res, 201, true, "Service created"));
router.put('/:id', (req, res) => sendResponse(res, 200, true, `Updated service ${req.params.id}`));
router.delete('/:id', (req, res) => sendResponse(res, 200, true, `Deleted service ${req.params.id}`));

module.exports = router;
