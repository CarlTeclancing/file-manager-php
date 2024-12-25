<?php
// Get the raw input data
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Validate input
if (!$data) {
    echo json_encode(['error' => 'Invalid input']);
    exit;
}

$requiredFields = ['name', 'description', 'status', 'time_allocation', 'type'];
foreach ($requiredFields as $field) {
    if (!isset($data[$field]) || empty($data[$field])) {
        echo json_encode(['error' => "Missing or empty field: $field"]);
        exit;
    }
}

// Load existing projects
$projectsFilePath = '../db/projects.json';
if (!file_exists($projectsFilePath) || !filesize($projectsFilePath)) {
    file_put_contents($projectsFilePath, '[]');
}

$projects = json_decode(file_get_contents($projectsFilePath), true) ?: [];

// Assign a unique ID
$data['id'] = count($projects) ? max(array_column($projects, 'id')) + 1 : 1;

// Add to the list
$projects[] = $data;

// Save back to the file
if (file_put_contents($projectsFilePath, json_encode($projects, JSON_PRETTY_PRINT))) {
    echo json_encode(['success' => true, 'project' => $data]);
} else {
    echo json_encode(['error' => 'Failed to save project']);
}
?>
