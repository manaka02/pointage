<?php

namespace App\Models\Map;

use App\Models\Debauche;
use App\Models\DebaucheQuery;
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
 * This class defines the structure of the 'debauche' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class DebaucheTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.DebaucheTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'debauche';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\App\\Models\\Debauche';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Debauche';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 11;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 11;

    /**
     * the column name for the debauche_id field
     */
    const COL_DEBAUCHE_ID = 'debauche.debauche_id';

    /**
     * the column name for the civilite field
     */
    const COL_CIVILITE = 'debauche.civilite';

    /**
     * the column name for the ref_interne field
     */
    const COL_REF_INTERNE = 'debauche.ref_interne';

    /**
     * the column name for the nom_prenom field
     */
    const COL_NOM_PRENOM = 'debauche.nom_prenom';

    /**
     * the column name for the fonction field
     */
    const COL_FONCTION = 'debauche.fonction';

    /**
     * the column name for the departement_id field
     */
    const COL_DEPARTEMENT_ID = 'debauche.departement_id';

    /**
     * the column name for the photo_link field
     */
    const COL_PHOTO_LINK = 'debauche.photo_link';

    /**
     * the column name for the date_embauche field
     */
    const COL_DATE_EMBAUCHE = 'debauche.date_embauche';

    /**
     * the column name for the date_depart field
     */
    const COL_DATE_DEPART = 'debauche.date_depart';

    /**
     * the column name for the raisons field
     */
    const COL_RAISONS = 'debauche.raisons';

    /**
     * the column name for the motif field
     */
    const COL_MOTIF = 'debauche.motif';

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
        self::TYPE_PHPNAME       => array('DebaucheId', 'Civilite', 'RefInterne', 'NomPrenom', 'Fonction', 'DepartementId', 'PhotoLink', 'DateEmbauche', 'DateDepart', 'Raisons', 'Motif', ),
        self::TYPE_CAMELNAME     => array('debaucheId', 'civilite', 'refInterne', 'nomPrenom', 'fonction', 'departementId', 'photoLink', 'dateEmbauche', 'dateDepart', 'raisons', 'motif', ),
        self::TYPE_COLNAME       => array(DebaucheTableMap::COL_DEBAUCHE_ID, DebaucheTableMap::COL_CIVILITE, DebaucheTableMap::COL_REF_INTERNE, DebaucheTableMap::COL_NOM_PRENOM, DebaucheTableMap::COL_FONCTION, DebaucheTableMap::COL_DEPARTEMENT_ID, DebaucheTableMap::COL_PHOTO_LINK, DebaucheTableMap::COL_DATE_EMBAUCHE, DebaucheTableMap::COL_DATE_DEPART, DebaucheTableMap::COL_RAISONS, DebaucheTableMap::COL_MOTIF, ),
        self::TYPE_FIELDNAME     => array('debauche_id', 'civilite', 'ref_interne', 'nom_prenom', 'fonction', 'departement_id', 'photo_link', 'date_embauche', 'date_depart', 'raisons', 'motif', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('DebaucheId' => 0, 'Civilite' => 1, 'RefInterne' => 2, 'NomPrenom' => 3, 'Fonction' => 4, 'DepartementId' => 5, 'PhotoLink' => 6, 'DateEmbauche' => 7, 'DateDepart' => 8, 'Raisons' => 9, 'Motif' => 10, ),
        self::TYPE_CAMELNAME     => array('debaucheId' => 0, 'civilite' => 1, 'refInterne' => 2, 'nomPrenom' => 3, 'fonction' => 4, 'departementId' => 5, 'photoLink' => 6, 'dateEmbauche' => 7, 'dateDepart' => 8, 'raisons' => 9, 'motif' => 10, ),
        self::TYPE_COLNAME       => array(DebaucheTableMap::COL_DEBAUCHE_ID => 0, DebaucheTableMap::COL_CIVILITE => 1, DebaucheTableMap::COL_REF_INTERNE => 2, DebaucheTableMap::COL_NOM_PRENOM => 3, DebaucheTableMap::COL_FONCTION => 4, DebaucheTableMap::COL_DEPARTEMENT_ID => 5, DebaucheTableMap::COL_PHOTO_LINK => 6, DebaucheTableMap::COL_DATE_EMBAUCHE => 7, DebaucheTableMap::COL_DATE_DEPART => 8, DebaucheTableMap::COL_RAISONS => 9, DebaucheTableMap::COL_MOTIF => 10, ),
        self::TYPE_FIELDNAME     => array('debauche_id' => 0, 'civilite' => 1, 'ref_interne' => 2, 'nom_prenom' => 3, 'fonction' => 4, 'departement_id' => 5, 'photo_link' => 6, 'date_embauche' => 7, 'date_depart' => 8, 'raisons' => 9, 'motif' => 10, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
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
        $this->setName('debauche');
        $this->setPhpName('Debauche');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\App\\Models\\Debauche');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('debauche_id', 'DebaucheId', 'INTEGER', true, null, null);
        $this->addColumn('civilite', 'Civilite', 'VARCHAR', true, 10, null);
        $this->addColumn('ref_interne', 'RefInterne', 'VARCHAR', true, 250, null);
        $this->addColumn('nom_prenom', 'NomPrenom', 'VARCHAR', true, 250, null);
        $this->addColumn('fonction', 'Fonction', 'VARCHAR', true, 250, null);
        $this->addForeignKey('departement_id', 'DepartementId', 'INTEGER', 'departement', 'departement_id', false, null, null);
        $this->addColumn('photo_link', 'PhotoLink', 'VARCHAR', true, 250, null);
        $this->addColumn('date_embauche', 'DateEmbauche', 'DATE', false, null, null);
        $this->addColumn('date_depart', 'DateDepart', 'DATE', true, null, null);
        $this->addColumn('raisons', 'Raisons', 'VARCHAR', true, 250, null);
        $this->addColumn('motif', 'Motif', 'VARCHAR', false, 250, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Departement', '\\App\\Models\\Departement', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':departement_id',
    1 => ':departement_id',
  ),
), null, null, null, false);
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('DebaucheId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('DebaucheId', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('DebaucheId', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('DebaucheId', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('DebaucheId', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('DebaucheId', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('DebaucheId', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? DebaucheTableMap::CLASS_DEFAULT : DebaucheTableMap::OM_CLASS;
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
     * @return array           (Debauche object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = DebaucheTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = DebaucheTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + DebaucheTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = DebaucheTableMap::OM_CLASS;
            /** @var Debauche $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            DebaucheTableMap::addInstanceToPool($obj, $key);
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
            $key = DebaucheTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = DebaucheTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Debauche $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                DebaucheTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(DebaucheTableMap::COL_DEBAUCHE_ID);
            $criteria->addSelectColumn(DebaucheTableMap::COL_CIVILITE);
            $criteria->addSelectColumn(DebaucheTableMap::COL_REF_INTERNE);
            $criteria->addSelectColumn(DebaucheTableMap::COL_NOM_PRENOM);
            $criteria->addSelectColumn(DebaucheTableMap::COL_FONCTION);
            $criteria->addSelectColumn(DebaucheTableMap::COL_DEPARTEMENT_ID);
            $criteria->addSelectColumn(DebaucheTableMap::COL_PHOTO_LINK);
            $criteria->addSelectColumn(DebaucheTableMap::COL_DATE_EMBAUCHE);
            $criteria->addSelectColumn(DebaucheTableMap::COL_DATE_DEPART);
            $criteria->addSelectColumn(DebaucheTableMap::COL_RAISONS);
            $criteria->addSelectColumn(DebaucheTableMap::COL_MOTIF);
        } else {
            $criteria->addSelectColumn($alias . '.debauche_id');
            $criteria->addSelectColumn($alias . '.civilite');
            $criteria->addSelectColumn($alias . '.ref_interne');
            $criteria->addSelectColumn($alias . '.nom_prenom');
            $criteria->addSelectColumn($alias . '.fonction');
            $criteria->addSelectColumn($alias . '.departement_id');
            $criteria->addSelectColumn($alias . '.photo_link');
            $criteria->addSelectColumn($alias . '.date_embauche');
            $criteria->addSelectColumn($alias . '.date_depart');
            $criteria->addSelectColumn($alias . '.raisons');
            $criteria->addSelectColumn($alias . '.motif');
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
        return Propel::getServiceContainer()->getDatabaseMap(DebaucheTableMap::DATABASE_NAME)->getTable(DebaucheTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(DebaucheTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(DebaucheTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new DebaucheTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Debauche or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Debauche object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(DebaucheTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \App\Models\Debauche) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(DebaucheTableMap::DATABASE_NAME);
            $criteria->add(DebaucheTableMap::COL_DEBAUCHE_ID, (array) $values, Criteria::IN);
        }

        $query = DebaucheQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            DebaucheTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                DebaucheTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the debauche table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return DebaucheQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Debauche or Criteria object.
     *
     * @param mixed               $criteria Criteria or Debauche object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DebaucheTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Debauche object
        }

        if ($criteria->containsKey(DebaucheTableMap::COL_DEBAUCHE_ID) && $criteria->keyContainsValue(DebaucheTableMap::COL_DEBAUCHE_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.DebaucheTableMap::COL_DEBAUCHE_ID.')');
        }


        // Set the correct dbName
        $query = DebaucheQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // DebaucheTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
DebaucheTableMap::buildTableMap();
