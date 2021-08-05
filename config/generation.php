<?php

use Codeat3\BladeIconGeneration\Exceptions\InvalidFileExtensionException;
use Codeat3\BladeIconGeneration\IconProcessor;

$svgNormalization = static function (string $tempFilepath, array $iconSet) {

    // perform generic optimizations
    try {
        $iconProcessor = new IconProcessor($tempFilepath, $iconSet);
        $iconProcessor
            ->optimize()
            ->save(filenameCallable: function ($filename, $file) {
                return str_replace('-plain', '', $filename);
            });
    }catch (InvalidFileExtensionException $ife)   {
        unlink($tempFilepath);
    }
};

return [
    [
        // Define a source directory for the sets like a node_modules/ or vendor/ directory...
        'source' => __DIR__.'/../dist/icons/*/',

        // Define a destination directory for your icons. The below is a good default...
        'destination' => __DIR__.'/../resources/svg',

        // Enable "safe" mode which will prevent deletion of old icons...
        'safe' => false,

        // Call an optional callback to manipulate the icon
        // with the pathname of the icon and the settings from above...
        'after' => $svgNormalization,

        'is-solid' => true,

        'blacklisted-ext' => [
            'eps'
        ],

        'whitelisted-pattern' => [
            '.*plain\.svg',
        ]
    ],
];
