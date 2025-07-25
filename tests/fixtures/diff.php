<?php

return [
    [
        'key' => 'common',
        'status' => 'nested',
        'children' => [
            [
                'key' => 'follow',
                'status' => 'added',
                'value' => false,
            ],
            [
                'key' => 'setting1',
                'status' => 'unchanged',
                'value' => 'Value 1',
            ],
            [
                'key' => 'setting2',
                'status' => 'removed',
                'value' => 200,
            ],
            [
                'key' => 'setting3',
                'status' => 'changed',
                'oldValue' => true,
                'newValue' => null,
            ],
            [
                'key' => 'setting4',
                'status' => 'added',
                'value' => 'blah blah',
            ],
            [
                'key' => 'setting5',
                'status' => 'added',
                'value' => [
                    'key5' => 'value5',
                ],
            ],
            [
                'key' => 'setting6',
                'status' => 'nested',
                'children' => [
                    [
                        'key' => 'doge',
                        'status' => 'nested',
                        'children' => [
                            [
                                'key' => 'wow',
                                'status' => 'changed',
                                'oldValue' => '',
                                'newValue' => 'so much',
                            ],
                        ],
                    ],
                    [
                        'key' => 'key',
                        'status' => 'unchanged',
                        'value' => 'value',
                    ],
                    [
                        'key' => 'ops',
                        'status' => 'added',
                        'value' => 'vops',
                    ],
                ],
            ],
        ],
    ],
    [
        'key' => 'group1',
        'status' => 'nested',
        'children' => [
            [
                'key' => 'baz',
                'status' => 'changed',
                'oldValue' => 'bas',
                'newValue' => 'bars',
            ],
            [
                'key' => 'foo',
                'status' => 'unchanged',
                'value' => 'bar',
            ],
            [
                'key' => 'nest',
                'status' => 'changed',
                'oldValue' => [
                    'key' => 'value',
                ],
                'newValue' => 'str',
            ],
        ],
    ],
    [
        'key' => 'group2',
        'status' => 'removed',
        'value' => [
            'abc' => 12345,
            'deep' => [
                'id' => 45,
            ],
        ],
    ],
    [
        'key' => 'group3',
        'status' => 'added',
        'value' => [
            'deep' => [
                'id' => [
                    'number' => 45,
                ],
            ],
            'fee' => 100500,
        ],
    ],
];
