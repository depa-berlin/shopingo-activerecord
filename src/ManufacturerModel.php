<?php
namespace Shopingo\ActiveRecord;

use Depa\ActiveRecord\ActiveRecord;

/**
 *
 * @author der Firmen Afghane
 *
 */
class ManufacturerModel extends ActiveRecord
{
    public $tablename = 'manufacturer_portal';

    public $primaryKeys = [
        'id'
    ];

    public $attributes = [
        'id',
        'name',
        'abbrevation'
    ];

    public $rules = [
        [
            'attribute' => 'id',
            'type' => 'required'
        ],
        [
            'attribute' => 'name',
            'type' => 'required'
        ],
        [
            'attribute' => 'abbrevation',
            'type' => 'required'
        ]
    ];
}

