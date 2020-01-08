<?php

/**
 * Mount the controller onto a mountpoint.
 */
return [
    "routes" => [
        [
            "info" => "Question controller.",
            "mount" => "questions",
            "handler" => "\Elpr\Question\QuestionController",
        ],
    ]
];
