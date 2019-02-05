<?php

/*
 * Data Object
 * https://github.com/ivopetkov/data-object
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

require __DIR__ . '/vendor/autoload.php';

$docsGenerator = new IvoPetkov\DocsGenerator(__DIR__);
$docsGenerator->addSourceDir('/src');
$options = [
    'showPrivate' => false,
    'showProtected' => true
];
$docsGenerator->generateMarkdown(__DIR__ . '/docs/markdown', $options);
