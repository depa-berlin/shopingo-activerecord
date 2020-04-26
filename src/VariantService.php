<?php

namespace Shopingo\ActiveRecord;


class VariantService extends AbstractService
{

    private static $instance;

    /**
     * @param null $databaseConnection
     *
     * @return VariantService|void
     * @throws \Exception
     */
    public static function getInstance($databaseConnection = null)
    {
        if (!isset(self::$instance)) {
            if (is_null($databaseConnection)) {
                throw new \Exception('No database connection');
            }

            self::$instance = new VariantService($databaseConnection);
        }
        return self::$instance;
    }

    /**
     * Gibt alle ActiveRecords zurück, mit Inhalt der RoleTabelle.
     * Ist die Condition nicht null, werden nur dazu passenden ActiveRecords zurückgegeben.
     *
     * @param array|null $condition
     *
     * @return $objectArray
     */
    public function getAll($condition = null, $sort = null)
    {
        $newObject = new VariantModel(self::getDatabaseConnection());

        $objectArray = VariantModel::findAll($condition, $sort);
        return $objectArray;
    }

    /**
     * Gitb den Namen des (per id) erfragten Records zurück.
     *
     * @param unknown $name
     *
     * @return VariantModel
     */
    public function get($condition)
    {

        return $this->newArticleVariant($condition);
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

        if (!isset($data['articlenumber'])) {
            throw new \Exception("Error: articlenumber is required on create.");
        }

        $rowObj = $this->newArticleVariant();
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

        if (!isset($data['article_id'])) {
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
     * @param $rowObj
     * @param $data
     *
     * @return mixed
     */
    private function setObjectData($rowObj, $data)
    {

        if (isset($data['articlevariant_id'])) {
            $rowObj->articlevariant_id = $data['articlevariant_id'];
        }

        if (isset($data['article_id'])) {
            $rowObj->article_id = $data['article_id'];
        }

        if (isset($data['sort'])) {
            $rowObj->sort = $data['sort'];
        }

        if (isset($data['status'])) {
            $rowObj->status = $data['status'];
        }

        if (isset($data['special'])) {
            $rowObj->special = $data['special'];
        }

        if (isset($data['articlenumber'])) {
            $rowObj->articlenumber = $data['articlenumber'];
        }

        return $rowObj;

    }

    /**
     * Liefert ein neues User-Objekt oder ein User-Objekt anhand einer Condition
     *
     * Wird entsprechend der Condition kein Datensatz gefunden, wird NULL zurückgegeben
     * Wird keine Condition übergeben, wird ein neues Objekt zurückgegeben
     *
     * @param string|array|null $condition ID als String oder ein konkretes Condition-Array
     *
     * @return VariantModel
     */
    public function newArticleVariant($condition = null)
    {
        $newObject = new VariantModel(self::getDatabaseConnection());

        if ($condition !== null) {
            $object = VariantModel::find($condition);
            if ($object instanceof VariantModel) {
                return $object;
            }
            return null;
        }
        return $newObject;
    }
}