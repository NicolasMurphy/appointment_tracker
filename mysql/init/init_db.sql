CREATE DATABASE IF NOT EXISTS mydatabase;
USE mydatabase;

CREATE TABLE appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    address TEXT,
    date DATE NOT NULL,
    time TIME NOT NULL
);

-- Insert initial data if needed
INSERT INTO appointments (title, description, address, date, time) VALUES ('Sample Appointment', 'This is a test appointment.', 'Sample Address', CURDATE(), CURTIME());
