<?php
require_once('vendor/autoload.php');

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;

// URL of the Selenium WebDriver server
$serverUrl = 'http://127.0.0.1:43823';

// Create an instance of Chrome WebDriver
$driver = RemoteWebDriver::create($serverUrl, \Facebook\WebDriver\Remote\DesiredCapabilities::chrome());

// Load the target web page
$driver->get("C:\Rollno11\marksheet.html");  // Replace with your desired URL

// Wait for the table to be present
$driver->wait(10)->until(
    WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::xpath('//table'))
);

// Find all unique elements on the page
$allElements = $driver->findElements(WebDriverBy::xpath('//*'));

// Initialize an array to keep track of unique elements
$uniqueElements = [];

// Loop through each element
foreach ($allElements as $element) {
    $tagName = $element->getTagName();  // Get the tag name

    // If the tag name is not already in the uniqueElements array, add it
    if (!isset($uniqueElements[$tagName])) {
        $uniqueElements[$tagName] = 1;  // Initialize the count
    } else {
        $uniqueElements[$tagName]++;  // Increment the count
    }
}

// Output the total unique elements
echo "Unique elements and their counts:\n";
foreach ($uniqueElements as $tag => $count) {
    echo "$tag: $count\n";
}

// Close the browser session
$driver->quit();