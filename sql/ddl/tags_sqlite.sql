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

INSERT INTO Tags VALUES
    ("0", "Sweden"),
    ("1", "Europe"),
    ("2", "Asia"),
    ("3", "Restaurants"),
    ("4", "Housing"),
    ("5", "USA"),
    ("6", "Entertainment"),
    ("7", "To see")
;

