<?php

namespace Shopingo\ActiveRecord;


use Depa\ActiveRecord\ActiveRecord;

class ArticleVariantPriceModel extends ActiveRecord
{

    public $tablename = 'mod_shopingo_article_variant_price';

    public $primaryKeys = [
        'articlevariantprice_id',
    ];

    public $attributes = [
        'articlevariantprice_id',
        'articlevariant_id',
        'article_id',
        'quantity',
        'price',
        'pricelist_id',
        'measure',
    ];

    //Lt. ActiveRecord code müssen hier nur die Attribute drin stehen, die des types "required" entsprechen, da nur mit diesen weiter gearbeitet wird.
    public $rules = [
        [
            'attribute' => 'articlevariantprice_id',
            'type' => 'required',
        ],
        [
            'attribute' => 'articlevariant_id',
            'type' => 'required',
        ],
        [
            'attribute' => 'article_id',
            'type' => 'required',
        ],
        [
            'attribute' => 'quantity',
            'type' => 'required',
        ],
    ];

    public function getPrice()
    {
        return floatval($this->price);
    }

}