<?php

require_once('vendor/autoload.php');

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;

try {
    // Selenium Server URL (for local use, typically 'http://localhost:62685/wd/hub')
    $serverUrl = 'http://127.0.0.1:58187/';
    
    // Initialize the Chrome driver (you can choose other browsers as well)
    $driver = RemoteWebDriver::create($serverUrl, Facebook\WebDriver\Remote\DesiredCapabilities::chrome());

    // Navigate to the login page
    $driver->get('https://profile.w3schools.com/login');  // Replace with the target login page URL

    // Wait until the page is loaded
    $driver->wait()->until(
        WebDriverExpectedCondition::titleContains('Log in - W3Schools')
    );

    // Find the username/email input field and enter the username
    $driver->findElement(WebDriverBy::name('email'))->sendKeys('divyabora2@gmail.com'); // Adjust field name

    // Find the password input field and enter the password
    $driver->findElement(WebDriverBy::name('password'))->sendKeys('Passwd@123'); // Adjust field name

    // Click the login button
     $driver->findElement(WebDriverBy::cssSelector('button.LoginForm_login_button__B4Ksc'))->click();


    // Wait until the success message is visible
    $driver->wait()->until(
        WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::cssSelector('p.chakra-text.css-pkxz41'))
    );

    // Get the text of the success message
    $successMessage = $driver->findElement(WebDriverBy::cssSelector('p.chakra-text.css-pkxz41'))->getText();
    
    // Assert if the success message contains the expected text
    if (strpos($successMessage, 'Start your Pathfinder journey') !== false) {
        echo "Login successful, success message: " . $successMessage . "\n";
    } else {
        throw new Exception('Login successful but message is incorrect.');
    }

} catch (Exception $e) {
    echo 'Test failed: ' . $e->getMessage();
} finally {
    // Close the browser
    if (isset($driver)) {
        $driver->quit();
    }
}

