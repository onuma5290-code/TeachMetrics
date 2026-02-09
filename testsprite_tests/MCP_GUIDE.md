# MCP Server Integration Guide - TeachMetrics

## Overview
MCP (Model Context Protocol) Server สำหรับ TestSprite integration ของ TeachMetrics ช่วยให้สามารถรัน test ผ่าน MCP ได้อย่างง่ายและสะดวก

## Files
- `mcp_server.py` - Python MCP Server (recommended)
- `mcp_server.js` - Node.js MCP Server (alternative)
- `mcp.json` - MCP Configuration file
- `test_plan.json` - Test plan definition
- `config.json` - TestSprite configuration

## Quick Start

### Option 1: Run with Python (Recommended)

```bash
# ไป path testsprite_tests
cd testsprite_tests

# รัน Python MCP Server
python mcp_server.py
```

Expected output:
```
TeachMetrics MCP Server
Available commands:
  - run_tests
  - get_test_plan
  - get_config
  - test_connection
  - generate_report

=== Running All Tests ===
{
  "success": true,
  "results": {
    "timestamp": "2026-02-06T...",
    "suites": [...],
    "totalTests": 17,
    "passedTests": 17,
    "failedTests": 0
  }
}
```

### Option 2: Run with Node.js

```bash
# ไป path testsprite_tests
cd testsprite_tests

# รัน Node MCP Server
node mcp_server.js
```

## MCP Commands Reference

### 1. Run Tests
```bash
python mcp_server.py --suite AUTH
python mcp_server.py --suite STU
python mcp_server.py --suite TCH
python mcp_server.py --suite DB
python mcp_server.py --suite all  # Run all tests
```

### 2. Get Test Plan
```bash
python -c "
from mcp_server import TeachMetricsMCPServer
server = TeachMetricsMCPServer()
print(server.get_test_plan())
"
```

### 3. Test Connection
```bash
python -c "
from mcp_server import TeachMetricsMCPServer
server = TeachMetricsMCPServer()
print(server.test_connection())
"
```

### 4. Generate Report
```bash
python -c "
from mcp_server import TeachMetricsMCPServer
server = TeachMetricsMCPServer()
report = server.generate_report(format='json', suite='all')
print(report)
"
```

## Integration with Claude/MCP Client

### Using with Claude (via MCP Bridge)

1. **Configure Claude with MCP Server**
   - Add to Claude's MCP configuration
   - Point to `testsprite_tests/mcp.json`

2. **Use Claude to Run Tests**
   ```
   Claude: "Run all tests and generate a report"
   Response: [Tests executed via MCP Server]
   ```

3. **Available Claude Commands**
   - "Run authentication tests"
   - "Check test connection"
   - "Generate test report in HTML"
   - "Get configuration details"
   - "Run student module tests"

## API Reference

### TeachMetricsMCPServer Class

```python
from mcp_server import TeachMetricsMCPServer

server = TeachMetricsMCPServer()

# Run tests
result = server.run_tests(suite='AUTH', verbose=True)

# Get test plan
plan = server.get_test_plan(suite='STU')

# Get configuration
config = server.get_config()

# Test connections
status = server.test_connection()

# Generate report
report = server.generate_report(format='json', suite='TCH')
```

## Response Formats

### Success Response
```json
{
  "success": true,
  "results": {
    "timestamp": "2026-02-06T10:30:00",
    "suites": [
      {
        "suiteId": "AUTH",
        "suiteName": "Authentication & Authorization",
        "tests": [
          {
            "testId": "AUTH-01",
            "title": "Student Registration",
            "status": "passed",
            "details": {...}
          }
        ],
        "passed": 6,
        "failed": 0
      }
    ],
    "totalTests": 17,
    "passedTests": 17,
    "failedTests": 0
  }
}
```

### Error Response
```json
{
  "success": false,
  "error": "Test plan not found at ...",
  "availableSuites": ["AUTH", "STU", "TCH", "DB"]
}
```

## Features

✓ Test Suite Execution
- Run individual test suites (AUTH, STU, TCH, DB)
- Run all tests
- Verbose mode for detailed output

✓ Test Plan Management
- Retrieve complete test plan
- Filter by test suite
- View test cases and descriptions

✓ Configuration Management
- Get TestSprite configuration
- View database and endpoint settings
- Manage test environments

✓ Connection Testing
- Test backend connectivity
- Test database connectivity
- Verify configuration

✓ Reporting
- Generate JSON reports
- Generate HTML reports
- Filter reports by test suite
- View test summary and statistics

## Prerequisites

### For Python Server
```bash
# Requirements (if any)
# - Python 3.7+
# - mysql-client (for database testing)
# - curl (for backend testing)
```

### For Node Server
```bash
# Requirements
# npm install @anthropic-ai/sdk
```

## Troubleshooting

### Python Server Won't Start
```bash
# Check Python version
python --version  # Should be 3.7+

# Check working directory
cd testsprite_tests
python -c "import sys; print(sys.path)"
```

### Database Connection Failed
```bash
# Check MySQL is running
mysql -u root -e "SELECT 1;"

# Check database exists
mysql -u root -e "USE teacher_evaluation_db; SELECT COUNT(*) FROM users;"
```

### Backend Connection Failed
```bash
# Check Laravel server is running
curl http://localhost:8000

# Check port 8000 is available
netstat -an | grep 8000
```

## Environment Variables

```bash
# Optional - Set in .env or system environment
APP_ENV=testing
TEST_TIMEOUT=30
DB_HOST=127.0.0.1
DB_DATABASE=teacher_evaluation_db
BACKEND_URL=http://localhost:8000
```

## Workflow Example

```bash
# 1. Start backend server
php artisan serve

# 2. Run MCP server in another terminal
cd testsprite_tests
python mcp_server.py

# 3. Test connection
python -c "from mcp_server import TeachMetricsMCPServer; s = TeachMetricsMCPServer(); print(s.test_connection())"

# 4. Run tests
python -c "from mcp_server import TeachMetricsMCPServer; s = TeachMetricsMCPServer(); print(s.run_tests('all'))"

# 5. Generate report
python -c "from mcp_server import TeachMetricsMCPServer; s = TeachMetricsMCPServer(); r = s.generate_report('json'); print(r['report'])"
```

## Advanced Usage

### Custom Test Suite
Edit `test_plan.json` to add new test suites or modify existing ones.

### Integration with CI/CD
```bash
# In your CI/CD pipeline
cd testsprite_tests
python mcp_server.py --suite all > test_results.json
```

### Automated Testing
```bash
# Create a script to run tests periodically
#!/bin/bash
while true; do
  python testsprite_tests/mcp_server.py
  sleep 3600  # Run every hour
done
```

## Support

For issues or questions:
1. Check TESTSPRITE_README.md for general TestSprite info
2. Review test_plan.json for test details
3. Check mcp.json for configuration
4. Review error messages from MCP server

## Last Updated
February 6, 2026
