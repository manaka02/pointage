<?php

namespace App\Models\Base;

use \Exception;
use \PDO;
use App\Models\Employe as ChildEmploye;
use App\Models\EmployeQuery as ChildEmployeQuery;
use App\Models\Map\EmployeTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'employe' table.
 *
 *
 *
 * @method     ChildEmployeQuery orderByEmployeId($order = Criteria::ASC) Order by the employe_id column
 * @method     ChildEmployeQuery orderByRefInterne($order = Criteria::ASC) Order by the ref_interne column
 * @method     ChildEmployeQuery orderByUniteId($order = Criteria::ASC) Order by the unite_id column
 * @method     ChildEmployeQuery orderByNomPrenom($order = Criteria::ASC) Order by the nom_prenom column
 * @method     ChildEmployeQuery orderByPoste($order = Criteria::ASC) Order by the poste column
 * @method     ChildEmployeQuery orderByGenre($order = Criteria::ASC) Order by the genre column
 * @method     ChildEmployeQuery orderByDateEmbauche($order = Criteria::ASC) Order by the date_embauche column
 * @method     ChildEmployeQuery orderByPresent($order = Criteria::ASC) Order by the present column
 * @method     ChildEmployeQuery orderByStatus($order = Criteria::ASC) Order by the status column
 *
 * @method     ChildEmployeQuery groupByEmployeId() Group by the employe_id column
 * @method     ChildEmployeQuery groupByRefInterne() Group by the ref_interne column
 * @method     ChildEmployeQuery groupByUniteId() Group by the unite_id column
 * @method     ChildEmployeQuery groupByNomPrenom() Group by the nom_prenom column
 * @method     ChildEmployeQuery groupByPoste() Group by the poste column
 * @method     ChildEmployeQuery groupByGenre() Group by the genre column
 * @method     ChildEmployeQuery groupByDateEmbauche() Group by the date_embauche column
 * @method     ChildEmployeQuery groupByPresent() Group by the present column
 * @method     ChildEmployeQuery groupByStatus() Group by the status column
 *
 * @method     ChildEmployeQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildEmployeQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildEmployeQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildEmployeQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildEmployeQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildEmployeQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildEmployeQuery leftJoinUnite($relationAlias = null) Adds a LEFT JOIN clause to the query using the Unite relation
 * @method     ChildEmployeQuery rightJoinUnite($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Unite relation
 * @method     ChildEmployeQuery innerJoinUnite($relationAlias = null) Adds a INNER JOIN clause to the query using the Unite relation
 *
 * @method     ChildEmployeQuery joinWithUnite($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Unite relation
 *
 * @method     ChildEmployeQuery leftJoinWithUnite() Adds a LEFT JOIN clause and with to the query using the Unite relation
 * @method     ChildEmployeQuery rightJoinWithUnite() Adds a RIGHT JOIN clause and with to the query using the Unite relation
 * @method     ChildEmployeQuery innerJoinWithUnite() Adds a INNER JOIN clause and with to the query using the Unite relation
 *
 * @method     ChildEmployeQuery leftJoinAbsence($relationAlias = null) Adds a LEFT JOIN clause to the query using the Absence relation
 * @method     ChildEmployeQuery rightJoinAbsence($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Absence relation
 * @method     ChildEmployeQuery innerJoinAbsence($relationAlias = null) Adds a INNER JOIN clause to the query using the Absence relation
 *
 * @method     ChildEmployeQuery joinWithAbsence($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Absence relation
 *
 * @method     ChildEmployeQuery leftJoinWithAbsence() Adds a LEFT JOIN clause and with to the query using the Absence relation
 * @method     ChildEmployeQuery rightJoinWithAbsence() Adds a RIGHT JOIN clause and with to the query using the Absence relation
 * @method     ChildEmployeQuery innerJoinWithAbsence() Adds a INNER JOIN clause and with to the query using the Absence relation
 *
 * @method     ChildEmployeQuery leftJoinConge($relationAlias = null) Adds a LEFT JOIN clause to the query using the Conge relation
 * @method     ChildEmployeQuery rightJoinConge($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Conge relation
 * @method     ChildEmployeQuery innerJoinConge($relationAlias = null) Adds a INNER JOIN clause to the query using the Conge relation
 *
 * @method     ChildEmployeQuery joinWithConge($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Conge relation
 *
 * @method     ChildEmployeQuery leftJoinWithConge() Adds a LEFT JOIN clause and with to the query using the Conge relation
 * @method     ChildEmployeQuery rightJoinWithConge() Adds a RIGHT JOIN clause and with to the query using the Conge relation
 * @method     ChildEmployeQuery innerJoinWithConge() Adds a INNER JOIN clause and with to the query using the Conge relation
 *
 * @method     ChildEmployeQuery leftJoinPermission($relationAlias = null) Adds a LEFT JOIN clause to the query using the Permission relation
 * @method     ChildEmployeQuery rightJoinPermission($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Permission relation
 * @method     ChildEmployeQuery innerJoinPermission($relationAlias = null) Adds a INNER JOIN clause to the query using the Permission relation
 *
 * @method     ChildEmployeQuery joinWithPermission($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Permission relation
 *
 * @method     ChildEmployeQuery leftJoinWithPermission() Adds a LEFT JOIN clause and with to the query using the Permission relation
 * @method     ChildEmployeQuery rightJoinWithPermission() Adds a RIGHT JOIN clause and with to the query using the Permission relation
 * @method     ChildEmployeQuery innerJoinWithPermission() Adds a INNER JOIN clause and with to the query using the Permission relation
 *
 * @method     ChildEmployeQuery leftJoinPointage($relationAlias = null) Adds a LEFT JOIN clause to the query using the Pointage relation
 * @method     ChildEmployeQuery rightJoinPointage($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Pointage relation
 * @method     ChildEmployeQuery innerJoinPointage($relationAlias = null) Adds a INNER JOIN clause to the query using the Pointage relation
 *
 * @method     ChildEmployeQuery joinWithPointage($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Pointage relation
 *
 * @method     ChildEmployeQuery leftJoinWithPointage() Adds a LEFT JOIN clause and with to the query using the Pointage relation
 * @method     ChildEmployeQuery rightJoinWithPointage() Adds a RIGHT JOIN clause and with to the query using the Pointage relation
 * @method     ChildEmployeQuery innerJoinWithPointage() Adds a INNER JOIN clause and with to the query using the Pointage relation
 *
 * @method     ChildEmployeQuery leftJoinPresence($relationAlias = null) Adds a LEFT JOIN clause to the query using the Presence relation
 * @method     ChildEmployeQuery rightJoinPresence($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Presence relation
 * @method     ChildEmployeQuery innerJoinPresence($relationAlias = null) Adds a INNER JOIN clause to the query using the Presence relation
 *
 * @method     ChildEmployeQuery joinWithPresence($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Presence relation
 *
 * @method     ChildEmployeQuery leftJoinWithPresence() Adds a LEFT JOIN clause and with to the query using the Presence relation
 * @method     ChildEmployeQuery rightJoinWithPresence() Adds a RIGHT JOIN clause and with to the query using the Presence relation
 * @method     ChildEmployeQuery innerJoinWithPresence() Adds a INNER JOIN clause and with to the query using the Presence relation
 *
 * @method     ChildEmployeQuery leftJoinRetard($relationAlias = null) Adds a LEFT JOIN clause to the query using the Retard relation
 * @method     ChildEmployeQuery rightJoinRetard($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Retard relation
 * @method     ChildEmployeQuery innerJoinRetard($relationAlias = null) Adds a INNER JOIN clause to the query using the Retard relation
 *
 * @method     ChildEmployeQuery joinWithRetard($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Retard relation
 *
 * @method     ChildEmployeQuery leftJoinWithRetard() Adds a LEFT JOIN clause and with to the query using the Retard relation
 * @method     ChildEmployeQuery rightJoinWithRetard() Adds a RIGHT JOIN clause and with to the query using the Retard relation
 * @method     ChildEmployeQuery innerJoinWithRetard() Adds a INNER JOIN clause and with to the query using the Retard relation
 *
 * @method     \App\Models\UniteQuery|\App\Models\AbsenceQuery|\App\Models\CongeQuery|\App\Models\PermissionQuery|\App\Models\PointageQuery|\App\Models\PresenceQuery|\App\Models\RetardQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildEmploye findOne(ConnectionInterface $con = null) Return the first ChildEmploye matching the query
 * @method     ChildEmploye findOneOrCreate(ConnectionInterface $con = null) Return the first ChildEmploye matching the query, or a new ChildEmploye object populated from the query conditions when no match is found
 *
 * @method     ChildEmploye findOneByEmployeId(int $employe_id) Return the first ChildEmploye filtered by the employe_id column
 * @method     ChildEmploye findOneByRefInterne(int $ref_interne) Return the first ChildEmploye filtered by the ref_interne column
 * @method     ChildEmploye findOneByUniteId(int $unite_id) Return the first ChildEmploye filtered by the unite_id column
 * @method     ChildEmploye findOneByNomPrenom(string $nom_prenom) Return the first ChildEmploye filtered by the nom_prenom column
 * @method     ChildEmploye findOneByPoste(string $poste) Return the first ChildEmploye filtered by the poste column
 * @method     ChildEmploye findOneByGenre(string $genre) Return the first ChildEmploye filtered by the genre column
 * @method     ChildEmploye findOneByDateEmbauche(string $date_embauche) Return the first ChildEmploye filtered by the date_embauche column
 * @method     ChildEmploye findOneByPresent(int $present) Return the first ChildEmploye filtered by the present column
 * @method     ChildEmploye findOneByStatus(int $status) Return the first ChildEmploye filtered by the status column *

 * @method     ChildEmploye requirePk($key, ConnectionInterface $con = null) Return the ChildEmploye by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEmploye requireOne(ConnectionInterface $con = null) Return the first ChildEmploye matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildEmploye requireOneByEmployeId(int $employe_id) Return the first ChildEmploye filtered by the employe_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEmploye requireOneByRefInterne(int $ref_interne) Return the first ChildEmploye filtered by the ref_interne column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEmploye requireOneByUniteId(int $unite_id) Return the first ChildEmploye filtered by the unite_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEmploye requireOneByNomPrenom(string $nom_prenom) Return the first ChildEmploye filtered by the nom_prenom column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEmploye requireOneByPoste(string $poste) Return the first ChildEmploye filtered by the poste column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEmploye requireOneByGenre(string $genre) Return the first ChildEmploye filtered by the genre column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEmploye requireOneByDateEmbauche(string $date_embauche) Return the first ChildEmploye filtered by the date_embauche column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEmploye requireOneByPresent(int $present) Return the first ChildEmploye filtered by the present column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEmploye requireOneByStatus(int $status) Return the first ChildEmploye filtered by the status column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildEmploye[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildEmploye objects based on current ModelCriteria
 * @method     ChildEmploye[]|ObjectCollection findByEmployeId(int $employe_id) Return ChildEmploye objects filtered by the employe_id column
 * @method     ChildEmploye[]|ObjectCollection findByRefInterne(int $ref_interne) Return ChildEmploye objects filtered by the ref_interne column
 * @method     ChildEmploye[]|ObjectCollection findByUniteId(int $unite_id) Return ChildEmploye objects filtered by the unite_id column
 * @method     ChildEmploye[]|ObjectCollection findByNomPrenom(string $nom_prenom) Return ChildEmploye objects filtered by the nom_prenom column
 * @method     ChildEmploye[]|ObjectCollection findByPoste(string $poste) Return ChildEmploye objects filtered by the poste column
 * @method     ChildEmploye[]|ObjectCollection findByGenre(string $genre) Return ChildEmploye objects filtered by the genre column
 * @method     ChildEmploye[]|ObjectCollection findByDateEmbauche(string $date_embauche) Return ChildEmploye objects filtered by the date_embauche column
 * @method     ChildEmploye[]|ObjectCollection findByPresent(int $present) Return ChildEmploye objects filtered by the present column
 * @method     ChildEmploye[]|ObjectCollection findByStatus(int $status) Return ChildEmploye objects filtered by the status column
 * @method     ChildEmploye[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class EmployeQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \App\Models\Base\EmployeQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\App\\Models\\Employe', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildEmployeQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildEmployeQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildEmployeQuery) {
            return $criteria;
        }
        $query = new ChildEmployeQuery();
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
     * @return ChildEmploye|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(EmployeTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = EmployeTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildEmploye A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT employe_id, ref_interne, unite_id, nom_prenom, poste, genre, date_embauche, present, status FROM employe WHERE employe_id = :p0';
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
            /** @var ChildEmploye $obj */
            $obj = new ChildEmploye();
            $obj->hydrate($row);
            EmployeTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildEmploye|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildEmployeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(EmployeTableMap::COL_EMPLOYE_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildEmployeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(EmployeTableMap::COL_EMPLOYE_ID, $keys, Criteria::IN);
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
     * @param     mixed $employeId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEmployeQuery The current query, for fluid interface
     */
    public function filterByEmployeId($employeId = null, $comparison = null)
    {
        if (is_array($employeId)) {
            $useMinMax = false;
            if (isset($employeId['min'])) {
                $this->addUsingAlias(EmployeTableMap::COL_EMPLOYE_ID, $employeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($employeId['max'])) {
                $this->addUsingAlias(EmployeTableMap::COL_EMPLOYE_ID, $employeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EmployeTableMap::COL_EMPLOYE_ID, $employeId, $comparison);
    }

    /**
     * Filter the query on the ref_interne column
     *
     * Example usage:
     * <code>
     * $query->filterByRefInterne(1234); // WHERE ref_interne = 1234
     * $query->filterByRefInterne(array(12, 34)); // WHERE ref_interne IN (12, 34)
     * $query->filterByRefInterne(array('min' => 12)); // WHERE ref_interne > 12
     * </code>
     *
     * @param     mixed $refInterne The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEmployeQuery The current query, for fluid interface
     */
    public function filterByRefInterne($refInterne = null, $comparison = null)
    {
        if (is_array($refInterne)) {
            $useMinMax = false;
            if (isset($refInterne['min'])) {
                $this->addUsingAlias(EmployeTableMap::COL_REF_INTERNE, $refInterne['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($refInterne['max'])) {
                $this->addUsingAlias(EmployeTableMap::COL_REF_INTERNE, $refInterne['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EmployeTableMap::COL_REF_INTERNE, $refInterne, $comparison);
    }

    /**
     * Filter the query on the unite_id column
     *
     * Example usage:
     * <code>
     * $query->filterByUniteId(1234); // WHERE unite_id = 1234
     * $query->filterByUniteId(array(12, 34)); // WHERE unite_id IN (12, 34)
     * $query->filterByUniteId(array('min' => 12)); // WHERE unite_id > 12
     * </code>
     *
     * @see       filterByUnite()
     *
     * @param     mixed $uniteId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEmployeQuery The current query, for fluid interface
     */
    public function filterByUniteId($uniteId = null, $comparison = null)
    {
        if (is_array($uniteId)) {
            $useMinMax = false;
            if (isset($uniteId['min'])) {
                $this->addUsingAlias(EmployeTableMap::COL_UNITE_ID, $uniteId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($uniteId['max'])) {
                $this->addUsingAlias(EmployeTableMap::COL_UNITE_ID, $uniteId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EmployeTableMap::COL_UNITE_ID, $uniteId, $comparison);
    }

    /**
     * Filter the query on the nom_prenom column
     *
     * Example usage:
     * <code>
     * $query->filterByNomPrenom('fooValue');   // WHERE nom_prenom = 'fooValue'
     * $query->filterByNomPrenom('%fooValue%', Criteria::LIKE); // WHERE nom_prenom LIKE '%fooValue%'
     * </code>
     *
     * @param     string $nomPrenom The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEmployeQuery The current query, for fluid interface
     */
    public function filterByNomPrenom($nomPrenom = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($nomPrenom)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EmployeTableMap::COL_NOM_PRENOM, $nomPrenom, $comparison);
    }

    /**
     * Filter the query on the poste column
     *
     * Example usage:
     * <code>
     * $query->filterByPoste('fooValue');   // WHERE poste = 'fooValue'
     * $query->filterByPoste('%fooValue%', Criteria::LIKE); // WHERE poste LIKE '%fooValue%'
     * </code>
     *
     * @param     string $poste The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEmployeQuery The current query, for fluid interface
     */
    public function filterByPoste($poste = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($poste)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EmployeTableMap::COL_POSTE, $poste, $comparison);
    }

    /**
     * Filter the query on the genre column
     *
     * Example usage:
     * <code>
     * $query->filterByGenre('fooValue');   // WHERE genre = 'fooValue'
     * $query->filterByGenre('%fooValue%', Criteria::LIKE); // WHERE genre LIKE '%fooValue%'
     * </code>
     *
     * @param     string $genre The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEmployeQuery The current query, for fluid interface
     */
    public function filterByGenre($genre = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($genre)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EmployeTableMap::COL_GENRE, $genre, $comparison);
    }

    /**
     * Filter the query on the date_embauche column
     *
     * Example usage:
     * <code>
     * $query->filterByDateEmbauche('2011-03-14'); // WHERE date_embauche = '2011-03-14'
     * $query->filterByDateEmbauche('now'); // WHERE date_embauche = '2011-03-14'
     * $query->filterByDateEmbauche(array('max' => 'yesterday')); // WHERE date_embauche > '2011-03-13'
     * </code>
     *
     * @param     mixed $dateEmbauche The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEmployeQuery The current query, for fluid interface
     */
    public function filterByDateEmbauche($dateEmbauche = null, $comparison = null)
    {
        if (is_array($dateEmbauche)) {
            $useMinMax = false;
            if (isset($dateEmbauche['min'])) {
                $this->addUsingAlias(EmployeTableMap::COL_DATE_EMBAUCHE, $dateEmbauche['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateEmbauche['max'])) {
                $this->addUsingAlias(EmployeTableMap::COL_DATE_EMBAUCHE, $dateEmbauche['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EmployeTableMap::COL_DATE_EMBAUCHE, $dateEmbauche, $comparison);
    }

    /**
     * Filter the query on the present column
     *
     * Example usage:
     * <code>
     * $query->filterByPresent(1234); // WHERE present = 1234
     * $query->filterByPresent(array(12, 34)); // WHERE present IN (12, 34)
     * $query->filterByPresent(array('min' => 12)); // WHERE present > 12
     * </code>
     *
     * @param     mixed $present The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEmployeQuery The current query, for fluid interface
     */
    public function filterByPresent($present = null, $comparison = null)
    {
        if (is_array($present)) {
            $useMinMax = false;
            if (isset($present['min'])) {
                $this->addUsingAlias(EmployeTableMap::COL_PRESENT, $present['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($present['max'])) {
                $this->addUsingAlias(EmployeTableMap::COL_PRESENT, $present['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EmployeTableMap::COL_PRESENT, $present, $comparison);
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
     * @return $this|ChildEmployeQuery The current query, for fluid interface
     */
    public function filterByStatus($status = null, $comparison = null)
    {
        if (is_array($status)) {
            $useMinMax = false;
            if (isset($status['min'])) {
                $this->addUsingAlias(EmployeTableMap::COL_STATUS, $status['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($status['max'])) {
                $this->addUsingAlias(EmployeTableMap::COL_STATUS, $status['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EmployeTableMap::COL_STATUS, $status, $comparison);
    }

    /**
     * Filter the query by a related \App\Models\Unite object
     *
     * @param \App\Models\Unite|ObjectCollection $unite The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildEmployeQuery The current query, for fluid interface
     */
    public function filterByUnite($unite, $comparison = null)
    {
        if ($unite instanceof \App\Models\Unite) {
            return $this
                ->addUsingAlias(EmployeTableMap::COL_UNITE_ID, $unite->getUniteId(), $comparison);
        } elseif ($unite instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(EmployeTableMap::COL_UNITE_ID, $unite->toKeyValue('PrimaryKey', 'UniteId'), $comparison);
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
     * @return $this|ChildEmployeQuery The current query, for fluid interface
     */
    public function joinUnite($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useUniteQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinUnite($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Unite', '\App\Models\UniteQuery');
    }

    /**
     * Filter the query by a related \App\Models\Absence object
     *
     * @param \App\Models\Absence|ObjectCollection $absence the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildEmployeQuery The current query, for fluid interface
     */
    public function filterByAbsence($absence, $comparison = null)
    {
        if ($absence instanceof \App\Models\Absence) {
            return $this
                ->addUsingAlias(EmployeTableMap::COL_EMPLOYE_ID, $absence->getEmployeId(), $comparison);
        } elseif ($absence instanceof ObjectCollection) {
            return $this
                ->useAbsenceQuery()
                ->filterByPrimaryKeys($absence->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAbsence() only accepts arguments of type \App\Models\Absence or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Absence relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildEmployeQuery The current query, for fluid interface
     */
    public function joinAbsence($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Absence');

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
            $this->addJoinObject($join, 'Absence');
        }

        return $this;
    }

    /**
     * Use the Absence relation Absence object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \App\Models\AbsenceQuery A secondary query class using the current class as primary query
     */
    public function useAbsenceQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAbsence($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Absence', '\App\Models\AbsenceQuery');
    }

    /**
     * Filter the query by a related \App\Models\Conge object
     *
     * @param \App\Models\Conge|ObjectCollection $conge the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildEmployeQuery The current query, for fluid interface
     */
    public function filterByConge($conge, $comparison = null)
    {
        if ($conge instanceof \App\Models\Conge) {
            return $this
                ->addUsingAlias(EmployeTableMap::COL_EMPLOYE_ID, $conge->getEmployeId(), $comparison);
        } elseif ($conge instanceof ObjectCollection) {
            return $this
                ->useCongeQuery()
                ->filterByPrimaryKeys($conge->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByConge() only accepts arguments of type \App\Models\Conge or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Conge relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildEmployeQuery The current query, for fluid interface
     */
    public function joinConge($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Conge');

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
            $this->addJoinObject($join, 'Conge');
        }

        return $this;
    }

    /**
     * Use the Conge relation Conge object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \App\Models\CongeQuery A secondary query class using the current class as primary query
     */
    public function useCongeQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinConge($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Conge', '\App\Models\CongeQuery');
    }

    /**
     * Filter the query by a related \App\Models\Permission object
     *
     * @param \App\Models\Permission|ObjectCollection $permission the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildEmployeQuery The current query, for fluid interface
     */
    public function filterByPermission($permission, $comparison = null)
    {
        if ($permission instanceof \App\Models\Permission) {
            return $this
                ->addUsingAlias(EmployeTableMap::COL_EMPLOYE_ID, $permission->getEmployeId(), $comparison);
        } elseif ($permission instanceof ObjectCollection) {
            return $this
                ->usePermissionQuery()
                ->filterByPrimaryKeys($permission->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPermission() only accepts arguments of type \App\Models\Permission or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Permission relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildEmployeQuery The current query, for fluid interface
     */
    public function joinPermission($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Permission');

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
            $this->addJoinObject($join, 'Permission');
        }

        return $this;
    }

    /**
     * Use the Permission relation Permission object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \App\Models\PermissionQuery A secondary query class using the current class as primary query
     */
    public function usePermissionQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPermission($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Permission', '\App\Models\PermissionQuery');
    }

    /**
     * Filter the query by a related \App\Models\Pointage object
     *
     * @param \App\Models\Pointage|ObjectCollection $pointage the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildEmployeQuery The current query, for fluid interface
     */
    public function filterByPointage($pointage, $comparison = null)
    {
        if ($pointage instanceof \App\Models\Pointage) {
            return $this
                ->addUsingAlias(EmployeTableMap::COL_EMPLOYE_ID, $pointage->getEmployeId(), $comparison);
        } elseif ($pointage instanceof ObjectCollection) {
            return $this
                ->usePointageQuery()
                ->filterByPrimaryKeys($pointage->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPointage() only accepts arguments of type \App\Models\Pointage or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Pointage relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildEmployeQuery The current query, for fluid interface
     */
    public function joinPointage($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Pointage');

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
            $this->addJoinObject($join, 'Pointage');
        }

        return $this;
    }

    /**
     * Use the Pointage relation Pointage object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \App\Models\PointageQuery A secondary query class using the current class as primary query
     */
    public function usePointageQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPointage($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Pointage', '\App\Models\PointageQuery');
    }

    /**
     * Filter the query by a related \App\Models\Presence object
     *
     * @param \App\Models\Presence|ObjectCollection $presence the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildEmployeQuery The current query, for fluid interface
     */
    public function filterByPresence($presence, $comparison = null)
    {
        if ($presence instanceof \App\Models\Presence) {
            return $this
                ->addUsingAlias(EmployeTableMap::COL_EMPLOYE_ID, $presence->getEmployeId(), $comparison);
        } elseif ($presence instanceof ObjectCollection) {
            return $this
                ->usePresenceQuery()
                ->filterByPrimaryKeys($presence->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPresence() only accepts arguments of type \App\Models\Presence or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Presence relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildEmployeQuery The current query, for fluid interface
     */
    public function joinPresence($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Presence');

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
            $this->addJoinObject($join, 'Presence');
        }

        return $this;
    }

    /**
     * Use the Presence relation Presence object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \App\Models\PresenceQuery A secondary query class using the current class as primary query
     */
    public function usePresenceQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPresence($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Presence', '\App\Models\PresenceQuery');
    }

    /**
     * Filter the query by a related \App\Models\Retard object
     *
     * @param \App\Models\Retard|ObjectCollection $retard the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildEmployeQuery The current query, for fluid interface
     */
    public function filterByRetard($retard, $comparison = null)
    {
        if ($retard instanceof \App\Models\Retard) {
            return $this
                ->addUsingAlias(EmployeTableMap::COL_EMPLOYE_ID, $retard->getEmployeId(), $comparison);
        } elseif ($retard instanceof ObjectCollection) {
            return $this
                ->useRetardQuery()
                ->filterByPrimaryKeys($retard->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRetard() only accepts arguments of type \App\Models\Retard or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Retard relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildEmployeQuery The current query, for fluid interface
     */
    public function joinRetard($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Retard');

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
            $this->addJoinObject($join, 'Retard');
        }

        return $this;
    }

    /**
     * Use the Retard relation Retard object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \App\Models\RetardQuery A secondary query class using the current class as primary query
     */
    public function useRetardQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRetard($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Retard', '\App\Models\RetardQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildEmploye $employe Object to remove from the list of results
     *
     * @return $this|ChildEmployeQuery The current query, for fluid interface
     */
    public function prune($employe = null)
    {
        if ($employe) {
            $this->addUsingAlias(EmployeTableMap::COL_EMPLOYE_ID, $employe->getEmployeId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the employe table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(EmployeTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            EmployeTableMap::clearInstancePool();
            EmployeTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(EmployeTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(EmployeTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            EmployeTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            EmployeTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // EmployeQuery
