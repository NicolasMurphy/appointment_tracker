# Appointment Tracker

## Project Overview

Appointment Tracker is a web application developed as a learning project. It demonstrates basic CRUD (Create, Read, Update, Delete) operations using PHP for backend and frontend, MySQL for database, and TypeScript for dynamic updates.

Originally designed as a microservice architecture, the project was refactored into a monolithic structure to provide a more tightly coupled and straightforward setup. Initially, the frontend was built with React and TypeScript, but it was later refactored to use PHP and vanilla TypeScript to gain experience with PHP server-side rendering and using vanilla TypeScript.

The project features a Dockerized setup for easy and consistent development environments, with nodemon configured for hot reloading in TypeScript development. An included SQL script initializes the database with sample data.

The application allows users to schedule, view, edit, and delete appointments, providing a full-stack experience with a focus on learning and implementing best practices in both frontend and backend development.

## Technologies Used

- **Backend**: PHP for server-side logic.
- **Database**: MySQL for data storage.
- **Frontend**: PHP for serving HTML and vanilla TypeScript for dynamic changes.
- **Environment**: Docker for containerized development, with nodemon for hot reloading during TypeScript development.
- **Testing**: PHPUnit for unit testing the PHP codebase.

## Features

- **Appointments**

  - **Create Appointments**: Client name, caregiver name, service code, address, date, start time, end time, notes. (Client ID, Caregiver ID, and Service ID are used as foreign keys.)
  - **View Appointments**
  - **Edit Appointments**
  - **Delete Appointments**

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

## Project Initialization

Ensure Docker Desktop is installed.

1. Fork and clone this project.
2. Open Docker Desktop.
3. From the cloned directory, type:
   > `docker-compose up`
4. View the project at [localhost:3000](http://localhost:3000).
