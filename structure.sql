DROP TABLE IF EXISTS test;

CREATE DATABASE IF NOT EXISTS test;

use test;

CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT,
    username VARCHAR(255),
    password CHAR(128),
    email VARCHAR(255),
    address VARCHAR(255),
    PRIMARY KEY (user_id)
);

CREATE TABLE IF NOT EXISTS parcel (
    parcel_id INT AUTO_INCREMENT NOT NULL,
    product_name VARCHAR(255) NOT NULL,
    order_id VARCHAR(255) NOT NULL,
    parcel_status VARCHAR(48) NOT NULL DEFAULT "Not Delivered",
    PRIMARY KEY (parcel_id)
);

### * TEST DATA
INSERT INTO
    users (
        username,
        password,
        email,
        address
    )
VALUES
    (
        "admin",
        "$2y$10$QuHLlrU6J/8j9WMTuPvcgeBejOGubw2xXQyIlqY.8LR81D.9lfz5y",
        -- PASSWORD: 1234
        "Administrator@gmail.com",
        "FEU"
    );

INSERT INTO
    parcel (product_name, order_id, parcel_status)
VALUES
    (
        "Ghana Chocolate Heart",
        "ORID051608ELLE",
        "Not Delivered"
    );