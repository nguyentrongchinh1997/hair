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
        ],
    ],
    'rate' => [
        'type' => [
            'substract' => 0,
            'plus' => 1,
        ],
    ]
];