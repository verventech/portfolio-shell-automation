-- Create user and database (What step 3 was doing)
CREATE USER musharaf WITH PASSWORD 'musharaf_secure_pass_123';
CREATE DATABASE portfolio_db OWNER musharaf;

-- Connect to the new database 
\c portfolio_db
SET ROLE musharaf

-- Drop the table if it already exists
DROP TABLE IF EXISTS education;

-- Create the education table (What step 5 is doing)
CREATE TABLE education (
    id SERIAL PRIMARY KEY,
    course_name VARCHAR(255) NOT NULL,
    session VARCHAR(50) NOT NULL,
    cgpa NUMERIC(3, 2) NOT NULL,
    institute VARCHAR(255) NOT NULL
);

-- Insert sample portfolio data
INSERT INTO education (course_name, session, cgpa, institute) VALUES 
('B.Tech Computer Science & Engineering', '2019-2023', 8.75, 'NIT Srinagar'),
('Diploma in Artificial Intelligence', '2023-2024', 9.10, 'CDAC Pune'),
('Cloud Computing Fundamentals', 'Summer 2022', 8.90, 'AWS Academy');
