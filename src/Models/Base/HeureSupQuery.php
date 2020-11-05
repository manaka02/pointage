<?php

namespace App\Models\Base;

use \Exception;
use \PDO;
use App\Models\HeureSup as ChildHeureSup;
use App\Models\HeureSupQuery as ChildHeureSupQuery;
use App\Models\Map\HeureSupTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'heure_sup' table.
 *
 *
 *
 * @method     ChildHeureSupQuery orderByHeureSupId($order = Criteria::ASC) Order by the heure_sup_id column
 * @method     ChildHeureSupQuery orderByEmployeId($order = Criteria::ASC) Order by the employe_id column
 * @method     ChildHeureSupQuery orderByDateHeureSup($order = Criteria::ASC) Order by the date_heure_sup column
 * @method     ChildHeureSupQuery orderByHeureEntree($order = Criteria::ASC) Order by the heure_entree column
 * @method     ChildHeureSupQuery orderByHeureSortie($order = Criteria::ASC) Order by the heure_sortie column
 * @method     ChildHeureSupQuery orderByHeureTravail($order = Criteria::ASC) Order by the heure_travail column
 * @method     ChildHeureSupQuery orderByHeureSupp($order = Criteria::ASC) Order by the heure_supp column
 * @method     ChildHeureSupQuery orderByHeureSupNormal($order = Criteria::ASC) Order by the heure_sup_normal column
 * @method     ChildHeureSupQuery orderByHeureSupExtra($order = Criteria::ASC) Order by the heure_sup_extra column
 * @method     ChildHeureSupQuery orderByHeureSupSamedi($order = Criteria::ASC) Order by the heure_sup_samedi column
 *
 * @method     ChildHeureSupQuery groupByHeureSupId() Group by the heure_sup_id column
 * @method     ChildHeureSupQuery groupByEmployeId() Group by the employe_id column
 * @method     ChildHeureSupQuery groupByDateHeureSup() Group by the date_heure_sup column
 * @method     ChildHeureSupQuery groupByHeureEntree() Group by the heure_entree column
 * @method     ChildHeureSupQuery groupByHeureSortie() Group by the heure_sortie column
 * @method     ChildHeureSupQuery groupByHeureTravail() Group by the heure_travail column
 * @method     ChildHeureSupQuery groupByHeureSupp() Group by the heure_supp column
 * @method     ChildHeureSupQuery groupByHeureSupNormal() Group by the heure_sup_normal column
 * @method     ChildHeureSupQuery groupByHeureSupExtra() Group by the heure_sup_extra column
 * @method     ChildHeureSupQuery groupByHeureSupSamedi() Group by the heure_sup_samedi column
 *
 * @method     ChildHeureSupQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildHeureSupQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildHeureSupQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildHeureSupQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildHeureSupQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildHeureSupQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildHeureSupQuery leftJoinEmploye($relationAlias = null) Adds a LEFT JOIN clause to the query using the Employe relation
 * @method     ChildHeureSupQuery rightJoinEmploye($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Employe relation
 * @method     ChildHeureSupQuery innerJoinEmploye($relationAlias = null) Adds a INNER JOIN clause to the query using the Employe relation
 *
 * @method     ChildHeureSupQuery joinWithEmploye($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Employe relation
 *
 * @method     ChildHeureSupQuery leftJoinWithEmploye() Adds a LEFT JOIN clause and with to the query using the Employe relation
 * @method     ChildHeureSupQuery rightJoinWithEmploye() Adds a RIGHT JOIN clause and with to the query using the Employe relation
 * @method     ChildHeureSupQuery innerJoinWithEmploye() Adds a INNER JOIN clause and with to the query using the Employe relation
 *
 * @method     \App\Models\EmployeQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildHeureSup findOne(ConnectionInterface $con = null) Return the first ChildHeureSup matching the query
 * @method     ChildHeureSup findOneOrCreate(ConnectionInterface $con = null) Return the first ChildHeureSup matching the query, or a new ChildHeureSup object populated from the query conditions when no match is found
 *
 * @method     ChildHeureSup findOneByHeureSupId(int $heure_sup_id) Return the first ChildHeureSup filtered by the heure_sup_id column
 * @method     ChildHeureSup findOneByEmployeId(int $employe_id) Return the first ChildHeureSup filtered by the employe_id column
 * @method     ChildHeureSup findOneByDateHeureSup(string $date_heure_sup) Return the first ChildHeureSup filtered by the date_heure_sup column
 * @method     ChildHeureSup findOneByHeureEntree(string $heure_entree) Return the first ChildHeureSup filtered by the heure_entree column
 * @method     ChildHeureSup findOneByHeureSortie(string $heure_sortie) Return the first ChildHeureSup filtered by the heure_sortie column
 * @method     ChildHeureSup findOneByHeureTravail(string $heure_travail) Return the first ChildHeureSup filtered by the heure_travail column
 * @method     ChildHeureSup findOneByHeureSupp(string $heure_supp) Return the first ChildHeureSup filtered by the heure_supp column
 * @method     ChildHeureSup findOneByHeureSupNormal(string $heure_sup_normal) Return the first ChildHeureSup filtered by the heure_sup_normal column
 * @method     ChildHeureSup findOneByHeureSupExtra(string $heure_sup_extra) Return the first ChildHeureSup filtered by the heure_sup_extra column
 * @method     ChildHeureSup findOneByHeureSupSamedi(string $heure_sup_samedi) Return the first ChildHeureSup filtered by the heure_sup_samedi column *

 * @method     ChildHeureSup requirePk($key, ConnectionInterface $con = null) Return the ChildHeureSup by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildHeureSup requireOne(ConnectionInterface $con = null) Return the first ChildHeureSup matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildHeureSup requireOneByHeureSupId(int $heure_sup_id) Return the first ChildHeureSup filtered by the heure_sup_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildHeureSup requireOneByEmployeId(int $employe_id) Return the first ChildHeureSup filtered by the employe_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildHeureSup requireOneByDateHeureSup(string $date_heure_sup) Return the first ChildHeureSup filtered by the date_heure_sup column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildHeureSup requireOneByHeureEntree(string $heure_entree) Return the first ChildHeureSup filtered by the heure_entree column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildHeureSup requireOneByHeureSortie(string $heure_sortie) Return the first ChildHeureSup filtered by the heure_sortie column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildHeureSup requireOneByHeureTravail(string $heure_travail) Return the first ChildHeureSup filtered by the heure_travail column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildHeureSup requireOneByHeureSupp(string $heure_supp) Return the first ChildHeureSup filtered by the heure_supp column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildHeureSup requireOneByHeureSupNormal(string $heure_sup_normal) Return the first ChildHeureSup filtered by the heure_sup_normal column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildHeureSup requireOneByHeureSupExtra(string $heure_sup_extra) Return the first ChildHeureSup filtered by the heure_sup_extra column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildHeureSup requireOneByHeureSupSamedi(string $heure_sup_samedi) Return the first ChildHeureSup filtered by the heure_sup_samedi column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildHeureSup[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildHeureSup objects based on current ModelCriteria
 * @method     ChildHeureSup[]|ObjectCollection findByHeureSupId(int $heure_sup_id) Return ChildHeureSup objects filtered by the heure_sup_id column
 * @method     ChildHeureSup[]|ObjectCollection findByEmployeId(int $employe_id) Return ChildHeureSup objects filtered by the employe_id column
 * @method     ChildHeureSup[]|ObjectCollection findByDateHeureSup(string $date_heure_sup) Return ChildHeureSup objects filtered by the date_heure_sup column
 * @method     ChildHeureSup[]|ObjectCollection findByHeureEntree(string $heure_entree) Return ChildHeureSup objects filtered by the heure_entree column
 * @method     ChildHeureSup[]|ObjectCollection findByHeureSortie(string $heure_sortie) Return ChildHeureSup objects filtered by the heure_sortie column
 * @method     ChildHeureSup[]|ObjectCollection findByHeureTravail(string $heure_travail) Return ChildHeureSup objects filtered by the heure_travail column
 * @method     ChildHeureSup[]|ObjectCollection findByHeureSupp(string $heure_supp) Return ChildHeureSup objects filtered by the heure_supp column
 * @method     ChildHeureSup[]|ObjectCollection findByHeureSupNormal(string $heure_sup_normal) Return ChildHeureSup objects filtered by the heure_sup_normal column
 * @method     ChildHeureSup[]|ObjectCollection findByHeureSupExtra(string $heure_sup_extra) Return ChildHeureSup objects filtered by the heure_sup_extra column
 * @method     ChildHeureSup[]|ObjectCollection findByHeureSupSamedi(string $heure_sup_samedi) Return ChildHeureSup objects filtered by the heure_sup_samedi column
 * @method     ChildHeureSup[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class HeureSupQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \App\Models\Base\HeureSupQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\App\\Models\\HeureSup', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildHeureSupQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildHeureSupQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildHeureSupQuery) {
            return $criteria;
        }
        $query = new ChildHeureSupQuery();
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
     * @return ChildHeureSup|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(HeureSupTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = HeureSupTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildHeureSup A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT heure_sup_id, employe_id, date_heure_sup, heure_entree, heure_sortie, heure_travail, heure_supp, heure_sup_normal, heure_sup_extra, heure_sup_samedi FROM heure_sup WHERE heure_sup_id = :p0';
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
            /** @var ChildHeureSup $obj */
            $obj = new ChildHeureSup();
            $obj->hydrate($row);
            HeureSupTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildHeureSup|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildHeureSupQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(HeureSupTableMap::COL_HEURE_SUP_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildHeureSupQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(HeureSupTableMap::COL_HEURE_SUP_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the heure_sup_id column
     *
     * Example usage:
     * <code>
     * $query->filterByHeureSupId(1234); // WHERE heure_sup_id = 1234
     * $query->filterByHeureSupId(array(12, 34)); // WHERE heure_sup_id IN (12, 34)
     * $query->filterByHeureSupId(array('min' => 12)); // WHERE heure_sup_id > 12
     * </code>
     *
     * @param     mixed $heureSupId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildHeureSupQuery The current query, for fluid interface
     */
    public function filterByHeureSupId($heureSupId = null, $comparison = null)
    {
        if (is_array($heureSupId)) {
            $useMinMax = false;
            if (isset($heureSupId['min'])) {
                $this->addUsingAlias(HeureSupTableMap::COL_HEURE_SUP_ID, $heureSupId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($heureSupId['max'])) {
                $this->addUsingAlias(HeureSupTableMap::COL_HEURE_SUP_ID, $heureSupId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HeureSupTableMap::COL_HEURE_SUP_ID, $heureSupId, $comparison);
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
     * @return $this|ChildHeureSupQuery The current query, for fluid interface
     */
    public function filterByEmployeId($employeId = null, $comparison = null)
    {
        if (is_array($employeId)) {
            $useMinMax = false;
            if (isset($employeId['min'])) {
                $this->addUsingAlias(HeureSupTableMap::COL_EMPLOYE_ID, $employeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($employeId['max'])) {
                $this->addUsingAlias(HeureSupTableMap::COL_EMPLOYE_ID, $employeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HeureSupTableMap::COL_EMPLOYE_ID, $employeId, $comparison);
    }

    /**
     * Filter the query on the date_heure_sup column
     *
     * Example usage:
     * <code>
     * $query->filterByDateHeureSup('2011-03-14'); // WHERE date_heure_sup = '2011-03-14'
     * $query->filterByDateHeureSup('now'); // WHERE date_heure_sup = '2011-03-14'
     * $query->filterByDateHeureSup(array('max' => 'yesterday')); // WHERE date_heure_sup > '2011-03-13'
     * </code>
     *
     * @param     mixed $dateHeureSup The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildHeureSupQuery The current query, for fluid interface
     */
    public function filterByDateHeureSup($dateHeureSup = null, $comparison = null)
    {
        if (is_array($dateHeureSup)) {
            $useMinMax = false;
            if (isset($dateHeureSup['min'])) {
                $this->addUsingAlias(HeureSupTableMap::COL_DATE_HEURE_SUP, $dateHeureSup['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateHeureSup['max'])) {
                $this->addUsingAlias(HeureSupTableMap::COL_DATE_HEURE_SUP, $dateHeureSup['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HeureSupTableMap::COL_DATE_HEURE_SUP, $dateHeureSup, $comparison);
    }

    /**
     * Filter the query on the heure_entree column
     *
     * Example usage:
     * <code>
     * $query->filterByHeureEntree('2011-03-14'); // WHERE heure_entree = '2011-03-14'
     * $query->filterByHeureEntree('now'); // WHERE heure_entree = '2011-03-14'
     * $query->filterByHeureEntree(array('max' => 'yesterday')); // WHERE heure_entree > '2011-03-13'
     * </code>
     *
     * @param     mixed $heureEntree The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildHeureSupQuery The current query, for fluid interface
     */
    public function filterByHeureEntree($heureEntree = null, $comparison = null)
    {
        if (is_array($heureEntree)) {
            $useMinMax = false;
            if (isset($heureEntree['min'])) {
                $this->addUsingAlias(HeureSupTableMap::COL_HEURE_ENTREE, $heureEntree['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($heureEntree['max'])) {
                $this->addUsingAlias(HeureSupTableMap::COL_HEURE_ENTREE, $heureEntree['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HeureSupTableMap::COL_HEURE_ENTREE, $heureEntree, $comparison);
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
     * @return $this|ChildHeureSupQuery The current query, for fluid interface
     */
    public function filterByHeureSortie($heureSortie = null, $comparison = null)
    {
        if (is_array($heureSortie)) {
            $useMinMax = false;
            if (isset($heureSortie['min'])) {
                $this->addUsingAlias(HeureSupTableMap::COL_HEURE_SORTIE, $heureSortie['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($heureSortie['max'])) {
                $this->addUsingAlias(HeureSupTableMap::COL_HEURE_SORTIE, $heureSortie['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HeureSupTableMap::COL_HEURE_SORTIE, $heureSortie, $comparison);
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
     * @return $this|ChildHeureSupQuery The current query, for fluid interface
     */
    public function filterByHeureTravail($heureTravail = null, $comparison = null)
    {
        if (is_array($heureTravail)) {
            $useMinMax = false;
            if (isset($heureTravail['min'])) {
                $this->addUsingAlias(HeureSupTableMap::COL_HEURE_TRAVAIL, $heureTravail['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($heureTravail['max'])) {
                $this->addUsingAlias(HeureSupTableMap::COL_HEURE_TRAVAIL, $heureTravail['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HeureSupTableMap::COL_HEURE_TRAVAIL, $heureTravail, $comparison);
    }

    /**
     * Filter the query on the heure_supp column
     *
     * Example usage:
     * <code>
     * $query->filterByHeureSupp('2011-03-14'); // WHERE heure_supp = '2011-03-14'
     * $query->filterByHeureSupp('now'); // WHERE heure_supp = '2011-03-14'
     * $query->filterByHeureSupp(array('max' => 'yesterday')); // WHERE heure_supp > '2011-03-13'
     * </code>
     *
     * @param     mixed $heureSupp The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildHeureSupQuery The current query, for fluid interface
     */
    public function filterByHeureSupp($heureSupp = null, $comparison = null)
    {
        if (is_array($heureSupp)) {
            $useMinMax = false;
            if (isset($heureSupp['min'])) {
                $this->addUsingAlias(HeureSupTableMap::COL_HEURE_SUPP, $heureSupp['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($heureSupp['max'])) {
                $this->addUsingAlias(HeureSupTableMap::COL_HEURE_SUPP, $heureSupp['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HeureSupTableMap::COL_HEURE_SUPP, $heureSupp, $comparison);
    }

    /**
     * Filter the query on the heure_sup_normal column
     *
     * Example usage:
     * <code>
     * $query->filterByHeureSupNormal('2011-03-14'); // WHERE heure_sup_normal = '2011-03-14'
     * $query->filterByHeureSupNormal('now'); // WHERE heure_sup_normal = '2011-03-14'
     * $query->filterByHeureSupNormal(array('max' => 'yesterday')); // WHERE heure_sup_normal > '2011-03-13'
     * </code>
     *
     * @param     mixed $heureSupNormal The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildHeureSupQuery The current query, for fluid interface
     */
    public function filterByHeureSupNormal($heureSupNormal = null, $comparison = null)
    {
        if (is_array($heureSupNormal)) {
            $useMinMax = false;
            if (isset($heureSupNormal['min'])) {
                $this->addUsingAlias(HeureSupTableMap::COL_HEURE_SUP_NORMAL, $heureSupNormal['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($heureSupNormal['max'])) {
                $this->addUsingAlias(HeureSupTableMap::COL_HEURE_SUP_NORMAL, $heureSupNormal['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HeureSupTableMap::COL_HEURE_SUP_NORMAL, $heureSupNormal, $comparison);
    }

    /**
     * Filter the query on the heure_sup_extra column
     *
     * Example usage:
     * <code>
     * $query->filterByHeureSupExtra('2011-03-14'); // WHERE heure_sup_extra = '2011-03-14'
     * $query->filterByHeureSupExtra('now'); // WHERE heure_sup_extra = '2011-03-14'
     * $query->filterByHeureSupExtra(array('max' => 'yesterday')); // WHERE heure_sup_extra > '2011-03-13'
     * </code>
     *
     * @param     mixed $heureSupExtra The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildHeureSupQuery The current query, for fluid interface
     */
    public function filterByHeureSupExtra($heureSupExtra = null, $comparison = null)
    {
        if (is_array($heureSupExtra)) {
            $useMinMax = false;
            if (isset($heureSupExtra['min'])) {
                $this->addUsingAlias(HeureSupTableMap::COL_HEURE_SUP_EXTRA, $heureSupExtra['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($heureSupExtra['max'])) {
                $this->addUsingAlias(HeureSupTableMap::COL_HEURE_SUP_EXTRA, $heureSupExtra['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HeureSupTableMap::COL_HEURE_SUP_EXTRA, $heureSupExtra, $comparison);
    }

    /**
     * Filter the query on the heure_sup_samedi column
     *
     * Example usage:
     * <code>
     * $query->filterByHeureSupSamedi('2011-03-14'); // WHERE heure_sup_samedi = '2011-03-14'
     * $query->filterByHeureSupSamedi('now'); // WHERE heure_sup_samedi = '2011-03-14'
     * $query->filterByHeureSupSamedi(array('max' => 'yesterday')); // WHERE heure_sup_samedi > '2011-03-13'
     * </code>
     *
     * @param     mixed $heureSupSamedi The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildHeureSupQuery The current query, for fluid interface
     */
    public function filterByHeureSupSamedi($heureSupSamedi = null, $comparison = null)
    {
        if (is_array($heureSupSamedi)) {
            $useMinMax = false;
            if (isset($heureSupSamedi['min'])) {
                $this->addUsingAlias(HeureSupTableMap::COL_HEURE_SUP_SAMEDI, $heureSupSamedi['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($heureSupSamedi['max'])) {
                $this->addUsingAlias(HeureSupTableMap::COL_HEURE_SUP_SAMEDI, $heureSupSamedi['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HeureSupTableMap::COL_HEURE_SUP_SAMEDI, $heureSupSamedi, $comparison);
    }

    /**
     * Filter the query by a related \App\Models\Employe object
     *
     * @param \App\Models\Employe|ObjectCollection $employe The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildHeureSupQuery The current query, for fluid interface
     */
    public function filterByEmploye($employe, $comparison = null)
    {
        if ($employe instanceof \App\Models\Employe) {
            return $this
                ->addUsingAlias(HeureSupTableMap::COL_EMPLOYE_ID, $employe->getEmployeId(), $comparison);
        } elseif ($employe instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(HeureSupTableMap::COL_EMPLOYE_ID, $employe->toKeyValue('PrimaryKey', 'EmployeId'), $comparison);
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
     * @return $this|ChildHeureSupQuery The current query, for fluid interface
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
     * @param   ChildHeureSup $heureSup Object to remove from the list of results
     *
     * @return $this|ChildHeureSupQuery The current query, for fluid interface
     */
    public function prune($heureSup = null)
    {
        if ($heureSup) {
            $this->addUsingAlias(HeureSupTableMap::COL_HEURE_SUP_ID, $heureSup->getHeureSupId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the heure_sup table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(HeureSupTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            HeureSupTableMap::clearInstancePool();
            HeureSupTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(HeureSupTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(HeureSupTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            HeureSupTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            HeureSupTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // HeureSupQuery
