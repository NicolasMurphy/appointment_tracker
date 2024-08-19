# 8/19

    Goals:
        - use autoload
        - CRUD for client and caregiver
            - client
                - validate email in class function
        - nav
        - CRUD for services (service name, description, rate)
        - verification
        - Billing report, Payroll report
        - styling - tailwind, table (calendar later)
        - authentication
        -
    Notes:
        -

# 8/18

    Goals:
        - use autoload
        - Create client and caregiver tables to be referenced by id in the appointments table
            - client (name, email, phone number, address)
            - caregiver (name, email, phone number, address, pay rate)
            - CRUD for client and caregiver
        - nav
        - CRUD for services (service name, description, rate)
        - Billing report, Payroll report
        - styling - tailwind, table (calendar later)
        - authentication
        -
    Notes:
        - HTML time picker does not support only showing 15 min increments
        -

# 8/17

    Goals:
        - alter table - perhaps address, date, start time, end time, notes
        - update readme
        -
    Notes:
        -

# 8/16

    Goals:
        - singleton pattern
        - alter table - perhaps address, date, start time, end time, notes
        - update readme
        -
    Notes:
        -

# 8/15

    Goals:
        - singleton pattern
        - finish crud
        - alter table - perhaps address, date, start time, end time, notes
        -
    Notes:
        -

# 8/14

    Goals:
        - block .env from localhost:3000/.env
        - create a dbconnect.php file
            - singleton pattern?
        - crud for php mysql
        - alter table - perhaps address, date, start time, end time, notes
        -
    Notes:
        -

# 8/13

    Goals:
        - env for mysql
        - create a dbconnect.php file
            - singleton pattern?
        - crud for php mysql
        - alter table - perhaps address, date, start time, end time, notes
        -
    Notes:
        -

# 8/12

    Goals:
        - Add back MySQL initialization
        -
    Notes:
        -

# 8/11

    Goals:
        - Move hot reload files to root directory
        -
    Notes:
        - Use PHP for HTML, and use TypeScript for dynamic interactions
        -

# 8/10

    Goals:
        - Move hot reload files to root directory
        - Start recreating the backend
        - Start rebuilding the frontend
        - Bring back MySQL
        -
    Notes:
        -

# 8/8

    Goals:
        - Get typescript hot reloading working with php in single container
        -
    Notes:
        -

# 8/7

    Goals:
        - Get typescript hot reloading working with php in single container
        -
    Notes:
        - Got it working with express
        - Ran into issues with nodemon.json, putting it in package.json seems to work
        -

# 8/6

    Goals:
        - Now that --legacy-watch makes nodemon work, finish incorporating the frontend
        -
    Notes:
        - Docker on Windows with WSL 2 doesn't propagate file system events, --legacy-watch polling as workaround
        -

# 8/5

    Goals:
        - Live reloading for frontend
        -
    Notes:
        - nodemon watch?
        - apache.conf?
        - tsc watch?
        - need index.html
        - separate ports?
        -

# 8/4

    Goals:
        - Live reloading for frontend
        -
    Notes:
        - nodemon watch
        -

# 8/3

    Goals:
        - Add TypeScript
        -
    Notes:
        - Trying to not use api for backend/frontend communication
        -

# 7/31/24

    Goals:
        - Drop React, use vanilla Typescript instead
        - Singleton Pattern
        - docker compose env
        - refactor -> types
        - Work on Calendar
        - Add authentication
        - Do a test deploy with Heroku
        -
    Notes:
        -

# 7/30/24

    Goals:
        - Singleton Pattern
        - Fix default time init db
        - docker compose env
        - update MySQL
        - refactor -> types
        - Look into ways to make the frontend and backend more tightly coupled
        - Work on Calendar
        - Add authentication
        - Do a test deploy with Heroku
        -
    Notes:
        -

# 7/29/24

    Goals:
        - Look into ways to make the frontend and backend more tightly coupled
        - Fix appointment form error
        - Work on Calendar
        -
    Notes:
        -

# 7/28/24

    Goals:
        - Transition from microservices to monolithic architecture
        - Update to latest version of PHP
        -
    Notes:
        -

# 2/28/24

    Goals:
        - Update README
    Notes:
        -

# 1/7/24

    Goals:
        - Dockerize the backend, database, and frontend ✓
        - Create an appointments table on build ✓
        - Update 'FILTER_SANITIZE_STRING', since it is deprecated. Or perhaps get rid of sanitization
        - Get rid of modals?
        - Use the singleton pattern for database connections
        - Test the app on a different computer
        - Update README
        - Update PHP, SQL, and node versions
        - Update SQL TIMESTAMP ([Warning] TIMESTAMP with implicit DEFAULT value is deprecated.)
        -
    Notes:
        - CHOKIDAR_USEPOLLING=true to enable polling for hot reloading to work in Docker
        - /docker-entrypoint-initdb.d for mounting SQL scripts to create the table on build
        -

# 12/23/23

    Goals:
        - Narrow down the goals from below
        -
    Notes:
        -

# 12/22/23

    Goals:
        - Add toast for "appointment successfully created/edited/deleted" ✓
        - Improve security in backend:
            - Review validation and sanitization
            - CSRF
            - XSS
            - HIPAA-compliant
        - Add time to appointment list ✓
        - Add user authentication (Firebase?)
        - Add ranges for time and date
        - Add more fields: address, medications, assistance with bathroom, cooking, washing, etc,
        - Make 2 types of users: nurses and clients
        - Filter nurses by availability and location
        - Add state management tool
        - Testing (PHPUnit? PestPHP? Jest)
        - Third party APIs
            - Google Maps API
            - Google Calendar
            - SMS or email API (Twilio, SendGrid)
            - Healthcare data API (Redox, Health Gorilla)
    Notes:
        - Review The Twelve-Factor App
        - For parse_str you use Form URL Encoded instead of JSON
        - Using POST for updates is acceptable. PUT is idempotent, POST is not
        -

# 12/21/23

    Goals:
        - Make sure Edit is functioning properly (time issue) ✓
        - Make Edit Appointment Form a modal ✓
        - Style both forms ✓
        - Order appointments by date/time ✓
        - Fix these two issues in the console: ✓
            - A form field element should have an id or name attribute ✓
            - No label associated with a form field ✓
    Notes:
        - Look into why PHP changes time to with seconds
        -

# 12/20/23

    Goals:
        - Order appointments by date/time
        - When creating an appointment, update state locally instead of refetching all appointments to prevent 'blinking' ✓
        - Fix type issues in App.tsx and AppointmentList.tsx ✓
        -
    Notes:
        - '=> void' means does not return a value
        - redux and contextAPI sucks, look into Zustand, Jotai
        - Edit is currently broken, seems to be an issue with time using seconds or not
        -
