
<?php
$data = json_decode(file_get_contents('php://input'), true);
$projects = json_decode(file_get_contents('../db/projects.json'), true);

$data['id'] = count($projects) ? max(array_column($projects, 'id')) + 1 : 1;
$projects[] = $data;

file_put_contents('../db/projects.json', json_encode($projects, JSON_PRETTY_PRINT));
?>
    