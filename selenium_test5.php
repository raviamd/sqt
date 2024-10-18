<?php
require 'vendor/autoload.php';

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\WebDriverBy;

// Connect directly to ChromeDriver
$serverUrl = 'http://localhost:54696/';

$capabilities = DesiredCapabilities::chrome();
$driver = RemoteWebDriver::create($serverUrl, $capabilities);

// Navigate to Google
$driver->get('https://www.google.com');

// Perform search
$searchBox = $driver->findElement(WebDriverBy::name('q'));
$searchBox->sendKeys('Selenium WebDriver with PHP');
$searchBox->submit();

// Wait and close the browser
sleep(5);
$driver->quit();
?>
