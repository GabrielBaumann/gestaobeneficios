<?php

/**
 * DATABASE
 */

define("CONF_DB_HOST", "localhost");
define("CONF_DB_USER", "root");
define("CONF_DB_PASS", "");
define("CONF_DB_NAME", "managment");
define("CONF_DB_NAME2", "db_office");

/**
 * PROJECT URLs
 */
define("CONF_URL_BASE", "https://teste.syscerberus.com");
define("CONF_URL_TEST", "http://localhost/gestaobeneficios");

/**
 * DATES
 */
define("CONF_DATE_BR", "d/m/Y H:i:s");

/**
 * MESSAGE
 */

define("CONF_MESSAGE_ERROR", "");
define("CONF_MESSAGE_WARNING", "");
define("CONF_MESSAGE_SUCCESS", "");
define("CONF_MESSAGE_BUTTON", "");
define("CONF_MESSAGE_LOAD", "");


/**
 * VIEW
*/
define("CONF_VIEW_PATH", __DIR__ . "/../../themes");
define("CONF_VIEW_EXT", "php");
define("CONF_VIEW_THEME", "managmentweb");
define("CONF_VIEW_APP", "managment");

/**
 * MAIL
 */
define("CONF_MAIL_HOST", "mail.syscerberus.com");
define("CONF_MAIL_PORT", "465");
define("CONF_MAIL_USER", "testeemail@syscerberus.com");
define("CONF_MAIL_PASS","1900@@25081900");
define("CONF_MAIL_SENDER", ["name" => "SysCerberus", "address" => "testeemail@syscerberus.com"]);
define("CONF_MAIL_OPTION_LANG", "br");
define("CONF_MAIL_OPTION_HTML", true);
define("CONF_MAIL_OPTION_AUTH", true);
define("CONF_MAIL_OPTION_CHARSET", "utf-8");

/**
 * UPLOAD
 */
define("CONF_UPLOAD_DIR", "storage/uploads");
define("CONF_UPLOAD_IMAGE_DIR", "images");
define("CONF_UPLOAD_FILE_DIR", "files");
define("CONF_UPLOAD_MEDIA_DIR", "medias");

/**
 * IMAGES
 */
define("CONF_IMAGE_CACHE", CONF_UPLOAD_DIR . "/" . CONF_UPLOAD_IMAGE_DIR . "/cache");
define("CONF_IMAGE_SIZE", 2000);
define("CONF_IMAGE_QUALITY", ["jpg" => 75, "png" => 5]);