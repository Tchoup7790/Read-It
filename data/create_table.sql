-- Create Table Read It Project

-- Create users
CREATE TABLE users (
  id_user     INT AUTO_INCREMENT PRIMARY KEY,
  alias       VARCHAR(255) DEFAULT NULL,
  description TEXT DEFAULT NULL,
  email       VARCHAR(255) NOT NULL UNIQUE,
  name        VARCHAR(255),
  birth_date  DATE DEFAULT NULL,
  country     VARCHAR(255) DEFAULT NULL,
  created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create articles
CREATE TABLE articles (
  id_article     INT AUTO_INCREMENT PRIMARY KEY,
  id_user        INT NULL,
  title_article  VARCHAR(255) NOT NULL,
  text_article   TEXT NOT NULL,
  vote           INT DEFAULT NULL,
  created_at     TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at     TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_users FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE
);

-- Create reviews
CREATE TABLE reviews (
  id_review     INT AUTO_INCREMENT PRIMARY KEY,
  id_user       INT NULL,
  id_article    INT NULL,
  title_review  VARCHAR(255) NOT NULL,
  text_review   TEXT NOT NULL,
  created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_users_reviews FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE,
  CONSTRAINT fk_articles_reviews FOREIGN KEY (id_article) REFERENCES articles(id_article) ON DELETE CASCADE,
);
