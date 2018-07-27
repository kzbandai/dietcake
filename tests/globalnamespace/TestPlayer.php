<?php

class TestPlayer extends Model
{
    public $validation = [
        'name' => [
            'between' => ['validate_between', 3, 16],
        ],
    ];
}
