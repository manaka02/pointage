<?php

namespace App\Models\Base;

use \Exception;
use \PDO;
use App\Models\Pointage as ChildPointage;
use App\Models\PointageQuery as ChildPointageQuery;
use App\Models\Map\PointageTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'pointage' table.
 *
 *
 *
 * @method     ChildPointageQuery orderByPointageId($order = Criteria::ASC) Order by the pointage_id column
 * @method     ChildPointageQuery orderByEmployeId($order = Criteria::ASC) Order by the employe_id column
 * @method     ChildPointageQuery orderByDatePointage($order = Criteria::ASC) Order by the date_pointage column
 * @method     ChildPointageQuery orderByStatus($order = Criteria::ASC) Order by the status column
 *
 * @method     ChildPointageQuery groupByPointageId() Group by the pointage_id column
 * @method     ChildPointageQuery groupByEmployeId() Group by the employe_id column
 * @method     ChildPointageQuery groupByDatePointage() Group by the date_pointage column
 * @method     ChildPointageQuery groupByStatus() Group by the status column
 *
 * @method     ChildPointageQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPointageQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPointageQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPointageQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildPointageQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildPointageQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildPointageQuery leftJoinEmploye($relationAlias = null) Adds a LEFT JOIN clause to the query using the Employe relation
 * @method     ChildPointageQuery rightJoinEmploye($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Employe relation
 * @method     ChildPointageQuery innerJoinEmploye($relationAlias = null) Adds a INNER JOIN clause to the query using the Employe relation
 *
 * @method     ChildPointageQuery joinWithEmploye($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Employe relation
 *
 * @method     ChildPointageQuery leftJoinWithEmploye() Adds a LEFT JOIN clause and with to the query using the Employe relation
 * @method     ChildPointageQuery rightJoinWithEmploye() Adds a RIGHT JOIN clause and with to the query using the Employe relation
 * @method     ChildPointageQuery innerJoinWithEmploye() Adds a INNER JOIN clause and with to the query using the Employe relation
 *
 * @method     \App\Models\EmployeQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPointage findOne(ConnectionInterface $con = null) Return the first ChildPointage matching the query
 * @method     ChildPointage findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPointage matching the query, or a new ChildPointage object populated from the query conditions when no match is found
 *
 * @method     ChildPointage findOneByPointageId(int $pointage_id) Return the first ChildPointage filtered by the pointage_id column
 * @method     ChildPointage findOneByEmployeId(int $employe_id) Return the first ChildPointage filtered by the employe_id column
 * @method     ChildPointage findOneByDatePointage(string $date_pointage) Return the first ChildPointage filtered by the date_pointage column
 * @method     ChildPointage findOneByStatus(string $status) Return the first ChildPointage filtered by the status column *

 * @method     ChildPointage requirePk($key, ConnectionInterface $con = null) Return the ChildPointage by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPointage requireOne(ConnectionInterface $con = null) Return the first ChildPointage matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPointage requireOneByPointageId(int $pointage_id) Return the first ChildPointage filtered by the pointage_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPointage requireOneByEmployeId(int $employe_id) Return the first ChildPointage filtered by the employe_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPointage requireOneByDatePointage(string $date_pointage) Return the first ChildPointage filtered by the date_pointage column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPointage requireOneByStatus(string $status) Return the first ChildPointage filtered by the status column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPointage[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPointage objects based on current ModelCriteria
 * @method     ChildPointage[]|ObjectCollection findByPointageId(int $pointage_id) Return ChildPointage objects filtered by the pointage_id column
 * @method     ChildPointage[]|ObjectCollection findByEmployeId(int $employe_id) Return ChildPointage objects filtered by the employe_id column
 * @method     ChildPointage[]|ObjectCollection findByDatePointage(string $date_pointage) Return ChildPointage objects filtered by the date_pointage column
 * @method     ChildPointage[]|ObjectCollection findByStatus(string $status) Return ChildPointage objects filtered by the status column
 * @method     ChildPointage[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PointageQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \App\Models\Base\PointageQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\App\\Models\\Pointage', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPointageQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPointageQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPointageQuery) {
            return $criteria;
        }
        $query = new ChildPointageQuery();
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
     * @return ChildPointage|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PointageTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = PointageTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildPointage A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT pointage_id, employe_id, date_pointage, status FROM pointage WHERE pointage_id = :p0';
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
            /** @var ChildPointage $obj */
            $obj = new ChildPointage();
            $obj->hydrate($row);
            PointageTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildPointage|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildPointageQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PointageTableMap::COL_POINTAGE_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPointageQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PointageTableMap::COL_POINTAGE_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the pointage_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPointageId(1234); // WHERE pointage_id = 1234
     * $query->filterByPointageId(array(12, 34)); // WHERE pointage_id IN (12, 34)
     * $query->filterByPointageId(array('min' => 12)); // WHERE pointage_id > 12
     * </code>
     *
     * @param     mixed $pointageId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPointageQuery The current query, for fluid interface
     */
    public function filterByPointageId($pointageId = null, $comparison = null)
    {
        if (is_array($pointageId)) {
            $useMinMax = false;
            if (isset($pointageId['min'])) {
                $this->addUsingAlias(PointageTableMap::COL_POINTAGE_ID, $pointageId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($pointageId['max'])) {
                $this->addUsingAlias(PointageTableMap::COL_POINTAGE_ID, $pointageId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PointageTableMap::COL_POINTAGE_ID, $pointageId, $comparison);
    }

    /**
     * Filter the query on the employe_id column
     *
     * Example usage:
     * <code>
     * $query->filterByEmployeId(1234); // WHERE employe_id = 1234
     * $query->filterByEmployeId(array(12, 34)); // WHERE employe_id IN (12, 34)
     * $query->filterByEmployeId(array('min' => 12)); // WHERE employe_id > 12
     * </code>
     *
     * @see       filterByEmploye()
     *
     * @param     mixed $employeId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPointageQuery The current query, for fluid interface
     */
    public function filterByEmployeId($employeId = null, $comparison = null)
    {
        if (is_array($employeId)) {
            $useMinMax = false;
            if (isset($employeId['min'])) {
                $this->addUsingAlias(PointageTableMap::COL_EMPLOYE_ID, $employeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($employeId['max'])) {
                $this->addUsingAlias(PointageTableMap::COL_EMPLOYE_ID, $employeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PointageTableMap::COL_EMPLOYE_ID, $employeId, $comparison);
    }

    /**
     * Filter the query on the date_pointage column
     *
     * Example usage:
     * <code>
     * $query->filterByDatePointage('2011-03-14'); // WHERE date_pointage = '2011-03-14'
     * $query->filterByDatePointage('now'); // WHERE date_pointage = '2011-03-14'
     * $query->filterByDatePointage(array('max' => 'yesterday')); // WHERE date_pointage > '2011-03-13'
     * </code>
     *
     * @param     mixed $datePointage The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPointageQuery The current query, for fluid interface
     */
    public function filterByDatePointage($datePointage = null, $comparison = null)
    {
        if (is_array($datePointage)) {
            $useMinMax = false;
            if (isset($datePointage['min'])) {
                $this->addUsingAlias(PointageTableMap::COL_DATE_POINTAGE, $datePointage['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($datePointage['max'])) {
                $this->addUsingAlias(PointageTableMap::COL_DATE_POINTAGE, $datePointage['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PointageTableMap::COL_DATE_POINTAGE, $datePointage, $comparison);
    }

    /**
     * Filter the query on the status column
     *
     * Example usage:
     * <code>
     * $query->filterByStatus('fooValue');   // WHERE status = 'fooValue'
     * $query->filterByStatus('%fooValue%', Criteria::LIKE); // WHERE status LIKE '%fooValue%'
     * </code>
     *
     * @param     string $status The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPointageQuery The current query, for fluid interface
     */
    public function filterByStatus($status = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($status)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PointageTableMap::COL_STATUS, $status, $comparison);
    }

    /**
     * Filter the query by a related \App\Models\Employe object
     *
     * @param \App\Models\Employe|ObjectCollection $employe The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPointageQuery The current query, for fluid interface
     */
    public function filterByEmploye($employe, $comparison = null)
    {
        if ($employe instanceof \App\Models\Employe) {
            return $this
                ->addUsingAlias(PointageTableMap::COL_EMPLOYE_ID, $employe->getEmployeId(), $comparison);
        } elseif ($employe instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PointageTableMap::COL_EMPLOYE_ID, $employe->toKeyValue('PrimaryKey', 'EmployeId'), $comparison);
        } else {
            throw new PropelException('filterByEmploye() only accepts arguments of type \App\Models\Employe or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Employe relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPointageQuery The current query, for fluid interface
     */
    public function joinEmploye($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Employe');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Employe');
        }

        return $this;
    }

    /**
     * Use the Employe relation Employe object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \App\Models\EmployeQuery A secondary query class using the current class as primary query
     */
    public function useEmployeQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinEmploye($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Employe', '\App\Models\EmployeQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPointage $pointage Object to remove from the list of results
     *
     * @return $this|ChildPointageQuery The current query, for fluid interface
     */
    public function prune($pointage = null)
    {
        if ($pointage) {
            $this->addUsingAlias(PointageTableMap::COL_POINTAGE_ID, $pointage->getPointageId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the pointage table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PointageTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PointageTableMap::clearInstancePool();
            PointageTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PointageTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PointageTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PointageTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PointageTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PointageQuery
