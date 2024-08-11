<?php
$appointments = [
    [
        'id' => 1,
        'title' => 'B',
        'description' => 'Description 1',
        'address' => '123',
        'date' => date('Y-m-d'),
        'time' => date('H:i')
    ],
    [
        'id' => 2,
        'title' => 'A',
        'description' => 'Description 2',
        'address' => '456',
        'date' => date('Y-m-d', strtotime('+1 day')),
        'time' => date('H:i', strtotime('+1 hour'))
    ]
];

echo '<ul id="appointment-list">';
foreach ($appointments as $appointment) {
    echo '<li data-title="' . $appointment['title'] . '" data-date="' . $appointment['date'] . '">';
    echo $appointment['title'] . ' - ' . $appointment['description'] . ' - ' . $appointment['address'] . ' - ' . $appointment['date'] . ' at ' . $appointment['time'];
    echo '</li>';
}
echo '</ul>';
?>
