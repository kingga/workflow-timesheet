<?php

return [
    'target_php_version' => 7.2,

    'directory_list' => [
        'src',
    ],

    'exclude_analysis_directory_list' => [
        'vendor',
    ],

    'plugins' => [
        'UnreachableCodePlugin',
        'DollarDollarPlugin',
        'DuplicateArrayKeyPlugin',
        'PregRegexCheckerPlugin',
        'PrintfCheckerPlugin',
        'UnknownElementTypePlugin',
        'DuplicateExpressionPlugin',
        'HasPHPDocPlugin',
        'WhitespacePlugin',
        'SuspiciousParamOrderPlugin',
    ],
];
