<?php
// Authors: Rick Mercer, Ali Elbekov

include 'DatabaseAdaptor.php';

$theDBA = new DatabaseAdaptor();
$theDBA->startFromScratch();
$arr = $theDBA->getAllQuotations();
assert(empty($arr));  // if one of these fail, Rick's startFromScratch is wrong
$arr = $theDBA->getAllUsers();
assert(empty($arr));

$theDBA->addUser("Sammi", "1234");
$theDBA->addUser("Chris", "abcd");
$theDBA->addUser("Gabriel", "abc123");
$arr = $theDBA->getAllUsers();
assert($arr[0]['username'] === 'Sammi');
assert($arr[0]['id'] == 1);  // Using === can't be used, MariaDB ints are not PHP ints
assert($arr[1]['username'] === 'Chris');
assert($arr[1]['id'] == 2);
assert($arr[2]['username'] === 'Gabriel');
assert($arr[2]['id'] == 3);


assert($theDBA->verifyCredentials('Sammi', '1234'));
assert($theDBA->verifyCredentials('Chris', 'abcd'));
assert($theDBA->verifyCredentials('Gabriel', 'abc123'));
assert(! $theDBA->verifyCredentials('Huh', '1234'));
assert(! $theDBA->verifyCredentials('Sammi', 'xyz'));


$theDBA->addQuote('one', 'A');
$theDBA->addQuote('two', 'B');
$theDBA->addQuote('three', 'C');
$theDBA->addQuote('Hello World', 'Ali Elbekov');
$theDBA->addQuote('Bear Down', 'The University of Arizona');

$arr = $theDBA->getAllQuotations();
assert(count($arr) == 5);
assert($arr[0]['quote'] === 'one');
assert($arr[0]['author'] === 'A');
// Can't use === because SQL ints are not PHP ints
assert($arr[0]['rating'] == 0);   
assert($arr[0]['flagged'] == 0);
assert($arr[1]['quote'] === 'two');
assert($arr[1]['author'] === 'B');
assert($arr[1]['rating'] == 0);
assert($arr[1]['flagged'] == 0);
assert($arr[3]['quote'] === 'Hello World');
assert($arr[3]['author'] === 'Ali Elbekov');
assert($arr[3]['rating'] == 0);
assert($arr[3]['flagged'] == 0);
// No assert tests for NOW() are possible without some more work
?>
