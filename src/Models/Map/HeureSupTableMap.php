<?php

namespace App\Models\Map;

use App\Models\HeureSup;
use App\Models\HeureSupQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'heure_sup' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class HeureSupTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.HeureSupTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'heure_sup';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\App\\Models\\HeureSup';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'HeureSup';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 7;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 7;

    /**
     * the column name for the heure_sup_id field
     */
    const COL_HEURE_SUP_ID = 'heure_sup.heure_sup_id';

    /**
     * the column name for the employe_id field
     */
    const COL_EMPLOYE_ID = 'heure_sup.employe_id';

    /**
     * the column name for the date_heure_sup field
     */
    const COL_DATE_HEURE_SUP = 'heure_sup.date_heure_sup';

    /**
     * the column name for the heure_entree field
     */
    const COL_HEURE_ENTREE = 'heure_sup.heure_entree';

    /**
     * the column name for the heure_sortie field
     */
    const COL_HEURE_SORTIE = 'heure_sup.heure_sortie';

    /**
     * the column name for the heure_travail field
     */
    const COL_HEURE_TRAVAIL = 'heure_sup.heure_travail';

    /**
     * the column name for the heure_supp field
     */
    const COL_HEURE_SUPP = 'heure_sup.heure_supp';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('HeureSupId', 'EmployeId', 'DateHeureSup', 'HeureEntree', 'HeureSortie', 'HeureTravail', 'HeureSupp', ),
        self::TYPE_CAMELNAME     => array('heureSupId', 'employeId', 'dateHeureSup', 'heureEntree', 'heureSortie', 'heureTravail', 'heureSupp', ),
        self::TYPE_COLNAME       => array(HeureSupTableMap::COL_HEURE_SUP_ID, HeureSupTableMap::COL_EMPLOYE_ID, HeureSupTableMap::COL_DATE_HEURE_SUP, HeureSupTableMap::COL_HEURE_ENTREE, HeureSupTableMap::COL_HEURE_SORTIE, HeureSupTableMap::COL_HEURE_TRAVAIL, HeureSupTableMap::COL_HEURE_SUPP, ),
        self::TYPE_FIELDNAME     => array('heure_sup_id', 'employe_id', 'date_heure_sup', 'heure_entree', 'heure_sortie', 'heure_travail', 'heure_supp', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('HeureSupId' => 0, 'EmployeId' => 1, 'DateHeureSup' => 2, 'HeureEntree' => 3, 'HeureSortie' => 4, 'HeureTravail' => 5, 'HeureSupp' => 6, ),
        self::TYPE_CAMELNAME     => array('heureSupId' => 0, 'employeId' => 1, 'dateHeureSup' => 2, 'heureEntree' => 3, 'heureSortie' => 4, 'heureTravail' => 5, 'heureSupp' => 6, ),
        self::TYPE_COLNAME       => array(HeureSupTableMap::COL_HEURE_SUP_ID => 0, HeureSupTableMap::COL_EMPLOYE_ID => 1, HeureSupTableMap::COL_DATE_HEURE_SUP => 2, HeureSupTableMap::COL_HEURE_ENTREE => 3, HeureSupTableMap::COL_HEURE_SORTIE => 4, HeureSupTableMap::COL_HEURE_TRAVAIL => 5, HeureSupTableMap::COL_HEURE_SUPP => 6, ),
        self::TYPE_FIELDNAME     => array('heure_sup_id' => 0, 'employe_id' => 1, 'date_heure_sup' => 2, 'heure_entree' => 3, 'heure_sortie' => 4, 'heure_travail' => 5, 'heure_supp' => 6, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('heure_sup');
        $this->setPhpName('HeureSup');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\App\\Models\\HeureSup');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('heure_sup_id', 'HeureSupId', 'INTEGER', true, null, null);
        $this->addColumn('employe_id', 'EmployeId', 'INTEGER', true, null, null);
        $this->addColumn('date_heure_sup', 'DateHeureSup', 'DATE', true, null, null);
        $this->addColumn('heure_entree', 'HeureEntree', 'TIME', true, null, null);
        $this->addColumn('heure_sortie', 'HeureSortie', 'TIME', true, null, null);
        $this->addColumn('heure_travail', 'HeureTravail', 'TIME', true, null, null);
        $this->addColumn('heure_supp', 'HeureSupp', 'TIME', true, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
    } // buildRelations()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('HeureSupId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('HeureSupId', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('HeureSupId', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('HeureSupId', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('HeureSupId', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('HeureSupId', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('HeureSupId', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? HeureSupTableMap::CLASS_DEFAULT : HeureSupTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (HeureSup object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = HeureSupTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = HeureSupTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + HeureSupTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = HeureSupTableMap::OM_CLASS;
            /** @var HeureSup $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            HeureSupTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = HeureSupTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = HeureSupTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var HeureSup $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                HeureSupTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(HeureSupTableMap::COL_HEURE_SUP_ID);
            $criteria->addSelectColumn(HeureSupTableMap::COL_EMPLOYE_ID);
            $criteria->addSelectColumn(HeureSupTableMap::COL_DATE_HEURE_SUP);
            $criteria->addSelectColumn(HeureSupTableMap::COL_HEURE_ENTREE);
            $criteria->addSelectColumn(HeureSupTableMap::COL_HEURE_SORTIE);
            $criteria->addSelectColumn(HeureSupTableMap::COL_HEURE_TRAVAIL);
            $criteria->addSelectColumn(HeureSupTableMap::COL_HEURE_SUPP);
        } else {
            $criteria->addSelectColumn($alias . '.heure_sup_id');
            $criteria->addSelectColumn($alias . '.employe_id');
            $criteria->addSelectColumn($alias . '.date_heure_sup');
            $criteria->addSelectColumn($alias . '.heure_entree');
            $criteria->addSelectColumn($alias . '.heure_sortie');
            $criteria->addSelectColumn($alias . '.heure_travail');
            $criteria->addSelectColumn($alias . '.heure_supp');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(HeureSupTableMap::DATABASE_NAME)->getTable(HeureSupTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(HeureSupTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(HeureSupTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new HeureSupTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a HeureSup or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or HeureSup object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(HeureSupTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \App\Models\HeureSup) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(HeureSupTableMap::DATABASE_NAME);
            $criteria->add(HeureSupTableMap::COL_HEURE_SUP_ID, (array) $values, Criteria::IN);
        }

        $query = HeureSupQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            HeureSupTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                HeureSupTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the heure_sup table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return HeureSupQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a HeureSup or Criteria object.
     *
     * @param mixed               $criteria Criteria or HeureSup object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(HeureSupTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from HeureSup object
        }

        if ($criteria->containsKey(HeureSupTableMap::COL_HEURE_SUP_ID) && $criteria->keyContainsValue(HeureSupTableMap::COL_HEURE_SUP_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.HeureSupTableMap::COL_HEURE_SUP_ID.')');
        }


        // Set the correct dbName
        $query = HeureSupQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // HeureSupTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
HeureSupTableMap::buildTableMap();
