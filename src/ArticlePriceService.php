<?php
namespace Shopingo\ActiveRecord;



class ArticlePriceService extends AbstractService
{

    private static $instance;

    /**
     * @param null $databaseConnection
     *
     * @return ArticlePriceService|void
     * @throws \Exception
     */
    public static function getInstance($databaseConnection = NULL)
    {
        if (! isset(self::$instance)) {
            if (is_null($databaseConnection)) {
                throw new \Exception('No database connection');
            }
            
            self::$instance = new ArticlePriceService($databaseConnection);
        }
        return self::$instance;
    }


    /**
     * Gibt alle ActiveRecords zurück, mit Inhalt der RoleTabelle.
     * Ist die Condition nicht null, werden nur dazu passenden ActiveRecords zurückgegeben.
     *
     * @param array|null $condition
     *
     * @return ResultSet
     */
    public function getAll($condition = null, $sort = null)
    {
        $newObject = new ArticlePriceModel(self::getDatabaseConnection());

        $objectArray = ArticlePriceModel::findAll($condition, $sort);
        return $objectArray;
    }

    /**
     * @param $conditions
     *
     * @return ArticlePriceModel
     */
    public function get($conditions)
    {
        $condition = $conditions;
        
        return $this->newArticlePrice($condition);
    }

    /**
     * Erstellt einen Eintrag
     *
     * @param
     *            $data
     * @throws \Exception
     */
    public function create($data)
    {
        if (! isset($data['article_id'])) {
            throw new \Exception("Error: article_id is required on create.");
        }
        
        $rowObj = $this->newArticlePrice();
        $rowObj = $this->setObjectData($rowObj, $data);
        $rowObj->save();
    }

    /**
     * Editiert einen Eintrag per data Array.
     *
     * @param
     *            $data
     * @throws \Exception
     */
    public function update($data)
    {
        if (! isset($data['id'])) {
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
     * @param
     *            $rowObj
     * @param
     *            $data
     * @return mixed
     */
    private function setObjectData($rowObj, $data)
    {
        
        // loop through all cols of the table and check if new data is avaiable.
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
     * @return ArticlePriceModel
     */
    public function newArticlePrice($condition = NULL)
    {
        $newObject = new ArticlePriceModel(self::getDatabaseConnection());
        
        if ($condition !== null) {
            $object = ArticlePriceModel::find($condition);
            if ($object instanceof ArticlePriceModel) {
                return $object;
            }
            return NULL;
        }
        return $newObject;
    }
}