# Visit Tracker

## Project Overview

Visit Tracker is a web application developed as a learning project. It utilizes PHP for both the backend and frontend, MySQL for the database, and TypeScript for dynamic updates.

Originally designed as a basic CRUD application, the application has evolved to include features like visit verification and exclusion of deletion to maintain data integrity.

The project was initially structured as a microservice architecture but was later refactored into a monolithic setup to provide a more tightly coupled and straightforward environment. The frontend, originally built with React and TypeScript, was refactored to use PHP and vanilla TypeScript, offering experience with PHP server-side rendering and vanilla TypeScript.

The project features a Dockerized setup for easy and consistent development environments, with nodemon configured for hot reloading in TypeScript development. An included SQL script initializes the database with sample data.

## Technologies Used

- **Backend**: PHP for server-side logic.
- **Database**: MySQL for data storage.
- **Frontend**: PHP for serving HTML and vanilla TypeScript for dynamic changes.
- **Environment**: Docker for containerized development, with nodemon for hot reloading during TypeScript development.
- **Testing**: PHPUnit for unit and integration testing of the PHP codebase.

## Features

- **Visits**

  - **Create Visits**: Client name, caregiver name, service code, address, date, start time, end time, notes. (Client ID, Caregiver ID, and Service ID are used as foreign keys.)
  - **View Visits**
  - **Edit Visits**
  - **Delete Visits**
  - **Verify Visits**: Mark visits as verified, enabling them to be included in reports for billing and payroll.

- **Clients**

  - **Create Clients**: Client first name, client last name, email, phone number, address.
  - **View Clients**
  - **Edit Clients**

- **Caregivers**

  - **Create Caregivers**: Caregiver first name, caregiver last name, email, phone number, address, pay rate.
  - **View Caregivers**
  - **Edit Caregivers**

- **Services**

  - **Create Services**: Service code, description, bill rate.
  - **View Services**
  - **Edit Services**

- **Reports**

  - **Billing Report**:

    - **Choose Date Range**: Select a date range to view reports for verified visits.
    - **View Hours and Revenue per Client**: Access detailed reports showing the total hours and revenue for each client.
    - **View Total Hours and Revenue for All Clients**: Summarize the overall hours and revenue across all clients within the selected date range.

  - **Payroll Report**:
    - **Choose Date Range**: Select a date range to generate payroll reports based on verified visits.
    - **View Hours and Revenue per Caregiver**: Access detailed reports showing the total hours and revenue for each caregiver.
    - **View Total Hours and Revenue for All Caregivers**: Summarize the overall hours and payroll wages across all caregivers within the selected date range.

## Future Enhancements

- **Authentication**
- **Role-Based Access Control (RBAC)**
- **Auditing**
- **Data Import/Export Capabilities**
- **Styling**

## Project Initialization

Ensure Docker Desktop is installed.

1. Fork and clone this project.
2. Open Docker Desktop.
3. From the cloned directory, type:
   > `docker-compose up`
4. View the project at [localhost:3000](http://localhost:3000).
