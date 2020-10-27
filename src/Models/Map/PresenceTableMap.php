<?php

namespace App\Models\Map;

use App\Models\Presence;
use App\Models\PresenceQuery;
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
 * This class defines the structure of the 'presence' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class PresenceTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.PresenceTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'presence';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\App\\Models\\Presence';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Presence';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 6;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 6;

    /**
     * the column name for the presence_id field
     */
    const COL_PRESENCE_ID = 'presence.presence_id';

    /**
     * the column name for the employe_id field
     */
    const COL_EMPLOYE_ID = 'presence.employe_id';

    /**
     * the column name for the date_presence field
     */
    const COL_DATE_PRESENCE = 'presence.date_presence';

    /**
     * the column name for the heure_arrive field
     */
    const COL_HEURE_ARRIVE = 'presence.heure_arrive';

    /**
     * the column name for the heure_sortie field
     */
    const COL_HEURE_SORTIE = 'presence.heure_sortie';

    /**
     * the column name for the heure_travail field
     */
    const COL_HEURE_TRAVAIL = 'presence.heure_travail';

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
        self::TYPE_PHPNAME       => array('PresenceId', 'EmployeId', 'DatePresence', 'HeureArrive', 'HeureSortie', 'HeureTravail', ),
        self::TYPE_CAMELNAME     => array('presenceId', 'employeId', 'datePresence', 'heureArrive', 'heureSortie', 'heureTravail', ),
        self::TYPE_COLNAME       => array(PresenceTableMap::COL_PRESENCE_ID, PresenceTableMap::COL_EMPLOYE_ID, PresenceTableMap::COL_DATE_PRESENCE, PresenceTableMap::COL_HEURE_ARRIVE, PresenceTableMap::COL_HEURE_SORTIE, PresenceTableMap::COL_HEURE_TRAVAIL, ),
        self::TYPE_FIELDNAME     => array('presence_id', 'employe_id', 'date_presence', 'heure_arrive', 'heure_sortie', 'heure_travail', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('PresenceId' => 0, 'EmployeId' => 1, 'DatePresence' => 2, 'HeureArrive' => 3, 'HeureSortie' => 4, 'HeureTravail' => 5, ),
        self::TYPE_CAMELNAME     => array('presenceId' => 0, 'employeId' => 1, 'datePresence' => 2, 'heureArrive' => 3, 'heureSortie' => 4, 'heureTravail' => 5, ),
        self::TYPE_COLNAME       => array(PresenceTableMap::COL_PRESENCE_ID => 0, PresenceTableMap::COL_EMPLOYE_ID => 1, PresenceTableMap::COL_DATE_PRESENCE => 2, PresenceTableMap::COL_HEURE_ARRIVE => 3, PresenceTableMap::COL_HEURE_SORTIE => 4, PresenceTableMap::COL_HEURE_TRAVAIL => 5, ),
        self::TYPE_FIELDNAME     => array('presence_id' => 0, 'employe_id' => 1, 'date_presence' => 2, 'heure_arrive' => 3, 'heure_sortie' => 4, 'heure_travail' => 5, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
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
        $this->setName('presence');
        $this->setPhpName('Presence');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\App\\Models\\Presence');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('presence_id', 'PresenceId', 'INTEGER', true, null, null);
        $this->addForeignKey('employe_id', 'EmployeId', 'INTEGER', 'employe', 'employe_id', true, null, null);
        $this->addColumn('date_presence', 'DatePresence', 'DATE', true, null, null);
        $this->addColumn('heure_arrive', 'HeureArrive', 'TIME', true, null, null);
        $this->addColumn('heure_sortie', 'HeureSortie', 'TIME', true, null, null);
        $this->addColumn('heure_travail', 'HeureTravail', 'TIME', true, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Employe', '\\App\\Models\\Employe', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':employe_id',
    1 => ':employe_id',
  ),
), 'CASCADE', null, null, false);
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PresenceId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PresenceId', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PresenceId', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PresenceId', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PresenceId', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PresenceId', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('PresenceId', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? PresenceTableMap::CLASS_DEFAULT : PresenceTableMap::OM_CLASS;
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
     * @return array           (Presence object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = PresenceTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = PresenceTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + PresenceTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PresenceTableMap::OM_CLASS;
            /** @var Presence $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            PresenceTableMap::addInstanceToPool($obj, $key);
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
            $key = PresenceTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = PresenceTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Presence $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                PresenceTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(PresenceTableMap::COL_PRESENCE_ID);
            $criteria->addSelectColumn(PresenceTableMap::COL_EMPLOYE_ID);
            $criteria->addSelectColumn(PresenceTableMap::COL_DATE_PRESENCE);
            $criteria->addSelectColumn(PresenceTableMap::COL_HEURE_ARRIVE);
            $criteria->addSelectColumn(PresenceTableMap::COL_HEURE_SORTIE);
            $criteria->addSelectColumn(PresenceTableMap::COL_HEURE_TRAVAIL);
        } else {
            $criteria->addSelectColumn($alias . '.presence_id');
            $criteria->addSelectColumn($alias . '.employe_id');
            $criteria->addSelectColumn($alias . '.date_presence');
            $criteria->addSelectColumn($alias . '.heure_arrive');
            $criteria->addSelectColumn($alias . '.heure_sortie');
            $criteria->addSelectColumn($alias . '.heure_travail');
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
        return Propel::getServiceContainer()->getDatabaseMap(PresenceTableMap::DATABASE_NAME)->getTable(PresenceTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(PresenceTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(PresenceTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new PresenceTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Presence or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Presence object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(PresenceTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \App\Models\Presence) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PresenceTableMap::DATABASE_NAME);
            $criteria->add(PresenceTableMap::COL_PRESENCE_ID, (array) $values, Criteria::IN);
        }

        $query = PresenceQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            PresenceTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                PresenceTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the presence table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return PresenceQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Presence or Criteria object.
     *
     * @param mixed               $criteria Criteria or Presence object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PresenceTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Presence object
        }

        if ($criteria->containsKey(PresenceTableMap::COL_PRESENCE_ID) && $criteria->keyContainsValue(PresenceTableMap::COL_PRESENCE_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.PresenceTableMap::COL_PRESENCE_ID.')');
        }


        // Set the correct dbName
        $query = PresenceQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // PresenceTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
PresenceTableMap::buildTableMap();
