<?php
namespace Shopingo\ActiveRecord;

use Depa\ActiveRecord\ActiveRecord;

/**
 *
 * @author der Firmen Afghane
 *
 */
class ArticleModel extends ActiveRecord
{
    public $tablename = 'mod_shopingo_article';

    public $primaryKeys = [
        'article_id'
    ];

    public $attributes = [
        'article_id',
        'articlenumber',
        'tax_id',
        'manufacturer_id',
        'measure',
        'status',
        'special',
        'specialsort',
        'shippingcosts',
        'shippingcostsvalue',
        'stocknumber',
        'giftpaper',
        'status1',
        'status2',
        'baseprice_id',
        'baseprice_quantity',
        'articlevarianttype_id',
        'search_status',
        'noprice_status',
        'date_of_change',
        'valid_status',
        'date_of_validation'
    ];

    public $rules = [
        [
            'attribute' => 'article_id',
            'type' => 'required'
        ],
        [
            'attribute' => 'articlenumber',
            'type' => 'required'
        ]
    ];

    /*
     * Array mit Preis-ActiveRecords
     */
    protected $priceArray = array();

    protected $priceCount = Null;

    public $details = array();

    /*
     * Array mit Varianten-ActiveRecords
     */
    protected $variantArray = array();

    protected $variantCount = Null;



    public function save(){
        if(!empty($this->priceArray)){
            array_walk($this->priceArray, function($price){
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

    public function addPrice($conditions){

        $conditions['article_id'] = $this->article_id;
        print_r($conditions);
        ServiceManager::getInstance()->getArticlePriceService()->create($conditions);
    }

    

    /**
     * @param $conditions
     *
     * @return ArticlePriceModel
     * @throws \Exception
     */
    public function getPrice($conditions){
        if($this->hasPrice()){
            foreach ($this->priceArray as $price){
                if($price->quantity == $conditions['quantity']){
                    return $price;
                }
            }
        }

        $conditions['article_id'] = $this->article_id;
        $price = ServiceManager::getInstance()->getArticlePriceService()->get($conditions);
        return $price;
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
            $priceService = ServiceManager::getInstance()->getArticlePriceService();
            $this->priceArray = $priceService->getAll(['article_id' => $this->article_id], 'quantity ASC');
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

    /**
     * @param $articleId
     * @param $key
     *
     * @return array|ResultSet
     * @throws \Exception
     */
    public function getAllDetails() //($languageId, $key)
    {

        if(!empty($this->details)){
            return $this->details;
        }
        $detailService = ServiceManager::getInstance()->getArticleDetailService();
        $this->details = $detailService->getAll(['article_id' => $this->article_id]);
        return $this->details;
        /*if (! isset($this->properties['detail'][$languageId][$key]))
        {
            $this->properties['detail'] = $this->articleFunctions->getArticleDetail($this->articleId);
            $this->statusUpdate = true;
        }
        if (! isset($this->properties['detail'][$languageId][$key]))
        {
            return '';
        }
        return $this->properties['detail'][$languageId][$key];*/
    }

    /**
     * Gibt alles Varianten-ActiveRecords in einem Array zurück
     *
     * @return array
     * @throws \Exception
     */
    public function getAllVariants()
    {
        if(is_null($this->variantCount)){
            $variantService = ServiceManager::getInstance()->getArticleVariantService();
            $this->variantArray = $variantService->getAll(['article_id' => $this->article_id]);
            $this->variantCount = count($this->variantArray);
        }
        return $this->variantArray;
    }

    /**
     * Wenn Varianten existieren dann true, wenn keine existieren, dann false
     *
     * @return bool
     * @throws \Exception
     */
    public function hasVariant()
    {
        if (is_null($this->getVariantCount()))
        {
            $this->getAllVariants();
        }
        if($this->getVariantCount() > 0)
        {
            return true;
        }
        return false;
    }

    /**
     * Gibt Anzahl der Varianten zurück
     *
     * @return int
     * @throws \Exception
     */
    public function getVariantCount(){
        if (is_null($this->variantCount))
        {
            $this->getAllVariants();
        }
        return $this->variantCount;
    }

    /**
     * Gibt alle Varianten in einer Collection zurück
     *
     * @return $variantCollection
     */
    public function getVariantCollection()
    {
        //..
    }

    /**
     * Gibt eine bestimmte Variante zurück
     *
     * @param $variantId
     * @return
     */
    public function getVariant ($variantId)
    {
        //return ...;
    }

    /**
     * Gibt den NoPrice-Status eines Artikels zurück
     *
     * Ein Artikel mit Status 1 wird vom Shop so behandelt, als ob er keinen Preis besitzt und z.B. eine Preisanfrage erfolgen soll.
     * Solch ein Artikel kann nicht dem Warenkorb oder einer Merkliste hinzugefügt werden.
     * Die Darstellung eines solchen Artikels muss im Shoplayout erfragt werden (andere Preisdarstellung)...
     *
     * @return boolean
     */
    public function getNoPriceStatus()
    {
        if(! isset($this->properties['noprice_status']))
        {
            $requestpriceStatus = 0;
            if ($this->getData('noprice_status') == 1)
            {
                $requestpriceStatus = 1;
            }
            $this->properties['noprice_status'] = $requestpriceStatus;
            $this->statusUpdate = true;
        }
        return $this->properties['noprice_status'];
    }

}