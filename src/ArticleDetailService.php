<?php
namespace Shopingo\ActiveRecord;


class ArticleDetailService extends AbstractService
{

    private static $instance;

    /**
     * @param null $databaseConnection
     *
     * @return ArticleDetailService|void
     * @throws \Exception
     */
    public static function getInstance($databaseConnection = NULL)
    {
        if (! isset(self::$instance)) {
            if (is_null($databaseConnection)) {
                throw new \Exception('No database connection');
            }
            
            self::$instance = new ArticleDetailService($databaseConnection);
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
        $newObject = new ArticleDetailModel(self::getDatabaseConnection());

        $objectArray = ArticleDetailModel::findAll($condition, $sort);
        return $objectArray;
    }

    /**
     * @param $id
     *
     * @return ArticleDetailModel
     */
    public function get($id)
    {
        $condition = array(
            'article_id' => $id
        );
        
        return $this->newArticleDetail($condition);
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
        if (! isset($data['name'])) {
            throw new \Exception("Error: name is required on create.");
        }
        
        $rowObj = $this->newArticleDetail();
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
        if (! isset($data['article_id'])) {
            throw new \Exception("Error: article_id is required on update.");
        }
        $rowObj = $this->get($data['article_id']);
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
    public function setObjectData($rowObj, $data)
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
     * @return ArticleDetailModel
     */
    public function newArticleDetail($condition = NULL)
    {
        $newObject = new ArticleDetailModel(self::getDatabaseConnection());
        
        if ($condition !== null) {
            $object = ArticleDetailModel::find($condition);
            if ($object instanceof ArticleDetailModel) {
                return $object;
            }
            return NULL;
        }
        return $newObject;
    }
}