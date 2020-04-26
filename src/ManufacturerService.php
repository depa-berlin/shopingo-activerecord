<?php

namespace Shopingo\ActiveRecord;


class ManufacturerService extends AbstractService
{

    private static $instance;

    /**
     * @param null $databaseConnection
     *
     * @return ManufacturerService
     * @throws \Exception
     */
    public static function getInstance($databaseConnection = null)
    {
        if (! isset(self::$instance)) {
            if (is_null($databaseConnection)) {
                throw new \Exception('No database connection');
            }

            self::$instance = new ManufacturerService($databaseConnection);
        }
        return self::$instance;
    }

    /**
     * @param null $condition
     * @param null $sort
     *
     * @return \Zend\Db\ResultSet\ResultSet
     */
    public function getAll($condition = null, $sort = null)
    {
        $newObject = new ManufacturerModel(self::getDatabaseConnection());

        $objectArray = ManufacturerModel::findAll($condition, $sort);
        return $objectArray;
    }

    /**
     * @param $id
     *
     * @return ManufacturerModel
     */
    public function get($id)
    {
        $condition = [
            'id' => $id
        ];

        return $this->newManufacturer($condition);
    }

    /**
     * Erstellt einen Eintrag
     *
     * @param $data
     * @throws \Exception
     */
    public function create($data)
    {

        if (!isset($data['name'])) {
            throw new \Exception("Error: name is required on create.");
        }

        if (!isset($data['contraction'])) {
            throw new \Exception("Error: contraction is required on create.");
        }

        $rowObj = $this->newManufacturer();
        $rowObj = $this->setObjectData($rowObj, $data);

        $rowObj->save();
    }

    /**
     * Editiert einen Eintrag per data Array.
     *
     * @param $data
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
     * @return mixed
     */
    private function setObjectData($rowObj, $data)
    {

        if (isset($data['name'])) {
            $rowObj->name = $data['name'];
        }

        if (isset($data['abbrevation'])) {
            $rowObj->abbrevation = $data['abbrevation'];
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
     * @return ManufacturerModel
     */
    public function newManufacturer($condition = null)
    {
        $newObject = new ManufacturerModel(self::getDatabaseConnection());

        if ($condition !== null) {
            $object = ManufacturerModel::find($condition);
            if ($object instanceof ManufacturerModel) {
                return $object;
            }
            return null;
        }
        return $newObject;
    }
}