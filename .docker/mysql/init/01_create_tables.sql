-- Create the users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,  -- Unique ID for each user
    name VARCHAR(100) NOT NULL,         -- Name of the user
    email VARCHAR(100) UNIQUE NOT NULL, -- Unique email for the user
    password VARCHAR(255) NOT NULL,     -- User's hashed password
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Timestamp when the user is created
);

-- Insert test users
INSERT INTO users (name, email, password) VALUES
('Admin', 'admin@mail.com', SHA2('123456', 256)), -- Admin user with hashed password
('User1', 'user1@mail.com', SHA2('password', 256)); -- Regular user with hashed password

-- Insert test transactions
INSERT INTO transactions (user_id, amount, category, transaction_date) VALUES
(1, 50.00, 'Food', '2025-01-30'), -- Transaction for Admin
(2, 100.00, 'Transport', '2025-01-29'); -- Transaction for User1