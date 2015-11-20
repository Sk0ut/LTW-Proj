CREATE TABLE IF NOT EXISTS Users (
	id INTEGER,
	username VARCHAR,
	password VARCHAR,
	email VARCHAR, 
	session VARCHAR,

	CONSTRAINT pk_Users PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS EventType (
	id INTEGER,
	type VARCHAR,

	CONSTRAINT pk_EventTypes PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS Photos (
	id INTEGER,
	albumId INTEGER,
	url VARCHAR,

	CONSTRAINT pk_Photos PRIMARY KEY (id),
	CONSTRAINT fk_Album FOREIGN KEY (albumId) REFERENCES Album(id)
);

CREATE TABLE IF NOT EXISTS Events (
	id INTEGER,
	name VARCHAR,
	description VARCHAR,
	ownerId INTEGER,
	photoId INTEGER,
	eventDate DATE,
	typeId INTEGER,
	private BOOLEAN,

	CONSTRAINT pk_Events PRIMARY KEY (id),
	CONSTRAINT fk_Owner FOREIGN KEY (ownerId) REFERENCES Users(id),
	CONSTRAINT fk_Photo FOREIGN KEY (photoId) REFERENCES Photos(id),
	CONSTRAINT fk_EventType FOREIGN KEY (typeId) REFERENCES EventType(id)	
);

CREATE TABLE IF NOT EXISTS Albums (
	id INTEGER,
	eventId INTEGER,
	title VARCHAR,

	CONSTRAINT pk_Albums PRIMARY KEY (id),
	CONSTRAINT fk_Event FOREIGN KEY (eventId) REFERENCES Events(id)
);

CREATE TABLE IF NOT EXISTS UserEvents (
	userId INTEGER,
	eventId INTEGER,

	CONSTRAINT pk_UserEvents PRIMARY KEY (userId, eventId),
	CONSTRAINT fk_User FOREIGN KEY (userId) REFERENCES Users(id),
	CONSTRAINT fk_Event FOREIGN KEY (eventId) REFERENCES Events(id)
);

CREATE TABLE IF NOT EXISTS Threads (
	id INTEGER,
	eventId INTEGER,
	title VARCHAR,
	description VARCHAR,

	CONSTRAINT pk_Threads PRIMARY KEY (id),
	CONSTRAINT fk_Event FOREIGN KEY (eventId) REFERENCES Events(id)
);

CREATE TABLE IF NOT EXISTS UserComment (
	id INTEGER,
	userId INTEGER,
	threadId INTEGER,
	comment VARCHAR,
	commentDate DATE,
	parentId INTEGER,

	CONSTRAINT pk_UserComment PRIMARY KEY (id),
	CONSTRAINT fk_User FOREIGN KEY (userId) REFERENCES Users(id),
	CONSTRAINT fk_Thread FOREIGN KEY (threadId) REFERENCES Users(id),
	CONSTRAINT fk_Parent FOREIGN KEY (parentId) REFERENCES UserComment(id)
);