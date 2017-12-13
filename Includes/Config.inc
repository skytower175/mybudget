<?php

/**
 * This is the config file.
 * The environmental variables should be pulled out
 * of Heroku (or similar service), though this will
 * set them for local dev, etc.
 */

if (getenv('DB_HOST') == false)
    putenv('DB_HOST=us-cdbr-iron-east-04.cleardb.net');

if (getenv('DB_NAME') == false)
    putenv('DB_NAME=heroku_66554147defa056');

if (getenv('DB_USER') == false)
    putenv('DB_USER=bfdd12c04539a7');

if (getenv('DB_PASS') == false)
    putenv('DB_PASS=328dbc06');

if (getenv('SITE_LOC') == false)
    putenv('SITE_LOC=Queensland');

?>
