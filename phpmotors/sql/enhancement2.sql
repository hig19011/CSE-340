INSERT INTO `clients`(`clientFirstname`, `clientLastname`, `clientEmail`, `clientPassword`, `comment`) 
VALUES ('Tony', 'Stark', 'tony@starkent.com', 'Iam1ronM@n', '"I am the real Ironman"');

update clients 
set clientLevel = 3
where clientId = 1;

update inventory
set invDescription = Replace(invDescription,'small interior','spacious interior')
where invId = 12;

select invModel 
from inventory i 
	inner join carclassification cc on i.classificationId = cc.classificationId
where cc.classificationName = 'SUV';

delete from inventory
where invId = 1;

update inventory
set invImage = concat('/phpmotors', invImage),
	invThumbnail = concat('/phpmotors', invThumbnail);
  