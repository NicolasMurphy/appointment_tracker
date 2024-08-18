CREATE DATABASE IF NOT EXISTS mydatabase;

USE mydatabase;

CREATE TABLE IF NOT EXISTS clients (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        phoneNumber VARCHAR(20) NOT NULL,
        address VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS caregivers (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        phoneNumber VARCHAR(20) NOT NULL,
        address VARCHAR(255) NOT NULL,
        payRate DECIMAL(10, 2) NOT NULL
);

CREATE TABLE IF NOT EXISTS appointments (
        id INT AUTO_INCREMENT PRIMARY KEY,
        clientId INT NOT NULL,
        caregiverId INT NOT NULL,
        address VARCHAR(255) NOT NULL,
        date DATE NOT NULL,
        startTime TIME NOT NULL,
        endTime TIME NOT NULL,
        notes VARCHAR(1000),
        FOREIGN KEY (clientId) REFERENCES clients(id),
        FOREIGN KEY (caregiverId) REFERENCES caregivers(id)
);

INSERT INTO
        clients (name, email, phoneNumber, address)
VALUES
        (
                'John Doe',
                'john.doe@example.com',
                '123-456-7890',
                '123 Client Lane'
        ),
        (
                'Alice Johnson',
                'alice.johnson@example.com',
                '987-654-3210',
                '456 Client Street'
        );

INSERT INTO
        caregivers (name, email, phoneNumber, address, payRate)
VALUES
        (
                'Jane Smith',
                'jane.smith@example.com',
                '321-654-9870',
                '123 Caregiver Avenue',
                25.00
        ),
        (
                'Bob Brown',
                'bob.brown@example.com',
                '654-987-3210',
                '456 Caregiver Road',
                30.00
        );

INSERT INTO
        appointments (
                clientId,
                caregiverId,
                address,
                date,
                startTime,
                endTime,
                notes
        )
VALUES
        (
                1,
                1,
                '123 Address Lane',
                CURDATE(),
                TIME('12:00'),
                TIME('13:00'),
                'Initial meeting'
        );

INSERT INTO
        appointments (
                clientId,
                caregiverId,
                address,
                date,
                startTime,
                endTime,
                notes
        )
VALUES
        (
                2,
                2,
                '456 Street Street',
                CURDATE() + INTERVAL 1 DAY,
                TIME('12:00'),
                TIME('13:00'),
                'Follow-up visit'
        );
