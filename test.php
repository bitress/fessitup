<?php

include './Engine/E.php';
// echo Session::get('shhh');
$arr = array('name' => 'Cyanne',
            'age' => 12);
Session::set('array', $arr);

echo json_encode(Session::get('array'));