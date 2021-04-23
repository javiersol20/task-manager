CREATE DATABASE IF NOT EXISTS taskmanager;
USE taskmanager;

CREATE TABLE IF NOT EXISTS users(
id INT(11) NOT NULL AUTO_INCREMENT,
rol VARCHAR(50) NOT NULL,
name VARCHAR(150) NOT NULL,
surname VARCHAR(150) NOT NULL,
email VARCHAR (255) NOT NULL,
password VARCHAR(255),
created_at DATETIME,
    CONSTRAINT pk_users PRIMARY KEY(id),
    CONSTRAINT uq_email UNIQUE (email)
)ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS tasks(
    id INT(11) NOT NULL AUTO_INCREMENT,
    user_id INT(11) NOT NULL,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    priority VARCHAR(20),
    hours INT(100),
    created_at DATETIME,
    CONSTRAINT pk_tasks PRIMARY KEY (id),
    CONSTRAINT fk_user_task FOREIGN KEY (user_id) REFERENCES users(id)
)ENGINE=InnoDB;