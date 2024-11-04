-- Création des tables pour le projet

-- Création de users
CREATE TABLE users (
  id_user       INT AUTO_INCREMENT PRIMARY KEY,
  password      VARCHAR(255) NOT NULL,
  alias         VARCHAR(255) NOT NULL UNIQUE,
  description   TEXT DEFAULT NULL,
  email         VARCHAR(255) NOT NULL UNIQUE,
  name          VARCHAR(255) NOT NULL,
  created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Création de articles
CREATE TABLE articles (
  id_article        INT AUTO_INCREMENT PRIMARY KEY,
  id_user           INT NOT NULL,
  slug              VARCHAR(255) NOT NULL UNIQUE,
  title_article     VARCHAR(255) NOT NULL,
  content_article   TEXT NOT NULL,
  created_at        TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at        TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_users FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE
);

-- Création de reviews
CREATE TABLE reviews (
  id_review        INT AUTO_INCREMENT PRIMARY KEY,
  id_user          INT NULL,
  id_article       INT NULL,
  slug             VARCHAR(255) NOT NULL UNIQUE ,
  title_review     VARCHAR(255) NOT NULL,
  content_review   TEXT NOT NULL,
  created_at       TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at       TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_users_reviews FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE,
  CONSTRAINT fk_articles_reviews FOREIGN KEY (id_article) REFERENCES articles(id_article) ON DELETE CASCADE
);
