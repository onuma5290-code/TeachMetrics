# TestSprite Integration Guide - TeachMetrics

## Overview
This directory contains the TestSprite test plan and configuration for the TeachMetrics (Teacher Evaluation System) project.

## Project Details
- **Project Name**: TeachMetrics - Teacher Evaluation System
- **Framework**: Laravel 12.49.0
- **Frontend**: Vue.js + Vite
- **Database**: MySQL
- **API Type**: RESTful

## Test Coverage

### Test Suites
1. **Authentication & Authorization (AUTH)** - 6 test cases
   - Student & Teacher registration
   - Login functionality
   - Role-based access control
   - Unauthorized access handling

2. **Student Module (STU)** - 5 test cases
   - Dashboard access
   - Evaluation form viewing
   - Evaluation submission (valid & invalid)
   - Evaluation notes submission

3. **Teacher Module (TCH)** - 3 test cases
   - Teacher dashboard
   - Evaluation scores viewing
   - Subject evaluations

4. **Database Integrity (DB)** - 3 test cases
   - Score range validation
   - Foreign key integrity
   - Password hashing verification

**Total Test Cases: 17**

## Configuration

### Environment Setup
- **Backend Endpoint**: http://localhost:8000
- **Frontend Endpoint**: http://localhost:5173
- **Database**: teacher_evaluation_db (MySQL)
- **Auth Type**: Session-based

### Test Accounts
```
Student Account:
- Email: studenttest
- Password: 123456
- Role: student

Teacher Account:
- Email: teachertest
- Password: 123456
- Role: teacher
```

## Files Structure
```
testsprite_tests/
├── tmp/
│   ├── config.json          # TestSprite configuration
│   └── prd_files/          # Product requirement documents
├── test_plan.json          # Comprehensive test plan
└── TESTSPRITE_README.md    # This file
```

## Test Plan Details

### File: `test_plan.json`
Contains all test cases organized by suite:
- Complete HTTP endpoint definitions
- Request/response examples
- Expected status codes and responses
- Test tags and categorization
- Database integrity checks
- Seed data configuration

### Configuration File: `config.json`
Includes:
- TestSprite integration settings
- Database connection details
- Test framework configuration
- Feature flags
- Retry and timeout settings
- Test account credentials

## Running Tests

### Prerequisites
1. PHP 8.4+ installed and configured
2. MySQL server running with database created
3. Laravel application migrated (`php artisan migrate`)
4. Vite dev server running (optional for UI testing)
5. Laravel backend server running on port 8000

### Steps

1. **Start Backend Server** (if not already running)
   ```bash
   php artisan serve
   ```

2. **Start Frontend Dev Server** (optional)
   ```bash
   npm run dev
   ```

3. **Connect TestSprite**
   - Open TestSprite application
   - Import this test plan: `testsprite_tests/test_plan.json`
   - Configure endpoint: Use settings from `config.json`
   - Run test suites in order: AUTH → STU → TCH → DB

### Expected Results

| Test Suite | Tests | Expected Status |
|-----------|-------|-----------------|
| AUTH | 6 | All Pass ✓ |
| STU | 5 | All Pass ✓ |
| TCH | 3 | All Pass ✓ |
| DB | 3 | All Pass ✓ |
| **Total** | **17** | **All Pass ✓** |

## API Endpoints Reference

### Authentication
```
POST /api/register          - Register new user
POST /api/login            - Login user
POST /api/logout           - Logout user
```

### Student Endpoints
```
GET /api/student/dashboard  - View student dashboard
GET /api/evaluate/{id}      - View evaluation form
POST /api/evaluate          - Submit evaluation
```

### Teacher Endpoints
```
GET /api/teacher/dashboard  - View teacher dashboard
GET /api/teacher/scores     - View evaluation scores
GET /api/teacher/subject/{id}/evaluations - View subject evaluations
```

## Database Schema Validation

### Key Tables
- **evaluations** - Stores evaluation submissions (15 questions, notes)
- **students** - Student accounts
- **teachers** - Teacher accounts
- **subjects** - Courses/Subjects
- **teacher_subjects** - Teacher-Subject associations
- **users** - Base user table

### Data Integrity Checks
- Question scores must be 1-5
- Foreign key relationships valid
- Passwords hashed with bcrypt

## Troubleshooting

### Common Issues

1. **Connection Refused (localhost:8000)**
   - Ensure Laravel server is running: `php artisan serve`
   - Check PHP version: `php -v` (require 8.4+)

2. **Database Connection Error**
   - Verify MySQL is running
   - Check database name in `.env` matches `teacher_evaluation_db`
   - Verify credentials in `config.json`

3. **Authentication Failures**
   - Ensure test accounts exist (run `php artisan migrate:fresh --seed`)
   - Check session configuration in Laravel `.env`

4. **Test Timeout**
   - Increase timeout value in `config.json` `timeoutSeconds`
   - Check server responsiveness

## Integration with CI/CD

To integrate with continuous integration:

1. Use configuration from `config.json` in your CI/CD pipeline
2. Ensure all test environments match configuration
3. Generate reports to `testsprite_tests/reports` directory
4. Archive reports for documentation

## Support

For TestSprite-specific questions, refer to:
- TestSprite Documentation
- Laravel Testing Documentation: https://laravel.com/docs/testing
- API Endpoints in project routes: `routes/web.php`, `routes/backend.php`

## Last Updated
February 6, 2026

## Notes
- Test plan is compatible with TestSprite v2.0+
- All endpoints use relative paths from baseUrl
- Authentication uses Laravel session-based auth
- Database queries can be customized per environment
