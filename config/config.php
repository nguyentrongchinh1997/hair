<?php

return [
    'employee' => [
        'type' => [
            'skinner' => 2, // nhân viên gội
            'stylist' => 1, // nhân viên cắt
        ],
        'status' => [
            'leave' => 0,
            'doing' => 1,
        ],
    ],
    'service' => [
        'cut' => 1,
        'wash' => 2,
    ],
    'order' => [
        'status' => [
            'create' => 0,
            'check-in' => 1,
            'check-out' => 2,
            'cancel' => -1,
        ],
    ],
    'rate' => [
        'type' => [
            'substract' => 0,
            'plus' => 1,
        ],
        'level' => [
            'rate1' => 'Tệ',
            'rate2' => 'Được',
            'rate3' => 'Rất hài lòng',
        ],
        'star' => [
            'rate1' => 1,
            'rate2' => 2,
            'rate3' => 3,
        ]
    ],
    'request' => [
        'yes' => 1,
        'no' => 0,
    ],
    'card' => [
        'hoi_vien' => 0,
        'so_lan' => 1,
    ],
    'full' => 27,
];
