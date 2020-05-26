<?php
namespace Shopingo\ActiveRecord;

use Depa\ActiveRecord\ActiveRecord;

class ArticlePriceModel extends ActiveRecord
{

    public $tablename = 'mod_shopingo_article_price';

    public $primaryKeys = [
        'price_id'
    ];

    public $attributes = [
        'price_id',
        'article_id',
        'quantity',
        'price',
        'pricelist_id'
    ];

    // Lt. ActiveRecord code müssen hier nur die Attribute drin stehen, die des types "required" entsprechen, da nur mit diesen weiter gearbeitet wird.
    public $rules = [
        [
            'attribute' => 'price_id',
            'type' => 'required'
        ],
        [
            'attribute' => 'article_id',
            'type' => 'required'
        ],
        [
            'attribute' => 'quantity',
            'type' => 'required'
        ],
        [
            'attribute' => 'price',
            'type' => 'required'
        ],
        [
            'attribute' => 'pricelist_id',
            'type' => 'required'
        ]
    ];

    public function getPrice()
    {
        return floatval($this->price);
    }
}