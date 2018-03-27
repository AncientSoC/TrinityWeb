<?php
return [
    '<_c:[\w\-]+>/<_a:[\w\-]+>/<id:\d+>' => '<_c>/<_a>',
    '<cid:\d+>/<server:[^\/]+>/<query:[^\/]+>' => 'main/index',
    //'<server:[^\/]+>/<query:[^\/]+>' => 'main/index',
    '<cid:\d+>' => 'main/index',
    '' => 'main/index',
];