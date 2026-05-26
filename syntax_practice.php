<?php
// SmartQueue - PHP Syntax Practice

// 1. Variables and Data Types
$systemName = "SmartQueue"; // String
$version = 1.0; // Float
$isActive = true; // Boolean
$maxCapacity = 100; // Integer

echo "<h2>Welcome to $systemName v$version</h2>";

// 2. Arrays
$queueList = array("Alice", "Bob", "Charlie", "Diana");
echo "<p>Current people in queue: " . count($queueList) . "</p>";

// 3. Conditional Statements (if-else)
if ($isActive) {
    echo "<p>Status: The queue system is currently active.</p>";
} else {
    echo "<p>Status: The queue system is offline.</p>";
}

// 4. Loops (Foreach and For)
echo "<h3>Queue Roster:</h3>";
echo "<ul>";
foreach ($queueList as $index => $person) {
    $position = $index + 1;
    echo "<li>Position $position: $person</li>";
}
echo "</ul>";

// 5. Functions
function calculateEstimatedWaitTime($peopleAhead, $timePerPerson = 5) {
    return $peopleAhead * $timePerPerson;
}

$testPerson = "Alice";
$waitTime = calculateEstimatedWaitTime(3); // Alice has 3 people ahead conceptually for this example
echo "<p>Estimated wait time for new arrival: $waitTime minutes.</p>";

?>
