TRUNCATE TABLE category;

INSERT INTO `category`
(`id`, `name`, `image`, `colour`)
VALUES
  ('1', 'Assistance with daily life at home in the community, education and at work', 'img/icons/assistance1.png',
   '67623a'),
  ('2', 'Transport to access daily activities', 'img/icons/transport2.png', '778484'),
  ('3', 'Supported independent living', 'img/icons/lifeChoice14.png', 'b22430'),
  ('4', 'Improved daily living skills', 'img/icons/living4.png', 'af1eb6'),
  ('5', 'Assistive technology', 'img/icons/techAssistance5.png', '455678'),
  ('6', 'Vehicle modifications', 'img/icons/carMods6.png', 'ae9d5f'),
  ('7', 'Home modifications', 'img/icons/homeMods7.png', '7ba549'),
  ('8', 'Improved living arrangements', 'img/icons/living8.png', '4c6aa5'),
  ('9', 'Increased social and community participation', 'img/icons/social9.png', 'be5358'),
  ('10', 'Finding and keeping a job', 'img/icons/job10.png', '6f7932'),
  ('11', 'Improved relationships', 'img/icons/relationships11.png', '881934'),
  ('12', 'Improved health and wellbeing', 'img/icons/health12.png', '828572'),
  ('13', 'Improved learning', 'img/icons/learning13.png', '2543b6'),
  ('14', 'Improved life choices', 'img/icons/lifeChoice14.png', '568ea6');

SELECT *
FROM mbb.category;