<?php
// Make sure the request is coming from netti.ca!
if ($_SERVER['HTTP_HOST']=="netti.ca")
{
    // Database information.
    $db_server = 'localhost';
    $db_name = '';
    $db_user = '';
    $db_pass = '';

    // Global site settings.
    $version = 0.10;
    $mailer = "From: noreply@netti.ca";
    $maintenance = 0;
    $maintenance_msg = 'Nettica is down for maintenance. Check back soon.';
    $register = 1;

    // Game settings
    $kb_rate = 900; // seconds between each new kb
    $kb_max = 100; // kb limit before bandw
    $rowsPerPage = 15; // posts per page in forum

    // Don't change these without authorization from Bran. It *will* destroy the entire website if you do.
    $maxtextarealength = 4950; // Emails and forum posts are limited to 5000 characters.
    $maxbiolength = 450; // User bios and item descriptions are limited to 500 characters.

} else {
    die("Hacking attempt...");
}
?>
