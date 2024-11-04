-- Ajouter des données au table

-- Insertion de utilisateurs
INSERT INTO users (password, alias, description, email, name) VALUES
("test_pass", "alice123", "Passionnée de technologie et de photographie.", "alice@example.com", "Alice Martin"),
("test_pass", "bob_smith", "Amateur de cuisine et de voyage.", "bob@example.com", "Bob Smith"),
("test_pass", "charlie_89", "Blogueur sur les jeux vidéo et la culture geek.", "charlie@example.com", "Charlie Dupont"),
("test_pass", "diana_white", "Fan de littérature et de cinéma.", "diana@example.com", "Diana White"),
("test_pass", "edward_green", "Coureur et passionné de fitness.", "edward@example.com", "Edward Green");

-- Insertion de articles
INSERT INTO articles (id_user, slug, title_article, content_article) VALUES
(1, "tech-innovations-2024", "Innovations Technologiques de 2024", "Découvrez les dernières innovations technologiques qui transforment notre quotidien."),
(2, "cuisine-italienne-facile", "Recettes Faciles de Cuisine Italienne", "Apprenez à préparer des plats italiens simples et délicieux pour impressionner vos amis."),
(3, "meilleurs-jeux-video-2024", "Top des Meilleurs Jeux Vidéo de 2024", "Un aperçu des jeux vidéo les plus attendus et comment y jouer."),
(4, "livres-a-lire-2024", "5 Livres à Lire en 2024", "Les livres qui devraient figurer sur votre liste de lecture cette année."),
(5, "fitness-pour-debutants", "Guide de Fitness pour Débutants", "Commencez votre parcours de fitness avec ces conseils et exercices essentiels.");

-- Insertion de reviews
INSERT INTO reviews (id_user, id_article, slug, title_review, content_review) VALUES
(1, 1, "tech-innovations-review", "Une lecture incontournable!", "Cet article présente des innovations incroyables qui méritent d'être explorées."),
(2, 2, "cuisine-italienne-review", "Des recettes délicieuses", "Les recettes partagées ici sont faciles à suivre et vraiment savoureuses."),
(3, 3, "jeux-video-review", "Superbe sélection de jeux!", "Un guide fantastique sur les jeux à ne pas manquer cette année."),
(4, 4, "livres-a-lire-review", "Inspiration littéraire", "Une excellente sélection de livres qui m'ont beaucoup inspiré."),
(5, 5, "fitness-guide-review", "Parfait pour débuter!", "Ce guide m'a aidé à démarrer mon parcours de fitness avec succès.");

