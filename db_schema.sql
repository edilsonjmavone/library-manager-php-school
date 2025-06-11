create database lib_manager;

-- auth related tables

CREATE TABLE user(
    id int PRIMARY KEY AUTO_INCREMENT, 
    email varchar(50) UNIQUE NOT NULL,
    user_name varchar(50),
    pwdHash varchar(100) NOT NULL,
    role enum('admin', 'user') DEFAULT 'user'
);

-- app core functionalities related tables

create table book(
    id int PRIMARY KEY AUTO_INCREMENT, 
    title varchar(70) NOT NULL,
    status enum('available', 'borrowed') DEFAULT 'available',
    genre varchar(100),
    author_id int,
    publication_date Date, -- not yet
    FOREIGN KEY (author_id) REFERENCES author(id)
);

create table author(
    id int PRIMARY KEY AUTO_INCREMENT, 
    name varchar(70) NOT NULL
    
);

CREATE TABLE borrowed_book(
    id int PRIMARY KEY AUTO_INCREMENT, 
    user_id int,
    book_id int,
    borrow_date DATE NOT NULL,
    return_date DATE,
    FOREIGN KEY (user_id) REFERENCES user(id),
    FOREIGN KEY (book_id) REFERENCES book(id)
);

-- insertions

INSERT into user (email, pwdHash, role) values ('admin@mail.com', 'hash', 'admin');

alter table add user_name