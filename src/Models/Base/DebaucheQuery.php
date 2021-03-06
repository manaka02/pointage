<?php

namespace App\Models\Base;

use \Exception;
use \PDO;
use App\Models\Debauche as ChildDebauche;
use App\Models\DebaucheQuery as ChildDebaucheQuery;
use App\Models\Map\DebaucheTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'debauche' table.
 *
 *
 *
 * @method     ChildDebaucheQuery orderByDebaucheId($order = Criteria::ASC) Order by the debauche_id column
 * @method     ChildDebaucheQuery orderByCivilite($order = Criteria::ASC) Order by the civilite column
 * @method     ChildDebaucheQuery orderByRefInterne($order = Criteria::ASC) Order by the ref_interne column
 * @method     ChildDebaucheQuery orderByNomPrenom($order = Criteria::ASC) Order by the nom_prenom column
 * @method     ChildDebaucheQuery orderByFonction($order = Criteria::ASC) Order by the fonction column
 * @method     ChildDebaucheQuery orderByDepartementId($order = Criteria::ASC) Order by the departement_id column
 * @method     ChildDebaucheQuery orderByPhotoLink($order = Criteria::ASC) Order by the photo_link column
 * @method     ChildDebaucheQuery orderByDateEmbauche($order = Criteria::ASC) Order by the date_embauche column
 * @method     ChildDebaucheQuery orderByDateDepart($order = Criteria::ASC) Order by the date_depart column
 * @method     ChildDebaucheQuery orderByRaisons($order = Criteria::ASC) Order by the raisons column
 * @method     ChildDebaucheQuery orderByMotif($order = Criteria::ASC) Order by the motif column
 *
 * @method     ChildDebaucheQuery groupByDebaucheId() Group by the debauche_id column
 * @method     ChildDebaucheQuery groupByCivilite() Group by the civilite column
 * @method     ChildDebaucheQuery groupByRefInterne() Group by the ref_interne column
 * @method     ChildDebaucheQuery groupByNomPrenom() Group by the nom_prenom column
 * @method     ChildDebaucheQuery groupByFonction() Group by the fonction column
 * @method     ChildDebaucheQuery groupByDepartementId() Group by the departement_id column
 * @method     ChildDebaucheQuery groupByPhotoLink() Group by the photo_link column
 * @method     ChildDebaucheQuery groupByDateEmbauche() Group by the date_embauche column
 * @method     ChildDebaucheQuery groupByDateDepart() Group by the date_depart column
 * @method     ChildDebaucheQuery groupByRaisons() Group by the raisons column
 * @method     ChildDebaucheQuery groupByMotif() Group by the motif column
 *
 * @method     ChildDebaucheQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildDebaucheQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildDebaucheQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildDebaucheQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildDebaucheQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildDebaucheQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildDebaucheQuery leftJoinDepartement($relationAlias = null) Adds a LEFT JOIN clause to the query using the Departement relation
 * @method     ChildDebaucheQuery rightJoinDepartement($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Departement relation
 * @method     ChildDebaucheQuery innerJoinDepartement($relationAlias = null) Adds a INNER JOIN clause to the query using the Departement relation
 *
 * @method     ChildDebaucheQuery joinWithDepartement($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Departement relation
 *
 * @method     ChildDebaucheQuery leftJoinWithDepartement() Adds a LEFT JOIN clause and with to the query using the Departement relation
 * @method     ChildDebaucheQuery rightJoinWithDepartement() Adds a RIGHT JOIN clause and with to the query using the Departement relation
 * @method     ChildDebaucheQuery innerJoinWithDepartement() Adds a INNER JOIN clause and with to the query using the Departement relation
 *
 * @method     \App\Models\DepartementQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildDebauche findOne(ConnectionInterface $con = null) Return the first ChildDebauche matching the query
 * @method     ChildDebauche findOneOrCreate(ConnectionInterface $con = null) Return the first ChildDebauche matching the query, or a new ChildDebauche object populated from the query conditions when no match is found
 *
 * @method     ChildDebauche findOneByDebaucheId(int $debauche_id) Return the first ChildDebauche filtered by the debauche_id column
 * @method     ChildDebauche findOneByCivilite(string $civilite) Return the first ChildDebauche filtered by the civilite column
 * @method     ChildDebauche findOneByRefInterne(string $ref_interne) Return the first ChildDebauche filtered by the ref_interne column
 * @method     ChildDebauche findOneByNomPrenom(string $nom_prenom) Return the first ChildDebauche filtered by the nom_prenom column
 * @method     ChildDebauche findOneByFonction(string $fonction) Return the first ChildDebauche filtered by the fonction column
 * @method     ChildDebauche findOneByDepartementId(int $departement_id) Return the first ChildDebauche filtered by the departement_id column
 * @method     ChildDebauche findOneByPhotoLink(string $photo_link) Return the first ChildDebauche filtered by the photo_link column
 * @method     ChildDebauche findOneByDateEmbauche(string $date_embauche) Return the first ChildDebauche filtered by the date_embauche column
 * @method     ChildDebauche findOneByDateDepart(string $date_depart) Return the first ChildDebauche filtered by the date_depart column
 * @method     ChildDebauche findOneByRaisons(string $raisons) Return the first ChildDebauche filtered by the raisons column
 * @method     ChildDebauche findOneByMotif(string $motif) Return the first ChildDebauche filtered by the motif column *

 * @method     ChildDebauche requirePk($key, ConnectionInterface $con = null) Return the ChildDebauche by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDebauche requireOne(ConnectionInterface $con = null) Return the first ChildDebauche matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDebauche requireOneByDebaucheId(int $debauche_id) Return the first ChildDebauche filtered by the debauche_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDebauche requireOneByCivilite(string $civilite) Return the first ChildDebauche filtered by the civilite column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDebauche requireOneByRefInterne(string $ref_interne) Return the first ChildDebauche filtered by the ref_interne column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDebauche requireOneByNomPrenom(string $nom_prenom) Return the first ChildDebauche filtered by the nom_prenom column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDebauche requireOneByFonction(string $fonction) Return the first ChildDebauche filtered by the fonction column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDebauche requireOneByDepartementId(int $departement_id) Return the first ChildDebauche filtered by the departement_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDebauche requireOneByPhotoLink(string $photo_link) Return the first ChildDebauche filtered by the photo_link column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDebauche requireOneByDateEmbauche(string $date_embauche) Return the first ChildDebauche filtered by the date_embauche column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDebauche requireOneByDateDepart(string $date_depart) Return the first ChildDebauche filtered by the date_depart column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDebauche requireOneByRaisons(string $raisons) Return the first ChildDebauche filtered by the raisons column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDebauche requireOneByMotif(string $motif) Return the first ChildDebauche filtered by the motif column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDebauche[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildDebauche objects based on current ModelCriteria
 * @method     ChildDebauche[]|ObjectCollection findByDebaucheId(int $debauche_id) Return ChildDebauche objects filtered by the debauche_id column
 * @method     ChildDebauche[]|ObjectCollection findByCivilite(string $civilite) Return ChildDebauche objects filtered by the civilite column
 * @method     ChildDebauche[]|ObjectCollection findByRefInterne(string $ref_interne) Return ChildDebauche objects filtered by the ref_interne column
 * @method     ChildDebauche[]|ObjectCollection findByNomPrenom(string $nom_prenom) Return ChildDebauche objects filtered by the nom_prenom column
 * @method     ChildDebauche[]|ObjectCollection findByFonction(string $fonction) Return ChildDebauche objects filtered by the fonction column
 * @method     ChildDebauche[]|ObjectCollection findByDepartementId(int $departement_id) Return ChildDebauche objects filtered by the departement_id column
 * @method     ChildDebauche[]|ObjectCollection findByPhotoLink(string $photo_link) Return ChildDebauche objects filtered by the photo_link column
 * @method     ChildDebauche[]|ObjectCollection findByDateEmbauche(string $date_embauche) Return ChildDebauche objects filtered by the date_embauche column
 * @method     ChildDebauche[]|ObjectCollection findByDateDepart(string $date_depart) Return ChildDebauche objects filtered by the date_depart column
 * @method     ChildDebauche[]|ObjectCollection findByRaisons(string $raisons) Return ChildDebauche objects filtered by the raisons column
 * @method     ChildDebauche[]|ObjectCollection findByMotif(string $motif) Return ChildDebauche objects filtered by the motif column
 * @method     ChildDebauche[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class DebaucheQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \App\Models\Base\DebaucheQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\App\\Models\\Debauche', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildDebaucheQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildDebaucheQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildDebaucheQuery) {
            return $criteria;
        }
        $query = new ChildDebaucheQuery();
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
     * @return ChildDebauche|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(DebaucheTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = DebaucheTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildDebauche A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT debauche_id, civilite, ref_interne, nom_prenom, fonction, departement_id, photo_link, date_embauche, date_depart, raisons, motif FROM debauche WHERE debauche_id = :p0';
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
            /** @var ChildDebauche $obj */
            $obj = new ChildDebauche();
            $obj->hydrate($row);
            DebaucheTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildDebauche|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildDebaucheQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(DebaucheTableMap::COL_DEBAUCHE_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildDebaucheQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(DebaucheTableMap::COL_DEBAUCHE_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the debauche_id column
     *
     * Example usage:
     * <code>
     * $query->filterByDebaucheId(1234); // WHERE debauche_id = 1234
     * $query->filterByDebaucheId(array(12, 34)); // WHERE debauche_id IN (12, 34)
     * $query->filterByDebaucheId(array('min' => 12)); // WHERE debauche_id > 12
     * </code>
     *
     * @param     mixed $debaucheId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDebaucheQuery The current query, for fluid interface
     */
    public function filterByDebaucheId($debaucheId = null, $comparison = null)
    {
        if (is_array($debaucheId)) {
            $useMinMax = false;
            if (isset($debaucheId['min'])) {
                $this->addUsingAlias(DebaucheTableMap::COL_DEBAUCHE_ID, $debaucheId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($debaucheId['max'])) {
                $this->addUsingAlias(DebaucheTableMap::COL_DEBAUCHE_ID, $debaucheId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DebaucheTableMap::COL_DEBAUCHE_ID, $debaucheId, $comparison);
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
     * @return $this|ChildDebaucheQuery The current query, for fluid interface
     */
    public function filterByCivilite($civilite = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($civilite)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DebaucheTableMap::COL_CIVILITE, $civilite, $comparison);
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
     * @return $this|ChildDebaucheQuery The current query, for fluid interface
     */
    public function filterByRefInterne($refInterne = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($refInterne)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DebaucheTableMap::COL_REF_INTERNE, $refInterne, $comparison);
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
     * @return $this|ChildDebaucheQuery The current query, for fluid interface
     */
    public function filterByNomPrenom($nomPrenom = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($nomPrenom)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DebaucheTableMap::COL_NOM_PRENOM, $nomPrenom, $comparison);
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
     * @return $this|ChildDebaucheQuery The current query, for fluid interface
     */
    public function filterByFonction($fonction = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($fonction)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DebaucheTableMap::COL_FONCTION, $fonction, $comparison);
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
     * @return $this|ChildDebaucheQuery The current query, for fluid interface
     */
    public function filterByDepartementId($departementId = null, $comparison = null)
    {
        if (is_array($departementId)) {
            $useMinMax = false;
            if (isset($departementId['min'])) {
                $this->addUsingAlias(DebaucheTableMap::COL_DEPARTEMENT_ID, $departementId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($departementId['max'])) {
                $this->addUsingAlias(DebaucheTableMap::COL_DEPARTEMENT_ID, $departementId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DebaucheTableMap::COL_DEPARTEMENT_ID, $departementId, $comparison);
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
     * @return $this|ChildDebaucheQuery The current query, for fluid interface
     */
    public function filterByPhotoLink($photoLink = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($photoLink)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DebaucheTableMap::COL_PHOTO_LINK, $photoLink, $comparison);
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
     * @return $this|ChildDebaucheQuery The current query, for fluid interface
     */
    public function filterByDateEmbauche($dateEmbauche = null, $comparison = null)
    {
        if (is_array($dateEmbauche)) {
            $useMinMax = false;
            if (isset($dateEmbauche['min'])) {
                $this->addUsingAlias(DebaucheTableMap::COL_DATE_EMBAUCHE, $dateEmbauche['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateEmbauche['max'])) {
                $this->addUsingAlias(DebaucheTableMap::COL_DATE_EMBAUCHE, $dateEmbauche['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DebaucheTableMap::COL_DATE_EMBAUCHE, $dateEmbauche, $comparison);
    }

    /**
     * Filter the query on the date_depart column
     *
     * Example usage:
     * <code>
     * $query->filterByDateDepart('2011-03-14'); // WHERE date_depart = '2011-03-14'
     * $query->filterByDateDepart('now'); // WHERE date_depart = '2011-03-14'
     * $query->filterByDateDepart(array('max' => 'yesterday')); // WHERE date_depart > '2011-03-13'
     * </code>
     *
     * @param     mixed $dateDepart The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDebaucheQuery The current query, for fluid interface
     */
    public function filterByDateDepart($dateDepart = null, $comparison = null)
    {
        if (is_array($dateDepart)) {
            $useMinMax = false;
            if (isset($dateDepart['min'])) {
                $this->addUsingAlias(DebaucheTableMap::COL_DATE_DEPART, $dateDepart['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateDepart['max'])) {
                $this->addUsingAlias(DebaucheTableMap::COL_DATE_DEPART, $dateDepart['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DebaucheTableMap::COL_DATE_DEPART, $dateDepart, $comparison);
    }

    /**
     * Filter the query on the raisons column
     *
     * Example usage:
     * <code>
     * $query->filterByRaisons('fooValue');   // WHERE raisons = 'fooValue'
     * $query->filterByRaisons('%fooValue%', Criteria::LIKE); // WHERE raisons LIKE '%fooValue%'
     * </code>
     *
     * @param     string $raisons The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDebaucheQuery The current query, for fluid interface
     */
    public function filterByRaisons($raisons = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($raisons)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DebaucheTableMap::COL_RAISONS, $raisons, $comparison);
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
     * @return $this|ChildDebaucheQuery The current query, for fluid interface
     */
    public function filterByMotif($motif = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($motif)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DebaucheTableMap::COL_MOTIF, $motif, $comparison);
    }

    /**
     * Filter the query by a related \App\Models\Departement object
     *
     * @param \App\Models\Departement|ObjectCollection $departement The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildDebaucheQuery The current query, for fluid interface
     */
    public function filterByDepartement($departement, $comparison = null)
    {
        if ($departement instanceof \App\Models\Departement) {
            return $this
                ->addUsingAlias(DebaucheTableMap::COL_DEPARTEMENT_ID, $departement->getDepartementId(), $comparison);
        } elseif ($departement instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(DebaucheTableMap::COL_DEPARTEMENT_ID, $departement->toKeyValue('PrimaryKey', 'DepartementId'), $comparison);
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
     * @return $this|ChildDebaucheQuery The current query, for fluid interface
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
     * @param   ChildDebauche $debauche Object to remove from the list of results
     *
     * @return $this|ChildDebaucheQuery The current query, for fluid interface
     */
    public function prune($debauche = null)
    {
        if ($debauche) {
            $this->addUsingAlias(DebaucheTableMap::COL_DEBAUCHE_ID, $debauche->getDebaucheId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the debauche table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DebaucheTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            DebaucheTableMap::clearInstancePool();
            DebaucheTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(DebaucheTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(DebaucheTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            DebaucheTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            DebaucheTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // DebaucheQuery
