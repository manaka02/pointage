<?php

namespace App\Models\Base;

use \Exception;
use \PDO;
use App\Models\Utilisateur as ChildUtilisateur;
use App\Models\UtilisateurQuery as ChildUtilisateurQuery;
use App\Models\Map\UtilisateurTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'utilisateur' table.
 *
 *
 *
 * @method     ChildUtilisateurQuery orderByUtilisateurId($order = Criteria::ASC) Order by the utilisateur_id column
 * @method     ChildUtilisateurQuery orderByMail($order = Criteria::ASC) Order by the mail column
 * @method     ChildUtilisateurQuery orderByPass($order = Criteria::ASC) Order by the pass column
 * @method     ChildUtilisateurQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildUtilisateurQuery orderBySurname($order = Criteria::ASC) Order by the surname column
 * @method     ChildUtilisateurQuery orderByStatus($order = Criteria::ASC) Order by the status column
 * @method     ChildUtilisateurQuery orderByLastLogin($order = Criteria::ASC) Order by the last_login column
 * @method     ChildUtilisateurQuery orderByEmailActivationKey($order = Criteria::ASC) Order by the email_activation_key column
 *
 * @method     ChildUtilisateurQuery groupByUtilisateurId() Group by the utilisateur_id column
 * @method     ChildUtilisateurQuery groupByMail() Group by the mail column
 * @method     ChildUtilisateurQuery groupByPass() Group by the pass column
 * @method     ChildUtilisateurQuery groupByName() Group by the name column
 * @method     ChildUtilisateurQuery groupBySurname() Group by the surname column
 * @method     ChildUtilisateurQuery groupByStatus() Group by the status column
 * @method     ChildUtilisateurQuery groupByLastLogin() Group by the last_login column
 * @method     ChildUtilisateurQuery groupByEmailActivationKey() Group by the email_activation_key column
 *
 * @method     ChildUtilisateurQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildUtilisateurQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildUtilisateurQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildUtilisateurQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildUtilisateurQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildUtilisateurQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildUtilisateur findOne(ConnectionInterface $con = null) Return the first ChildUtilisateur matching the query
 * @method     ChildUtilisateur findOneOrCreate(ConnectionInterface $con = null) Return the first ChildUtilisateur matching the query, or a new ChildUtilisateur object populated from the query conditions when no match is found
 *
 * @method     ChildUtilisateur findOneByUtilisateurId(int $utilisateur_id) Return the first ChildUtilisateur filtered by the utilisateur_id column
 * @method     ChildUtilisateur findOneByMail(string $mail) Return the first ChildUtilisateur filtered by the mail column
 * @method     ChildUtilisateur findOneByPass(string $pass) Return the first ChildUtilisateur filtered by the pass column
 * @method     ChildUtilisateur findOneByName(string $name) Return the first ChildUtilisateur filtered by the name column
 * @method     ChildUtilisateur findOneBySurname(string $surname) Return the first ChildUtilisateur filtered by the surname column
 * @method     ChildUtilisateur findOneByStatus(int $status) Return the first ChildUtilisateur filtered by the status column
 * @method     ChildUtilisateur findOneByLastLogin(string $last_login) Return the first ChildUtilisateur filtered by the last_login column
 * @method     ChildUtilisateur findOneByEmailActivationKey(string $email_activation_key) Return the first ChildUtilisateur filtered by the email_activation_key column *

 * @method     ChildUtilisateur requirePk($key, ConnectionInterface $con = null) Return the ChildUtilisateur by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUtilisateur requireOne(ConnectionInterface $con = null) Return the first ChildUtilisateur matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildUtilisateur requireOneByUtilisateurId(int $utilisateur_id) Return the first ChildUtilisateur filtered by the utilisateur_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUtilisateur requireOneByMail(string $mail) Return the first ChildUtilisateur filtered by the mail column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUtilisateur requireOneByPass(string $pass) Return the first ChildUtilisateur filtered by the pass column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUtilisateur requireOneByName(string $name) Return the first ChildUtilisateur filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUtilisateur requireOneBySurname(string $surname) Return the first ChildUtilisateur filtered by the surname column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUtilisateur requireOneByStatus(int $status) Return the first ChildUtilisateur filtered by the status column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUtilisateur requireOneByLastLogin(string $last_login) Return the first ChildUtilisateur filtered by the last_login column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUtilisateur requireOneByEmailActivationKey(string $email_activation_key) Return the first ChildUtilisateur filtered by the email_activation_key column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildUtilisateur[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildUtilisateur objects based on current ModelCriteria
 * @method     ChildUtilisateur[]|ObjectCollection findByUtilisateurId(int $utilisateur_id) Return ChildUtilisateur objects filtered by the utilisateur_id column
 * @method     ChildUtilisateur[]|ObjectCollection findByMail(string $mail) Return ChildUtilisateur objects filtered by the mail column
 * @method     ChildUtilisateur[]|ObjectCollection findByPass(string $pass) Return ChildUtilisateur objects filtered by the pass column
 * @method     ChildUtilisateur[]|ObjectCollection findByName(string $name) Return ChildUtilisateur objects filtered by the name column
 * @method     ChildUtilisateur[]|ObjectCollection findBySurname(string $surname) Return ChildUtilisateur objects filtered by the surname column
 * @method     ChildUtilisateur[]|ObjectCollection findByStatus(int $status) Return ChildUtilisateur objects filtered by the status column
 * @method     ChildUtilisateur[]|ObjectCollection findByLastLogin(string $last_login) Return ChildUtilisateur objects filtered by the last_login column
 * @method     ChildUtilisateur[]|ObjectCollection findByEmailActivationKey(string $email_activation_key) Return ChildUtilisateur objects filtered by the email_activation_key column
 * @method     ChildUtilisateur[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class UtilisateurQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \App\Models\Base\UtilisateurQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\App\\Models\\Utilisateur', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildUtilisateurQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildUtilisateurQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildUtilisateurQuery) {
            return $criteria;
        }
        $query = new ChildUtilisateurQuery();
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
     * @return ChildUtilisateur|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(UtilisateurTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = UtilisateurTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildUtilisateur A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT utilisateur_id, mail, pass, name, surname, status, last_login, email_activation_key FROM utilisateur WHERE utilisateur_id = :p0';
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
            /** @var ChildUtilisateur $obj */
            $obj = new ChildUtilisateur();
            $obj->hydrate($row);
            UtilisateurTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildUtilisateur|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildUtilisateurQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(UtilisateurTableMap::COL_UTILISATEUR_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildUtilisateurQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(UtilisateurTableMap::COL_UTILISATEUR_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the utilisateur_id column
     *
     * Example usage:
     * <code>
     * $query->filterByUtilisateurId(1234); // WHERE utilisateur_id = 1234
     * $query->filterByUtilisateurId(array(12, 34)); // WHERE utilisateur_id IN (12, 34)
     * $query->filterByUtilisateurId(array('min' => 12)); // WHERE utilisateur_id > 12
     * </code>
     *
     * @param     mixed $utilisateurId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUtilisateurQuery The current query, for fluid interface
     */
    public function filterByUtilisateurId($utilisateurId = null, $comparison = null)
    {
        if (is_array($utilisateurId)) {
            $useMinMax = false;
            if (isset($utilisateurId['min'])) {
                $this->addUsingAlias(UtilisateurTableMap::COL_UTILISATEUR_ID, $utilisateurId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($utilisateurId['max'])) {
                $this->addUsingAlias(UtilisateurTableMap::COL_UTILISATEUR_ID, $utilisateurId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UtilisateurTableMap::COL_UTILISATEUR_ID, $utilisateurId, $comparison);
    }

    /**
     * Filter the query on the mail column
     *
     * Example usage:
     * <code>
     * $query->filterByMail('fooValue');   // WHERE mail = 'fooValue'
     * $query->filterByMail('%fooValue%', Criteria::LIKE); // WHERE mail LIKE '%fooValue%'
     * </code>
     *
     * @param     string $mail The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUtilisateurQuery The current query, for fluid interface
     */
    public function filterByMail($mail = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($mail)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UtilisateurTableMap::COL_MAIL, $mail, $comparison);
    }

    /**
     * Filter the query on the pass column
     *
     * Example usage:
     * <code>
     * $query->filterByPass('fooValue');   // WHERE pass = 'fooValue'
     * $query->filterByPass('%fooValue%', Criteria::LIKE); // WHERE pass LIKE '%fooValue%'
     * </code>
     *
     * @param     string $pass The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUtilisateurQuery The current query, for fluid interface
     */
    public function filterByPass($pass = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($pass)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UtilisateurTableMap::COL_PASS, $pass, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%', Criteria::LIKE); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUtilisateurQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UtilisateurTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the surname column
     *
     * Example usage:
     * <code>
     * $query->filterBySurname('fooValue');   // WHERE surname = 'fooValue'
     * $query->filterBySurname('%fooValue%', Criteria::LIKE); // WHERE surname LIKE '%fooValue%'
     * </code>
     *
     * @param     string $surname The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUtilisateurQuery The current query, for fluid interface
     */
    public function filterBySurname($surname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($surname)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UtilisateurTableMap::COL_SURNAME, $surname, $comparison);
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
     * @return $this|ChildUtilisateurQuery The current query, for fluid interface
     */
    public function filterByStatus($status = null, $comparison = null)
    {
        if (is_array($status)) {
            $useMinMax = false;
            if (isset($status['min'])) {
                $this->addUsingAlias(UtilisateurTableMap::COL_STATUS, $status['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($status['max'])) {
                $this->addUsingAlias(UtilisateurTableMap::COL_STATUS, $status['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UtilisateurTableMap::COL_STATUS, $status, $comparison);
    }

    /**
     * Filter the query on the last_login column
     *
     * Example usage:
     * <code>
     * $query->filterByLastLogin('2011-03-14'); // WHERE last_login = '2011-03-14'
     * $query->filterByLastLogin('now'); // WHERE last_login = '2011-03-14'
     * $query->filterByLastLogin(array('max' => 'yesterday')); // WHERE last_login > '2011-03-13'
     * </code>
     *
     * @param     mixed $lastLogin The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUtilisateurQuery The current query, for fluid interface
     */
    public function filterByLastLogin($lastLogin = null, $comparison = null)
    {
        if (is_array($lastLogin)) {
            $useMinMax = false;
            if (isset($lastLogin['min'])) {
                $this->addUsingAlias(UtilisateurTableMap::COL_LAST_LOGIN, $lastLogin['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($lastLogin['max'])) {
                $this->addUsingAlias(UtilisateurTableMap::COL_LAST_LOGIN, $lastLogin['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UtilisateurTableMap::COL_LAST_LOGIN, $lastLogin, $comparison);
    }

    /**
     * Filter the query on the email_activation_key column
     *
     * Example usage:
     * <code>
     * $query->filterByEmailActivationKey('fooValue');   // WHERE email_activation_key = 'fooValue'
     * $query->filterByEmailActivationKey('%fooValue%', Criteria::LIKE); // WHERE email_activation_key LIKE '%fooValue%'
     * </code>
     *
     * @param     string $emailActivationKey The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUtilisateurQuery The current query, for fluid interface
     */
    public function filterByEmailActivationKey($emailActivationKey = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($emailActivationKey)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UtilisateurTableMap::COL_EMAIL_ACTIVATION_KEY, $emailActivationKey, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildUtilisateur $utilisateur Object to remove from the list of results
     *
     * @return $this|ChildUtilisateurQuery The current query, for fluid interface
     */
    public function prune($utilisateur = null)
    {
        if ($utilisateur) {
            $this->addUsingAlias(UtilisateurTableMap::COL_UTILISATEUR_ID, $utilisateur->getUtilisateurId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the utilisateur table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UtilisateurTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            UtilisateurTableMap::clearInstancePool();
            UtilisateurTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(UtilisateurTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(UtilisateurTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            UtilisateurTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            UtilisateurTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // UtilisateurQuery
