# CWS Apartment Finder Demo

The purpose of this simple demo project is to help me phamiliarize myself with
the PHP and the Phalcon framework.

The goal of the project is to create a simple website that allows one to select
one of the [CWS apartment complexes](http://www.cwsapartments.com/apartments/locations), and then see apartments available within
that complex.

## Installation

Setup should be pretty easy.

1. Create the database and setup tables using /config/schema.sql

    mysql -uroot -p < config/schema.sql

2. Make a copy of config/local.template.php and fill in details

    cp config/local.template.php config/local.php
    vim config/local.php

3. Setup the default appartment complexes using:

    php cli.php complex update


