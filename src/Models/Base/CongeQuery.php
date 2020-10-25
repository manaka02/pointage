<?php

namespace App\Models\Base;

use \Exception;
use \PDO;
use App\Models\Conge as ChildConge;
use App\Models\CongeQuery as ChildCongeQuery;
use App\Models\Map\CongeTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'conge' table.
 *
 *
 *
 * @method     ChildCongeQuery orderByCongeId($order = Criteria::ASC) Order by the conge_id column
 * @method     ChildCongeQuery orderByEmployeId($order = Criteria::ASC) Order by the employe_id column
 * @method     ChildCongeQuery orderByDateDebut($order = Criteria::ASC) Order by the date_debut column
 * @method     ChildCongeQuery orderByDateFin($order = Criteria::ASC) Order by the date_fin column
 * @method     ChildCongeQuery orderByDateDemande($order = Criteria::ASC) Order by the date_demande column
 * @method     ChildCongeQuery orderByMotif($order = Criteria::ASC) Order by the motif column
 * @method     ChildCongeQuery orderByStatus($order = Criteria::ASC) Order by the status column
 *
 * @method     ChildCongeQuery groupByCongeId() Group by the conge_id column
 * @method     ChildCongeQuery groupByEmployeId() Group by the employe_id column
 * @method     ChildCongeQuery groupByDateDebut() Group by the date_debut column
 * @method     ChildCongeQuery groupByDateFin() Group by the date_fin column
 * @method     ChildCongeQuery groupByDateDemande() Group by the date_demande column
 * @method     ChildCongeQuery groupByMotif() Group by the motif column
 * @method     ChildCongeQuery groupByStatus() Group by the status column
 *
 * @method     ChildCongeQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCongeQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCongeQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCongeQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildCongeQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildCongeQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildCongeQuery leftJoinEmploye($relationAlias = null) Adds a LEFT JOIN clause to the query using the Employe relation
 * @method     ChildCongeQuery rightJoinEmploye($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Employe relation
 * @method     ChildCongeQuery innerJoinEmploye($relationAlias = null) Adds a INNER JOIN clause to the query using the Employe relation
 *
 * @method     ChildCongeQuery joinWithEmploye($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Employe relation
 *
 * @method     ChildCongeQuery leftJoinWithEmploye() Adds a LEFT JOIN clause and with to the query using the Employe relation
 * @method     ChildCongeQuery rightJoinWithEmploye() Adds a RIGHT JOIN clause and with to the query using the Employe relation
 * @method     ChildCongeQuery innerJoinWithEmploye() Adds a INNER JOIN clause and with to the query using the Employe relation
 *
 * @method     \App\Models\EmployeQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildConge findOne(ConnectionInterface $con = null) Return the first ChildConge matching the query
 * @method     ChildConge findOneOrCreate(ConnectionInterface $con = null) Return the first ChildConge matching the query, or a new ChildConge object populated from the query conditions when no match is found
 *
 * @method     ChildConge findOneByCongeId(int $conge_id) Return the first ChildConge filtered by the conge_id column
 * @method     ChildConge findOneByEmployeId(int $employe_id) Return the first ChildConge filtered by the employe_id column
 * @method     ChildConge findOneByDateDebut(string $date_debut) Return the first ChildConge filtered by the date_debut column
 * @method     ChildConge findOneByDateFin(string $date_fin) Return the first ChildConge filtered by the date_fin column
 * @method     ChildConge findOneByDateDemande(string $date_demande) Return the first ChildConge filtered by the date_demande column
 * @method     ChildConge findOneByMotif(string $motif) Return the first ChildConge filtered by the motif column
 * @method     ChildConge findOneByStatus(int $status) Return the first ChildConge filtered by the status column *

 * @method     ChildConge requirePk($key, ConnectionInterface $con = null) Return the ChildConge by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildConge requireOne(ConnectionInterface $con = null) Return the first ChildConge matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildConge requireOneByCongeId(int $conge_id) Return the first ChildConge filtered by the conge_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildConge requireOneByEmployeId(int $employe_id) Return the first ChildConge filtered by the employe_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildConge requireOneByDateDebut(string $date_debut) Return the first ChildConge filtered by the date_debut column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildConge requireOneByDateFin(string $date_fin) Return the first ChildConge filtered by the date_fin column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildConge requireOneByDateDemande(string $date_demande) Return the first ChildConge filtered by the date_demande column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildConge requireOneByMotif(string $motif) Return the first ChildConge filtered by the motif column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildConge requireOneByStatus(int $status) Return the first ChildConge filtered by the status column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildConge[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildConge objects based on current ModelCriteria
 * @method     ChildConge[]|ObjectCollection findByCongeId(int $conge_id) Return ChildConge objects filtered by the conge_id column
 * @method     ChildConge[]|ObjectCollection findByEmployeId(int $employe_id) Return ChildConge objects filtered by the employe_id column
 * @method     ChildConge[]|ObjectCollection findByDateDebut(string $date_debut) Return ChildConge objects filtered by the date_debut column
 * @method     ChildConge[]|ObjectCollection findByDateFin(string $date_fin) Return ChildConge objects filtered by the date_fin column
 * @method     ChildConge[]|ObjectCollection findByDateDemande(string $date_demande) Return ChildConge objects filtered by the date_demande column
 * @method     ChildConge[]|ObjectCollection findByMotif(string $motif) Return ChildConge objects filtered by the motif column
 * @method     ChildConge[]|ObjectCollection findByStatus(int $status) Return ChildConge objects filtered by the status column
 * @method     ChildConge[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class CongeQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \App\Models\Base\CongeQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\App\\Models\\Conge', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCongeQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCongeQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildCongeQuery) {
            return $criteria;
        }
        $query = new ChildCongeQuery();
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
     * @return ChildConge|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CongeTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = CongeTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildConge A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT conge_id, employe_id, date_debut, date_fin, date_demande, motif, status FROM conge WHERE conge_id = :p0';
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
            /** @var ChildConge $obj */
            $obj = new ChildConge();
            $obj->hydrate($row);
            CongeTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildConge|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildCongeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CongeTableMap::COL_CONGE_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildCongeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CongeTableMap::COL_CONGE_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the conge_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCongeId(1234); // WHERE conge_id = 1234
     * $query->filterByCongeId(array(12, 34)); // WHERE conge_id IN (12, 34)
     * $query->filterByCongeId(array('min' => 12)); // WHERE conge_id > 12
     * </code>
     *
     * @param     mixed $congeId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCongeQuery The current query, for fluid interface
     */
    public function filterByCongeId($congeId = null, $comparison = null)
    {
        if (is_array($congeId)) {
            $useMinMax = false;
            if (isset($congeId['min'])) {
                $this->addUsingAlias(CongeTableMap::COL_CONGE_ID, $congeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($congeId['max'])) {
                $this->addUsingAlias(CongeTableMap::COL_CONGE_ID, $congeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CongeTableMap::COL_CONGE_ID, $congeId, $comparison);
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
     * @return $this|ChildCongeQuery The current query, for fluid interface
     */
    public function filterByEmployeId($employeId = null, $comparison = null)
    {
        if (is_array($employeId)) {
            $useMinMax = false;
            if (isset($employeId['min'])) {
                $this->addUsingAlias(CongeTableMap::COL_EMPLOYE_ID, $employeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($employeId['max'])) {
                $this->addUsingAlias(CongeTableMap::COL_EMPLOYE_ID, $employeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CongeTableMap::COL_EMPLOYE_ID, $employeId, $comparison);
    }

    /**
     * Filter the query on the date_debut column
     *
     * Example usage:
     * <code>
     * $query->filterByDateDebut('2011-03-14'); // WHERE date_debut = '2011-03-14'
     * $query->filterByDateDebut('now'); // WHERE date_debut = '2011-03-14'
     * $query->filterByDateDebut(array('max' => 'yesterday')); // WHERE date_debut > '2011-03-13'
     * </code>
     *
     * @param     mixed $dateDebut The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCongeQuery The current query, for fluid interface
     */
    public function filterByDateDebut($dateDebut = null, $comparison = null)
    {
        if (is_array($dateDebut)) {
            $useMinMax = false;
            if (isset($dateDebut['min'])) {
                $this->addUsingAlias(CongeTableMap::COL_DATE_DEBUT, $dateDebut['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateDebut['max'])) {
                $this->addUsingAlias(CongeTableMap::COL_DATE_DEBUT, $dateDebut['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CongeTableMap::COL_DATE_DEBUT, $dateDebut, $comparison);
    }

    /**
     * Filter the query on the date_fin column
     *
     * Example usage:
     * <code>
     * $query->filterByDateFin('2011-03-14'); // WHERE date_fin = '2011-03-14'
     * $query->filterByDateFin('now'); // WHERE date_fin = '2011-03-14'
     * $query->filterByDateFin(array('max' => 'yesterday')); // WHERE date_fin > '2011-03-13'
     * </code>
     *
     * @param     mixed $dateFin The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCongeQuery The current query, for fluid interface
     */
    public function filterByDateFin($dateFin = null, $comparison = null)
    {
        if (is_array($dateFin)) {
            $useMinMax = false;
            if (isset($dateFin['min'])) {
                $this->addUsingAlias(CongeTableMap::COL_DATE_FIN, $dateFin['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateFin['max'])) {
                $this->addUsingAlias(CongeTableMap::COL_DATE_FIN, $dateFin['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CongeTableMap::COL_DATE_FIN, $dateFin, $comparison);
    }

    /**
     * Filter the query on the date_demande column
     *
     * Example usage:
     * <code>
     * $query->filterByDateDemande('2011-03-14'); // WHERE date_demande = '2011-03-14'
     * $query->filterByDateDemande('now'); // WHERE date_demande = '2011-03-14'
     * $query->filterByDateDemande(array('max' => 'yesterday')); // WHERE date_demande > '2011-03-13'
     * </code>
     *
     * @param     mixed $dateDemande The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCongeQuery The current query, for fluid interface
     */
    public function filterByDateDemande($dateDemande = null, $comparison = null)
    {
        if (is_array($dateDemande)) {
            $useMinMax = false;
            if (isset($dateDemande['min'])) {
                $this->addUsingAlias(CongeTableMap::COL_DATE_DEMANDE, $dateDemande['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateDemande['max'])) {
                $this->addUsingAlias(CongeTableMap::COL_DATE_DEMANDE, $dateDemande['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CongeTableMap::COL_DATE_DEMANDE, $dateDemande, $comparison);
    }

    /**
     * Filter the query on the motif column
     *
     * Example usage:
     * <code>
     * $query->filterByMotif('fooValue');   // WHERE motif = 'fooValue'
     * $query->filterByMotif('%fooValue%', Criteria::LIKE); // WHERE motif LIKE '%fooValue%'
     * </code>
     *
     * @param     string $motif The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCongeQuery The current query, for fluid interface
     */
    public function filterByMotif($motif = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($motif)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CongeTableMap::COL_MOTIF, $motif, $comparison);
    }

    /**
     * Filter the query on the status column
     *
     * Example usage:
     * <code>
     * $query->filterByStatus(1234); // WHERE status = 1234
     * $query->filterByStatus(array(12, 34)); // WHERE status IN (12, 34)
     * $query->filterByStatus(array('min' => 12)); // WHERE status > 12
     * </code>
     *
     * @param     mixed $status The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCongeQuery The current query, for fluid interface
     */
    public function filterByStatus($status = null, $comparison = null)
    {
        if (is_array($status)) {
            $useMinMax = false;
            if (isset($status['min'])) {
                $this->addUsingAlias(CongeTableMap::COL_STATUS, $status['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($status['max'])) {
                $this->addUsingAlias(CongeTableMap::COL_STATUS, $status['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CongeTableMap::COL_STATUS, $status, $comparison);
    }

    /**
     * Filter the query by a related \App\Models\Employe object
     *
     * @param \App\Models\Employe|ObjectCollection $employe The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCongeQuery The current query, for fluid interface
     */
    public function filterByEmploye($employe, $comparison = null)
    {
        if ($employe instanceof \App\Models\Employe) {
            return $this
                ->addUsingAlias(CongeTableMap::COL_EMPLOYE_ID, $employe->getEmployeId(), $comparison);
        } elseif ($employe instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CongeTableMap::COL_EMPLOYE_ID, $employe->toKeyValue('PrimaryKey', 'EmployeId'), $comparison);
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
     * @return $this|ChildCongeQuery The current query, for fluid interface
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
     * @param   ChildConge $conge Object to remove from the list of results
     *
     * @return $this|ChildCongeQuery The current query, for fluid interface
     */
    public function prune($conge = null)
    {
        if ($conge) {
            $this->addUsingAlias(CongeTableMap::COL_CONGE_ID, $conge->getCongeId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the conge table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CongeTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CongeTableMap::clearInstancePool();
            CongeTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(CongeTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CongeTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            CongeTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            CongeTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // CongeQuery
