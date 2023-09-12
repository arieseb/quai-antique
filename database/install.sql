SET NAMES utf8;
INSERT INTO category (id, name) VALUES
      (0x0187666dcb627c5c8bcd92d48bf6ee3f, 'Entrées'),
      (0x0187666e25f87a3595ee8495463b902a, 'Plats'),
      (0x0187666e48fa7394aa3659e3ddcc30ff, 'Desserts');
INSERT INTO dish (id, category_id, name, price, description) VALUES
     (0x018766729b647c3e909191086fd623b0, 0x0187666dcb627c5c8bcd92d48bf6ee3f, 'Salade savoyarde', '9.00', 'Salade gourmande avec des pommes de terre, de la charcuterie, des pignons de pin et des croutons, recouverte de fromage à raclette'),
     (0x01876675835b75a494fb79b69a1ab639, 0x0187666dcb627c5c8bcd92d48bf6ee3f, 'Salade de chou au Comté', '10.50', 'Salade de chou blanc accompagnée de lardons fumés et de Comté affiné, assaisonnée à la moutarde'),
     (0x01876679cde07b93870078632a3b481a, 0x0187666dcb627c5c8bcd92d48bf6ee3f, 'Salade montagnarde', '12.00', 'Une salade riche avec des pommes de terre, de la charcuterie (lardons fumés, jambon sec) et du fromage (chèvre, beaufort et abondance)'),
     (0x0187667f2c6f7ca3a3dddb90cecdbd67, 0x0187666dcb627c5c8bcd92d48bf6ee3f, 'Plateau de charcuterie', '10.50', 'Assortiment de charcuterie typique de nos montagnes, avec du jambon de Savoie, saucisse sèche, viande des Grisons, speck (selon arrivages)'),
     (0x01876681c3ee76cb9fb848a0fe1e5e16, 0x0187666e25f87a3595ee8495463b902a, 'Raclette', '16.00', 'Repas convivial à base de fromage fondu. On y ajoute des pommes de terre, de la charcuterie, des cornichons et des oignons.'),
     (0x0187668231a57917a2f3e9b992f8735c, 0x0187666e25f87a3595ee8495463b902a, 'Tartiflette', '17.00', 'Gratin de pommes de terre, d''oignons, de lardons et de fromage reblochon, le tout cuit au four jusqu''à ce qu''il soit doré et fondant.'),
     (0x0187668565467b439ec84fe5052a9ddf, 0x0187666e25f87a3595ee8495463b902a, 'Fondue savoyarde', '15.00', 'Caquelon d''abondance fondue dans lequel vous pourrez tremper des morceaux de pain. servie avec une salade verte et quelques tranches de charcuterie locale'),
     (0x0187668689677765919aab34b9b1578f, 0x0187666e25f87a3595ee8495463b902a, 'Croziflette', '17.00', 'Gratin de crozets, d''oignons, de lardons et de reblochon, le tout cuit au four jusqu''à ce qu''il soit doré et fondant.'),
     (0x018766894c8a77549a487d05507264a5, 0x0187666e25f87a3595ee8495463b902a, 'Potchon', '15.00', 'Gratin de pommes de terre, crottins de chèvre et purée de tomate au vin blanc. Servi avec une compotée d''oignons'),
     (0x0187668b704f7ea4836549867d983f7c, 0x0187666e25f87a3595ee8495463b902a, 'Matouille', '18.00', 'Tome de Savoie passée au four et piquée à l''ail et arrosée de vin blanc. Servie avec un assortiment de charcuterie savoyarde'),
     (0x0187668d187470848e027bd91f17325e, 0x0187666e25f87a3595ee8495463b902a, 'Farcement', '15.00', 'Dôme de lardons fumés, pruneaux, pommes de terre et poires séchées à la crème fraîche. Servi avec une salade verte'),
     (0x0187668ea97d746786c3290b6cfe316d, 0x0187666e25f87a3595ee8495463b902a, 'Tarte au reblochon', '14.00', 'Tarte à la pâte feuilletée au reblochon fondu et à la crème fraîche, gratinée en surface. Servie avec une salade verte'),
     (0x0187669048f1739d805b12ef3e3f37d3, 0x0187666e25f87a3595ee8495463b902a, 'Diots et pormoniers', '18.00', 'Assortiment de diots et pormoniers, de savoureuses saucisses accompagnées de crozets'),
     (0x01876691aa88781f97225c0d714e33d8, 0x0187666e25f87a3595ee8495463b902a, 'Poêlée montagnarde', '16.00', 'Poêlée de pommes de terre, de lardons fumés, d''abondance et de vin blanc'),
     (0x0187669478c07ccaab85288aea4c9bc4, 0x0187666e48fa7394aa3659e3ddcc30ff, 'Gateau de Savoie', '4.50', 'Part d''un traditionnel gâteau de Savoie, gourmand et très moelleux'),
     (0x018766966ed37bb092d032d0f29666fa, 0x0187666e48fa7394aa3659e3ddcc30ff, 'Tartelette aux myrtilles', '6.00', 'Tartelette gourmande avec de délicieuses myrtilles fraîches sur une légère crème vanillée'),
     (0x0187669889b272ccb2990734e64d9c1f, 0x0187666e48fa7394aa3659e3ddcc30ff, 'Brioche bescoin', '7.50', 'Brioche traditionnelle au safran et à l''anis'),
     (0x01876699baef7dda8cbb37466945bc1e, 0x0187666e48fa7394aa3659e3ddcc30ff, 'Café gourmand', '4.50', 'L''indémodable café gourmand, avec son brownie au chocoloat, sa boule de glace vanille et quelques biscuits aux noix');
INSERT INTO menu (id, name) VALUES
      (1, 'Menu Routier'),
      (2, 'Menu Montagnard'),
      (3, 'Menu Gourmand');
INSERT INTO formula (id, menu_id, name, description, period, price) VALUES
    (1, 1, 'Formule Déjeuner', 'Entrée + plat ou plat + dessert', '(Du mardi au vendredi midi)', '25.00'),
    (2, 1, 'Formule Souper', 'Entrée + plat + dessert', '(Du mardi au vendredi soir)', '28.00'),
    (3, 2, 'Formule Déjeuner', 'Entrée + plat ou plat + dessert', '(Le samedi et le dimanche midi)', '27.00'),
    (4, 2, 'Formule Souper', 'Entrée + plat ou plat + dessert', '(Le samedi et le dimanche soir)', '28.00'),
    (5, 3, 'Formule Déjeuner', 'Entrée + plat  + dessert + café + digestif', '(Du mardi au dimanche midi)', '35.00'),
    (6, 3, 'Formule Souper', 'Entrée + plat  + dessert + café + digestif', '(Du mardi au dimanche soir)', '32.00');
