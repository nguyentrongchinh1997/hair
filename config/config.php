<?php

return [
    'employee' => [
        'type' => [
            'skinner' => 0, // nhân viên gội
            'stylist' => 1, // nhân viên cắt
        ],
        'status' => [
            'leave' => 0,
            'doing' => 1,
        ],
    ],
    'order' => [
        'status' => [
            'create' => 0,
            'check-in' => 1,
            'check-out' => 2,
        ],
    ],
];