# Aircon Cleaning and Repair Services Schedule - Setup Guide

## Prerequisites

- Node.js (v18.0.0 or higher)
- npm (v9.0.0 or higher)
- MySQL (v5.7 or higher)

## Installation Steps

### 1. Clone and Install Dependencies

```bash
cd Aircon-Cleaning-and-Repair-Services-Schedule
npm install
```

### 2. Create MySQL Database

Start your MySQL server and run:

```bash
mysql -u root -p
```

Then execute:

```sql
CREATE DATABASE aircon_schedule CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Or import the schema directly:

```bash
mysql -u root -p aircon_schedule < database/schema.sql
```

### 3. Configure Environment Variables

Copy `.env.example` to `.env` and update with your MySQL credentials:

```bash
cp .env.example .env
```

Edit `.env`:

```env
DB_HOST=localhost
DB_PORT=3306
DB_USER=root
DB_PASSWORD=your_mysql_password
DB_NAME=aircon_schedule
PORT=3000
NODE_ENV=development
```

### 4. Create Database Tables

Option A - Using SQL file directly:

```bash
mysql -u root -p aircon_schedule < database/schema.sql
```

Option B - Using Node script:

```bash
node scripts/setup-db.js
```

### 5. Populate Sample Data (Optional)

```bash
node scripts/seed.js
```

This will create:
- 1 admin user
- 3 technicians
- 3 customers
- 8 services
- 4 sample appointments

**Test Credentials:**
- Admin: `admin` / `password123`
- Customer: `customer1` / `password123`

### 6. Start the Server

Development mode:

```bash
npm run dev
```

Production mode:

```bash
npm start
```

The server will be running at `http://localhost:3000`

## Database Schema

### Tables

1. **users** - User accounts (admin, technician, customer)
2. **services** - Available aircon services
3. **technicians** - Technician profiles
4. **appointments** - Service appointments/bookings
5. **audit_logs** - Activity logging

### API Endpoints

#### Authentication
- `POST /api/login` - User login
- `POST /api/register` - User registration

#### Appointments
- `GET /api/appointments` - List all appointments
- `POST /api/appointments` - Create appointment
- `PUT /api/appointments/:id` - Update appointment
- `DELETE /api/appointments/:id` - Cancel appointment

#### Technicians
- `GET /api/techs` - List available technicians
- `GET /api/techs/:id` - Get technician details

#### Services
- `GET /api/services` - List all services

#### Users
- `GET /api/users/:id` - Get user profile

#### Health
- `GET /api/health` - Server health check

## Common Issues

### Database Connection Error

**Error:** `connect ECONNREFUSED 127.0.0.1:3306`

**Solution:**
1. Ensure MySQL is running
2. Check `.env` credentials are correct
3. Verify MySQL is listening on port 3306

```bash
# macOS with Homebrew
brew services start mysql

# Linux with systemd
sudo systemctl start mysql

# Windows with MySQL service
net start MySQL80
```

### Access Denied Error

**Error:** `ER_ACCESS_DENIED_ERROR`

**Solution:**
1. Check DB_USER and DB_PASSWORD in `.env`
2. Verify MySQL user has database access
3. Reset MySQL root password if needed

```bash
mysql -u root
ALTER USER 'root'@'localhost' IDENTIFIED BY 'new_password';
FLUSH PRIVILEGES;
```

### Database Not Found Error

**Error:** `ER_BAD_DB_ERROR`

**Solution:**
1. Create the database manually:

```bash
mysql -u root -p -e "CREATE DATABASE aircon_schedule CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

2. Or use the setup script:

```bash
node scripts/setup-db.js
```

## Testing the Connection

```bash
curl http://localhost:3000/api/health
```

Expected response:

```json
{
  "status": "OK",
  "message": "Server is running",
  "timestamp": "2026-10-08T07:30:00.000Z"
}
```

## Testing Login

```bash
curl -X POST http://localhost:3000/api/login \
  -H "Content-Type: application/json" \
  -d '{"username":"admin","password":"password123"}'
```

## Development Commands

```bash
# Start development server with auto-reload
npm run dev

# Start production server
npm start

# Setup database schema
node scripts/setup-db.js

# Seed sample data
node scripts/seed.js

# Run migrations
node scripts/migrate.js

# Run tests
npm test

# Lint code
npm run lint

# Full setup (install + migrate + seed)
npm run setup
```

## Production Deployment

1. Set `NODE_ENV=production` in `.env`
2. Use a process manager like PM2:

```bash
npm install -g pm2
pm2 start server.js --name aircon-app
pm2 startup
pm2 save
```

3. Configure NGINX reverse proxy
4. Enable HTTPS/SSL
5. Set strong JWT and SESSION secrets
6. Use environment variables for sensitive data

## Support

For issues or questions, check:
- MySQL documentation: https://dev.mysql.com/doc/
- Express.js guide: https://expressjs.com/
- mysql2/promise docs: https://github.com/sidorares/node-mysql2
