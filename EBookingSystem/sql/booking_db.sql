-- Create Database
CREATE DATABASE IF NOT EXISTS ebookingsystem;
USE ebookingsystem;

-- Facilities Table
CREATE TABLE facilities (
    facility_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    location VARCHAR(100) NOT NULL
);

-- Sample facilities
INSERT INTO facilities (name, location) VALUES
('Auditorium', 'Main Building'),
('Gymnasium', 'Sports Complex'),
('Library Hall', 'Second Floor'),
('TED Library', 'Third Floor'),
('MAC Lab', 'T Boli Second Floor'),
('COM Lab', 'T Boli Second Floor'),
('RSM Events Center', 'Gate 1'),;

-- Bookings Table
CREATE TABLE bookings (
    booking_id INT AUTO_INCREMENT PRIMARY KEY,
    facility_id INT,
    date DATE,
    time_in TIME,
    time_out TIME,
    booked_by VARCHAR(100),
    description TEXT,
    status VARCHAR(20) DEFAULT 'Booked',
    FOREIGN KEY (facility_id) REFERENCES facilities(facility_id)
);
INSERT INTO users (username, password, role) 
VALUES ('admin', SHA1('admin123'), 'admin');

