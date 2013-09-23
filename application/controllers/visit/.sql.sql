SELECT 
	parent.anamnese_id, 
	GROUP_CONCAT(child.anamnese_id SEPARATOR ', ') ,
	AnamneseName(parent.anamnese_id) as a,
	GROUP_CONCAT(AnamneseName(child.anamnese_id) SEPARATOR ', ') as b
FROM	expert_anamnese_diagnoses child
	JOIN (
		SELECT 
		id, parent_id, anamnese_id
		FROM expert_anamnese_diagnoses xead
	) parent ON (parent.id = child.parent_id)
GROUP BY child.parent_id

DROP PROCEDURE IF EXISTS ListDescendants;
DELIMITER |

CREATE PROCEDURE ListDescendants( ancestor CHAR(20) )
BEGIN
  DECLARE rows, iLevel, iMode INT DEFAULT 0;
  DROP TEMPORARY TABLE IF EXISTS descendants,nextparents,prevparents;
  CREATE TEMPORARY TABLE descendants( childID INT, parentID INT, level INT );
  CREATE TEMPORARY TABLE IF NOT EXISTS nextparents ( parentID SMALLINT) ENGINE=MEMORY;
  CREATE TEMPORARY TABLE prevparents LIKE nextparents;


  IF ancestor RLIKE '[:alpha:]+' THEN      -- ancestor passed as a string
    INSERT INTO nextparents SELECT id FROM family WHERE name=ancestor;
  ELSE
    SET iMode = 1;                         -- ancestor passed as a numeric
    INSERT INTO nextparents VALUES( CAST( ancestor AS UNSIGNED ));
  END IF;
  SET rows = ROW_COUNT();
  WHILE rows > 0 DO

    SET iLevel = iLevel + 1;
    INSERT INTO descendants
      SELECT t.childID, t.parentID, iLevel
      FROM familytree AS t
      INNER JOIN nextparents USING(parentID);
    SET rows = ROW_COUNT();

    TRUNCATE prevparents;
    INSERT INTO prevparents
      SELECT * FROM nextparents;

    TRUNCATE nextparents;
    INSERT INTO nextparents
      SELECT childID FROM familytree
      INNER JOIN prevparents USING (parentID);
    SET rows = rows + ROW_COUNT();
  END WHILE;  

  IF iMode = 1 THEN
    SELECT CONCAT(REPEAT( ' ', level), parentID ) As Parent, GROUP_CONCAT(childID) AS Child
    FROM descendants GROUP BY parentID ORDER BY level;
  ELSE
    SELECT CONCAT(REPEAT( ' ', level), PersonName(parentID) ) As Parent, PersonName(childID) AS Child
    FROM descendants;
  END IF;
  DROP TEMPORARY TABLE descendants,nextparents,prevparents;
END;
|
DELIMITER ;
CALL ListDescendants( 1 );




SET @@SESSION.max_sp_recursion_depth=25;
DROP PROCEDURE IF EXISTS recursivesubtree;
DELIMITER |
CREATE PROCEDURE recursivesubtree( iroot INT, ilevel INT )
BEGIN
  DECLARE ichildid, iparentid,ichildcount,done INT DEFAULT 0;
  DECLARE cname VARCHAR(64);
  DECLARE cur CURSOR FOR
  SELECT 
    t.childid,t.parentid,f.name,
    (SELECT COUNT(*) FROM familytree WHERE parentID=t.childID) AS childcount
  FROM familytree t JOIN family f ON t.childID=f.ID
  WHERE parentid=iroot ORDER BY childcount<>0,t.childID;
  DECLARE CONTINUE HANDLER FOR SQLSTATE '02000' SET done = 1;
  IF ilevel = 0 THEN
    DROP TEMPORARY TABLE IF EXISTS descendants;
    CREATE TEMPORARY TABLE descendants(
      childID INT,parentID INT,name VARCHAR(64),childcount INT,level INT
    );
  END IF;
  OPEN cur;
  WHILE NOT done DO
    FETCH cur INTO ichildid,iparentid,cname,ichildcount;
    IF NOT done THEN
      INSERT INTO descendants VALUES(ichildid,iparentid,cname,ichildcount,ilevel );
      IF ichildcount > 0 THEN
        CALL recursivesubtree( ichildid, ilevel + 1 );
      END IF;
    END IF;
  END WHILE;
  CLOSE cur;
END;
|
DELIMITER ;

CALL recursivesubtree(1,0);
SELECT CONCAT(REPEAT(' ',2*level),IF(childcount,UPPER(name),name)) AS 'Richard\'s Descendants'
FROM descendants;
