<?php

namespace App\Models\Base;

use \Exception;
use \PDO;
use App\Models\Direction as ChildDirection;
use App\Models\DirectionQuery as ChildDirectionQuery;
use App\Models\Map\DirectionTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'direction' table.
 *
 *
 *
 * @method     ChildDirectionQuery orderByDirectionId($order = Criteria::ASC) Order by the direction_id column
 * @method     ChildDirectionQuery orderByDesignation($order = Criteria::ASC) Order by the designation column
 * @method     ChildDirectionQuery orderByDescription($order = Criteria::ASC) Order by the description column
 *
 * @method     ChildDirectionQuery groupByDirectionId() Group by the direction_id column
 * @method     ChildDirectionQuery groupByDesignation() Group by the designation column
 * @method     ChildDirectionQuery groupByDescription() Group by the description column
 *
 * @method     ChildDirectionQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildDirectionQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildDirectionQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildDirectionQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildDirectionQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildDirectionQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildDirectionQuery leftJoinDepartement($relationAlias = null) Adds a LEFT JOIN clause to the query using the Departement relation
 * @method     ChildDirectionQuery rightJoinDepartement($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Departement relation
 * @method     ChildDirectionQuery innerJoinDepartement($relationAlias = null) Adds a INNER JOIN clause to the query using the Departement relation
 *
 * @method     ChildDirectionQuery joinWithDepartement($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Departement relation
 *
 * @method     ChildDirectionQuery leftJoinWithDepartement() Adds a LEFT JOIN clause and with to the query using the Departement relation
 * @method     ChildDirectionQuery rightJoinWithDepartement() Adds a RIGHT JOIN clause and with to the query using the Departement relation
 * @method     ChildDirectionQuery innerJoinWithDepartement() Adds a INNER JOIN clause and with to the query using the Departement relation
 *
 * @method     \App\Models\DepartementQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildDirection findOne(ConnectionInterface $con = null) Return the first ChildDirection matching the query
 * @method     ChildDirection findOneOrCreate(ConnectionInterface $con = null) Return the first ChildDirection matching the query, or a new ChildDirection object populated from the query conditions when no match is found
 *
 * @method     ChildDirection findOneByDirectionId(int $direction_id) Return the first ChildDirection filtered by the direction_id column
 * @method     ChildDirection findOneByDesignation(string $designation) Return the first ChildDirection filtered by the designation column
 * @method     ChildDirection findOneByDescription(string $description) Return the first ChildDirection filtered by the description column *

 * @method     ChildDirection requirePk($key, ConnectionInterface $con = null) Return the ChildDirection by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDirection requireOne(ConnectionInterface $con = null) Return the first ChildDirection matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDirection requireOneByDirectionId(int $direction_id) Return the first ChildDirection filtered by the direction_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDirection requireOneByDesignation(string $designation) Return the first ChildDirection filtered by the designation column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDirection requireOneByDescription(string $description) Return the first ChildDirection filtered by the description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDirection[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildDirection objects based on current ModelCriteria
 * @method     ChildDirection[]|ObjectCollection findByDirectionId(int $direction_id) Return ChildDirection objects filtered by the direction_id column
 * @method     ChildDirection[]|ObjectCollection findByDesignation(string $designation) Return ChildDirection objects filtered by the designation column
 * @method     ChildDirection[]|ObjectCollection findByDescription(string $description) Return ChildDirection objects filtered by the description column
 * @method     ChildDirection[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class DirectionQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \App\Models\Base\DirectionQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\App\\Models\\Direction', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildDirectionQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildDirectionQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildDirectionQuery) {
            return $criteria;
        }
        $query = new ChildDirectionQuery();
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
     * @return ChildDirection|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(DirectionTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = DirectionTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildDirection A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT direction_id, designation, description FROM direction WHERE direction_id = :p0';
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
            /** @var ChildDirection $obj */
            $obj = new ChildDirection();
            $obj->hydrate($row);
            DirectionTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildDirection|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildDirectionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(DirectionTableMap::COL_DIRECTION_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildDirectionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(DirectionTableMap::COL_DIRECTION_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the direction_id column
     *
     * Example usage:
     * <code>
     * $query->filterByDirectionId(1234); // WHERE direction_id = 1234
     * $query->filterByDirectionId(array(12, 34)); // WHERE direction_id IN (12, 34)
     * $query->filterByDirectionId(array('min' => 12)); // WHERE direction_id > 12
     * </code>
     *
     * @param     mixed $directionId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDirectionQuery The current query, for fluid interface
     */
    public function filterByDirectionId($directionId = null, $comparison = null)
    {
        if (is_array($directionId)) {
            $useMinMax = false;
            if (isset($directionId['min'])) {
                $this->addUsingAlias(DirectionTableMap::COL_DIRECTION_ID, $directionId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($directionId['max'])) {
                $this->addUsingAlias(DirectionTableMap::COL_DIRECTION_ID, $directionId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DirectionTableMap::COL_DIRECTION_ID, $directionId, $comparison);
    }

    /**
     * Filter the query on the designation column
     *
     * Example usage:
     * <code>
     * $query->filterByDesignation('fooValue');   // WHERE designation = 'fooValue'
     * $query->filterByDesignation('%fooValue%', Criteria::LIKE); // WHERE designation LIKE '%fooValue%'
     * </code>
     *
     * @param     string $designation The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDirectionQuery The current query, for fluid interface
     */
    public function filterByDesignation($designation = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($designation)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DirectionTableMap::COL_DESIGNATION, $designation, $comparison);
    }

    /**
     * Filter the query on the description column
     *
     * Example usage:
     * <code>
     * $query->filterByDescription('fooValue');   // WHERE description = 'fooValue'
     * $query->filterByDescription('%fooValue%', Criteria::LIKE); // WHERE description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $description The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDirectionQuery The current query, for fluid interface
     */
    public function filterByDescription($description = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($description)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DirectionTableMap::COL_DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query by a related \App\Models\Departement object
     *
     * @param \App\Models\Departement|ObjectCollection $departement the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDirectionQuery The current query, for fluid interface
     */
    public function filterByDepartement($departement, $comparison = null)
    {
        if ($departement instanceof \App\Models\Departement) {
            return $this
                ->addUsingAlias(DirectionTableMap::COL_DIRECTION_ID, $departement->getDirectionId(), $comparison);
        } elseif ($departement instanceof ObjectCollection) {
            return $this
                ->useDepartementQuery()
                ->filterByPrimaryKeys($departement->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByDepartement() only accepts arguments of type \App\Models\Departement or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Departement relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildDirectionQuery The current query, for fluid interface
     */
    public function joinDepartement($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Departement');

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
            $this->addJoinObject($join, 'Departement');
        }

        return $this;
    }

    /**
     * Use the Departement relation Departement object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \App\Models\DepartementQuery A secondary query class using the current class as primary query
     */
    public function useDepartementQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinDepartement($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Departement', '\App\Models\DepartementQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildDirection $direction Object to remove from the list of results
     *
     * @return $this|ChildDirectionQuery The current query, for fluid interface
     */
    public function prune($direction = null)
    {
        if ($direction) {
            $this->addUsingAlias(DirectionTableMap::COL_DIRECTION_ID, $direction->getDirectionId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the direction table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DirectionTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            DirectionTableMap::clearInstancePool();
            DirectionTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(DirectionTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(DirectionTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            DirectionTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            DirectionTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // DirectionQuery
