<?php
$c=file_get_contents('resources/views/parent/dashboard.blade.php');
preg_match('/<script>(.*?)<\/script>/s', $c, $m);
file_put_contents('test.js', str_replace(['@json($students)', '@json($children)', '@json($schedules)', '@if', '@endif', '($children->isNotEmpty())'], ['[]', '[]', '[]', '//', '//', ''], $m[1]));
system('node -c test.js');
