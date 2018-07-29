<?php

class TestPlayer extends \DietCook\Model
{
    public $validation = [
        'name' => [
            'between' => ['validate_between', 3, 16],
        ],
    ];
}
