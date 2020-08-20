<?php

namespace App\Models\Map;

use App\Models\Utilisateur;
use App\Models\UtilisateurQuery;
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
 * This class defines the structure of the 'utilisateur' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class UtilisateurTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.UtilisateurTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'utilisateur';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\App\\Models\\Utilisateur';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Utilisateur';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 8;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 8;

    /**
     * the column name for the utilisateur_id field
     */
    const COL_UTILISATEUR_ID = 'utilisateur.utilisateur_id';

    /**
     * the column name for the mail field
     */
    const COL_MAIL = 'utilisateur.mail';

    /**
     * the column name for the pass field
     */
    const COL_PASS = 'utilisateur.pass';

    /**
     * the column name for the name field
     */
    const COL_NAME = 'utilisateur.name';

    /**
     * the column name for the surname field
     */
    const COL_SURNAME = 'utilisateur.surname';

    /**
     * the column name for the status field
     */
    const COL_STATUS = 'utilisateur.status';

    /**
     * the column name for the last_login field
     */
    const COL_LAST_LOGIN = 'utilisateur.last_login';

    /**
     * the column name for the email_activation_key field
     */
    const COL_EMAIL_ACTIVATION_KEY = 'utilisateur.email_activation_key';

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
        self::TYPE_PHPNAME       => array('UtilisateurId', 'Mail', 'Pass', 'Name', 'Surname', 'Status', 'LastLogin', 'EmailActivationKey', ),
        self::TYPE_CAMELNAME     => array('utilisateurId', 'mail', 'pass', 'name', 'surname', 'status', 'lastLogin', 'emailActivationKey', ),
        self::TYPE_COLNAME       => array(UtilisateurTableMap::COL_UTILISATEUR_ID, UtilisateurTableMap::COL_MAIL, UtilisateurTableMap::COL_PASS, UtilisateurTableMap::COL_NAME, UtilisateurTableMap::COL_SURNAME, UtilisateurTableMap::COL_STATUS, UtilisateurTableMap::COL_LAST_LOGIN, UtilisateurTableMap::COL_EMAIL_ACTIVATION_KEY, ),
        self::TYPE_FIELDNAME     => array('utilisateur_id', 'mail', 'pass', 'name', 'surname', 'status', 'last_login', 'email_activation_key', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('UtilisateurId' => 0, 'Mail' => 1, 'Pass' => 2, 'Name' => 3, 'Surname' => 4, 'Status' => 5, 'LastLogin' => 6, 'EmailActivationKey' => 7, ),
        self::TYPE_CAMELNAME     => array('utilisateurId' => 0, 'mail' => 1, 'pass' => 2, 'name' => 3, 'surname' => 4, 'status' => 5, 'lastLogin' => 6, 'emailActivationKey' => 7, ),
        self::TYPE_COLNAME       => array(UtilisateurTableMap::COL_UTILISATEUR_ID => 0, UtilisateurTableMap::COL_MAIL => 1, UtilisateurTableMap::COL_PASS => 2, UtilisateurTableMap::COL_NAME => 3, UtilisateurTableMap::COL_SURNAME => 4, UtilisateurTableMap::COL_STATUS => 5, UtilisateurTableMap::COL_LAST_LOGIN => 6, UtilisateurTableMap::COL_EMAIL_ACTIVATION_KEY => 7, ),
        self::TYPE_FIELDNAME     => array('utilisateur_id' => 0, 'mail' => 1, 'pass' => 2, 'name' => 3, 'surname' => 4, 'status' => 5, 'last_login' => 6, 'email_activation_key' => 7, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
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
        $this->setName('utilisateur');
        $this->setPhpName('Utilisateur');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\App\\Models\\Utilisateur');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('utilisateur_id', 'UtilisateurId', 'INTEGER', true, null, null);
        $this->addColumn('mail', 'Mail', 'VARCHAR', true, 100, null);
        $this->addColumn('pass', 'Pass', 'VARCHAR', true, 255, null);
        $this->addColumn('name', 'Name', 'VARCHAR', false, 200, null);
        $this->addColumn('surname', 'Surname', 'VARCHAR', false, 200, null);
        $this->addColumn('status', 'Status', 'INTEGER', true, null, 0);
        $this->addColumn('last_login', 'LastLogin', 'TIMESTAMP', false, null, null);
        $this->addColumn('email_activation_key', 'EmailActivationKey', 'VARCHAR', false, 200, null);
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('UtilisateurId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('UtilisateurId', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('UtilisateurId', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('UtilisateurId', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('UtilisateurId', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('UtilisateurId', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('UtilisateurId', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? UtilisateurTableMap::CLASS_DEFAULT : UtilisateurTableMap::OM_CLASS;
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
     * @return array           (Utilisateur object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = UtilisateurTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = UtilisateurTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + UtilisateurTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = UtilisateurTableMap::OM_CLASS;
            /** @var Utilisateur $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            UtilisateurTableMap::addInstanceToPool($obj, $key);
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
            $key = UtilisateurTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = UtilisateurTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Utilisateur $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                UtilisateurTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(UtilisateurTableMap::COL_UTILISATEUR_ID);
            $criteria->addSelectColumn(UtilisateurTableMap::COL_MAIL);
            $criteria->addSelectColumn(UtilisateurTableMap::COL_PASS);
            $criteria->addSelectColumn(UtilisateurTableMap::COL_NAME);
            $criteria->addSelectColumn(UtilisateurTableMap::COL_SURNAME);
            $criteria->addSelectColumn(UtilisateurTableMap::COL_STATUS);
            $criteria->addSelectColumn(UtilisateurTableMap::COL_LAST_LOGIN);
            $criteria->addSelectColumn(UtilisateurTableMap::COL_EMAIL_ACTIVATION_KEY);
        } else {
            $criteria->addSelectColumn($alias . '.utilisateur_id');
            $criteria->addSelectColumn($alias . '.mail');
            $criteria->addSelectColumn($alias . '.pass');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.surname');
            $criteria->addSelectColumn($alias . '.status');
            $criteria->addSelectColumn($alias . '.last_login');
            $criteria->addSelectColumn($alias . '.email_activation_key');
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
        return Propel::getServiceContainer()->getDatabaseMap(UtilisateurTableMap::DATABASE_NAME)->getTable(UtilisateurTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(UtilisateurTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(UtilisateurTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new UtilisateurTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Utilisateur or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Utilisateur object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(UtilisateurTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \App\Models\Utilisateur) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(UtilisateurTableMap::DATABASE_NAME);
            $criteria->add(UtilisateurTableMap::COL_UTILISATEUR_ID, (array) $values, Criteria::IN);
        }

        $query = UtilisateurQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            UtilisateurTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                UtilisateurTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the utilisateur table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return UtilisateurQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Utilisateur or Criteria object.
     *
     * @param mixed               $criteria Criteria or Utilisateur object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UtilisateurTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Utilisateur object
        }

        if ($criteria->containsKey(UtilisateurTableMap::COL_UTILISATEUR_ID) && $criteria->keyContainsValue(UtilisateurTableMap::COL_UTILISATEUR_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.UtilisateurTableMap::COL_UTILISATEUR_ID.')');
        }


        // Set the correct dbName
        $query = UtilisateurQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // UtilisateurTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
UtilisateurTableMap::buildTableMap();
