<?php

namespace Shopingo\ActiveRecord;

class ServiceManager
{

    private $dbAdapter;

    private static $instance;

    public function __construct($dbAdapter)
    {
       $this->dbAdapter = $dbAdapter;
    }

    public static function getInstance($dbAdapter = null){

        if (!isset(self::$instance)) {
            if (is_null($dbAdapter)) {
                throw new \Exception('No database connection');
            }
            self::$instance = new ServiceManager($dbAdapter);
        }
        return self::$instance;
    }

    public function getArticleService(){
        
        return ArticleService::getInstance($this->dbAdapter);

    }

    public function getArticlePriceService(){

        return ArticlePriceService::getInstance($this->dbAdapter);

    }

    public function getArticleDetailService(){

        return ArticleDetailService::getInstance($this->dbAdapter);

    }

    public function getArticleVariantService(){

        return VariantService::getInstance($this->dbAdapter);

    }

    public function getManufacturerService(){

        return ManufacturerService::getInstance($this->dbAdapter);

    }

    public function getArticleVariantPriceService(){

      return ArticleVariantPriceService::getInstance($this->dbAdapter);

    }

    public function getArticleVariantDetailService(){

        return ArticleVariantDetailService::getInstance($this->dbAdapter);

    }

    public function getQueueService(){

        return \ShopProductUpdate\Model\ImportData\Service::getInstance($this->dbAdapter);

    }
}