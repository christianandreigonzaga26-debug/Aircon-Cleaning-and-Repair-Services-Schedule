# Quick Start Guide

Get the Aircon Scheduling app running in 5 minutes.

## 1. Prerequisites Check

```bash
node --version  # v18+ required
mysql --version # MySQL v5.7+ required
```

## 2. Clone Repository

```bash
git clone https://github.com/christianandreigonzaga26-debug/Aircon-Cleaning-and-Repair-Services-Schedule.git
cd Aircon-Cleaning-and-Repair-Services-Schedule
```

## 3. Install Dependencies

```bash
npm install
```

## 4. Setup MySQL Database

**Option 1 - Quick Setup (Recommended):**

```bash
# Create database
mysql -u root -p -e "CREATE DATABASE aircon_schedule CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Import schema
mysql -u root -p aircon_schedule < database/schema.sql

# Seed sample data
node scripts/seed.js
```

**Option 2 - Manual Setup:**

```bash
# Login to MySQL
mysql -u root -p

# In MySQL shell:
CREATE DATABASE aircon_schedule CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE aircon_schedule;
source database/schema.sql;
exit;
```

## 5. Configure Environment

```bash
# Copy example file
cp .env.example .env

# Edit .env with your MySQL password
# nano .env (or use your preferred editor)
```

**Minimal .env:**

```env
DB_HOST=localhost
DB_PORT=3306
DB_USER=root
DB_PASSWORD=your_password
DB_NAME=aircon_schedule
PORT=3000
```

## 6. Start Server

```bash
npm start
```

✅ Server running at: **http://localhost:3000**

## 7. Test Connection

```bash
curl http://localhost:3000/api/health
```

Should return:

```json
{"status":"OK","message":"Server is running"}
```

## 8. Test Login

```bash
curl -X POST http://localhost:3000/api/login \
  -H "Content-Type: application/json" \
  -d '{"username":"admin","password":"password123"}'
```

## 9. Try the Frontend

Open browser: **http://localhost:3000**

Login with:
- Username: `admin` or `customer1`
- Password: `password123`

## Common Issues

| Issue | Fix |
|-------|-----|
| Connection refused | Ensure MySQL is running: `mysql -u root -p` |
| Access denied | Check .env DB_USER and DB_PASSWORD |
| Database not found | Run: `mysql -u root -p aircon_schedule < database/schema.sql` |
| Port 3000 in use | Change PORT in .env or: `lsof -i :3000` to find process |

## What's Included

- ✅ MySQL database with 5 tables
- ✅ Express.js REST API
- ✅ User authentication
- ✅ Appointment booking system
- ✅ Technician management
- ✅ Service catalog
- ✅ Sample data (optional)

## Next Steps

- Read [SETUP.md](SETUP.md) for detailed configuration
- Review API endpoints in [server.js](server.js)
- Check database schema in [database/schema.sql](database/schema.sql)
- View sample data in [database/seeders.sql](database/seeders.sql)
