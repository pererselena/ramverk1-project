# ramverk1-project
[![Build Status](https://travis-ci.org/pererselena/ramverk1-project.svg?branch=master)](https://travis-ci.org/pererselena/ramverk1-project)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/pererselena/ramverk1-project/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/pererselena/ramverk1-project/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/pererselena/ramverk1-project/badges/build.png?b=master)](https://scrutinizer-ci.com/g/pererselena/ramverk1-project/build-status/master)


Table of content
------------------------------------

* [Clone](#Clone)
* [Dependency](#Dependency)
* [Install](#Install)
* [Database](#Database)
* [License](#License)



Clone
------------------------------------

This is how you clone your own version from GitHub.


```
git clone https://github.com/pererselena/ramverk1-project.git
```


Dependency
------------------

Note that the following php extentions and sqlite3 needs to be installed on your system.

* PHP-7.2
* PHP-XML
* PHP-gd
* PHP-mbstring



Install
------------------------------------

This is how you install and configure your environment.

Install using composer.

```
cd ramverk1-project
composer install
make install
chmod 777 cache/*
chmod 777 data
```


Database
------------------

This project is using sqlite database, run the following command.

```
bash setup_db.bash
```

License
------------------

This software carries a MIT license. See [LICENSE.txt](LICENSE.txt) for details.



```
 .  
..:  Copyright (c) 2020 Elena Perers
```

