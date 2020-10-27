<?php

namespace App\Models\Base;

use \Exception;
use \PDO;
use App\Models\Presence as ChildPresence;
use App\Models\PresenceQuery as ChildPresenceQuery;
use App\Models\Map\PresenceTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'presence' table.
 *
 *
 *
 * @method     ChildPresenceQuery orderByPresenceId($order = Criteria::ASC) Order by the presence_id column
 * @method     ChildPresenceQuery orderByEmployeId($order = Criteria::ASC) Order by the employe_id column
 * @method     ChildPresenceQuery orderByDatePresence($order = Criteria::ASC) Order by the date_presence column
 * @method     ChildPresenceQuery orderByHeureArrive($order = Criteria::ASC) Order by the heure_arrive column
 * @method     ChildPresenceQuery orderByHeureSortie($order = Criteria::ASC) Order by the heure_sortie column
 * @method     ChildPresenceQuery orderByHeureTravail($order = Criteria::ASC) Order by the heure_travail column
 *
 * @method     ChildPresenceQuery groupByPresenceId() Group by the presence_id column
 * @method     ChildPresenceQuery groupByEmployeId() Group by the employe_id column
 * @method     ChildPresenceQuery groupByDatePresence() Group by the date_presence column
 * @method     ChildPresenceQuery groupByHeureArrive() Group by the heure_arrive column
 * @method     ChildPresenceQuery groupByHeureSortie() Group by the heure_sortie column
 * @method     ChildPresenceQuery groupByHeureTravail() Group by the heure_travail column
 *
 * @method     ChildPresenceQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPresenceQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPresenceQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPresenceQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildPresenceQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildPresenceQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildPresenceQuery leftJoinEmploye($relationAlias = null) Adds a LEFT JOIN clause to the query using the Employe relation
 * @method     ChildPresenceQuery rightJoinEmploye($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Employe relation
 * @method     ChildPresenceQuery innerJoinEmploye($relationAlias = null) Adds a INNER JOIN clause to the query using the Employe relation
 *
 * @method     ChildPresenceQuery joinWithEmploye($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Employe relation
 *
 * @method     ChildPresenceQuery leftJoinWithEmploye() Adds a LEFT JOIN clause and with to the query using the Employe relation
 * @method     ChildPresenceQuery rightJoinWithEmploye() Adds a RIGHT JOIN clause and with to the query using the Employe relation
 * @method     ChildPresenceQuery innerJoinWithEmploye() Adds a INNER JOIN clause and with to the query using the Employe relation
 *
 * @method     \App\Models\EmployeQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPresence findOne(ConnectionInterface $con = null) Return the first ChildPresence matching the query
 * @method     ChildPresence findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPresence matching the query, or a new ChildPresence object populated from the query conditions when no match is found
 *
 * @method     ChildPresence findOneByPresenceId(int $presence_id) Return the first ChildPresence filtered by the presence_id column
 * @method     ChildPresence findOneByEmployeId(int $employe_id) Return the first ChildPresence filtered by the employe_id column
 * @method     ChildPresence findOneByDatePresence(string $date_presence) Return the first ChildPresence filtered by the date_presence column
 * @method     ChildPresence findOneByHeureArrive(string $heure_arrive) Return the first ChildPresence filtered by the heure_arrive column
 * @method     ChildPresence findOneByHeureSortie(string $heure_sortie) Return the first ChildPresence filtered by the heure_sortie column
 * @method     ChildPresence findOneByHeureTravail(string $heure_travail) Return the first ChildPresence filtered by the heure_travail column *

 * @method     ChildPresence requirePk($key, ConnectionInterface $con = null) Return the ChildPresence by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPresence requireOne(ConnectionInterface $con = null) Return the first ChildPresence matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPresence requireOneByPresenceId(int $presence_id) Return the first ChildPresence filtered by the presence_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPresence requireOneByEmployeId(int $employe_id) Return the first ChildPresence filtered by the employe_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPresence requireOneByDatePresence(string $date_presence) Return the first ChildPresence filtered by the date_presence column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPresence requireOneByHeureArrive(string $heure_arrive) Return the first ChildPresence filtered by the heure_arrive column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPresence requireOneByHeureSortie(string $heure_sortie) Return the first ChildPresence filtered by the heure_sortie column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPresence requireOneByHeureTravail(string $heure_travail) Return the first ChildPresence filtered by the heure_travail column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPresence[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPresence objects based on current ModelCriteria
 * @method     ChildPresence[]|ObjectCollection findByPresenceId(int $presence_id) Return ChildPresence objects filtered by the presence_id column
 * @method     ChildPresence[]|ObjectCollection findByEmployeId(int $employe_id) Return ChildPresence objects filtered by the employe_id column
 * @method     ChildPresence[]|ObjectCollection findByDatePresence(string $date_presence) Return ChildPresence objects filtered by the date_presence column
 * @method     ChildPresence[]|ObjectCollection findByHeureArrive(string $heure_arrive) Return ChildPresence objects filtered by the heure_arrive column
 * @method     ChildPresence[]|ObjectCollection findByHeureSortie(string $heure_sortie) Return ChildPresence objects filtered by the heure_sortie column
 * @method     ChildPresence[]|ObjectCollection findByHeureTravail(string $heure_travail) Return ChildPresence objects filtered by the heure_travail column
 * @method     ChildPresence[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PresenceQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \App\Models\Base\PresenceQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\App\\Models\\Presence', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPresenceQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPresenceQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPresenceQuery) {
            return $criteria;
        }
        $query = new ChildPresenceQuery();
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
     * @return ChildPresence|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PresenceTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = PresenceTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildPresence A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT presence_id, employe_id, date_presence, heure_arrive, heure_sortie, heure_travail FROM presence WHERE presence_id = :p0';
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
            /** @var ChildPresence $obj */
            $obj = new ChildPresence();
            $obj->hydrate($row);
            PresenceTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildPresence|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildPresenceQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PresenceTableMap::COL_PRESENCE_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPresenceQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PresenceTableMap::COL_PRESENCE_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the presence_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPresenceId(1234); // WHERE presence_id = 1234
     * $query->filterByPresenceId(array(12, 34)); // WHERE presence_id IN (12, 34)
     * $query->filterByPresenceId(array('min' => 12)); // WHERE presence_id > 12
     * </code>
     *
     * @param     mixed $presenceId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPresenceQuery The current query, for fluid interface
     */
    public function filterByPresenceId($presenceId = null, $comparison = null)
    {
        if (is_array($presenceId)) {
            $useMinMax = false;
            if (isset($presenceId['min'])) {
                $this->addUsingAlias(PresenceTableMap::COL_PRESENCE_ID, $presenceId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($presenceId['max'])) {
                $this->addUsingAlias(PresenceTableMap::COL_PRESENCE_ID, $presenceId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PresenceTableMap::COL_PRESENCE_ID, $presenceId, $comparison);
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
     * @return $this|ChildPresenceQuery The current query, for fluid interface
     */
    public function filterByEmployeId($employeId = null, $comparison = null)
    {
        if (is_array($employeId)) {
            $useMinMax = false;
            if (isset($employeId['min'])) {
                $this->addUsingAlias(PresenceTableMap::COL_EMPLOYE_ID, $employeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($employeId['max'])) {
                $this->addUsingAlias(PresenceTableMap::COL_EMPLOYE_ID, $employeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PresenceTableMap::COL_EMPLOYE_ID, $employeId, $comparison);
    }

    /**
     * Filter the query on the date_presence column
     *
     * Example usage:
     * <code>
     * $query->filterByDatePresence('2011-03-14'); // WHERE date_presence = '2011-03-14'
     * $query->filterByDatePresence('now'); // WHERE date_presence = '2011-03-14'
     * $query->filterByDatePresence(array('max' => 'yesterday')); // WHERE date_presence > '2011-03-13'
     * </code>
     *
     * @param     mixed $datePresence The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPresenceQuery The current query, for fluid interface
     */
    public function filterByDatePresence($datePresence = null, $comparison = null)
    {
        if (is_array($datePresence)) {
            $useMinMax = false;
            if (isset($datePresence['min'])) {
                $this->addUsingAlias(PresenceTableMap::COL_DATE_PRESENCE, $datePresence['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($datePresence['max'])) {
                $this->addUsingAlias(PresenceTableMap::COL_DATE_PRESENCE, $datePresence['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PresenceTableMap::COL_DATE_PRESENCE, $datePresence, $comparison);
    }

    /**
     * Filter the query on the heure_arrive column
     *
     * Example usage:
     * <code>
     * $query->filterByHeureArrive('2011-03-14'); // WHERE heure_arrive = '2011-03-14'
     * $query->filterByHeureArrive('now'); // WHERE heure_arrive = '2011-03-14'
     * $query->filterByHeureArrive(array('max' => 'yesterday')); // WHERE heure_arrive > '2011-03-13'
     * </code>
     *
     * @param     mixed $heureArrive The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPresenceQuery The current query, for fluid interface
     */
    public function filterByHeureArrive($heureArrive = null, $comparison = null)
    {
        if (is_array($heureArrive)) {
            $useMinMax = false;
            if (isset($heureArrive['min'])) {
                $this->addUsingAlias(PresenceTableMap::COL_HEURE_ARRIVE, $heureArrive['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($heureArrive['max'])) {
                $this->addUsingAlias(PresenceTableMap::COL_HEURE_ARRIVE, $heureArrive['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PresenceTableMap::COL_HEURE_ARRIVE, $heureArrive, $comparison);
    }

    /**
     * Filter the query on the heure_sortie column
     *
     * Example usage:
     * <code>
     * $query->filterByHeureSortie('2011-03-14'); // WHERE heure_sortie = '2011-03-14'
     * $query->filterByHeureSortie('now'); // WHERE heure_sortie = '2011-03-14'
     * $query->filterByHeureSortie(array('max' => 'yesterday')); // WHERE heure_sortie > '2011-03-13'
     * </code>
     *
     * @param     mixed $heureSortie The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPresenceQuery The current query, for fluid interface
     */
    public function filterByHeureSortie($heureSortie = null, $comparison = null)
    {
        if (is_array($heureSortie)) {
            $useMinMax = false;
            if (isset($heureSortie['min'])) {
                $this->addUsingAlias(PresenceTableMap::COL_HEURE_SORTIE, $heureSortie['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($heureSortie['max'])) {
                $this->addUsingAlias(PresenceTableMap::COL_HEURE_SORTIE, $heureSortie['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PresenceTableMap::COL_HEURE_SORTIE, $heureSortie, $comparison);
    }

    /**
     * Filter the query on the heure_travail column
     *
     * Example usage:
     * <code>
     * $query->filterByHeureTravail('2011-03-14'); // WHERE heure_travail = '2011-03-14'
     * $query->filterByHeureTravail('now'); // WHERE heure_travail = '2011-03-14'
     * $query->filterByHeureTravail(array('max' => 'yesterday')); // WHERE heure_travail > '2011-03-13'
     * </code>
     *
     * @param     mixed $heureTravail The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPresenceQuery The current query, for fluid interface
     */
    public function filterByHeureTravail($heureTravail = null, $comparison = null)
    {
        if (is_array($heureTravail)) {
            $useMinMax = false;
            if (isset($heureTravail['min'])) {
                $this->addUsingAlias(PresenceTableMap::COL_HEURE_TRAVAIL, $heureTravail['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($heureTravail['max'])) {
                $this->addUsingAlias(PresenceTableMap::COL_HEURE_TRAVAIL, $heureTravail['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PresenceTableMap::COL_HEURE_TRAVAIL, $heureTravail, $comparison);
    }

    /**
     * Filter the query by a related \App\Models\Employe object
     *
     * @param \App\Models\Employe|ObjectCollection $employe The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPresenceQuery The current query, for fluid interface
     */
    public function filterByEmploye($employe, $comparison = null)
    {
        if ($employe instanceof \App\Models\Employe) {
            return $this
                ->addUsingAlias(PresenceTableMap::COL_EMPLOYE_ID, $employe->getEmployeId(), $comparison);
        } elseif ($employe instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PresenceTableMap::COL_EMPLOYE_ID, $employe->toKeyValue('PrimaryKey', 'EmployeId'), $comparison);
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
     * @return $this|ChildPresenceQuery The current query, for fluid interface
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
     * @param   ChildPresence $presence Object to remove from the list of results
     *
     * @return $this|ChildPresenceQuery The current query, for fluid interface
     */
    public function prune($presence = null)
    {
        if ($presence) {
            $this->addUsingAlias(PresenceTableMap::COL_PRESENCE_ID, $presence->getPresenceId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the presence table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PresenceTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PresenceTableMap::clearInstancePool();
            PresenceTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PresenceTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PresenceTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PresenceTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PresenceTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PresenceQuery
