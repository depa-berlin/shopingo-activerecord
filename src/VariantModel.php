<?php
namespace Shopingo\ActiveRecord;

use Depa\ActiveRecord\ActiveRecord;

/**
 *
 * @author der Firmen Afghane
 *
 */
class VariantModel extends ActiveRecord
{
    public $tablename = 'mod_shopingo_article_variant';

    public $primaryKeys = [
        'articlevariant_id'
    ];

    public $attributes = [
        'articlevariant_id',
        'article_id',
        'sort',
        'status',
        'special',
        'articlenumber',
        'status1', //Sprechstundenbedarf 1/0
        'text1' //Pharmazentralnummer
    ];

    public $rules = [
        [
            'attribute' => 'articlevariant_id',
            'type' => 'required'
        ]
    ];

    protected $priceArray = array();

    protected $priceCount = Null;

    public $details = array();


    public function save(){
        if(!empty($this->prices)){
            array_walk($this->prices, function($price){
                $price->save();
            });
        }
        /*if(!empty($this->details)){
            array_walk($this->details, function($detail){
                $detail->save();
            });
        }*/
        parent::save();
    }

    /**
     * Gibt alles Preis-ActiveRecords in einem Array zurück
     *
     * @return array|ResultSet
     * @throws \Exception
     */
    public function getAllPrices()
    {
        if(is_null($this->priceCount)){
            $priceService = ServiceManager::getInstance()->getArticleVariantPriceService();
            $this->priceArray = $priceService->getAll(['articlevariant_id' => $this->articlevariant_id], 'quantity ASC');
            $this->priceCount = count($this->priceArray);
        }
        return $this->priceArray;
    }

    /**
     * Wenn Preise Existieren, true - sonst false.
     *
     * @return bool
     * @throws \Exception
     */
    public function hasPrice(){
        if (is_null($this->getPriceCount()))
        {
            $this->getAllPrices();
        }
        if($this->getPriceCount() > 0)
        {
            return true;
        }
        return false;
    }

    /**
     * Gibt anzahl der Preise zurück.
     *
     * @return |null
     * @throws \Exception
     */
    public function getPriceCount(){
        if (is_null($this->priceCount))
        {
            $this->getAllPrices();
        }
        return $this->priceCount;
    }

    public function getAllDetails(){

        if(!empty($this->details)){
            return $this->details;
        }

        $detailService = ServiceManager::getInstance()->getArticleVariantDetailService();
        $this->details = $detailService->getAll(['articlevariant_id' => $this->articlevariant_id]);
        return $this->details;
    }
}

