<?php

/**
 * Mount the controller onto a mountpoint.
 */
return [
    "routes" => [
        [
            "info" => "Answer controller.",
            "mount" => "answer",
            "handler" => "\Elpr\Answer\AnswerController",
        ],
    ]
];
