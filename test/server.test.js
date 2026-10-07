const test = require('node:test');
const assert = require('node:assert/strict');
const http = require('node:http');

const app = require('../server');

function get(url) {
  return new Promise((resolve, reject) => {
    const server = app.listen(0, () => {
      const { port } = server.address();
      http.get({ host: '127.0.0.1', port, path: url }, (res) => {
        let body = '';
        res.on('data', (chunk) => {
          body += chunk;
        });
        res.on('end', () => {
          server.close();
          resolve({ statusCode: res.statusCode, body });
        });
      }).on('error', (err) => {
        server.close();
        reject(err);
      });
    });
  });
}

test('root route serves the booking app page', async () => {
  const response = await get('/');
  assert.equal(response.statusCode, 200);
  assert.match(response.body, /Aircon Services App/i);
});

test('appointments endpoint responds successfully', async () => {
  const response = await get('/appointments');
  assert.equal(response.statusCode, 200);
  assert.match(response.body, /Fetched all appointments/i);
});
