<?php

namespace App\Models\Base;

use \Exception;
use \PDO;
use App\Models\Import as ChildImport;
use App\Models\ImportQuery as ChildImportQuery;
use App\Models\Map\ImportTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'import' table.
 *
 *
 *
 * @method     ChildImportQuery orderByImportId($order = Criteria::ASC) Order by the import_id column
 * @method     ChildImportQuery orderByTarget($order = Criteria::ASC) Order by the target column
 * @method     ChildImportQuery orderByMapping($order = Criteria::ASC) Order by the mapping column
 *
 * @method     ChildImportQuery groupByImportId() Group by the import_id column
 * @method     ChildImportQuery groupByTarget() Group by the target column
 * @method     ChildImportQuery groupByMapping() Group by the mapping column
 *
 * @method     ChildImportQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildImportQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildImportQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildImportQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildImportQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildImportQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildImport findOne(ConnectionInterface $con = null) Return the first ChildImport matching the query
 * @method     ChildImport findOneOrCreate(ConnectionInterface $con = null) Return the first ChildImport matching the query, or a new ChildImport object populated from the query conditions when no match is found
 *
 * @method     ChildImport findOneByImportId(int $import_id) Return the first ChildImport filtered by the import_id column
 * @method     ChildImport findOneByTarget(string $target) Return the first ChildImport filtered by the target column
 * @method     ChildImport findOneByMapping(string $mapping) Return the first ChildImport filtered by the mapping column *

 * @method     ChildImport requirePk($key, ConnectionInterface $con = null) Return the ChildImport by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildImport requireOne(ConnectionInterface $con = null) Return the first ChildImport matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildImport requireOneByImportId(int $import_id) Return the first ChildImport filtered by the import_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildImport requireOneByTarget(string $target) Return the first ChildImport filtered by the target column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildImport requireOneByMapping(string $mapping) Return the first ChildImport filtered by the mapping column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildImport[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildImport objects based on current ModelCriteria
 * @method     ChildImport[]|ObjectCollection findByImportId(int $import_id) Return ChildImport objects filtered by the import_id column
 * @method     ChildImport[]|ObjectCollection findByTarget(string $target) Return ChildImport objects filtered by the target column
 * @method     ChildImport[]|ObjectCollection findByMapping(string $mapping) Return ChildImport objects filtered by the mapping column
 * @method     ChildImport[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ImportQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \App\Models\Base\ImportQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\App\\Models\\Import', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildImportQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildImportQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildImportQuery) {
            return $criteria;
        }
        $query = new ChildImportQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildImport|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ImportTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = ImportTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
            // the object is already in the instance pool
            return $obj;
        }

        return $this->findPkSimple($key, $con);
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildImport A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT import_id, target, mapping FROM import WHERE import_id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildImport $obj */
            $obj = new ChildImport();
            $obj->hydrate($row);
            ImportTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildImport|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildImportQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ImportTableMap::COL_IMPORT_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildImportQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ImportTableMap::COL_IMPORT_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the import_id column
     *
     * Example usage:
     * <code>
     * $query->filterByImportId(1234); // WHERE import_id = 1234
     * $query->filterByImportId(array(12, 34)); // WHERE import_id IN (12, 34)
     * $query->filterByImportId(array('min' => 12)); // WHERE import_id > 12
     * </code>
     *
     * @param     mixed $importId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildImportQuery The current query, for fluid interface
     */
    public function filterByImportId($importId = null, $comparison = null)
    {
        if (is_array($importId)) {
            $useMinMax = false;
            if (isset($importId['min'])) {
                $this->addUsingAlias(ImportTableMap::COL_IMPORT_ID, $importId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($importId['max'])) {
                $this->addUsingAlias(ImportTableMap::COL_IMPORT_ID, $importId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ImportTableMap::COL_IMPORT_ID, $importId, $comparison);
    }

    /**
     * Filter the query on the target column
     *
     * Example usage:
     * <code>
     * $query->filterByTarget('fooValue');   // WHERE target = 'fooValue'
     * $query->filterByTarget('%fooValue%', Criteria::LIKE); // WHERE target LIKE '%fooValue%'
     * </code>
     *
     * @param     string $target The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildImportQuery The current query, for fluid interface
     */
    public function filterByTarget($target = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($target)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ImportTableMap::COL_TARGET, $target, $comparison);
    }

    /**
     * Filter the query on the mapping column
     *
     * Example usage:
     * <code>
     * $query->filterByMapping('fooValue');   // WHERE mapping = 'fooValue'
     * $query->filterByMapping('%fooValue%', Criteria::LIKE); // WHERE mapping LIKE '%fooValue%'
     * </code>
     *
     * @param     string $mapping The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildImportQuery The current query, for fluid interface
     */
    public function filterByMapping($mapping = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($mapping)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ImportTableMap::COL_MAPPING, $mapping, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildImport $import Object to remove from the list of results
     *
     * @return $this|ChildImportQuery The current query, for fluid interface
     */
    public function prune($import = null)
    {
        if ($import) {
            $this->addUsingAlias(ImportTableMap::COL_IMPORT_ID, $import->getImportId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the import table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ImportTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ImportTableMap::clearInstancePool();
            ImportTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ImportTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ImportTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ImportTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ImportTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ImportQuery
