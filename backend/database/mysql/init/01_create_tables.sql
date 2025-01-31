CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,  -- Unique ID for each user
    name VARCHAR(100) NOT NULL,         -- Name of the user
    email VARCHAR(100) UNIQUE NOT NULL, -- Unique email for the user
    password VARCHAR(255) NOT NULL,     -- User's hashed password
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Timestamp when the user is created
);
