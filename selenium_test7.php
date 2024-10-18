<?php
require_once('vendor/autoload.php'); // Include the Composer autoloader

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;

// URL of the Selenium Server (make sure Selenium and ChromeDriver are running)
$serverUrl = 'http://127.0.0.1:53865';

// Start a Chrome browser session using the RemoteWebDriver
$driver = RemoteWebDriver::create($serverUrl, \Facebook\WebDriver\Remote\DesiredCapabilities::chrome());

// Set an implicit wait of 30 seconds (global wait for element search)
$driver->manage()->timeouts()->implicitlyWait(30);

// Open the webpage containing the student marks table
$driver->get("C:\Users\HP\OneDrive\Documents\Practicals\STQA PRAC\marksheet.html");  // replace with your file URL or path


// echo $driver->getPageSource();die;

// Wait until the table is fully loaded
$driver->wait(30)->until(
    WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::xpath('//table/tbody/tr'))
);

// Find all student rows
$tableRows = $driver->findElements(WebDriverBy::xpath('//table/tbody/tr'));

// Initialize counts
$studentsWithMarksAbove60InAnySubject = 0;
$studentsWithMarksAbove60InAllSubjects = 0;

// Loop through each student (each row)
foreach ($tableRows as $row) {
    // Extract all the marks from the row (English, Maths, Science, etc.)
    $marks = $row->findElements(WebDriverBy::xpath('./td[position() >= 3 and position() <= 7]'));

    // Check if the student has marks greater than 60 in any subject
    $above60InAnySubject = false;
    $allAbove60InAllSubjects = true;

    foreach ($marks as $mark) {
        $markValue = intval($mark->getText());  // Convert text to integer

        // Check for any subject > 60
        if ($markValue > 60) {
            $above60InAnySubject = true;
        }

        // Check if all subjects > 60
        if ($markValue <= 60) {
            $allAbove60InAllSubjects = false;  // If any mark is ≤ 60, this student doesn't qualify for all subjects
        }
    }

    // Increment for students who scored > 60 in any subject
    if ($above60InAnySubject) {
        $studentsWithMarksAbove60InAnySubject++;
    }

    // Increment for students who scored > 60 in all subjects
    if ($allAbove60InAllSubjects) {
        $studentsWithMarksAbove60InAllSubjects++;
    }
}

// Output the result
echo "Number of students who scored more than 60 in at least one subject: $studentsWithMarksAbove60InAnySubject\n";
echo "Number of students who scored more than 60 in all subjects: $studentsWithMarksAbove60InAllSubjects\n";

// Close the browser session
$driver->quit();