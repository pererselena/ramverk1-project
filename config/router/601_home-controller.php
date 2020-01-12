<?php

/**
 * Mount the controller onto a mountpoint.
 */
return [
    "routes" => [
        [
            "info" => "Start page controller.",
            "mount" => "/",
            "handler" => "\Elpr\Home\HomeController",
        ],
    ]
];
