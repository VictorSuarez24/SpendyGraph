-- Insertar usuarios de prueba
INSERT INTO users (name, email, password) VALUES
('Admin', 'admin@mail.com', SHA2('123456', 256)),
('User1', 'user1@mail.com', SHA2('password', 256));

-- Insertar transacciones de prueba
INSERT INTO transactions (user_id, amount, category, transaction_date) VALUES
(1, 50.00, 'Alimentación', '2025-01-30'),
(2, 100.00, 'Transporte', '2025-01-29');