<?php

namespace App\Models\Base;

use \Exception;
use \PDO;
use App\Models\Service as ChildService;
use App\Models\ServiceQuery as ChildServiceQuery;
use App\Models\Map\ServiceTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'service' table.
 *
 *
 *
 * @method     ChildServiceQuery orderByServiceId($order = Criteria::ASC) Order by the service_id column
 * @method     ChildServiceQuery orderByDesignation($order = Criteria::ASC) Order by the designation column
 * @method     ChildServiceQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method     ChildServiceQuery orderByDepartementId($order = Criteria::ASC) Order by the departement_id column
 *
 * @method     ChildServiceQuery groupByServiceId() Group by the service_id column
 * @method     ChildServiceQuery groupByDesignation() Group by the designation column
 * @method     ChildServiceQuery groupByDescription() Group by the description column
 * @method     ChildServiceQuery groupByDepartementId() Group by the departement_id column
 *
 * @method     ChildServiceQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildServiceQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildServiceQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildServiceQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildServiceQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildServiceQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildServiceQuery leftJoinDepartement($relationAlias = null) Adds a LEFT JOIN clause to the query using the Departement relation
 * @method     ChildServiceQuery rightJoinDepartement($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Departement relation
 * @method     ChildServiceQuery innerJoinDepartement($relationAlias = null) Adds a INNER JOIN clause to the query using the Departement relation
 *
 * @method     ChildServiceQuery joinWithDepartement($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Departement relation
 *
 * @method     ChildServiceQuery leftJoinWithDepartement() Adds a LEFT JOIN clause and with to the query using the Departement relation
 * @method     ChildServiceQuery rightJoinWithDepartement() Adds a RIGHT JOIN clause and with to the query using the Departement relation
 * @method     ChildServiceQuery innerJoinWithDepartement() Adds a INNER JOIN clause and with to the query using the Departement relation
 *
 * @method     ChildServiceQuery leftJoinUnite($relationAlias = null) Adds a LEFT JOIN clause to the query using the Unite relation
 * @method     ChildServiceQuery rightJoinUnite($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Unite relation
 * @method     ChildServiceQuery innerJoinUnite($relationAlias = null) Adds a INNER JOIN clause to the query using the Unite relation
 *
 * @method     ChildServiceQuery joinWithUnite($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Unite relation
 *
 * @method     ChildServiceQuery leftJoinWithUnite() Adds a LEFT JOIN clause and with to the query using the Unite relation
 * @method     ChildServiceQuery rightJoinWithUnite() Adds a RIGHT JOIN clause and with to the query using the Unite relation
 * @method     ChildServiceQuery innerJoinWithUnite() Adds a INNER JOIN clause and with to the query using the Unite relation
 *
 * @method     \App\Models\DepartementQuery|\App\Models\UniteQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildService findOne(ConnectionInterface $con = null) Return the first ChildService matching the query
 * @method     ChildService findOneOrCreate(ConnectionInterface $con = null) Return the first ChildService matching the query, or a new ChildService object populated from the query conditions when no match is found
 *
 * @method     ChildService findOneByServiceId(int $service_id) Return the first ChildService filtered by the service_id column
 * @method     ChildService findOneByDesignation(string $designation) Return the first ChildService filtered by the designation column
 * @method     ChildService findOneByDescription(string $description) Return the first ChildService filtered by the description column
 * @method     ChildService findOneByDepartementId(int $departement_id) Return the first ChildService filtered by the departement_id column *

 * @method     ChildService requirePk($key, ConnectionInterface $con = null) Return the ChildService by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildService requireOne(ConnectionInterface $con = null) Return the first ChildService matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildService requireOneByServiceId(int $service_id) Return the first ChildService filtered by the service_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildService requireOneByDesignation(string $designation) Return the first ChildService filtered by the designation column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildService requireOneByDescription(string $description) Return the first ChildService filtered by the description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildService requireOneByDepartementId(int $departement_id) Return the first ChildService filtered by the departement_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildService[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildService objects based on current ModelCriteria
 * @method     ChildService[]|ObjectCollection findByServiceId(int $service_id) Return ChildService objects filtered by the service_id column
 * @method     ChildService[]|ObjectCollection findByDesignation(string $designation) Return ChildService objects filtered by the designation column
 * @method     ChildService[]|ObjectCollection findByDescription(string $description) Return ChildService objects filtered by the description column
 * @method     ChildService[]|ObjectCollection findByDepartementId(int $departement_id) Return ChildService objects filtered by the departement_id column
 * @method     ChildService[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ServiceQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \App\Models\Base\ServiceQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\App\\Models\\Service', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildServiceQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildServiceQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildServiceQuery) {
            return $criteria;
        }
        $query = new ChildServiceQuery();
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
     * @return ChildService|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ServiceTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = ServiceTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildService A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT service_id, designation, description, departement_id FROM service WHERE service_id = :p0';
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
            /** @var ChildService $obj */
            $obj = new ChildService();
            $obj->hydrate($row);
            ServiceTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildService|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildServiceQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ServiceTableMap::COL_SERVICE_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildServiceQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ServiceTableMap::COL_SERVICE_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the service_id column
     *
     * Example usage:
     * <code>
     * $query->filterByServiceId(1234); // WHERE service_id = 1234
     * $query->filterByServiceId(array(12, 34)); // WHERE service_id IN (12, 34)
     * $query->filterByServiceId(array('min' => 12)); // WHERE service_id > 12
     * </code>
     *
     * @param     mixed $serviceId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildServiceQuery The current query, for fluid interface
     */
    public function filterByServiceId($serviceId = null, $comparison = null)
    {
        if (is_array($serviceId)) {
            $useMinMax = false;
            if (isset($serviceId['min'])) {
                $this->addUsingAlias(ServiceTableMap::COL_SERVICE_ID, $serviceId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($serviceId['max'])) {
                $this->addUsingAlias(ServiceTableMap::COL_SERVICE_ID, $serviceId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ServiceTableMap::COL_SERVICE_ID, $serviceId, $comparison);
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
     * @return $this|ChildServiceQuery The current query, for fluid interface
     */
    public function filterByDesignation($designation = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($designation)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ServiceTableMap::COL_DESIGNATION, $designation, $comparison);
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
     * @return $this|ChildServiceQuery The current query, for fluid interface
     */
    public function filterByDescription($description = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($description)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ServiceTableMap::COL_DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query on the departement_id column
     *
     * Example usage:
     * <code>
     * $query->filterByDepartementId(1234); // WHERE departement_id = 1234
     * $query->filterByDepartementId(array(12, 34)); // WHERE departement_id IN (12, 34)
     * $query->filterByDepartementId(array('min' => 12)); // WHERE departement_id > 12
     * </code>
     *
     * @see       filterByDepartement()
     *
     * @param     mixed $departementId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildServiceQuery The current query, for fluid interface
     */
    public function filterByDepartementId($departementId = null, $comparison = null)
    {
        if (is_array($departementId)) {
            $useMinMax = false;
            if (isset($departementId['min'])) {
                $this->addUsingAlias(ServiceTableMap::COL_DEPARTEMENT_ID, $departementId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($departementId['max'])) {
                $this->addUsingAlias(ServiceTableMap::COL_DEPARTEMENT_ID, $departementId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ServiceTableMap::COL_DEPARTEMENT_ID, $departementId, $comparison);
    }

    /**
     * Filter the query by a related \App\Models\Departement object
     *
     * @param \App\Models\Departement|ObjectCollection $departement The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildServiceQuery The current query, for fluid interface
     */
    public function filterByDepartement($departement, $comparison = null)
    {
        if ($departement instanceof \App\Models\Departement) {
            return $this
                ->addUsingAlias(ServiceTableMap::COL_DEPARTEMENT_ID, $departement->getDepartementId(), $comparison);
        } elseif ($departement instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ServiceTableMap::COL_DEPARTEMENT_ID, $departement->toKeyValue('PrimaryKey', 'DepartementId'), $comparison);
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
     * @return $this|ChildServiceQuery The current query, for fluid interface
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
     * Filter the query by a related \App\Models\Unite object
     *
     * @param \App\Models\Unite|ObjectCollection $unite the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildServiceQuery The current query, for fluid interface
     */
    public function filterByUnite($unite, $comparison = null)
    {
        if ($unite instanceof \App\Models\Unite) {
            return $this
                ->addUsingAlias(ServiceTableMap::COL_SERVICE_ID, $unite->getServiceId(), $comparison);
        } elseif ($unite instanceof ObjectCollection) {
            return $this
                ->useUniteQuery()
                ->filterByPrimaryKeys($unite->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByUnite() only accepts arguments of type \App\Models\Unite or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Unite relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildServiceQuery The current query, for fluid interface
     */
    public function joinUnite($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Unite');

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
            $this->addJoinObject($join, 'Unite');
        }

        return $this;
    }

    /**
     * Use the Unite relation Unite object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \App\Models\UniteQuery A secondary query class using the current class as primary query
     */
    public function useUniteQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUnite($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Unite', '\App\Models\UniteQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildService $service Object to remove from the list of results
     *
     * @return $this|ChildServiceQuery The current query, for fluid interface
     */
    public function prune($service = null)
    {
        if ($service) {
            $this->addUsingAlias(ServiceTableMap::COL_SERVICE_ID, $service->getServiceId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the service table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ServiceTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ServiceTableMap::clearInstancePool();
            ServiceTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ServiceTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ServiceTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ServiceTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ServiceTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ServiceQuery
