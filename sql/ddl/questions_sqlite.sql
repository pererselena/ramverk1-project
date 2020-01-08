--
-- Creating a Questions table.
--



--
-- Table Questions
--
DROP TABLE IF EXISTS Questions;
CREATE TABLE Questions (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "uid" INTEGER NOT NULL,
    "tid" INTEGER NOT NULL,
    `score` INTEGER,
    `tag` TEXT NOT NULL,
    `title` TEXT NOT NULL,
    `text` TEXT NOT NULL,
    "created" TIMESTAMP,
    "updated" DATETIME,
    "deleted" DATETIME,
    "active" DATETIME,
    FOREIGN KEY("uid") REFERENCES User("id"),
    FOREIGN KEY("tid") REFERENCES Tags("id")
);

--
-- Table Qcomments
--
DROP TABLE IF EXISTS Qcomments;
CREATE TABLE Qcomments (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "uid" INTEGER NOT NULL,
    "qid" INTEGER NOT NULL,
    `score` INTEGER,
    `text` TEXT NOT NULL,
    "created" TIMESTAMP,
    "updated" DATETIME,
    "deleted" DATETIME,
    "active" DATETIME,
    FOREIGN KEY("uid") REFERENCES User("id"),
    FOREIGN KEY("qid") REFERENCES Questions("id")
);

--
-- Table Answer
--
DROP TABLE IF EXISTS Answer;
CREATE TABLE Answer (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "uid" INTEGER NOT NULL,
    "qid" INTEGER NOT NULL,
    `score` INTEGER,
    `text` TEXT NOT NULL,
    "created" TIMESTAMP,
    "updated" DATETIME,
    "deleted" DATETIME,
    "active" DATETIME,
    FOREIGN KEY("uid") REFERENCES User("id"),
    FOREIGN KEY("qid") REFERENCES Questions("id")
);

--
-- Table Acomments
--
DROP TABLE IF EXISTS Acomments;
CREATE TABLE Acomments (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "uid" INTEGER NOT NULL,
    "aid" INTEGER NOT NULL,
    `score` INTEGER,
    `text` TEXT NOT NULL,
    "created" TIMESTAMP,
    "updated" DATETIME,
    "deleted" DATETIME,
    "active" DATETIME,
    FOREIGN KEY("uid") REFERENCES User("id"),
    FOREIGN KEY("aid") REFERENCES Answer("id")
);