CREATE DATABASE IF NOT EXISTS mydatabase;

USE mydatabase;

CREATE TABLE IF NOT EXISTS appointments (
        id INT AUTO_INCREMENT PRIMARY KEY,
        client VARCHAR(255) NOT NULL,
        caregiver VARCHAR(255) NOT NULL,
        address VARCHAR(255) NOT NULL,
        date DATE NOT NULL,
        startTime TIME NOT NULL,
        endTime TIME NOT NULL,
        notes VARCHAR(1000)
);

INSERT INTO
        appointments (client, caregiver, address, date, startTime, endTime, notes)
VALUES
        (
                'John Doe',
                'Jane Smith',
                '123 Address Lane',
                CURDATE(),
                TIME_FORMAT(CURTIME(), '%H:%i'),
                TIME_FORMAT(CURTIME() + INTERVAL 1 HOUR, '%H:%i'),
                'notes...'
        );

INSERT INTO
        appointments (client, caregiver, address, date, startTime, endTime, notes)
VALUES
        (
                'Alice Johnson',
                'Bob Brown',
                '456 Street Street',
                CURDATE() + INTERVAL 1 DAY,
                TIME_FORMAT(CURTIME(), '%H:%i'),
                TIME_FORMAT(CURTIME() + INTERVAL 1 HOUR, '%H:%i'),
                'notes...'
        );
