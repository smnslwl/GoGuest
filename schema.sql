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
    price INTEGER NOT NULL,
    description TEXT,
    FOREIGN KEY (user) REFERENCES users (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS bookings;

CREATE TABLE bookings(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    location INT NOT NULL,
    email VARCHAR(255) NOT NULL,
    date_from DATE NOT NULL,
    date_to DATE NOT NULL,
    adults INT DEFAULT 0,
    children INT DEFAULT 0,
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
    ('nepalgunj',28.05, 81.61667 ),
    ('jhapa',26.647038, 87.890495),
    ('birgunj',27.005915, 84.859085),
    ('butwal',27.686386, 83.432426),
    ('lumbini',27.467155, 83.274908),
    ('mount everest',27.986065, 86.922623),
    ('surkhet',28.60194, 81.63389),
    ('dang',28.13099, 82.29726),
    ('tikapur',28.5, 81.13333),
    ('dhankuta',26.98333, 87.33333),
    ('biratnagar',26.4831, 87.28337),
    ('janakpur', 26.71828, 85.90646);
