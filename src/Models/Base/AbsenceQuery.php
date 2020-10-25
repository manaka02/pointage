<?php

namespace App\Models\Base;

use \Exception;
use \PDO;
use App\Models\Absence as ChildAbsence;
use App\Models\AbsenceQuery as ChildAbsenceQuery;
use App\Models\Map\AbsenceTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'absence' table.
 *
 *
 *
 * @method     ChildAbsenceQuery orderByAbsenceId($order = Criteria::ASC) Order by the absence_id column
 * @method     ChildAbsenceQuery orderByEmployeId($order = Criteria::ASC) Order by the employe_id column
 * @method     ChildAbsenceQuery orderByDateAbsence($order = Criteria::ASC) Order by the date_absence column
 *
 * @method     ChildAbsenceQuery groupByAbsenceId() Group by the absence_id column
 * @method     ChildAbsenceQuery groupByEmployeId() Group by the employe_id column
 * @method     ChildAbsenceQuery groupByDateAbsence() Group by the date_absence column
 *
 * @method     ChildAbsenceQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAbsenceQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAbsenceQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAbsenceQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildAbsenceQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildAbsenceQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildAbsenceQuery leftJoinEmploye($relationAlias = null) Adds a LEFT JOIN clause to the query using the Employe relation
 * @method     ChildAbsenceQuery rightJoinEmploye($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Employe relation
 * @method     ChildAbsenceQuery innerJoinEmploye($relationAlias = null) Adds a INNER JOIN clause to the query using the Employe relation
 *
 * @method     ChildAbsenceQuery joinWithEmploye($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Employe relation
 *
 * @method     ChildAbsenceQuery leftJoinWithEmploye() Adds a LEFT JOIN clause and with to the query using the Employe relation
 * @method     ChildAbsenceQuery rightJoinWithEmploye() Adds a RIGHT JOIN clause and with to the query using the Employe relation
 * @method     ChildAbsenceQuery innerJoinWithEmploye() Adds a INNER JOIN clause and with to the query using the Employe relation
 *
 * @method     \App\Models\EmployeQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildAbsence findOne(ConnectionInterface $con = null) Return the first ChildAbsence matching the query
 * @method     ChildAbsence findOneOrCreate(ConnectionInterface $con = null) Return the first ChildAbsence matching the query, or a new ChildAbsence object populated from the query conditions when no match is found
 *
 * @method     ChildAbsence findOneByAbsenceId(int $absence_id) Return the first ChildAbsence filtered by the absence_id column
 * @method     ChildAbsence findOneByEmployeId(int $employe_id) Return the first ChildAbsence filtered by the employe_id column
 * @method     ChildAbsence findOneByDateAbsence(int $date_absence) Return the first ChildAbsence filtered by the date_absence column *

 * @method     ChildAbsence requirePk($key, ConnectionInterface $con = null) Return the ChildAbsence by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAbsence requireOne(ConnectionInterface $con = null) Return the first ChildAbsence matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAbsence requireOneByAbsenceId(int $absence_id) Return the first ChildAbsence filtered by the absence_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAbsence requireOneByEmployeId(int $employe_id) Return the first ChildAbsence filtered by the employe_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAbsence requireOneByDateAbsence(int $date_absence) Return the first ChildAbsence filtered by the date_absence column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAbsence[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildAbsence objects based on current ModelCriteria
 * @method     ChildAbsence[]|ObjectCollection findByAbsenceId(int $absence_id) Return ChildAbsence objects filtered by the absence_id column
 * @method     ChildAbsence[]|ObjectCollection findByEmployeId(int $employe_id) Return ChildAbsence objects filtered by the employe_id column
 * @method     ChildAbsence[]|ObjectCollection findByDateAbsence(int $date_absence) Return ChildAbsence objects filtered by the date_absence column
 * @method     ChildAbsence[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class AbsenceQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \App\Models\Base\AbsenceQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\App\\Models\\Absence', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAbsenceQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAbsenceQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildAbsenceQuery) {
            return $criteria;
        }
        $query = new ChildAbsenceQuery();
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
     * @return ChildAbsence|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AbsenceTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = AbsenceTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildAbsence A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT absence_id, employe_id, date_absence FROM absence WHERE absence_id = :p0';
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
            /** @var ChildAbsence $obj */
            $obj = new ChildAbsence();
            $obj->hydrate($row);
            AbsenceTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildAbsence|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildAbsenceQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AbsenceTableMap::COL_ABSENCE_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildAbsenceQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AbsenceTableMap::COL_ABSENCE_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the absence_id column
     *
     * Example usage:
     * <code>
     * $query->filterByAbsenceId(1234); // WHERE absence_id = 1234
     * $query->filterByAbsenceId(array(12, 34)); // WHERE absence_id IN (12, 34)
     * $query->filterByAbsenceId(array('min' => 12)); // WHERE absence_id > 12
     * </code>
     *
     * @param     mixed $absenceId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAbsenceQuery The current query, for fluid interface
     */
    public function filterByAbsenceId($absenceId = null, $comparison = null)
    {
        if (is_array($absenceId)) {
            $useMinMax = false;
            if (isset($absenceId['min'])) {
                $this->addUsingAlias(AbsenceTableMap::COL_ABSENCE_ID, $absenceId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($absenceId['max'])) {
                $this->addUsingAlias(AbsenceTableMap::COL_ABSENCE_ID, $absenceId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AbsenceTableMap::COL_ABSENCE_ID, $absenceId, $comparison);
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
     * @return $this|ChildAbsenceQuery The current query, for fluid interface
     */
    public function filterByEmployeId($employeId = null, $comparison = null)
    {
        if (is_array($employeId)) {
            $useMinMax = false;
            if (isset($employeId['min'])) {
                $this->addUsingAlias(AbsenceTableMap::COL_EMPLOYE_ID, $employeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($employeId['max'])) {
                $this->addUsingAlias(AbsenceTableMap::COL_EMPLOYE_ID, $employeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AbsenceTableMap::COL_EMPLOYE_ID, $employeId, $comparison);
    }

    /**
     * Filter the query on the date_absence column
     *
     * Example usage:
     * <code>
     * $query->filterByDateAbsence(1234); // WHERE date_absence = 1234
     * $query->filterByDateAbsence(array(12, 34)); // WHERE date_absence IN (12, 34)
     * $query->filterByDateAbsence(array('min' => 12)); // WHERE date_absence > 12
     * </code>
     *
     * @param     mixed $dateAbsence The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAbsenceQuery The current query, for fluid interface
     */
    public function filterByDateAbsence($dateAbsence = null, $comparison = null)
    {
        if (is_array($dateAbsence)) {
            $useMinMax = false;
            if (isset($dateAbsence['min'])) {
                $this->addUsingAlias(AbsenceTableMap::COL_DATE_ABSENCE, $dateAbsence['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateAbsence['max'])) {
                $this->addUsingAlias(AbsenceTableMap::COL_DATE_ABSENCE, $dateAbsence['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AbsenceTableMap::COL_DATE_ABSENCE, $dateAbsence, $comparison);
    }

    /**
     * Filter the query by a related \App\Models\Employe object
     *
     * @param \App\Models\Employe|ObjectCollection $employe The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildAbsenceQuery The current query, for fluid interface
     */
    public function filterByEmploye($employe, $comparison = null)
    {
        if ($employe instanceof \App\Models\Employe) {
            return $this
                ->addUsingAlias(AbsenceTableMap::COL_EMPLOYE_ID, $employe->getEmployeId(), $comparison);
        } elseif ($employe instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AbsenceTableMap::COL_EMPLOYE_ID, $employe->toKeyValue('PrimaryKey', 'EmployeId'), $comparison);
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
     * @return $this|ChildAbsenceQuery The current query, for fluid interface
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
     * @param   ChildAbsence $absence Object to remove from the list of results
     *
     * @return $this|ChildAbsenceQuery The current query, for fluid interface
     */
    public function prune($absence = null)
    {
        if ($absence) {
            $this->addUsingAlias(AbsenceTableMap::COL_ABSENCE_ID, $absence->getAbsenceId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the absence table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AbsenceTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AbsenceTableMap::clearInstancePool();
            AbsenceTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(AbsenceTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AbsenceTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            AbsenceTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            AbsenceTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // AbsenceQuery
