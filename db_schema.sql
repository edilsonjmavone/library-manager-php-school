create database lib_manager;
use lib_manager;
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
    genre varchar(100),
    author_id int,
    publication_date Date, 
    publishier varchar(50),
    copies int,
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
    state enum('available', 'borrowed', 'late') DEFAULT 'borrowed',
    FOREIGN KEY (user_id) REFERENCES user(id),
    FOREIGN KEY (book_id) REFERENCES book(id)
);

-- insertions

INSERT into user (email, pwdHash, role) values ('admin@mail.com', 'hash', 'admin');
-- modifications
alter table user add user_name varchar(50);
alter table book add publication_date Date not null;

alter table book drop COLUMN status;
alter table borrowed_book add state enum('available', 'borrowed', 'late' ) DEFAULT 'available',
alter table book add publishier varchar(50),
alter table book add copies int,




SELECT 
    b.id, 
    b.title, 
    b.genre, 
    a.name AS author, 
    b.publication_date,
    b.status,
    b_b.borrow_date as 'Borrow Date'
FROM book b 
LEFT JOIN author a ON b.author_id = a.id
LEFT JOIN borrowed_book b_b ON b.id = b_b.book_id
WHERE b_b.user_id = 2
  AND b_b.return_date IS NULL;