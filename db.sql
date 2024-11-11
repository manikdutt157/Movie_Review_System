CREATE DATABASE movie_review_system;

USE movie_review_system;

CREATE TABLE movies (
  id INT PRIMARY KEY AUTO_INCREMENT,
  title VARCHAR(255),
  image VARCHAR(255)
);

CREATE TABLE reviews (
  id INT PRIMARY KEY AUTO_INCREMENT,
  movie_id INT,
  review TEXT,
  rating INT,
  FOREIGN KEY (movie_id) REFERENCES movies(id)
);
