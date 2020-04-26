<?php

namespace Shopingo\ActiveRecord;


class ArticleVariantPriceService extends AbstractService
{

    private static $instance;

    /**
     * @param null $databaseConnection
     *
     * @return ArticleVariantPriceService|void
     * @throws \Exception
     */
    public static function getInstance($databaseConnection = NULL)
    {
        if (!isset(self::$instance)) {
            if (is_null($databaseConnection)) {
                throw new \Exception('No database connection');
            }

            self::$instance = new ArticleVariantPriceService($databaseConnection);
        }
        return self::$instance;
    }

    /**
     * @param $id
     *
     * @return \Core\Model\ActiveRecord\Ambigous|ArticleVariantPriceModel|null
     */
    public function get($id)
    {
        $condition = [
            'id' => $id,
        ];

        return $this->newArticleVariantPrice($condition);
    }

    /**
     * @param null $condition
     * @param null $sort
     *
     * @return \Zend\Db\ResultSet\ResultSet
     */
    public function getAll($condition = null, $sort = null)
    {
        $newObject = new ArticleVariantPriceModel(self::getDatabaseConnection());

        $objectArray = ArticleVariantPriceModel::findAll($condition, $sort);
        return $objectArray;
    }

    /**
     * Erstellt einen Eintrag
     *
     * @param $data
     *
     * @throws \Exception
     */
    public function create($data)
    {
        if (!isset($data['name'])) {
            throw new \Exception("Error: name is required on create.");
        }

        $rowObj = $this->newArticleVariantPrice();
        $rowObj = $this->setObjectData($rowObj, $data);

        $rowObj->save();
    }

    /**
     * Editiert einen Eintrag per data Array.
     *
     * @param $data
     *
     * @throws \Exception
     */
    public function update($data)
    {

        if (!isset($data['id'])) {
            throw new \Exception("Error: id is required on update.");
        }
        $rowObj = $this->get($data['id']);
        $rowObj = $this->setObjectData($rowObj, $data);

        $rowObj->save();
    }

    /**
     * @param $id
     *
     * @throws \Exception
     */
    public function delete($id)
    {

        $rowObj = $this->get($id);
        if (is_null($rowObj)) {
            throw new \Exception("row with id " . $id . " didn't exist.");
        }
        $rowObj->delete();
    }

    /**
     * Setzt die Informationen der einzelnen Spalten
     *
     * @param $rowObj
     * @param $data
     *
     * @return mixed
     */
    private function setObjectData($rowObj, $data)
    {

        //loop through all cols of the table and check if new data is avaiable.
        foreach ($rowObj->attributes as $attribute) {
            if (isset($data[$attribute])) {
                $rowObj->{$attribute} = $data[$attribute];
            }
        }

        return $rowObj;
    }

    /**
     * @param null $condition
     *
     * @return \Core\Model\ActiveRecord\Ambigous|ArticleVariantPriceModel|null
     */
    public function newArticleVariantPrice($condition = NULL)
    {
        $newObject = new ArticleVariantPriceModel(self::getDatabaseConnection());

        if ($condition !== NULL) {
            $object = ArticleVariantPriceModel::find($condition);
            if ($object instanceof ArticleVariantPriceModel) {
                return $object;
            }
            return NULL;
        }
        return $newObject;
    }
}