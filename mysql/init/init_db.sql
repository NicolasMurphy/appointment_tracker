CREATE DATABASE IF NOT EXISTS mydatabase;

USE mydatabase;

CREATE TABLE IF NOT EXISTS clients (
        id INT AUTO_INCREMENT PRIMARY KEY,
        first_name VARCHAR(255) NOT NULL,
        last_name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        phone_number VARCHAR(20) NOT NULL,
        address VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS caregivers (
        id INT AUTO_INCREMENT PRIMARY KEY,
        first_name VARCHAR(255) NOT NULL,
        last_name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        phone_number VARCHAR(20) NOT NULL,
        address VARCHAR(255) NOT NULL,
        pay_rate DECIMAL(10, 2) NOT NULL
);

CREATE TABLE IF NOT EXISTS services (
        id INT AUTO_INCREMENT PRIMARY KEY,
        code VARCHAR(255) NOT NULL,
        description VARCHAR(255) NOT NULL,
        bill_rate DECIMAL(10, 2) NOT NULL
);

CREATE TABLE IF NOT EXISTS appointments (
        id INT AUTO_INCREMENT PRIMARY KEY,
        client_id INT NOT NULL,
        caregiver_id INT NOT NULL,
        service_id INT NOT NULL,
        date DATE NOT NULL,
        start_time TIME NOT NULL,
        end_time TIME NOT NULL,
        notes VARCHAR(1000),
        verified TINYINT(1) NOT NULL DEFAULT 0,
        FOREIGN KEY (client_id) REFERENCES clients(id),
        FOREIGN KEY (caregiver_id) REFERENCES caregivers(id),
        FOREIGN KEY (service_id) REFERENCES services(id)
);

INSERT INTO
        clients (
                first_name,
                last_name,
                email,
                phone_number,
                address
        )
VALUES
        (
                'John',
                'Doe',
                'john.doe@example.com',
                '123-456-7890',
                '123 Client Lane'
        ),
        (
                'Alice',
                'Johnson',
                'alice.johnson@example.com',
                '987-654-3210',
                '456 Client Street'
        );

INSERT INTO
        caregivers (
                first_name,
                last_name,
                email,
                phone_number,
                address,
                pay_rate
        )
VALUES
        (
                'Jane',
                'Smith',
                'jane.smith@example.com',
                '321-654-9870',
                '123 Caregiver Avenue',
                15.00
        ),
        (
                'Bob',
                'Brown',
                'bob.brown@example.com',
                '654-987-3210',
                '456 Caregiver Road',
                20.00
        );

INSERT INTO
        services (code, description, bill_rate)
VALUES
        (
                'HC',
                'Home Care',
                35.00
        ),
        (
                'HMK',
                'Homemaker',
                29.00
        );

INSERT INTO
        appointments (
                client_id,
                caregiver_id,
                service_id,
                date,
                start_time,
                end_time,
                notes,
                verified
        )
VALUES
        (
                1,
                1,
                1,
                CURDATE(),
                TIME('12:00'),
                TIME('13:00'),
                'Initial meeting',
                0
        );

INSERT INTO
        appointments (
                client_id,
                caregiver_id,
                service_id,
                date,
                start_time,
                end_time,
                notes,
                verified
        )
VALUES
        (
                2,
                2,
                2,
                CURDATE() + INTERVAL 1 DAY,
                TIME('12:00'),
                TIME('13:00'),
                'Follow-up visit',
                0
        );
