# 7/29/24

    Goals:
        - Singleton Pattern
        - Fix default time init db
        - update MySQL
        - Look into ways to make the frontend and backend more tightly coupled
        - Work on Calendar
        - Add authentication
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
