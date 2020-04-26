<?php

namespace Shopingo\ActiveRecord;


class ArticleService extends AbstractService
{

    private static $instance;

    /**
     * @param null $databaseConnection
     *
     * @return ArticleService
     * @throws \Exception
     */
    public static function getInstance($databaseConnection = null)
    {
        if (!isset(self::$instance)) {
            if (is_null($databaseConnection)) {
                throw new \Exception('No database connection');
            }

            self::$instance = new ArticleService($databaseConnection);
        }
        return self::$instance;
    }

    /**
     * Gibt alle ActiveRecords zurück, mit Inhalt der RoleTabelle.
     * Ist die Condition nicht null, werden nur dazu passenden ActiveRecords zurückgegeben.
     *
     * @param array|null $condition
     *
     * @return ResultSet || null
     */
    public function getAll($condition = null, $sort = null)
    {
        $newObject = new ArticleModel(self::getDatabaseConnection());

        $objectArray = ArticleModel::findAll($condition, $sort);
        return $objectArray;
    }



    /**
     * Gitb den Namen des (per id) erfragten Records zurück.
     *
     * @param $condition
     *
     * @return ArticleModel
     */
    public function get($condition)
    {

        return $this->newArticle($condition);
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

        $rowObj = $this->newArticle();
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

        if (isset($data['articlenumber'])) {
            $rowObj->articlenumber = $data['articlenumber'];
        }

        if (isset($data['tax_id'])) {
            $rowObj->tax_id = $data['tax_id'];
        }

        if (isset($data['manufacturer_id'])) {
            $rowObj->manufacturer_id = $data['manufacturer_id'];
        }

        if (isset($data['measure'])) {
            $rowObj->measure = $data['measure'];
        }

        if (isset($data['status'])) {
            $rowObj->status = $data['status'];
        }

        if (isset($data['special'])) {
            $rowObj->special = $data['special'];
        }

        if (isset($data['specialsort'])) {
            $rowObj->specialsort = $data['specialsort'];
        }

        if (isset($data['shippingcosts'])) {
            $rowObj->shippingcosts = $data['shippingcosts'];
        }

        if (isset($data['shippingcostsvalue'])) {
            $rowObj->shippingcostsvalue = $data['shippingcostsvalue'];
        }

        if (isset($data['stocknumber'])) {
            $rowObj->stocknumber = $data['stocknumber'];
        }

        if (isset($data['giftpaper'])) {
            $rowObj->giftpaper = $data['giftpaper'];
        }

        if (isset($data['status1'])) {
            $rowObj->status1 = $data['status1'];
        }

        if (isset($data['status2'])) {
            $rowObj->status2 = $data['status2'];
        }

        if (isset($data['baseprice_id'])) {
            $rowObj->baseprice_id = $data['baseprice_id'];
        }

        if (isset($data['baseprice_quantity'])) {
            $rowObj->baseprice_quantity = $data['baseprice_quantity'];
        }

        if (isset($data['articlevarianttype_id'])) {
            $rowObj->articlevarianttype_id = $data['articlevarianttype_id'];
        }

        if (isset($data['search_status'])) {
            $rowObj->search_status = $data['search_status'];
        }

        if (isset($data['noprice_status'])) {
            $rowObj->noprice_status = $data['noprice_status'];
        }

        if (isset($data['date_of_change'])) {
            $rowObj->date_of_change = $data['date_of_change'];
        }

        if (isset($data['valid_status'])) {
            $rowObj->date_of_change = $data['date_of_change'];
        }

        if (isset($data['date_of_validation'])) {
            $rowObj->date_of_validation = $data['date_of_validation'];
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
     * @return ArticleModel
     */
    public function newArticle($condition = null)
    {
        $newObject = new ArticleModel(self::getDatabaseConnection());

        if ($condition !== null) {
            $object = ArticleModel::find($condition);
            if ($object instanceof ArticleModel) {
                return $object;
            }
            return null;
        }
        return $newObject;
    }
}