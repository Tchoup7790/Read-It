-- Populate Table for test_database

-- Inset users
INSERT INTO users (password, alias, description, email, name, birth_date, country)
VALUES 
('test', 'laura_m', 'Passionnée de littérature et de voyage.', 'laura@example.com', 'Laura Martin', '1988-03-12', 'France'),
('test', 'max_b', 'Photographe amateur et amateur de café.', 'max@example.com', 'Maxime Bernard', '1992-05-20', 'Belgique'),
('test', 'clara_s', 'Adepte de la cuisine végétarienne.', 'clara@example.com', 'Clara Simon', '1995-08-15', 'France'),
('test', 'olivier_d', 'Technophile et amateur de jeux vidéo.', 'olivier@example.com', 'Olivier Dubois', '1985-11-22', 'Canada'),
('test', 'sophie_t', 'Passionnée par les arts et la culture.', 'sophie@example.com', 'Sophie Thomas', '1990-07-30', 'Suisse'),
('test', 'antoine_r', 'Voyageur dans l’âme, explorant le monde.', 'antoine@example.com', 'Antoine Renault', '1991-01-25', 'France'),
('test', 'marie_l', 'Enseignante, aimant partager ses connaissances.', 'marie@example.com', 'Marie Lefevre', '1980-09-05', 'France'),
('test', 'lucas_p', 'Blogger passionné de technologie.', 'lucas@example.com', 'Lucas Petit', '1993-06-10', 'Belgique');

-- Insert articles
INSERT INTO articles (title_article, text_article, vote, id_user)
VALUES 
('Les merveilles de la nature', 'La nature est pleine de merveilles, des montagnes majestueuses aux océans vastes. Dans cet article, nous explorerons certains des paysages les plus impressionnants du monde, tels que le Grand Canyon, les fjords norvégiens et la grande barrière de corail. Chacun de ces lieux a sa propre beauté unique, façonnée par des millions d’années d’érosion et de climat. Nous discuterons également de l’importance de préserver ces environnements fragiles pour les générations futures.', 14, 1),
('Café : un art à part entière', 'Le café n’est pas seulement une boisson, c’est un véritable art. Cet article examine les différentes méthodes de préparation du café, y compris l’espresso, le filtre, et la presse française. Nous plongerons dans l’histoire du café, ses origines en Éthiopie et son évolution à travers les siècles. Les amateurs de café apprendront également des conseils pour choisir les meilleures grains, les moudre correctement et créer des infusions délicieuses. Enfin, nous mettrons en lumière quelques-unes des plus belles cafés autour du monde.', 18, 2),
('Recettes végétariennes faciles', "La cuisine végétarienne peut être à la fois délicieuse et simple à préparer. Dans cet article, nous partagerons des recettes faciles à réaliser pour tous les repas de la journée, des petits déjeuners nutritifs aux dîners savoureux. Découvrez des plats tels que les tacos de lentilles, les lasagnes aux légumes et les smoothies énergétiques. Nous parlerons également des bienfaits d'une alimentation végétarienne et de la façon dont elle peut contribuer à un mode de vie sain.", 20, 3),
('Les tendances technologiques en 2024', 'Avec l’évolution rapide de la technologie, il est essentiel de rester informé des dernières tendances. Cet article explore les innovations qui façonnent notre futur, y compris l’intelligence artificielle, la réalité augmentée, et les technologies durables. Nous analyserons comment ces tendances influencent divers secteurs, de la santé à l’éducation, et comment elles peuvent changer notre quotidien. Des exemples concrets d’applications de ces technologies seront présentés pour illustrer leur impact potentiel.', 22, 4),
('L’importance de l’art dans la société', 'L’art joue un rôle crucial dans notre société, agissant comme un miroir de notre culture et de nos valeurs. Dans cet article, nous examinerons les différentes formes d’art, de la peinture à la musique, et comment elles influencent notre perception du monde. Nous discuterons de l’impact de l’art sur l’éducation et le bien-être, ainsi que de son pouvoir de rassembler les gens. Enfin, nous mettrons en lumière des initiatives artistiques qui cherchent à transformer des communautés à travers le monde.', 17, 5),
('Voyager seul : conseils et astuces', 'Voyager seul peut être une expérience incroyablement enrichissante. Cet article offre des conseils pratiques pour ceux qui envisagent d’explorer le monde en solo. Nous aborderons des sujets tels que la sécurité, la planification des voyages, et l’importance de se connecter avec les autres. De plus, nous partagerons des témoignages de voyageurs solitaires qui racontent leurs aventures et les leçons qu’ils ont apprises en chemin. Que vous soyez un voyageur débutant ou expérimenté, cet article vous fournira des informations utiles pour votre prochaine aventure.', 15, 6),
('L’éducation et son impact', 'L’éducation est l’un des piliers fondamentaux de notre société. Dans cet article, nous explorerons le rôle de l’éducation dans le développement personnel et social. Nous discuterons des défis auxquels l’éducation est confrontée aujourd’hui, notamment l’accès équitable et l’intégration des nouvelles technologies dans l’apprentissage. En examinant différents systèmes éducatifs à travers le monde, nous mettrons en lumière des initiatives innovantes qui visent à améliorer l’éducation pour tous.', 19, 7),
('Les meilleurs jeux vidéo de l’année', 'Cette année a vu la sortie de plusieurs jeux vidéo remarquables qui ont captivé l’attention des joueurs. Cet article propose une sélection des meilleurs jeux de l’année, en analysant ce qui les rend uniques. Nous parlerons de divers genres, du RPG à l’action, en mettant en avant des titres qui se démarquent par leur gameplay, leur histoire et leur esthétique. De plus, nous examinerons l’impact de ces jeux sur la culture populaire et leur communauté de joueurs.', 25, 8);

-- Insert review
INSERT INTO reviews (title_review, text_review, id_user, id_article)
VALUES 
('Un article captivant !', 'J’ai adoré cet article sur la nature, très bien écrit.', 1, 1),
('Superbes conseils!', 'L’article sur le café m’a vraiment ouvert les yeux.', 2, 2),
('Recettes inspirantes', 'Les recettes végétariennes sont délicieuses, merci !', 3, 3),
('Un must-read', 'Une analyse complète des tendances technologiques, j’ai appris beaucoup.', 4, 4),
('Très enrichissant', 'J’ai beaucoup apprécié cet article sur l’art.', 5, 5),
('Des conseils pratiques', 'Les astuces pour voyager seul sont très utiles.', 6, 6),
('Réflexion nécessaire', 'Un bon article sur l’éducation, à lire absolument.', 7, 7),
('Excellente sélection', 'Merci pour la liste des jeux vidéo, je vais les essayer !', 8, 8),
('Inspirant et bien écrit', 'Une belle exploration des merveilles de la nature.', 1, 1),
('Une bonne introduction au sujet', 'J’ai aimé le contenu de cet article.', 2, 2);
