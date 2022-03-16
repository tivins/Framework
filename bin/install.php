<?php

var_dump($argv[0]);

function askQuestion(string $question): string {
    return readline($question." ");
}
$answer = askQuestion("Are you at the root of the project? (y/n)");
if (strtolower($answer) !== 'y') {
    exit("Go to the root of project and run the installer again.\n");
}

var_dump($answer);
