<?php
foreach ($data as $row):
    echo json_encode($data);
    /*foreach ($row['Subscriber'] as &$cell):
// Escape double quotation marks
        $cell = '"' . preg_replace('/"/', '""', $cell) . '"';
    endforeach;
    echo implode(',', $row['Subscriber']) . "\n";*/
endforeach;