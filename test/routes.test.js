const test = require('node:test');
const assert = require('node:assert');
const http = require('node:http');
const app = require('../server');

let server;

test.before(async () => {
  server = app.listen(0);
  console.log(`Test server listening on port ${server.address().port}`);
});

test.after(async () => {
  server.close();
});

const request = (method, path, body = null) => {
  return new Promise((resolve, reject) => {
    const options = {
      hostname: 'localhost',
      port: server.address().port,
      path,
      method,
      headers: {
        'Content-Type': 'application/json'
      }
    };

    const req = http.request(options, (res) => {
      let data = '';
      res.on('data', (chunk) => {
        data += chunk;
      });
      res.on('end', () => {
        resolve({
          status: res.statusCode,
          body: data ? JSON.parse(data) : null
        });
      });
    });

    req.on('error', reject);
    if (body) req.write(JSON.stringify(body));
    req.end();
  });
};

// Health Check
test('GET /health returns 200', async () => {
  const res = await request('GET', '/health');
  assert.strictEqual(res.status, 200);
  assert.strictEqual(res.body.status, 'ok');
});

// Customers
test('GET /customers returns list', async () => {
  const res = await request('GET', '/customers');
  assert.strictEqual(res.status, 200);
  assert.ok(Array.isArray(res.body.data));
});

test('POST /customers creates customer with valid data', async () => {
  const res = await request('POST', '/customers', {
    name: 'John Doe',
    phone: '09876543210',
    address: '456 Oak Ave, Metro Manila',
    email: 'john@example.com'
  });
  assert.strictEqual(res.status, 201);
  assert.strictEqual(res.body.success, true);
  assert.strictEqual(res.body.data.name, 'John Doe');
});

test('POST /customers rejects empty name', async () => {
  const res = await request('POST', '/customers', {
    name: '',
    phone: '09876543210'
  });
  assert.strictEqual(res.status, 422);
  assert.strictEqual(res.body.success, false);
  assert.ok(res.body.data.name);
});

test('POST /customers rejects invalid phone', async () => {
  const res = await request('POST', '/customers', {
    name: 'Jane Doe',
    phone: 'abc'
  });
  assert.strictEqual(res.status, 422);
  assert.strictEqual(res.body.success, false);
});

// Appointments
test('GET /appointments returns list', async () => {
  const res = await request('GET', '/appointments');
  assert.strictEqual(res.status, 200);
  assert.ok(Array.isArray(res.body.data));
});

test('POST /appointments creates appointment with valid data', async () => {
  const res = await request('POST', '/appointments', {
    customer_id: 1,
    service_id: 1,
    appointment_date: '2026-10-20',
    appointment_time: '14:00',
    status: 'pending'
  });
  assert.strictEqual(res.status, 201);
  assert.strictEqual(res.body.success, true);
});

test('POST /appointments rejects invalid date format', async () => {
  const res = await request('POST', '/appointments', {
    customer_id: 1,
    service_id: 1,
    appointment_date: '20-10-2026',
    appointment_time: '14:00'
  });
  assert.strictEqual(res.status, 422);
});

test('POST /appointments rejects invalid status', async () => {
  const res = await request('POST', '/appointments', {
    customer_id: 1,
    service_id: 1,
    appointment_date: '2026-10-20',
    appointment_time: '14:00',
    status: 'invalid'
  });
  assert.strictEqual(res.status, 422);
});

// Services
test('GET /services returns list', async () => {
  const res = await request('GET', '/services');
  assert.strictEqual(res.status, 200);
  assert.ok(Array.isArray(res.body.data));
});

test('POST /services rejects negative price', async () => {
  const res = await request('POST', '/services', {
    name: 'Test Service',
    price: -500
  });
  assert.strictEqual(res.status, 422);
});

// Schedules
test('GET /schedules returns list', async () => {
  const res = await request('GET', '/schedules');
  assert.strictEqual(res.status, 200);
  assert.ok(Array.isArray(res.body.data));
});

test('404 for non-existent routes', async () => {
  const res = await request('GET', '/nonexistent');
  assert.strictEqual(res.status, 404);
});
