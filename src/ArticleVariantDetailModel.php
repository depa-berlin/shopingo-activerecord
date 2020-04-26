<?php

namespace Shopingo\ActiveRecord;


use Depa\ActiveRecord\ActiveRecord;

class ArticleVariantDetailModel extends ActiveRecord
{

    public $tablename = 'mod_shopingo_article_variant_detail';

    public $primaryKeys = [
        'articlevariantdetail_id',
    ];

    public $attributes = [
        'articlevariantdetail_id',
        'articlevariant_id',
        'article_id',
        'language_id',
        'variant',
        'variant_specification',
        'description',
    ];

    //Lt. ActiveRecord code müssen hier nur die Attribute drin stehen, die des types "required" entsprechen, da nur mit diesen weiter gearbeitet wird.
    public $rules = [
        [
            'attribute' => 'articlevariantdetail_id',
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
            'attribute' => 'variant',
            'type' => 'required',
        ],
        [
            'attribute' => 'variant_specification',
            'type' => 'required',
        ],
    ];

}