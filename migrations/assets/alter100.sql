ALTER TABLE studentcourseevaluation
  ADD COLUMN Withdraw VARCHAR(2) NULL;


CREATE FUNCTION number_pos(pData CHAR(10))
  RETURNS INT
  BEGIN
    DECLARE vPos INT DEFAULT 1;
    DECLARE vChar INT;
    WHILE vPos <= LENGTH(pData) DO
      SET vChar = ASCII(SUBSTR(pData, vPos, 1));
      IF vChar BETWEEN 48 AND 57
      THEN
        RETURN vPos;
      END IF;
      SET vPos = vPos + 1;
    END WHILE;
    RETURN NULL;
  END;


CREATE FUNCTION explode(str VARCHAR(255), delim VARCHAR(12), pos INT)
  RETURNS VARCHAR(255)
  RETURN REPLACE(
      SUBSTRING
      (SUBSTRING_INDEX(str, delim, pos),
       LENGTH(SUBSTRING_INDEX(str, delim, pos - 1)) + 1),
      delim, ''
  );