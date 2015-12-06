CREATE TABLE IF NOT EXISTS Users (
    id INTEGER,
    photo VARCHAR,
    username VARCHAR,
    password VARCHAR,
    email VARCHAR,

    CONSTRAINT pk_Users PRIMARY KEY (id),
    CONSTRAINT uv_Username UNIQUE (username),
    CONSTRAINT uv_Email UNIQUE (email)
);

CREATE TABLE IF NOT EXISTS AwaitingUsers (
    id INTEGER,
    username VARCHAR,
    password VARCHAR,
    email VARCHAR,
    authToken VARCHAR,
    registerDate DATE,

    CONSTRAINT pk_Users PRIMARY KEY (id),
    CONSTRAINT uv_Username UNIQUE (username),
    CONSTRAINT uv_Email UNIQUE (email)
);

CREATE TABLE IF NOT EXISTS LostUsers (
    userId INTEGER,
    authToken VARCHAR,

    CONSTRAINT pk_Users PRIMARY KEY (userId),
    CONSTRAINT fk_User FOREIGN KEY (userId) REFERENCES Users(id)
);

CREATE TABLE IF NOT EXISTS EventType (
    id INTEGER,
    type VARCHAR,

    CONSTRAINT pk_EventTypes PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS Events (
    id INTEGER,
    name VARCHAR,
    description VARCHAR,
    ownerId INTEGER,
    photo VARCHAR,
    eventDate DATE,
    typeId INTEGER,
    private INTEGER,

    CONSTRAINT pk_Events PRIMARY KEY (id),
    CONSTRAINT fk_Owner FOREIGN KEY (ownerId) REFERENCES Users(id),
    CONSTRAINT fk_EventType FOREIGN KEY (typeId) REFERENCES EventType(id)
);

CREATE TABLE IF NOT EXISTS Albums (
    id INTEGER,
    eventId INTEGER,
    title VARCHAR,

    CONSTRAINT pk_Albums PRIMARY KEY (id),
    CONSTRAINT fk_Event FOREIGN KEY (eventId) REFERENCES Events(id)
);

CREATE TABLE IF NOT EXISTS Photos (
    id INTEGER,
    albumId INTEGER,
    path VARCHAR,

    CONSTRAINT pk_Photos PRIMARY KEY (id),
    CONSTRAINT fk_Album FOREIGN KEY (albumId) REFERENCES Albums(id)
);

CREATE TABLE IF NOT EXISTS UserEvents (
    userId INTEGER,
    eventId INTEGER,

    CONSTRAINT pk_UserEvents PRIMARY KEY (userId, eventId),
    CONSTRAINT fk_User FOREIGN KEY (userId) REFERENCES Users(id),
    CONSTRAINT fk_Event FOREIGN KEY (eventId) REFERENCES Events(id)
);

CREATE TABLE IF NOT EXISTS EventInvites (
	userId INTEGER,
	eventId INTEGER,
	
	CONSTRAINT pk_UserInvites PRIMARY KEY (userId, eventId),
	CONSTRAINT fk_User FOREIGN KEY (userId) REFERENCES Users(id),
	CONSTRAINT fk_Event FOREIGN KEY (eventId) REFERENCES Events(id)
);

CREATE TABLE IF NOT EXISTS UserSessions (
    userId INTEGER,
    footprint VARCHAR,
    token VARCHAR,

    CONSTRAINT pk_UserSessions PRIMARY KEY (userId, token),
    CONSTRAINT fk_UserSessions FOREIGN KEY (userId) REFERENCES Users(id)
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
