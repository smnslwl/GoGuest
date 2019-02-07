DROP TABLE IF EXISTS users;

CREATE TABLE  users(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS locations;

CREATE TABLE locations(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    user INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    latitude DECIMAL(9, 6) NOT NULL,
    longitude DECIMAL(9, 6) NOT NULL,
    FOREIGN KEY (user) REFERENCES users (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS bookings;

CREATE TABLE bookings(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    location INT NOT NULL,
    email VARCHAR(255) NOT NULL,
    status INT DEFAULT 0,
    FOREIGN KEY (location) REFERENCES locations (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS savedlocations;

CREATE TABLE savedlocations(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    latitude DECIMAL(9, 6) NOT NULL,
    longitude DECIMAL(9, 6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO savedlocations (name, latitude, longitude) VALUES
    ('kathmandu', 27.70169, 85.3206),
    ('pokhara', 28.26689, 83.96851),
    ('janakpur', 26.71828, 85.90646);
