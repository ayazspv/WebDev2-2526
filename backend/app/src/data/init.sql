-- Drop existing tables if they exist (order matters due to FKs)
DROP TABLE IF EXISTS orderitems;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS materials;
DROP TABLE IF EXISTS users;

-- USERS table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phoneNumber VARCHAR(20),
    status ENUM('active', 'inactive') DEFAULT 'active'
);

-- MATERIALS table
CREATE TABLE materials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL,
    seller VARCHAR(100) NOT NULL,
    status ENUM('In Stock', 'Out of Stock') DEFAULT 'In Stock',
    location VARCHAR(100) NOT NULL,
    image VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ORDERS table
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    userId INT NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    status ENUM('pending', 'completed', 'shipped') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (userId) REFERENCES users(id) ON DELETE CASCADE
);

-- ORDERITEMS table
CREATE TABLE orderitems (
    id INT AUTO_INCREMENT PRIMARY KEY,
    orderId INT NOT NULL,
    materialId INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (orderId) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (materialId) REFERENCES materials(id) ON DELETE CASCADE
);

INSERT INTO users (firstname, lastname, role, email, password, phoneNumber, status) VALUES
('Alice', 'Johnson', 'admin', 'alice@example.com', '$2y$10$eEi7JRvX.pqvomOAQ6V.weIUzW4ZHdG.6UKyErhuHp0./fnVcqmnS', '1234567890', 'active'),
('Bob', 'Smith', 'user', 'bob@example.com', '$2y$10$eEi7JRvX.pqvomOAQ6V.weIUzW4ZHdG.6UKyErhuHp0./fnVcqmnS', '0987654321', 'active'),
('Charlie', 'Lee', 'user', 'charlie@example.com', '$2y$10$eEi7JRvX.pqvomOAQ6V.weIUzW4ZHdG.6UKyErhuHp0./fnVcqmnS', NULL, 'inactive');

INSERT INTO materials (name, description, price, quantity, seller, status, location, image) VALUES
('Recycled Wood Planks', 'Planks from demolished buildings, good condition.', 10.50, 100, 1, 'In Stock', 'Amsterdam', 'images/wood.jpg'),
('Scrap Metal Sheets', 'Mixed metal sheets, mostly aluminum and steel.', 5.75, 250, 2, 'In Stock', 'Rotterdam', 'images/metal.jpg'),
('Glass Panels', 'Clear tempered glass panels, 1x2m.', 20.00, 50, 2, 'In Stock', 'Utrecht', 'images/glass.jpg');

INSERT INTO orders (userId, total_amount, status) VALUES
(2, 115.00, 'pending'),
(3, 40.00, 'completed');

INSERT INTO orderitems (orderId, materialId, quantity, price) VALUES
(1, 1, 5, 10.50),
(1, 2, 10, 5.75),
(2, 3, 2, 20.00);
