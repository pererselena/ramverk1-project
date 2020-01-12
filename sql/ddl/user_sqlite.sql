--
-- Creating a User table.
--



--
-- Table User
--
DROP TABLE IF EXISTS User;
CREATE TABLE User (
    "id" INTEGER PRIMARY KEY NOT NULL,
    `email` TEXT UNIQUE NOT NULL,
    `name` TEXT NOT NULL,
    `password` TEXT NOT NULL,
    `birthdate` TEXT NOT NULL,
    `tel` TEXT,
    `image` TEXT,
    `score` INTEGER,
    "created" TIMESTAMP,
    "updated" DATETIME,
    "deleted" DATETIME,
    "votes" INTEGER,
    "active" DATETIME
);
