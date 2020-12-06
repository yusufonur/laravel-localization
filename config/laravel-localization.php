<?php

return [
    "tables" => [
        "languages" => "languages",                                 // Languages
        "language_metas" => "language_metas",                       // Words
        "language_meta_translates" => "language_meta_translates",   // Translate
    ],

    "cache" => [
        "status" => true,
        "prefix" => "lang",
        "tag" => "lang",
        "ttl" => 86400,         // seconds
    ],
];
