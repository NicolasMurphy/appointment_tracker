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
