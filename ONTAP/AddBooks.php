<?php
// Assuming $conn is your MySQLi connection object
$tableName = "user";
$data = array(
    'Name' => 'Tiếng Việt',
    'Password' => 200,    
);

// Call the insertData function
insertData($conn, $tableName, $data);