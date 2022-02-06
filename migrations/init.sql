CREATE DATABASE rowles;

USE rowles;

CREATE TABLE users
(
    id             BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    email          VARCHAR(255) NOT NULL,
    password       VARCHAR(255) NOT NULL,
    remember_token VARCHAR(255) NULL,
    name           VARCHAR(255) NOT NULL,
    created_at     TIMESTAMP    NULL,
    updated_at     TIMESTAMP    NULL
);

CREATE TABLE sessions
(
    id         VARCHAR(255)    NOT NULL PRIMARY KEY,
    user_id    BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP       NULL,
    updated_at TIMESTAMP       NULL
);

CREATE TABLE blog
(
    id         BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title      VARCHAR(255) NOT NULL,
    author     VARCHAR(255) NOT NULL,
    content    LONGTEXT     NOT NULL,
    created_at TIMESTAMP    NULL,
    updated_at TIMESTAMP    NULL
);