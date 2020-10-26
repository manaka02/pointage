<?php

namespace App\Models\Base;

use \Exception;
use \PDO;
use App\Models\Departement as ChildDepartement;
use App\Models\DepartementQuery as ChildDepartementQuery;
use App\Models\Map\DepartementTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'departement' table.
 *
 *
 *
 * @method     ChildDepartementQuery orderByDepartementId($order = Criteria::ASC) Order by the departement_id column
 * @method     ChildDepartementQuery orderByDirectionId($order = Criteria::ASC) Order by the direction_id column
 * @method     ChildDepartementQuery orderByDesignation($order = Criteria::ASC) Order by the designation column
 * @method     ChildDepartementQuery orderByDescription($order = Criteria::ASC) Order by the description column
 *
 * @method     ChildDepartementQuery groupByDepartementId() Group by the departement_id column
 * @method     ChildDepartementQuery groupByDirectionId() Group by the direction_id column
 * @method     ChildDepartementQuery groupByDesignation() Group by the designation column
 * @method     ChildDepartementQuery groupByDescription() Group by the description column
 *
 * @method     ChildDepartementQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildDepartementQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildDepartementQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildDepartementQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildDepartementQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildDepartementQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildDepartementQuery leftJoinDirection($relationAlias = null) Adds a LEFT JOIN clause to the query using the Direction relation
 * @method     ChildDepartementQuery rightJoinDirection($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Direction relation
 * @method     ChildDepartementQuery innerJoinDirection($relationAlias = null) Adds a INNER JOIN clause to the query using the Direction relation
 *
 * @method     ChildDepartementQuery joinWithDirection($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Direction relation
 *
 * @method     ChildDepartementQuery leftJoinWithDirection() Adds a LEFT JOIN clause and with to the query using the Direction relation
 * @method     ChildDepartementQuery rightJoinWithDirection() Adds a RIGHT JOIN clause and with to the query using the Direction relation
 * @method     ChildDepartementQuery innerJoinWithDirection() Adds a INNER JOIN clause and with to the query using the Direction relation
 *
 * @method     ChildDepartementQuery leftJoinDebauche($relationAlias = null) Adds a LEFT JOIN clause to the query using the Debauche relation
 * @method     ChildDepartementQuery rightJoinDebauche($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Debauche relation
 * @method     ChildDepartementQuery innerJoinDebauche($relationAlias = null) Adds a INNER JOIN clause to the query using the Debauche relation
 *
 * @method     ChildDepartementQuery joinWithDebauche($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Debauche relation
 *
 * @method     ChildDepartementQuery leftJoinWithDebauche() Adds a LEFT JOIN clause and with to the query using the Debauche relation
 * @method     ChildDepartementQuery rightJoinWithDebauche() Adds a RIGHT JOIN clause and with to the query using the Debauche relation
 * @method     ChildDepartementQuery innerJoinWithDebauche() Adds a INNER JOIN clause and with to the query using the Debauche relation
 *
 * @method     ChildDepartementQuery leftJoinEmbauche($relationAlias = null) Adds a LEFT JOIN clause to the query using the Embauche relation
 * @method     ChildDepartementQuery rightJoinEmbauche($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Embauche relation
 * @method     ChildDepartementQuery innerJoinEmbauche($relationAlias = null) Adds a INNER JOIN clause to the query using the Embauche relation
 *
 * @method     ChildDepartementQuery joinWithEmbauche($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Embauche relation
 *
 * @method     ChildDepartementQuery leftJoinWithEmbauche() Adds a LEFT JOIN clause and with to the query using the Embauche relation
 * @method     ChildDepartementQuery rightJoinWithEmbauche() Adds a RIGHT JOIN clause and with to the query using the Embauche relation
 * @method     ChildDepartementQuery innerJoinWithEmbauche() Adds a INNER JOIN clause and with to the query using the Embauche relation
 *
 * @method     ChildDepartementQuery leftJoinService($relationAlias = null) Adds a LEFT JOIN clause to the query using the Service relation
 * @method     ChildDepartementQuery rightJoinService($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Service relation
 * @method     ChildDepartementQuery innerJoinService($relationAlias = null) Adds a INNER JOIN clause to the query using the Service relation
 *
 * @method     ChildDepartementQuery joinWithService($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Service relation
 *
 * @method     ChildDepartementQuery leftJoinWithService() Adds a LEFT JOIN clause and with to the query using the Service relation
 * @method     ChildDepartementQuery rightJoinWithService() Adds a RIGHT JOIN clause and with to the query using the Service relation
 * @method     ChildDepartementQuery innerJoinWithService() Adds a INNER JOIN clause and with to the query using the Service relation
 *
 * @method     \App\Models\DirectionQuery|\App\Models\DebaucheQuery|\App\Models\EmbaucheQuery|\App\Models\ServiceQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildDepartement findOne(ConnectionInterface $con = null) Return the first ChildDepartement matching the query
 * @method     ChildDepartement findOneOrCreate(ConnectionInterface $con = null) Return the first ChildDepartement matching the query, or a new ChildDepartement object populated from the query conditions when no match is found
 *
 * @method     ChildDepartement findOneByDepartementId(int $departement_id) Return the first ChildDepartement filtered by the departement_id column
 * @method     ChildDepartement findOneByDirectionId(int $direction_id) Return the first ChildDepartement filtered by the direction_id column
 * @method     ChildDepartement findOneByDesignation(string $designation) Return the first ChildDepartement filtered by the designation column
 * @method     ChildDepartement findOneByDescription(string $description) Return the first ChildDepartement filtered by the description column *

 * @method     ChildDepartement requirePk($key, ConnectionInterface $con = null) Return the ChildDepartement by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDepartement requireOne(ConnectionInterface $con = null) Return the first ChildDepartement matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDepartement requireOneByDepartementId(int $departement_id) Return the first ChildDepartement filtered by the departement_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDepartement requireOneByDirectionId(int $direction_id) Return the first ChildDepartement filtered by the direction_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDepartement requireOneByDesignation(string $designation) Return the first ChildDepartement filtered by the designation column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDepartement requireOneByDescription(string $description) Return the first ChildDepartement filtered by the description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDepartement[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildDepartement objects based on current ModelCriteria
 * @method     ChildDepartement[]|ObjectCollection findByDepartementId(int $departement_id) Return ChildDepartement objects filtered by the departement_id column
 * @method     ChildDepartement[]|ObjectCollection findByDirectionId(int $direction_id) Return ChildDepartement objects filtered by the direction_id column
 * @method     ChildDepartement[]|ObjectCollection findByDesignation(string $designation) Return ChildDepartement objects filtered by the designation column
 * @method     ChildDepartement[]|ObjectCollection findByDescription(string $description) Return ChildDepartement objects filtered by the description column
 * @method     ChildDepartement[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class DepartementQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \App\Models\Base\DepartementQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\App\\Models\\Departement', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildDepartementQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildDepartementQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildDepartementQuery) {
            return $criteria;
        }
        $query = new ChildDepartementQuery();
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
     * @return ChildDepartement|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(DepartementTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = DepartementTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildDepartement A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT departement_id, direction_id, designation, description FROM departement WHERE departement_id = :p0';
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
            /** @var ChildDepartement $obj */
            $obj = new ChildDepartement();
            $obj->hydrate($row);
            DepartementTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildDepartement|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildDepartementQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(DepartementTableMap::COL_DEPARTEMENT_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildDepartementQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(DepartementTableMap::COL_DEPARTEMENT_ID, $keys, Criteria::IN);
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
     * @param     mixed $departementId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDepartementQuery The current query, for fluid interface
     */
    public function filterByDepartementId($departementId = null, $comparison = null)
    {
        if (is_array($departementId)) {
            $useMinMax = false;
            if (isset($departementId['min'])) {
                $this->addUsingAlias(DepartementTableMap::COL_DEPARTEMENT_ID, $departementId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($departementId['max'])) {
                $this->addUsingAlias(DepartementTableMap::COL_DEPARTEMENT_ID, $departementId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DepartementTableMap::COL_DEPARTEMENT_ID, $departementId, $comparison);
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
     * @see       filterByDirection()
     *
     * @param     mixed $directionId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDepartementQuery The current query, for fluid interface
     */
    public function filterByDirectionId($directionId = null, $comparison = null)
    {
        if (is_array($directionId)) {
            $useMinMax = false;
            if (isset($directionId['min'])) {
                $this->addUsingAlias(DepartementTableMap::COL_DIRECTION_ID, $directionId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($directionId['max'])) {
                $this->addUsingAlias(DepartementTableMap::COL_DIRECTION_ID, $directionId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DepartementTableMap::COL_DIRECTION_ID, $directionId, $comparison);
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
     * @return $this|ChildDepartementQuery The current query, for fluid interface
     */
    public function filterByDesignation($designation = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($designation)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DepartementTableMap::COL_DESIGNATION, $designation, $comparison);
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
     * @return $this|ChildDepartementQuery The current query, for fluid interface
     */
    public function filterByDescription($description = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($description)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DepartementTableMap::COL_DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query by a related \App\Models\Direction object
     *
     * @param \App\Models\Direction|ObjectCollection $direction The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildDepartementQuery The current query, for fluid interface
     */
    public function filterByDirection($direction, $comparison = null)
    {
        if ($direction instanceof \App\Models\Direction) {
            return $this
                ->addUsingAlias(DepartementTableMap::COL_DIRECTION_ID, $direction->getDirectionId(), $comparison);
        } elseif ($direction instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(DepartementTableMap::COL_DIRECTION_ID, $direction->toKeyValue('PrimaryKey', 'DirectionId'), $comparison);
        } else {
            throw new PropelException('filterByDirection() only accepts arguments of type \App\Models\Direction or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Direction relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildDepartementQuery The current query, for fluid interface
     */
    public function joinDirection($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Direction');

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
            $this->addJoinObject($join, 'Direction');
        }

        return $this;
    }

    /**
     * Use the Direction relation Direction object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \App\Models\DirectionQuery A secondary query class using the current class as primary query
     */
    public function useDirectionQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinDirection($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Direction', '\App\Models\DirectionQuery');
    }

    /**
     * Filter the query by a related \App\Models\Debauche object
     *
     * @param \App\Models\Debauche|ObjectCollection $debauche the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDepartementQuery The current query, for fluid interface
     */
    public function filterByDebauche($debauche, $comparison = null)
    {
        if ($debauche instanceof \App\Models\Debauche) {
            return $this
                ->addUsingAlias(DepartementTableMap::COL_DEPARTEMENT_ID, $debauche->getDepartementId(), $comparison);
        } elseif ($debauche instanceof ObjectCollection) {
            return $this
                ->useDebaucheQuery()
                ->filterByPrimaryKeys($debauche->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByDebauche() only accepts arguments of type \App\Models\Debauche or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Debauche relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildDepartementQuery The current query, for fluid interface
     */
    public function joinDebauche($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Debauche');

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
            $this->addJoinObject($join, 'Debauche');
        }

        return $this;
    }

    /**
     * Use the Debauche relation Debauche object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \App\Models\DebaucheQuery A secondary query class using the current class as primary query
     */
    public function useDebaucheQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinDebauche($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Debauche', '\App\Models\DebaucheQuery');
    }

    /**
     * Filter the query by a related \App\Models\Embauche object
     *
     * @param \App\Models\Embauche|ObjectCollection $embauche the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDepartementQuery The current query, for fluid interface
     */
    public function filterByEmbauche($embauche, $comparison = null)
    {
        if ($embauche instanceof \App\Models\Embauche) {
            return $this
                ->addUsingAlias(DepartementTableMap::COL_DEPARTEMENT_ID, $embauche->getDepartementId(), $comparison);
        } elseif ($embauche instanceof ObjectCollection) {
            return $this
                ->useEmbaucheQuery()
                ->filterByPrimaryKeys($embauche->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByEmbauche() only accepts arguments of type \App\Models\Embauche or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Embauche relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildDepartementQuery The current query, for fluid interface
     */
    public function joinEmbauche($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Embauche');

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
            $this->addJoinObject($join, 'Embauche');
        }

        return $this;
    }

    /**
     * Use the Embauche relation Embauche object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \App\Models\EmbaucheQuery A secondary query class using the current class as primary query
     */
    public function useEmbaucheQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinEmbauche($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Embauche', '\App\Models\EmbaucheQuery');
    }

    /**
     * Filter the query by a related \App\Models\Service object
     *
     * @param \App\Models\Service|ObjectCollection $service the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDepartementQuery The current query, for fluid interface
     */
    public function filterByService($service, $comparison = null)
    {
        if ($service instanceof \App\Models\Service) {
            return $this
                ->addUsingAlias(DepartementTableMap::COL_DEPARTEMENT_ID, $service->getDepartementId(), $comparison);
        } elseif ($service instanceof ObjectCollection) {
            return $this
                ->useServiceQuery()
                ->filterByPrimaryKeys($service->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByService() only accepts arguments of type \App\Models\Service or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Service relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildDepartementQuery The current query, for fluid interface
     */
    public function joinService($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Service');

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
            $this->addJoinObject($join, 'Service');
        }

        return $this;
    }

    /**
     * Use the Service relation Service object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \App\Models\ServiceQuery A secondary query class using the current class as primary query
     */
    public function useServiceQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinService($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Service', '\App\Models\ServiceQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildDepartement $departement Object to remove from the list of results
     *
     * @return $this|ChildDepartementQuery The current query, for fluid interface
     */
    public function prune($departement = null)
    {
        if ($departement) {
            $this->addUsingAlias(DepartementTableMap::COL_DEPARTEMENT_ID, $departement->getDepartementId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the departement table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DepartementTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            DepartementTableMap::clearInstancePool();
            DepartementTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(DepartementTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(DepartementTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            DepartementTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            DepartementTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // DepartementQuery
