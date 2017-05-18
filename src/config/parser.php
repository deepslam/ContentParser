<?php
return [
    "clean_code" => true,//Clean code from different styles, classes etc.
    "strip_tags" => true,//Strip tags?
    "allowed_tags" => [//List of the allowed tags
        '<br>',
        '<p>',
        '<a>',
        '<ul>',
        '<ol>',
        '<li>',
        '<i>',
        '<b>',
        '<strong>',
        '<img>',
        '<span>',
        '<pre>',
        '<code>',
        '<table>',
        '<tr>',
        '<th>',
        '<td>',
        '<tbody>',
        '<thead>',
        '<tfoot>',
        '<h1>',
        '<h2>',
        '<h3>',
        '<h4>',
        '<h5>',
        '<h6>',
    ],
    "parsers" => [
        'mercury' => \Deepslam\ContentParser\ContentParserMercury::class,
        'graby' => \Deepslam\ContentParser\ContentParserGraby::class,
    ]
];
?>