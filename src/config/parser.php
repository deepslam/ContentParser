<?php
return [
    "clean_code" => true,
    "parsers" => [
        'mercury' => \Deepslam\ContentParser\ContentParserMercury::class,
        'graby' => \Deepslam\ContentParser\ContentParserGraby::class,
    ]
];
?>