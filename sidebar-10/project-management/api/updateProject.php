
<?php
$data = json_decode(file_get_contents('php://input'), true);
$projects = json_decode(file_get_contents('../db/projects.json'), true);

foreach ($projects as &$project) {
    if ($project['id'] == $data['id']) {
        $project = $data;
        break;
    }
}

file_put_contents('../db/projects.json', json_encode($projects, JSON_PRETTY_PRINT));
?>
    