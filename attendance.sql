CREATE TABLE attendance (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id INT NOT NULL,
    status VARCHAR(255) NOT NULL,
    timestamp DATETIME NOT NULL
);