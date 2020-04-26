<?php
namespace Shopingo\ActiveRecord;

use Depa\ActiveRecord\ActiveRecord;

class ArticleDetailModel extends ActiveRecord
{

    public $tablename = 'mod_shopingo_article_detail';

    public $primaryKeys = [
        'articledetail_id'
    ];

    public $attributes = [
        'articledetail_id',
        'article_id',
        'language_id',
        'article',
        'text1',
        'text2',
        'text3',
        'text4',
        'text5',
        'text6',
        'text7',
        'text8',
        'text9',
        'keywords',
        'meta_keywords',
        'meta_title',
        'meta_description'
    ];

    // Lt. ActiveRecord code müssen hier nur die Attribute drin stehen, die des types "required" entsprechen, da nur mit diesen weiter gearbeitet wird.
    public $rules = [
        [
            'attribute' => 'articledetail_id',
            'type' => 'required'
        ],
        [
            'attribute' => 'article_id',
            'type' => 'required'
        ]
    ];
}