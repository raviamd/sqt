<?php
// Autoload the Composer dependencies
require_once 'vendor/autoload.php';

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;

try {
    // Define the WebDriver host and browser capabilities
    $host = 'http://localhost:3081'; // Selenium server address
    $capabilities = DesiredCapabilities::chrome(); // You can use Firefox or other browsers

    // Create a new instance of the WebDriver (Chrome in this case)
    $driver = RemoteWebDriver::create($host, $capabilities);

    // Navigate to the HTML page with the dropdown (use local or remote URL)
    $driver->get('file:///C:/stqa/ListBox.html'); // Replace with the actual file path or URL

    // Locate the dropdown element by its ID
    $dropdown = $driver->findElement(WebDriverBy::id('ListBox-id'));

    // Get all the <option> elements within the <select> dropdown
    $options = $dropdown->findElements(WebDriverBy::tagName('option'));

    // Count the number of options
    $numOptions = count($options);

    // Print the number of items in the dropdown
    echo "The ListBox contains $numOptions items.\n";

    // Close the browser session
    $driver->quit();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
