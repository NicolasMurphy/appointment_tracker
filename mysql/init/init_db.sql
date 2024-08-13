CREATE DATABASE IF NOT EXISTS mydatabase;

USE mydatabase;


CREATE TABLE IF NOT EXISTS appointments (id INT AUTO_INCREMENT PRIMARY KEY,
                                                         title VARCHAR(255) NOT NULL,
                                                                            description TEXT, address TEXT, date DATE NOT NULL,
                                                                                                                      time TIME NOT NULL);


INSERT INTO appointments (title, description, address, date, time)
VALUES ('B',
        'Description 1',
        '123',
        CURDATE(),
        TIME_FORMAT(CURTIME(), '%H:%i'));

INSERT INTO appointments (title, description, address, date, time)
VALUES ('A',
        'Description 2',
        '456',
        CURDATE() + INTERVAL 1 DAY,
        TIME_FORMAT(CURTIME() + INTERVAL 1 HOUR, '%H:%i'));
