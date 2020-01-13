#!/bin/bash

sqlite3 data/db.sqlite < sql/ddl/user_sqlite.sql
sqlite3 data/db.sqlite < sql/ddl/questions_sqlite.sql
sqlite3 data/db.sqlite < sql/ddl/tags_sqlite.sql