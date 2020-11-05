<?php

namespace App\Models\Map;

use App\Models\Employe;
use App\Models\EmployeQuery;
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
 * This class defines the structure of the 'employe' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class EmployeTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.EmployeTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'employe';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\App\\Models\\Employe';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Employe';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 9;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 9;

    /**
     * the column name for the employe_id field
     */
    const COL_EMPLOYE_ID = 'employe.employe_id';

    /**
     * the column name for the ref_interne field
     */
    const COL_REF_INTERNE = 'employe.ref_interne';

    /**
     * the column name for the unite_id field
     */
    const COL_UNITE_ID = 'employe.unite_id';

    /**
     * the column name for the nom_prenom field
     */
    const COL_NOM_PRENOM = 'employe.nom_prenom';

    /**
     * the column name for the poste field
     */
    const COL_POSTE = 'employe.poste';

    /**
     * the column name for the genre field
     */
    const COL_GENRE = 'employe.genre';

    /**
     * the column name for the date_embauche field
     */
    const COL_DATE_EMBAUCHE = 'employe.date_embauche';

    /**
     * the column name for the present field
     */
    const COL_PRESENT = 'employe.present';

    /**
     * the column name for the status field
     */
    const COL_STATUS = 'employe.status';

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
        self::TYPE_PHPNAME       => array('EmployeId', 'RefInterne', 'UniteId', 'NomPrenom', 'Poste', 'Genre', 'DateEmbauche', 'Present', 'Status', ),
        self::TYPE_CAMELNAME     => array('employeId', 'refInterne', 'uniteId', 'nomPrenom', 'poste', 'genre', 'dateEmbauche', 'present', 'status', ),
        self::TYPE_COLNAME       => array(EmployeTableMap::COL_EMPLOYE_ID, EmployeTableMap::COL_REF_INTERNE, EmployeTableMap::COL_UNITE_ID, EmployeTableMap::COL_NOM_PRENOM, EmployeTableMap::COL_POSTE, EmployeTableMap::COL_GENRE, EmployeTableMap::COL_DATE_EMBAUCHE, EmployeTableMap::COL_PRESENT, EmployeTableMap::COL_STATUS, ),
        self::TYPE_FIELDNAME     => array('employe_id', 'ref_interne', 'unite_id', 'nom_prenom', 'poste', 'genre', 'date_embauche', 'present', 'status', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('EmployeId' => 0, 'RefInterne' => 1, 'UniteId' => 2, 'NomPrenom' => 3, 'Poste' => 4, 'Genre' => 5, 'DateEmbauche' => 6, 'Present' => 7, 'Status' => 8, ),
        self::TYPE_CAMELNAME     => array('employeId' => 0, 'refInterne' => 1, 'uniteId' => 2, 'nomPrenom' => 3, 'poste' => 4, 'genre' => 5, 'dateEmbauche' => 6, 'present' => 7, 'status' => 8, ),
        self::TYPE_COLNAME       => array(EmployeTableMap::COL_EMPLOYE_ID => 0, EmployeTableMap::COL_REF_INTERNE => 1, EmployeTableMap::COL_UNITE_ID => 2, EmployeTableMap::COL_NOM_PRENOM => 3, EmployeTableMap::COL_POSTE => 4, EmployeTableMap::COL_GENRE => 5, EmployeTableMap::COL_DATE_EMBAUCHE => 6, EmployeTableMap::COL_PRESENT => 7, EmployeTableMap::COL_STATUS => 8, ),
        self::TYPE_FIELDNAME     => array('employe_id' => 0, 'ref_interne' => 1, 'unite_id' => 2, 'nom_prenom' => 3, 'poste' => 4, 'genre' => 5, 'date_embauche' => 6, 'present' => 7, 'status' => 8, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, )
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
        $this->setName('employe');
        $this->setPhpName('Employe');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\App\\Models\\Employe');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('employe_id', 'EmployeId', 'INTEGER', true, null, null);
        $this->addColumn('ref_interne', 'RefInterne', 'INTEGER', false, null, null);
        $this->addForeignKey('unite_id', 'UniteId', 'INTEGER', 'unite', 'unite_id', false, null, null);
        $this->addColumn('nom_prenom', 'NomPrenom', 'VARCHAR', false, 100, null);
        $this->addColumn('poste', 'Poste', 'VARCHAR', false, 100, null);
        $this->addColumn('genre', 'Genre', 'VARCHAR', false, 40, null);
        $this->addColumn('date_embauche', 'DateEmbauche', 'DATE', false, null, null);
        $this->addColumn('present', 'Present', 'INTEGER', false, null, 1);
        $this->addColumn('status', 'Status', 'INTEGER', true, null, 1);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Unite', '\\App\\Models\\Unite', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':unite_id',
    1 => ':unite_id',
  ),
), null, null, null, false);
        $this->addRelation('Absence', '\\App\\Models\\Absence', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':employe_id',
    1 => ':employe_id',
  ),
), 'CASCADE', null, 'Absences', false);
        $this->addRelation('Conge', '\\App\\Models\\Conge', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':employe_id',
    1 => ':employe_id',
  ),
), 'CASCADE', null, 'Conges', false);
        $this->addRelation('HeureSup', '\\App\\Models\\HeureSup', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':employe_id',
    1 => ':employe_id',
  ),
), 'CASCADE', null, 'HeureSups', false);
        $this->addRelation('Permission', '\\App\\Models\\Permission', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':employe_id',
    1 => ':employe_id',
  ),
), 'CASCADE', null, 'Permissions', false);
        $this->addRelation('Pointage', '\\App\\Models\\Pointage', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':employe_id',
    1 => ':employe_id',
  ),
), 'CASCADE', null, 'Pointages', false);
        $this->addRelation('Presence', '\\App\\Models\\Presence', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':employe_id',
    1 => ':employe_id',
  ),
), 'CASCADE', null, 'Presences', false);
        $this->addRelation('Retard', '\\App\\Models\\Retard', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':employe_id',
    1 => ':employe_id',
  ),
), 'CASCADE', null, 'Retards', false);
    } // buildRelations()
    /**
     * Method to invalidate the instance pool of all tables related to employe     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        AbsenceTableMap::clearInstancePool();
        CongeTableMap::clearInstancePool();
        HeureSupTableMap::clearInstancePool();
        PermissionTableMap::clearInstancePool();
        PointageTableMap::clearInstancePool();
        PresenceTableMap::clearInstancePool();
        RetardTableMap::clearInstancePool();
    }

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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('EmployeId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('EmployeId', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('EmployeId', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('EmployeId', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('EmployeId', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('EmployeId', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('EmployeId', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? EmployeTableMap::CLASS_DEFAULT : EmployeTableMap::OM_CLASS;
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
     * @return array           (Employe object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = EmployeTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = EmployeTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + EmployeTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = EmployeTableMap::OM_CLASS;
            /** @var Employe $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            EmployeTableMap::addInstanceToPool($obj, $key);
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
            $key = EmployeTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = EmployeTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Employe $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                EmployeTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(EmployeTableMap::COL_EMPLOYE_ID);
            $criteria->addSelectColumn(EmployeTableMap::COL_REF_INTERNE);
            $criteria->addSelectColumn(EmployeTableMap::COL_UNITE_ID);
            $criteria->addSelectColumn(EmployeTableMap::COL_NOM_PRENOM);
            $criteria->addSelectColumn(EmployeTableMap::COL_POSTE);
            $criteria->addSelectColumn(EmployeTableMap::COL_GENRE);
            $criteria->addSelectColumn(EmployeTableMap::COL_DATE_EMBAUCHE);
            $criteria->addSelectColumn(EmployeTableMap::COL_PRESENT);
            $criteria->addSelectColumn(EmployeTableMap::COL_STATUS);
        } else {
            $criteria->addSelectColumn($alias . '.employe_id');
            $criteria->addSelectColumn($alias . '.ref_interne');
            $criteria->addSelectColumn($alias . '.unite_id');
            $criteria->addSelectColumn($alias . '.nom_prenom');
            $criteria->addSelectColumn($alias . '.poste');
            $criteria->addSelectColumn($alias . '.genre');
            $criteria->addSelectColumn($alias . '.date_embauche');
            $criteria->addSelectColumn($alias . '.present');
            $criteria->addSelectColumn($alias . '.status');
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
        return Propel::getServiceContainer()->getDatabaseMap(EmployeTableMap::DATABASE_NAME)->getTable(EmployeTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(EmployeTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(EmployeTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new EmployeTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Employe or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Employe object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(EmployeTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \App\Models\Employe) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(EmployeTableMap::DATABASE_NAME);
            $criteria->add(EmployeTableMap::COL_EMPLOYE_ID, (array) $values, Criteria::IN);
        }

        $query = EmployeQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            EmployeTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                EmployeTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the employe table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return EmployeQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Employe or Criteria object.
     *
     * @param mixed               $criteria Criteria or Employe object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(EmployeTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Employe object
        }

        if ($criteria->containsKey(EmployeTableMap::COL_EMPLOYE_ID) && $criteria->keyContainsValue(EmployeTableMap::COL_EMPLOYE_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.EmployeTableMap::COL_EMPLOYE_ID.')');
        }


        // Set the correct dbName
        $query = EmployeQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // EmployeTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
EmployeTableMap::buildTableMap();
