/*items with tags from category*/
SELECT c.name, i.id, i.title, i.alias, i.hits, i.extra_fields, t.id as tagId, t.name as tagName
FROM t10ws_k2_categories as c 
INNER JOIN  t10ws_k2_items as i ON c.id = i.catid
LEFT JOIN t10ws_k2_tags_xref as tref ON i.id=tref.itemID
LEFT JOIN t10ws_k2_tags as t ON t.id=tref.tagID
WHERE c.parent = 13


SELECT c.name, i.id, i.title, i.alias, i.hits, i.extra_fields, t.fabric, t.color, t.image
FROM t10ws_k2_categories as c 
INNER JOIN  t10ws_k2_items as i ON c.id = i.catid
LEFT JOIN t10ws_fabrics as t ON t.itemID=i.id
WHERE c.parent = 13


/*insert into items and tags*/
INSERT INTO t10ws_k2_items (`title`, `alias`, `catid`, `published`, `created`, `extra_fields`, `access`, `publish_up`) 
VALUES ('Test Item', 'testitem12', '50', '1', '2015-02-09 18:32', '[{"id":"4","value":"\/images\/fabrics\/respect\/6468357948.jpg"}, {"id":"9","value":"red"}]', '1', '2015-02-09 18:32');
INSERT INTO t10ws_k2_tags (`name`, `published`) 
VALUES ('testTag2', '1');
INSERT INTO t10ws_k2_tags_xref (`itemID`, `tagID`) 
VALUES ((SELECT t10ws_k2_items.id 
				FROM t10ws_k2_items
				WHERE t10ws_k2_items.alias = 'testitem12'),
				(SELECT t10ws_k2_tags.id 
					FROM t10ws_k2_tags
					WHERE t10ws_k2_tags.name = 'testTag'));


