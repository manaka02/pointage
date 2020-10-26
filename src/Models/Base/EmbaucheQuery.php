<?php

namespace App\Models\Base;

use \Exception;
use \PDO;
use App\Models\Embauche as ChildEmbauche;
use App\Models\EmbaucheQuery as ChildEmbaucheQuery;
use App\Models\Map\EmbaucheTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'embauche' table.
 *
 *
 *
 * @method     ChildEmbaucheQuery orderByEmbaucheId($order = Criteria::ASC) Order by the embauche_id column
 * @method     ChildEmbaucheQuery orderByCivilite($order = Criteria::ASC) Order by the civilite column
 * @method     ChildEmbaucheQuery orderByRefInterne($order = Criteria::ASC) Order by the ref_interne column
 * @method     ChildEmbaucheQuery orderByNomPrenom($order = Criteria::ASC) Order by the nom_prenom column
 * @method     ChildEmbaucheQuery orderByPhotoLink($order = Criteria::ASC) Order by the photo_link column
 * @method     ChildEmbaucheQuery orderByFonction($order = Criteria::ASC) Order by the fonction column
 * @method     ChildEmbaucheQuery orderByDepartementId($order = Criteria::ASC) Order by the departement_id column
 * @method     ChildEmbaucheQuery orderByDateDebut($order = Criteria::ASC) Order by the date_debut column
 * @method     ChildEmbaucheQuery orderByDateFin($order = Criteria::ASC) Order by the date_fin column
 * @method     ChildEmbaucheQuery orderByStatus($order = Criteria::ASC) Order by the status column
 *
 * @method     ChildEmbaucheQuery groupByEmbaucheId() Group by the embauche_id column
 * @method     ChildEmbaucheQuery groupByCivilite() Group by the civilite column
 * @method     ChildEmbaucheQuery groupByRefInterne() Group by the ref_interne column
 * @method     ChildEmbaucheQuery groupByNomPrenom() Group by the nom_prenom column
 * @method     ChildEmbaucheQuery groupByPhotoLink() Group by the photo_link column
 * @method     ChildEmbaucheQuery groupByFonction() Group by the fonction column
 * @method     ChildEmbaucheQuery groupByDepartementId() Group by the departement_id column
 * @method     ChildEmbaucheQuery groupByDateDebut() Group by the date_debut column
 * @method     ChildEmbaucheQuery groupByDateFin() Group by the date_fin column
 * @method     ChildEmbaucheQuery groupByStatus() Group by the status column
 *
 * @method     ChildEmbaucheQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildEmbaucheQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildEmbaucheQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildEmbaucheQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildEmbaucheQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildEmbaucheQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildEmbaucheQuery leftJoinDepartement($relationAlias = null) Adds a LEFT JOIN clause to the query using the Departement relation
 * @method     ChildEmbaucheQuery rightJoinDepartement($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Departement relation
 * @method     ChildEmbaucheQuery innerJoinDepartement($relationAlias = null) Adds a INNER JOIN clause to the query using the Departement relation
 *
 * @method     ChildEmbaucheQuery joinWithDepartement($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Departement relation
 *
 * @method     ChildEmbaucheQuery leftJoinWithDepartement() Adds a LEFT JOIN clause and with to the query using the Departement relation
 * @method     ChildEmbaucheQuery rightJoinWithDepartement() Adds a RIGHT JOIN clause and with to the query using the Departement relation
 * @method     ChildEmbaucheQuery innerJoinWithDepartement() Adds a INNER JOIN clause and with to the query using the Departement relation
 *
 * @method     \App\Models\DepartementQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildEmbauche findOne(ConnectionInterface $con = null) Return the first ChildEmbauche matching the query
 * @method     ChildEmbauche findOneOrCreate(ConnectionInterface $con = null) Return the first ChildEmbauche matching the query, or a new ChildEmbauche object populated from the query conditions when no match is found
 *
 * @method     ChildEmbauche findOneByEmbaucheId(int $embauche_id) Return the first ChildEmbauche filtered by the embauche_id column
 * @method     ChildEmbauche findOneByCivilite(string $civilite) Return the first ChildEmbauche filtered by the civilite column
 * @method     ChildEmbauche findOneByRefInterne(string $ref_interne) Return the first ChildEmbauche filtered by the ref_interne column
 * @method     ChildEmbauche findOneByNomPrenom(string $nom_prenom) Return the first ChildEmbauche filtered by the nom_prenom column
 * @method     ChildEmbauche findOneByPhotoLink(string $photo_link) Return the first ChildEmbauche filtered by the photo_link column
 * @method     ChildEmbauche findOneByFonction(string $fonction) Return the first ChildEmbauche filtered by the fonction column
 * @method     ChildEmbauche findOneByDepartementId(int $departement_id) Return the first ChildEmbauche filtered by the departement_id column
 * @method     ChildEmbauche findOneByDateDebut(string $date_debut) Return the first ChildEmbauche filtered by the date_debut column
 * @method     ChildEmbauche findOneByDateFin(string $date_fin) Return the first ChildEmbauche filtered by the date_fin column
 * @method     ChildEmbauche findOneByStatus(int $status) Return the first ChildEmbauche filtered by the status column *

 * @method     ChildEmbauche requirePk($key, ConnectionInterface $con = null) Return the ChildEmbauche by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEmbauche requireOne(ConnectionInterface $con = null) Return the first ChildEmbauche matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildEmbauche requireOneByEmbaucheId(int $embauche_id) Return the first ChildEmbauche filtered by the embauche_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEmbauche requireOneByCivilite(string $civilite) Return the first ChildEmbauche filtered by the civilite column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEmbauche requireOneByRefInterne(string $ref_interne) Return the first ChildEmbauche filtered by the ref_interne column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEmbauche requireOneByNomPrenom(string $nom_prenom) Return the first ChildEmbauche filtered by the nom_prenom column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEmbauche requireOneByPhotoLink(string $photo_link) Return the first ChildEmbauche filtered by the photo_link column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEmbauche requireOneByFonction(string $fonction) Return the first ChildEmbauche filtered by the fonction column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEmbauche requireOneByDepartementId(int $departement_id) Return the first ChildEmbauche filtered by the departement_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEmbauche requireOneByDateDebut(string $date_debut) Return the first ChildEmbauche filtered by the date_debut column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEmbauche requireOneByDateFin(string $date_fin) Return the first ChildEmbauche filtered by the date_fin column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEmbauche requireOneByStatus(int $status) Return the first ChildEmbauche filtered by the status column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildEmbauche[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildEmbauche objects based on current ModelCriteria
 * @method     ChildEmbauche[]|ObjectCollection findByEmbaucheId(int $embauche_id) Return ChildEmbauche objects filtered by the embauche_id column
 * @method     ChildEmbauche[]|ObjectCollection findByCivilite(string $civilite) Return ChildEmbauche objects filtered by the civilite column
 * @method     ChildEmbauche[]|ObjectCollection findByRefInterne(string $ref_interne) Return ChildEmbauche objects filtered by the ref_interne column
 * @method     ChildEmbauche[]|ObjectCollection findByNomPrenom(string $nom_prenom) Return ChildEmbauche objects filtered by the nom_prenom column
 * @method     ChildEmbauche[]|ObjectCollection findByPhotoLink(string $photo_link) Return ChildEmbauche objects filtered by the photo_link column
 * @method     ChildEmbauche[]|ObjectCollection findByFonction(string $fonction) Return ChildEmbauche objects filtered by the fonction column
 * @method     ChildEmbauche[]|ObjectCollection findByDepartementId(int $departement_id) Return ChildEmbauche objects filtered by the departement_id column
 * @method     ChildEmbauche[]|ObjectCollection findByDateDebut(string $date_debut) Return ChildEmbauche objects filtered by the date_debut column
 * @method     ChildEmbauche[]|ObjectCollection findByDateFin(string $date_fin) Return ChildEmbauche objects filtered by the date_fin column
 * @method     ChildEmbauche[]|ObjectCollection findByStatus(int $status) Return ChildEmbauche objects filtered by the status column
 * @method     ChildEmbauche[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class EmbaucheQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \App\Models\Base\EmbaucheQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\App\\Models\\Embauche', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildEmbaucheQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildEmbaucheQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildEmbaucheQuery) {
            return $criteria;
        }
        $query = new ChildEmbaucheQuery();
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
     * @return ChildEmbauche|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(EmbaucheTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = EmbaucheTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildEmbauche A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT embauche_id, civilite, ref_interne, nom_prenom, photo_link, fonction, departement_id, date_debut, date_fin, status FROM embauche WHERE embauche_id = :p0';
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
            /** @var ChildEmbauche $obj */
            $obj = new ChildEmbauche();
            $obj->hydrate($row);
            EmbaucheTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildEmbauche|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildEmbaucheQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(EmbaucheTableMap::COL_EMBAUCHE_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildEmbaucheQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(EmbaucheTableMap::COL_EMBAUCHE_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the embauche_id column
     *
     * Example usage:
     * <code>
     * $query->filterByEmbaucheId(1234); // WHERE embauche_id = 1234
     * $query->filterByEmbaucheId(array(12, 34)); // WHERE embauche_id IN (12, 34)
     * $query->filterByEmbaucheId(array('min' => 12)); // WHERE embauche_id > 12
     * </code>
     *
     * @param     mixed $embaucheId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEmbaucheQuery The current query, for fluid interface
     */
    public function filterByEmbaucheId($embaucheId = null, $comparison = null)
    {
        if (is_array($embaucheId)) {
            $useMinMax = false;
            if (isset($embaucheId['min'])) {
                $this->addUsingAlias(EmbaucheTableMap::COL_EMBAUCHE_ID, $embaucheId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($embaucheId['max'])) {
                $this->addUsingAlias(EmbaucheTableMap::COL_EMBAUCHE_ID, $embaucheId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EmbaucheTableMap::COL_EMBAUCHE_ID, $embaucheId, $comparison);
    }

    /**
     * Filter the query on the civilite column
     *
     * Example usage:
     * <code>
     * $query->filterByCivilite('fooValue');   // WHERE civilite = 'fooValue'
     * $query->filterByCivilite('%fooValue%', Criteria::LIKE); // WHERE civilite LIKE '%fooValue%'
     * </code>
     *
     * @param     string $civilite The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEmbaucheQuery The current query, for fluid interface
     */
    public function filterByCivilite($civilite = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($civilite)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EmbaucheTableMap::COL_CIVILITE, $civilite, $comparison);
    }

    /**
     * Filter the query on the ref_interne column
     *
     * Example usage:
     * <code>
     * $query->filterByRefInterne('fooValue');   // WHERE ref_interne = 'fooValue'
     * $query->filterByRefInterne('%fooValue%', Criteria::LIKE); // WHERE ref_interne LIKE '%fooValue%'
     * </code>
     *
     * @param     string $refInterne The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEmbaucheQuery The current query, for fluid interface
     */
    public function filterByRefInterne($refInterne = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($refInterne)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EmbaucheTableMap::COL_REF_INTERNE, $refInterne, $comparison);
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
     * @return $this|ChildEmbaucheQuery The current query, for fluid interface
     */
    public function filterByNomPrenom($nomPrenom = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($nomPrenom)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EmbaucheTableMap::COL_NOM_PRENOM, $nomPrenom, $comparison);
    }

    /**
     * Filter the query on the photo_link column
     *
     * Example usage:
     * <code>
     * $query->filterByPhotoLink('fooValue');   // WHERE photo_link = 'fooValue'
     * $query->filterByPhotoLink('%fooValue%', Criteria::LIKE); // WHERE photo_link LIKE '%fooValue%'
     * </code>
     *
     * @param     string $photoLink The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEmbaucheQuery The current query, for fluid interface
     */
    public function filterByPhotoLink($photoLink = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($photoLink)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EmbaucheTableMap::COL_PHOTO_LINK, $photoLink, $comparison);
    }

    /**
     * Filter the query on the fonction column
     *
     * Example usage:
     * <code>
     * $query->filterByFonction('fooValue');   // WHERE fonction = 'fooValue'
     * $query->filterByFonction('%fooValue%', Criteria::LIKE); // WHERE fonction LIKE '%fooValue%'
     * </code>
     *
     * @param     string $fonction The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEmbaucheQuery The current query, for fluid interface
     */
    public function filterByFonction($fonction = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($fonction)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EmbaucheTableMap::COL_FONCTION, $fonction, $comparison);
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
     * @return $this|ChildEmbaucheQuery The current query, for fluid interface
     */
    public function filterByDepartementId($departementId = null, $comparison = null)
    {
        if (is_array($departementId)) {
            $useMinMax = false;
            if (isset($departementId['min'])) {
                $this->addUsingAlias(EmbaucheTableMap::COL_DEPARTEMENT_ID, $departementId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($departementId['max'])) {
                $this->addUsingAlias(EmbaucheTableMap::COL_DEPARTEMENT_ID, $departementId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EmbaucheTableMap::COL_DEPARTEMENT_ID, $departementId, $comparison);
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
     * @return $this|ChildEmbaucheQuery The current query, for fluid interface
     */
    public function filterByDateDebut($dateDebut = null, $comparison = null)
    {
        if (is_array($dateDebut)) {
            $useMinMax = false;
            if (isset($dateDebut['min'])) {
                $this->addUsingAlias(EmbaucheTableMap::COL_DATE_DEBUT, $dateDebut['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateDebut['max'])) {
                $this->addUsingAlias(EmbaucheTableMap::COL_DATE_DEBUT, $dateDebut['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EmbaucheTableMap::COL_DATE_DEBUT, $dateDebut, $comparison);
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
     * @return $this|ChildEmbaucheQuery The current query, for fluid interface
     */
    public function filterByDateFin($dateFin = null, $comparison = null)
    {
        if (is_array($dateFin)) {
            $useMinMax = false;
            if (isset($dateFin['min'])) {
                $this->addUsingAlias(EmbaucheTableMap::COL_DATE_FIN, $dateFin['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateFin['max'])) {
                $this->addUsingAlias(EmbaucheTableMap::COL_DATE_FIN, $dateFin['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EmbaucheTableMap::COL_DATE_FIN, $dateFin, $comparison);
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
     * @return $this|ChildEmbaucheQuery The current query, for fluid interface
     */
    public function filterByStatus($status = null, $comparison = null)
    {
        if (is_array($status)) {
            $useMinMax = false;
            if (isset($status['min'])) {
                $this->addUsingAlias(EmbaucheTableMap::COL_STATUS, $status['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($status['max'])) {
                $this->addUsingAlias(EmbaucheTableMap::COL_STATUS, $status['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EmbaucheTableMap::COL_STATUS, $status, $comparison);
    }

    /**
     * Filter the query by a related \App\Models\Departement object
     *
     * @param \App\Models\Departement|ObjectCollection $departement The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildEmbaucheQuery The current query, for fluid interface
     */
    public function filterByDepartement($departement, $comparison = null)
    {
        if ($departement instanceof \App\Models\Departement) {
            return $this
                ->addUsingAlias(EmbaucheTableMap::COL_DEPARTEMENT_ID, $departement->getDepartementId(), $comparison);
        } elseif ($departement instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(EmbaucheTableMap::COL_DEPARTEMENT_ID, $departement->toKeyValue('PrimaryKey', 'DepartementId'), $comparison);
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
     * @return $this|ChildEmbaucheQuery The current query, for fluid interface
     */
    public function joinDepartement($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useDepartementQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinDepartement($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Departement', '\App\Models\DepartementQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildEmbauche $embauche Object to remove from the list of results
     *
     * @return $this|ChildEmbaucheQuery The current query, for fluid interface
     */
    public function prune($embauche = null)
    {
        if ($embauche) {
            $this->addUsingAlias(EmbaucheTableMap::COL_EMBAUCHE_ID, $embauche->getEmbaucheId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the embauche table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(EmbaucheTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            EmbaucheTableMap::clearInstancePool();
            EmbaucheTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(EmbaucheTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(EmbaucheTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            EmbaucheTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            EmbaucheTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // EmbaucheQuery
