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

## Features

- **Create Appointments**: Users can add new appointments with details such as client name, caregiver name, address, date, start time, end time, notes.
- **View Appointments**: All scheduled appointments are displayed on the main page.
- **Edit Appointments**: Users can modify the details of existing appointments.
- **Delete Appointments**: Users can remove appointments that are no longer needed.

## Project Initialization

Ensure Docker Desktop is installed.

1. Fork and clone this project.
2. Open Docker Desktop.
3. From the cloned directory, type:
   > `docker-compose up`
4. View the project at [localhost:3000](http://localhost:3000).
