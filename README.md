# Aircon-Cleaning-and-Repair-Services-Schedule

Book your professional aircon cleaning and repair services here. Choose a time that works best for you to keep your system efficient, your electricity bills low, and your air perfectly clean.

## PROJECT TITLE
"Aircon-Cleaning-and-Repair-Services-Schedule"

## PROJECT DESCRIPTION
"A scheduling and service management system for aircon cleaning, maintenance, and repair appointments."

## TEAM ROSTER
| Name                      | Role            |
| ------------------------- |---------------- |
| Gonzaga, Christian Andrei | Repo Lead       |
| Lora Nikko Paul B.        | Board Lead      |
| Curan Lawrence            | Scribe          | 
| Piluden Lander Ian        | Builder         |
| Dy Niño Victor Antonio M. | Builder         |

## PROBLEM STATEMENT
Many air conditioning service businesses still manage appointments, customer records, and repair histories using paper forms or messaging apps. This often results in scheduling conflicts, missed appointments, delayed service, and difficulty tracking customer and technician information. The proposed Aircon Cleaning and Repair Services Scheduling System provides a centralized platform where customers can request services, administrators can manage appointments, technicians can monitor their schedules, and service records are securely stored. The system aims to improve operational efficiency, reduce scheduling errors, and enhance customer satisfaction through organized scheduling and record management.

## CRUD Overview
| **Record Type**    | **Create**                                                      | **Read**                                      | **Update**                                            | **Delete**                         |
| ------------------ | --------------------------------------------------------------- | --------------------------------------------- | ----------------------------------------------------- | ---------------------------------- |
| **Customer**       | Register a new customer                                         | View customer information and service history | Edit customer details (name, contact number, address) | Remove customer record             |
| **Appointment**    | Schedule a cleaning or repair appointment                       | View appointment schedule and status          | Reschedule appointment or update status               | Cancel/Delete appointment          |
| **Technician**     | Add a new technician                                            | View technician profile and assigned schedule | Update technician details and availability            | Remove technician record           |
| **Service**        | Add a new service (Cleaning, Repair, Installation, Maintenance) | View available services and pricing           | Edit service details, description, or price           | Delete a service                   |
| **Service Record** | Record a completed cleaning or repair service                   | View customer service history                 | Update service notes, cost, or completion status      | Delete an incorrect service record |

## Getting Started

### Prerequisites
- Node.js 18.0.0 or higher
- npm (Node Package Manager)

### Installation
1. Clone the repository:
   ```bash
   git clone https://github.com/christianandreigonzaga26-debug/Aircon-Cleaning-and-Repair-Services-Schedule.git
   cd Aircon-Cleaning-and-Repair-Services-Schedule
   ```

2. Install dependencies:
   ```bash
   npm install
   ```

3. Set up environment variables:
   ```bash
   cp .env.example .env
   # Edit .env with your configuration
   ```

### Running Locally

**Development Mode:**
```bash
npm run dev
```
Server runs on `http://localhost:3000`

**Production Mode:**
```bash
NODE_ENV=production npm start
```

### Running Tests
```bash
npm test
```

### Database Migrations
```bash
npm run migrate
```

## API Endpoints

### Customers
- `GET /customers` - List all customers
- `GET /customers/:id` - Get customer by ID
- `POST /customers` - Create new customer
- `PUT /customers/:id` - Update customer
- `DELETE /customers/:id` - Delete customer

### Appointments
- `GET /appointments` - List all appointments
- `GET /appointments/:id` - Get appointment by ID
- `POST /appointments` - Create new appointment
- `PUT /appointments/:id` - Update appointment
- `DELETE /appointments/:id` - Delete appointment

### Technicians
- `GET /technicians` - List all technicians
- `GET /technicians/:id` - Get technician by ID
- `POST /technicians` - Create new technician
- `PUT /technicians/:id` - Update technician
- `DELETE /technicians/:id` - Delete technician

### Services
- `GET /services` - List all services
- `GET /services/:id` - Get service by ID
- `POST /services` - Create new service
- `PUT /services/:id` - Update service
- `DELETE /services/:id` - Delete service

### Service Records
- `GET /service-records` - List all service records
- `GET /service-records/:id` - Get service record by ID
- `POST /service-records` - Create new service record
- `PUT /service-records/:id` - Update service record
- `DELETE /service-records/:id` - Delete service record

### Schedules
- `GET /schedules` - List all schedules
- `GET /schedules/:id` - Get schedule by ID
- `POST /schedules` - Create new schedule
- `PUT /schedules/:id` - Update schedule
- `DELETE /schedules/:id` - Delete schedule

## Environment Variables
See `.env.example` for all available configuration options.

Key variables:
- `NODE_ENV` - Environment (development, production)
- `PORT` - Server port (default: 3000)
- `APP_DEBUG` - Enable debug logging (default: false in production)

## Deployment
See `/docs/deployment.md` for detailed deployment instructions.

## Testing
The project uses Node's built-in test runner:
```bash
npm test
```

Tests cover:
- API endpoint validation
- Input validation and error handling
- CRUD operations
- HTTP status codes

## Error Handling
The API returns standardized JSON responses:

**Success Response (2xx):**
```json
{
  "success": true,
  "message": "Operation successful",
  "data": { /* actual data */ }
}
```

**Error Response (4xx/5xx):**
```json
{
  "success": false,
  "message": "Error description",
  "data": { /* validation errors or null */ }
}
```

## Status Codes
- `200` - OK
- `201` - Created
- `400` - Bad Request
- `404` - Not Found
- `422` - Unprocessable Entity (validation error)
- `500` - Internal Server Error

## Security
- Input validation on all POST/PUT endpoints
- Security headers included (X-Content-Type-Options, X-Frame-Options, X-XSS-Protection)
- CORS enabled (configure in production)
- Environment variables for sensitive config
- No hardcoded secrets

## Contributing
1. Create a feature branch (`git checkout -b feature/your-feature`)
2. Commit your changes (`git commit -m 'Add feature'`)
3. Push to the branch (`git push origin feature/your-feature`)
4. Open a Pull Request

## License
MIT License - see LICENSE file for details

## Support
For issues or questions, please open an issue on GitHub.
