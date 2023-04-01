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
    product_name VARCHAR(255),
    tracking_id VARCHAR(255),
    order_id VARCHAR(255),
    image_proof_path VARCHAR(255),
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
    parcel (
        product_name,
        tracking_id,
        order_id
    )
VALUES
    (
        "Ghana Chocolate Heart",
        "TRID090516CUTE",
        "ORID051608ELLE"
    );