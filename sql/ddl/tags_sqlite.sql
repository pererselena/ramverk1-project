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
