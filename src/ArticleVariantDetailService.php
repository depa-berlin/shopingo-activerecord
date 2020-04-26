<?php

namespace Shopingo\ActiveRecord;


class ArticleVariantDetailService extends AbstractService
{

    private static $instance;

    /**
     * /**
     * @param null $databaseConnection
     *
     * @return ArticleVariantDetailService
     * @throws \Exception
     */
    public static function getInstance($databaseConnection = NULL)
    {
        if (!isset(self::$instance)) {
            if (is_null($databaseConnection)) {
                throw new \Exception('No database connection');
            }

            self::$instance = new ArticleVariantDetailService($databaseConnection);
        }
        return self::$instance;
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

        $rowObj = $this->newArticleVariantDetail();
        $rowObj = $this->setObjectData($rowObj, $data);

        $rowObj->save();
    }

    /**
     * @param null $condition
     *
     * @return ArticleVariantDetailModel|null
     */
    public function newArticleVariantDetail($condition = NULL)
    {
        $newObject = new ArticleVariantDetailModel(self::getDatabaseConnection());

        if ($condition !== NULL) {
            $object = ArticleVariantDetailModel::find($condition);
            if ($object instanceof ArticleVariantDetailModel) {
                return $object;
            }
            return NULL;
        }
        return $newObject;
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
     * @param null $condition
     * @param null $sort
     *
     * @return \Zend\Db\ResultSet\ResultSet
     */
    public function getAll($condition = null, $sort = null)
    {
        $newObject = new ArticleVariantDetailModel(self::getDatabaseConnection());

        $objectArray = ArticleVariantDetailModel::findAll($condition, $sort);
        return $objectArray;
    }

    /**
     * @param $id
     *
     * @return ArticleVariantDetailModel|null
     */
    public function get($id)
    {
        $condition = [
            'id' => $id,
        ];

        return $this->newArticleVariantDetail($condition);
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
}