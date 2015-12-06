CREATE TRIGGER IF NOT EXISTS UpdateParentComment
AFTER INSERT ON UserComment
FOR EACH ROW
WHEN NEW.parentId IS NOT NULL AND
     (SELECT parentId FROM UserComment
        WHERE id = NEW.parentId) IS NOT NULL
BEGIN
    UPDATE UserComment
    SET parentId = (SELECT parentId
                    FROM UserComment
                    WHERE id = NEW.parentId)
    WHERE id = NEW.id;
END;

CREATE TRIGGER IF NOT EXISTS LoadDefaultAlbum
AFTER INSERT ON Events
FOR EACH ROW
BEGIN
	INSERT INTO Albums(eventId, title) VALUES (NEW.id, "Other");
END;

CREATE TRIGGER IF NOT EXISTS DeleteEventData
AFTER DELETE ON Events
FOR EACH ROW
BEGIN
	DELETE FROM Albums WHERE eventId = OLD.id;
	DELETE FROM Threads WHERE eventId = OLD.id;
END;

CREATE TRIGGER IF NOT EXISTS DeleteAlbumPhotos
AFTER DELETE ON Albums
FOR EACH ROW
BEGIN
	DELETE FROM Photos WHERE albumId = OLD.id;
END;

CREATE TRIGGER IF NOT EXISTS DeleteThreadComments
AFTER DELETE ON Threads
FOR EACH ROW
BEGIN
	DELETE FROM UserComment WHERE threadID = OLD.id;
END;

CREATE TRIGGER IF NOT EXISTS RemoveInvite
AFTER INSERT ON UserEvents
FOR EACH ROW
BEGIN
	DELETE FROM EventInvites WHERE userId = NEW.userId AND eventId = NEW.eventId;
END;