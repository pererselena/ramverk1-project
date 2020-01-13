<?php

/**
 * Supply the basis for the navbar as an array.
 */

global $di;

$session = $di->get("session");

$items = [
    [
        "text" => "Home",
        "url" => "",
        "title" => "Home page.",
    ],
    [
        "text" => "About",
        "url" => "about",
        "title" => "About this webpage.",
    ],
    [
        "text" => "Tags",
        "url" => "tags",
        "title" => "Search tags.",
    ],
    [
        "text" => "Questions",
        "url" => "questions",
        "title" => "Forum questions",
    ],
    [
        "text" => "Users",
        "url" => "user",
        "title" => "View all users",
    ],
];

if ($session->has("userEmail")) {
    array_push($items, [
        "text" => "Profile",
        "url" => "user/profile",
        "title" => "View users profile",
        "class" => "nav-login nav-left",
    ], [
        "text" => "Logout",
        "url" => "user/logout",
        "title" => "Logout",
        "class" => "nav-login",
    ]);
} else {
    array_push($items, [
        "text" => "Register",
        "url" => "user/register",
        "title" => "Register user",
        "class" => "nav-login nav-left",
    ], [
        "text" => "Login",
        "url" => "user/login",
        "title" => "Login",
        "class" => "nav-login",
    ]);
}

return [
    // Use for styling the menu
    "wrapper" => null,
    "class" => "my-navbar rm-default rm-desktop",

    // Here comes the menu items
    "items" => $items
];
