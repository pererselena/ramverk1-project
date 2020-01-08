--
-- Creating a Tags table.
--



--
-- Table Tags
--
DROP TABLE IF EXISTS Tags;
CREATE TABLE Tags (
    "id" INTEGER PRIMARY KEY NOT NULL,
    `tag` TEXT NOT NULL
);

--
-- Table Tags to questions
--
DROP TABLE IF EXISTS TagToQuestion;
CREATE TABLE TagToQuestion (
    "id" INTEGER PRIMARY KEY NOT NULL,
    `tid` INTEGER NOT NULL,
    `qid` INTEGER NOT NULL,
    FOREIGN KEY("qid") REFERENCES Questions("id"),
    FOREIGN KEY("tid") REFERENCES Tags("id")
);
