<?php

namespace App\Models\Base;

use \Exception;
use \PDO;
use App\Models\Retard as ChildRetard;
use App\Models\RetardQuery as ChildRetardQuery;
use App\Models\Map\RetardTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'retard' table.
 *
 *
 *
 * @method     ChildRetardQuery orderByRetardId($order = Criteria::ASC) Order by the retard_id column
 * @method     ChildRetardQuery orderByEmployeId($order = Criteria::ASC) Order by the employe_id column
 * @method     ChildRetardQuery orderByDateRetard($order = Criteria::ASC) Order by the date_retard column
 * @method     ChildRetardQuery orderByDuree($order = Criteria::ASC) Order by the duree column
 *
 * @method     ChildRetardQuery groupByRetardId() Group by the retard_id column
 * @method     ChildRetardQuery groupByEmployeId() Group by the employe_id column
 * @method     ChildRetardQuery groupByDateRetard() Group by the date_retard column
 * @method     ChildRetardQuery groupByDuree() Group by the duree column
 *
 * @method     ChildRetardQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildRetardQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildRetardQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildRetardQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildRetardQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildRetardQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildRetardQuery leftJoinEmploye($relationAlias = null) Adds a LEFT JOIN clause to the query using the Employe relation
 * @method     ChildRetardQuery rightJoinEmploye($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Employe relation
 * @method     ChildRetardQuery innerJoinEmploye($relationAlias = null) Adds a INNER JOIN clause to the query using the Employe relation
 *
 * @method     ChildRetardQuery joinWithEmploye($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Employe relation
 *
 * @method     ChildRetardQuery leftJoinWithEmploye() Adds a LEFT JOIN clause and with to the query using the Employe relation
 * @method     ChildRetardQuery rightJoinWithEmploye() Adds a RIGHT JOIN clause and with to the query using the Employe relation
 * @method     ChildRetardQuery innerJoinWithEmploye() Adds a INNER JOIN clause and with to the query using the Employe relation
 *
 * @method     \App\Models\EmployeQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildRetard findOne(ConnectionInterface $con = null) Return the first ChildRetard matching the query
 * @method     ChildRetard findOneOrCreate(ConnectionInterface $con = null) Return the first ChildRetard matching the query, or a new ChildRetard object populated from the query conditions when no match is found
 *
 * @method     ChildRetard findOneByRetardId(int $retard_id) Return the first ChildRetard filtered by the retard_id column
 * @method     ChildRetard findOneByEmployeId(int $employe_id) Return the first ChildRetard filtered by the employe_id column
 * @method     ChildRetard findOneByDateRetard(int $date_retard) Return the first ChildRetard filtered by the date_retard column
 * @method     ChildRetard findOneByDuree(string $duree) Return the first ChildRetard filtered by the duree column *

 * @method     ChildRetard requirePk($key, ConnectionInterface $con = null) Return the ChildRetard by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRetard requireOne(ConnectionInterface $con = null) Return the first ChildRetard matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRetard requireOneByRetardId(int $retard_id) Return the first ChildRetard filtered by the retard_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRetard requireOneByEmployeId(int $employe_id) Return the first ChildRetard filtered by the employe_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRetard requireOneByDateRetard(int $date_retard) Return the first ChildRetard filtered by the date_retard column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRetard requireOneByDuree(string $duree) Return the first ChildRetard filtered by the duree column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRetard[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildRetard objects based on current ModelCriteria
 * @method     ChildRetard[]|ObjectCollection findByRetardId(int $retard_id) Return ChildRetard objects filtered by the retard_id column
 * @method     ChildRetard[]|ObjectCollection findByEmployeId(int $employe_id) Return ChildRetard objects filtered by the employe_id column
 * @method     ChildRetard[]|ObjectCollection findByDateRetard(int $date_retard) Return ChildRetard objects filtered by the date_retard column
 * @method     ChildRetard[]|ObjectCollection findByDuree(string $duree) Return ChildRetard objects filtered by the duree column
 * @method     ChildRetard[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class RetardQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \App\Models\Base\RetardQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\App\\Models\\Retard', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildRetardQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildRetardQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildRetardQuery) {
            return $criteria;
        }
        $query = new ChildRetardQuery();
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
     * @return ChildRetard|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(RetardTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = RetardTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildRetard A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT retard_id, employe_id, date_retard, duree FROM retard WHERE retard_id = :p0';
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
            /** @var ChildRetard $obj */
            $obj = new ChildRetard();
            $obj->hydrate($row);
            RetardTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildRetard|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildRetardQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(RetardTableMap::COL_RETARD_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildRetardQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(RetardTableMap::COL_RETARD_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the retard_id column
     *
     * Example usage:
     * <code>
     * $query->filterByRetardId(1234); // WHERE retard_id = 1234
     * $query->filterByRetardId(array(12, 34)); // WHERE retard_id IN (12, 34)
     * $query->filterByRetardId(array('min' => 12)); // WHERE retard_id > 12
     * </code>
     *
     * @param     mixed $retardId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRetardQuery The current query, for fluid interface
     */
    public function filterByRetardId($retardId = null, $comparison = null)
    {
        if (is_array($retardId)) {
            $useMinMax = false;
            if (isset($retardId['min'])) {
                $this->addUsingAlias(RetardTableMap::COL_RETARD_ID, $retardId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($retardId['max'])) {
                $this->addUsingAlias(RetardTableMap::COL_RETARD_ID, $retardId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RetardTableMap::COL_RETARD_ID, $retardId, $comparison);
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
     * @return $this|ChildRetardQuery The current query, for fluid interface
     */
    public function filterByEmployeId($employeId = null, $comparison = null)
    {
        if (is_array($employeId)) {
            $useMinMax = false;
            if (isset($employeId['min'])) {
                $this->addUsingAlias(RetardTableMap::COL_EMPLOYE_ID, $employeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($employeId['max'])) {
                $this->addUsingAlias(RetardTableMap::COL_EMPLOYE_ID, $employeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RetardTableMap::COL_EMPLOYE_ID, $employeId, $comparison);
    }

    /**
     * Filter the query on the date_retard column
     *
     * Example usage:
     * <code>
     * $query->filterByDateRetard(1234); // WHERE date_retard = 1234
     * $query->filterByDateRetard(array(12, 34)); // WHERE date_retard IN (12, 34)
     * $query->filterByDateRetard(array('min' => 12)); // WHERE date_retard > 12
     * </code>
     *
     * @param     mixed $dateRetard The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRetardQuery The current query, for fluid interface
     */
    public function filterByDateRetard($dateRetard = null, $comparison = null)
    {
        if (is_array($dateRetard)) {
            $useMinMax = false;
            if (isset($dateRetard['min'])) {
                $this->addUsingAlias(RetardTableMap::COL_DATE_RETARD, $dateRetard['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateRetard['max'])) {
                $this->addUsingAlias(RetardTableMap::COL_DATE_RETARD, $dateRetard['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RetardTableMap::COL_DATE_RETARD, $dateRetard, $comparison);
    }

    /**
     * Filter the query on the duree column
     *
     * Example usage:
     * <code>
     * $query->filterByDuree('2011-03-14'); // WHERE duree = '2011-03-14'
     * $query->filterByDuree('now'); // WHERE duree = '2011-03-14'
     * $query->filterByDuree(array('max' => 'yesterday')); // WHERE duree > '2011-03-13'
     * </code>
     *
     * @param     mixed $duree The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRetardQuery The current query, for fluid interface
     */
    public function filterByDuree($duree = null, $comparison = null)
    {
        if (is_array($duree)) {
            $useMinMax = false;
            if (isset($duree['min'])) {
                $this->addUsingAlias(RetardTableMap::COL_DUREE, $duree['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($duree['max'])) {
                $this->addUsingAlias(RetardTableMap::COL_DUREE, $duree['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RetardTableMap::COL_DUREE, $duree, $comparison);
    }

    /**
     * Filter the query by a related \App\Models\Employe object
     *
     * @param \App\Models\Employe|ObjectCollection $employe The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildRetardQuery The current query, for fluid interface
     */
    public function filterByEmploye($employe, $comparison = null)
    {
        if ($employe instanceof \App\Models\Employe) {
            return $this
                ->addUsingAlias(RetardTableMap::COL_EMPLOYE_ID, $employe->getEmployeId(), $comparison);
        } elseif ($employe instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(RetardTableMap::COL_EMPLOYE_ID, $employe->toKeyValue('PrimaryKey', 'EmployeId'), $comparison);
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
     * @return $this|ChildRetardQuery The current query, for fluid interface
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
     * @param   ChildRetard $retard Object to remove from the list of results
     *
     * @return $this|ChildRetardQuery The current query, for fluid interface
     */
    public function prune($retard = null)
    {
        if ($retard) {
            $this->addUsingAlias(RetardTableMap::COL_RETARD_ID, $retard->getRetardId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the retard table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RetardTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            RetardTableMap::clearInstancePool();
            RetardTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(RetardTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(RetardTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            RetardTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            RetardTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // RetardQuery
