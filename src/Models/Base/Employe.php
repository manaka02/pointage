<?php

namespace App\Models\Base;

use \DateTime;
use \Exception;
use \PDO;
use App\Models\Absence as ChildAbsence;
use App\Models\AbsenceQuery as ChildAbsenceQuery;
use App\Models\Conge as ChildConge;
use App\Models\CongeQuery as ChildCongeQuery;
use App\Models\Employe as ChildEmploye;
use App\Models\EmployeQuery as ChildEmployeQuery;
use App\Models\Pointage as ChildPointage;
use App\Models\PointageQuery as ChildPointageQuery;
use App\Models\Retard as ChildRetard;
use App\Models\RetardQuery as ChildRetardQuery;
use App\Models\Unite as ChildUnite;
use App\Models\UniteQuery as ChildUniteQuery;
use App\Models\Map\AbsenceTableMap;
use App\Models\Map\CongeTableMap;
use App\Models\Map\EmployeTableMap;
use App\Models\Map\PointageTableMap;
use App\Models\Map\RetardTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'employe' table.
 *
 *
 *
 * @package    propel.generator..Base
 */
abstract class Employe implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\App\\Models\\Map\\EmployeTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the employe_id field.
     *
     * @var        int
     */
    protected $employe_id;

    /**
     * The value for the ref_interne field.
     *
     * @var        int
     */
    protected $ref_interne;

    /**
     * The value for the unite_id field.
     *
     * @var        int
     */
    protected $unite_id;

    /**
     * The value for the nom_prenom field.
     *
     * @var        string
     */
    protected $nom_prenom;

    /**
     * The value for the poste field.
     *
     * @var        string
     */
    protected $poste;

    /**
     * The value for the genre field.
     *
     * @var        string
     */
    protected $genre;

    /**
     * The value for the date_embauche field.
     *
     * @var        DateTime
     */
    protected $date_embauche;

    /**
     * The value for the presence field.
     *
     * Note: this column has a database default value of: true
     * @var        boolean
     */
    protected $presence;

    /**
     * The value for the status field.
     *
     * Note: this column has a database default value of: 1
     * @var        int
     */
    protected $status;

    /**
     * @var        ChildUnite
     */
    protected $aUnite;

    /**
     * @var        ObjectCollection|ChildAbsence[] Collection to store aggregation of ChildAbsence objects.
     */
    protected $collAbsences;
    protected $collAbsencesPartial;

    /**
     * @var        ObjectCollection|ChildConge[] Collection to store aggregation of ChildConge objects.
     */
    protected $collConges;
    protected $collCongesPartial;

    /**
     * @var        ObjectCollection|ChildPointage[] Collection to store aggregation of ChildPointage objects.
     */
    protected $collPointages;
    protected $collPointagesPartial;

    /**
     * @var        ObjectCollection|ChildRetard[] Collection to store aggregation of ChildRetard objects.
     */
    protected $collRetards;
    protected $collRetardsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildAbsence[]
     */
    protected $absencesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildConge[]
     */
    protected $congesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPointage[]
     */
    protected $pointagesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRetard[]
     */
    protected $retardsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->presence = true;
        $this->status = 1;
    }

    /**
     * Initializes internal state of App\Models\Base\Employe object.
     * @see applyDefaults()
     */
    public function __construct()
    {
        $this->applyDefaultValues();
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>Employe</code> instance.  If
     * <code>obj</code> is an instance of <code>Employe</code>, delegates to
     * <code>equals(Employe)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return void
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        $serializableProperties = array_diff($cls->getProperties(), $cls->getProperties(\ReflectionProperty::IS_STATIC));

        foreach($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }

        return $propertyNames;
    }

    /**
     * Get the [employe_id] column value.
     *
     * @return int
     */
    public function getEmployeId()
    {
        return $this->employe_id;
    }

    /**
     * Get the [ref_interne] column value.
     *
     * @return int
     */
    public function getRefInterne()
    {
        return $this->ref_interne;
    }

    /**
     * Get the [unite_id] column value.
     *
     * @return int
     */
    public function getUniteId()
    {
        return $this->unite_id;
    }

    /**
     * Get the [nom_prenom] column value.
     *
     * @return string
     */
    public function getNomPrenom()
    {
        return $this->nom_prenom;
    }

    /**
     * Get the [poste] column value.
     *
     * @return string
     */
    public function getPoste()
    {
        return $this->poste;
    }

    /**
     * Get the [genre] column value.
     *
     * @return string
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * Get the [optionally formatted] temporal [date_embauche] column value.
     *
     *
     * @param      string|null $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDateEmbauche($format = NULL)
    {
        if ($format === null) {
            return $this->date_embauche;
        } else {
            return $this->date_embauche instanceof \DateTimeInterface ? $this->date_embauche->format($format) : null;
        }
    }

    /**
     * Get the [presence] column value.
     *
     * @return boolean
     */
    public function getPresence()
    {
        return $this->presence;
    }

    /**
     * Get the [presence] column value.
     *
     * @return boolean
     */
    public function isPresence()
    {
        return $this->getPresence();
    }

    /**
     * Get the [status] column value.
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of [employe_id] column.
     *
     * @param int $v New value
     * @return $this|\App\Models\Employe The current object (for fluent API support)
     */
    public function setEmployeId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->employe_id !== $v) {
            $this->employe_id = $v;
            $this->modifiedColumns[EmployeTableMap::COL_EMPLOYE_ID] = true;
        }

        return $this;
    } // setEmployeId()

    /**
     * Set the value of [ref_interne] column.
     *
     * @param int|null $v New value
     * @return $this|\App\Models\Employe The current object (for fluent API support)
     */
    public function setRefInterne($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->ref_interne !== $v) {
            $this->ref_interne = $v;
            $this->modifiedColumns[EmployeTableMap::COL_REF_INTERNE] = true;
        }

        return $this;
    } // setRefInterne()

    /**
     * Set the value of [unite_id] column.
     *
     * @param int|null $v New value
     * @return $this|\App\Models\Employe The current object (for fluent API support)
     */
    public function setUniteId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->unite_id !== $v) {
            $this->unite_id = $v;
            $this->modifiedColumns[EmployeTableMap::COL_UNITE_ID] = true;
        }

        if ($this->aUnite !== null && $this->aUnite->getUniteId() !== $v) {
            $this->aUnite = null;
        }

        return $this;
    } // setUniteId()

    /**
     * Set the value of [nom_prenom] column.
     *
     * @param string|null $v New value
     * @return $this|\App\Models\Employe The current object (for fluent API support)
     */
    public function setNomPrenom($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->nom_prenom !== $v) {
            $this->nom_prenom = $v;
            $this->modifiedColumns[EmployeTableMap::COL_NOM_PRENOM] = true;
        }

        return $this;
    } // setNomPrenom()

    /**
     * Set the value of [poste] column.
     *
     * @param string|null $v New value
     * @return $this|\App\Models\Employe The current object (for fluent API support)
     */
    public function setPoste($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->poste !== $v) {
            $this->poste = $v;
            $this->modifiedColumns[EmployeTableMap::COL_POSTE] = true;
        }

        return $this;
    } // setPoste()

    /**
     * Set the value of [genre] column.
     *
     * @param string|null $v New value
     * @return $this|\App\Models\Employe The current object (for fluent API support)
     */
    public function setGenre($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->genre !== $v) {
            $this->genre = $v;
            $this->modifiedColumns[EmployeTableMap::COL_GENRE] = true;
        }

        return $this;
    } // setGenre()

    /**
     * Sets the value of [date_embauche] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\App\Models\Employe The current object (for fluent API support)
     */
    public function setDateEmbauche($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->date_embauche !== null || $dt !== null) {
            if ($this->date_embauche === null || $dt === null || $dt->format("Y-m-d") !== $this->date_embauche->format("Y-m-d")) {
                $this->date_embauche = $dt === null ? null : clone $dt;
                $this->modifiedColumns[EmployeTableMap::COL_DATE_EMBAUCHE] = true;
            }
        } // if either are not null

        return $this;
    } // setDateEmbauche()

    /**
     * Sets the value of the [presence] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\App\Models\Employe The current object (for fluent API support)
     */
    public function setPresence($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->presence !== $v) {
            $this->presence = $v;
            $this->modifiedColumns[EmployeTableMap::COL_PRESENCE] = true;
        }

        return $this;
    } // setPresence()

    /**
     * Set the value of [status] column.
     *
     * @param int $v New value
     * @return $this|\App\Models\Employe The current object (for fluent API support)
     */
    public function setStatus($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->status !== $v) {
            $this->status = $v;
            $this->modifiedColumns[EmployeTableMap::COL_STATUS] = true;
        }

        return $this;
    } // setStatus()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
            if ($this->presence !== true) {
                return false;
            }

            if ($this->status !== 1) {
                return false;
            }

        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : EmployeTableMap::translateFieldName('EmployeId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->employe_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : EmployeTableMap::translateFieldName('RefInterne', TableMap::TYPE_PHPNAME, $indexType)];
            $this->ref_interne = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : EmployeTableMap::translateFieldName('UniteId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->unite_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : EmployeTableMap::translateFieldName('NomPrenom', TableMap::TYPE_PHPNAME, $indexType)];
            $this->nom_prenom = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : EmployeTableMap::translateFieldName('Poste', TableMap::TYPE_PHPNAME, $indexType)];
            $this->poste = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : EmployeTableMap::translateFieldName('Genre', TableMap::TYPE_PHPNAME, $indexType)];
            $this->genre = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : EmployeTableMap::translateFieldName('DateEmbauche', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00') {
                $col = null;
            }
            $this->date_embauche = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : EmployeTableMap::translateFieldName('Presence', TableMap::TYPE_PHPNAME, $indexType)];
            $this->presence = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : EmployeTableMap::translateFieldName('Status', TableMap::TYPE_PHPNAME, $indexType)];
            $this->status = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 9; // 9 = EmployeTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\App\\Models\\Employe'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
        if ($this->aUnite !== null && $this->unite_id !== $this->aUnite->getUniteId()) {
            $this->aUnite = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(EmployeTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildEmployeQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aUnite = null;
            $this->collAbsences = null;

            $this->collConges = null;

            $this->collPointages = null;

            $this->collRetards = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Employe::setDeleted()
     * @see Employe::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(EmployeTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildEmployeQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($this->alreadyInSave) {
            return 0;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(EmployeTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                EmployeTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aUnite !== null) {
                if ($this->aUnite->isModified() || $this->aUnite->isNew()) {
                    $affectedRows += $this->aUnite->save($con);
                }
                $this->setUnite($this->aUnite);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->absencesScheduledForDeletion !== null) {
                if (!$this->absencesScheduledForDeletion->isEmpty()) {
                    \App\Models\AbsenceQuery::create()
                        ->filterByPrimaryKeys($this->absencesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->absencesScheduledForDeletion = null;
                }
            }

            if ($this->collAbsences !== null) {
                foreach ($this->collAbsences as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->congesScheduledForDeletion !== null) {
                if (!$this->congesScheduledForDeletion->isEmpty()) {
                    \App\Models\CongeQuery::create()
                        ->filterByPrimaryKeys($this->congesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->congesScheduledForDeletion = null;
                }
            }

            if ($this->collConges !== null) {
                foreach ($this->collConges as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->pointagesScheduledForDeletion !== null) {
                if (!$this->pointagesScheduledForDeletion->isEmpty()) {
                    \App\Models\PointageQuery::create()
                        ->filterByPrimaryKeys($this->pointagesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->pointagesScheduledForDeletion = null;
                }
            }

            if ($this->collPointages !== null) {
                foreach ($this->collPointages as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->retardsScheduledForDeletion !== null) {
                if (!$this->retardsScheduledForDeletion->isEmpty()) {
                    \App\Models\RetardQuery::create()
                        ->filterByPrimaryKeys($this->retardsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->retardsScheduledForDeletion = null;
                }
            }

            if ($this->collRetards !== null) {
                foreach ($this->collRetards as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[EmployeTableMap::COL_EMPLOYE_ID] = true;
        if (null !== $this->employe_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . EmployeTableMap::COL_EMPLOYE_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(EmployeTableMap::COL_EMPLOYE_ID)) {
            $modifiedColumns[':p' . $index++]  = 'employe_id';
        }
        if ($this->isColumnModified(EmployeTableMap::COL_REF_INTERNE)) {
            $modifiedColumns[':p' . $index++]  = 'ref_interne';
        }
        if ($this->isColumnModified(EmployeTableMap::COL_UNITE_ID)) {
            $modifiedColumns[':p' . $index++]  = 'unite_id';
        }
        if ($this->isColumnModified(EmployeTableMap::COL_NOM_PRENOM)) {
            $modifiedColumns[':p' . $index++]  = 'nom_prenom';
        }
        if ($this->isColumnModified(EmployeTableMap::COL_POSTE)) {
            $modifiedColumns[':p' . $index++]  = 'poste';
        }
        if ($this->isColumnModified(EmployeTableMap::COL_GENRE)) {
            $modifiedColumns[':p' . $index++]  = 'genre';
        }
        if ($this->isColumnModified(EmployeTableMap::COL_DATE_EMBAUCHE)) {
            $modifiedColumns[':p' . $index++]  = 'date_embauche';
        }
        if ($this->isColumnModified(EmployeTableMap::COL_PRESENCE)) {
            $modifiedColumns[':p' . $index++]  = 'presence';
        }
        if ($this->isColumnModified(EmployeTableMap::COL_STATUS)) {
            $modifiedColumns[':p' . $index++]  = 'status';
        }

        $sql = sprintf(
            'INSERT INTO employe (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'employe_id':
                        $stmt->bindValue($identifier, $this->employe_id, PDO::PARAM_INT);
                        break;
                    case 'ref_interne':
                        $stmt->bindValue($identifier, $this->ref_interne, PDO::PARAM_INT);
                        break;
                    case 'unite_id':
                        $stmt->bindValue($identifier, $this->unite_id, PDO::PARAM_INT);
                        break;
                    case 'nom_prenom':
                        $stmt->bindValue($identifier, $this->nom_prenom, PDO::PARAM_STR);
                        break;
                    case 'poste':
                        $stmt->bindValue($identifier, $this->poste, PDO::PARAM_STR);
                        break;
                    case 'genre':
                        $stmt->bindValue($identifier, $this->genre, PDO::PARAM_STR);
                        break;
                    case 'date_embauche':
                        $stmt->bindValue($identifier, $this->date_embauche ? $this->date_embauche->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'presence':
                        $stmt->bindValue($identifier, (int) $this->presence, PDO::PARAM_INT);
                        break;
                    case 'status':
                        $stmt->bindValue($identifier, $this->status, PDO::PARAM_INT);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setEmployeId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = EmployeTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getEmployeId();
                break;
            case 1:
                return $this->getRefInterne();
                break;
            case 2:
                return $this->getUniteId();
                break;
            case 3:
                return $this->getNomPrenom();
                break;
            case 4:
                return $this->getPoste();
                break;
            case 5:
                return $this->getGenre();
                break;
            case 6:
                return $this->getDateEmbauche();
                break;
            case 7:
                return $this->getPresence();
                break;
            case 8:
                return $this->getStatus();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['Employe'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Employe'][$this->hashCode()] = true;
        $keys = EmployeTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getEmployeId(),
            $keys[1] => $this->getRefInterne(),
            $keys[2] => $this->getUniteId(),
            $keys[3] => $this->getNomPrenom(),
            $keys[4] => $this->getPoste(),
            $keys[5] => $this->getGenre(),
            $keys[6] => $this->getDateEmbauche(),
            $keys[7] => $this->getPresence(),
            $keys[8] => $this->getStatus(),
        );
        if ($result[$keys[6]] instanceof \DateTimeInterface) {
            $result[$keys[6]] = $result[$keys[6]]->format('c');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aUnite) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'unite';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'unite';
                        break;
                    default:
                        $key = 'Unite';
                }

                $result[$key] = $this->aUnite->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collAbsences) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'absences';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'absences';
                        break;
                    default:
                        $key = 'Absences';
                }

                $result[$key] = $this->collAbsences->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collConges) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'conges';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'conges';
                        break;
                    default:
                        $key = 'Conges';
                }

                $result[$key] = $this->collConges->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPointages) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'pointages';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'pointages';
                        break;
                    default:
                        $key = 'Pointages';
                }

                $result[$key] = $this->collPointages->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collRetards) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'retards';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'retards';
                        break;
                    default:
                        $key = 'Retards';
                }

                $result[$key] = $this->collRetards->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\App\Models\Employe
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = EmployeTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\App\Models\Employe
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setEmployeId($value);
                break;
            case 1:
                $this->setRefInterne($value);
                break;
            case 2:
                $this->setUniteId($value);
                break;
            case 3:
                $this->setNomPrenom($value);
                break;
            case 4:
                $this->setPoste($value);
                break;
            case 5:
                $this->setGenre($value);
                break;
            case 6:
                $this->setDateEmbauche($value);
                break;
            case 7:
                $this->setPresence($value);
                break;
            case 8:
                $this->setStatus($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = EmployeTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setEmployeId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setRefInterne($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setUniteId($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setNomPrenom($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setPoste($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setGenre($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setDateEmbauche($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setPresence($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setStatus($arr[$keys[8]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\App\Models\Employe The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(EmployeTableMap::DATABASE_NAME);

        if ($this->isColumnModified(EmployeTableMap::COL_EMPLOYE_ID)) {
            $criteria->add(EmployeTableMap::COL_EMPLOYE_ID, $this->employe_id);
        }
        if ($this->isColumnModified(EmployeTableMap::COL_REF_INTERNE)) {
            $criteria->add(EmployeTableMap::COL_REF_INTERNE, $this->ref_interne);
        }
        if ($this->isColumnModified(EmployeTableMap::COL_UNITE_ID)) {
            $criteria->add(EmployeTableMap::COL_UNITE_ID, $this->unite_id);
        }
        if ($this->isColumnModified(EmployeTableMap::COL_NOM_PRENOM)) {
            $criteria->add(EmployeTableMap::COL_NOM_PRENOM, $this->nom_prenom);
        }
        if ($this->isColumnModified(EmployeTableMap::COL_POSTE)) {
            $criteria->add(EmployeTableMap::COL_POSTE, $this->poste);
        }
        if ($this->isColumnModified(EmployeTableMap::COL_GENRE)) {
            $criteria->add(EmployeTableMap::COL_GENRE, $this->genre);
        }
        if ($this->isColumnModified(EmployeTableMap::COL_DATE_EMBAUCHE)) {
            $criteria->add(EmployeTableMap::COL_DATE_EMBAUCHE, $this->date_embauche);
        }
        if ($this->isColumnModified(EmployeTableMap::COL_PRESENCE)) {
            $criteria->add(EmployeTableMap::COL_PRESENCE, $this->presence);
        }
        if ($this->isColumnModified(EmployeTableMap::COL_STATUS)) {
            $criteria->add(EmployeTableMap::COL_STATUS, $this->status);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildEmployeQuery::create();
        $criteria->add(EmployeTableMap::COL_EMPLOYE_ID, $this->employe_id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getEmployeId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getEmployeId();
    }

    /**
     * Generic method to set the primary key (employe_id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setEmployeId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getEmployeId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \App\Models\Employe (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setRefInterne($this->getRefInterne());
        $copyObj->setUniteId($this->getUniteId());
        $copyObj->setNomPrenom($this->getNomPrenom());
        $copyObj->setPoste($this->getPoste());
        $copyObj->setGenre($this->getGenre());
        $copyObj->setDateEmbauche($this->getDateEmbauche());
        $copyObj->setPresence($this->getPresence());
        $copyObj->setStatus($this->getStatus());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getAbsences() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAbsence($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getConges() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addConge($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPointages() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPointage($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getRetards() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRetard($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setEmployeId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \App\Models\Employe Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Declares an association between this object and a ChildUnite object.
     *
     * @param  ChildUnite $v
     * @return $this|\App\Models\Employe The current object (for fluent API support)
     * @throws PropelException
     */
    public function setUnite(ChildUnite $v = null)
    {
        if ($v === null) {
            $this->setUniteId(NULL);
        } else {
            $this->setUniteId($v->getUniteId());
        }

        $this->aUnite = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildUnite object, it will not be re-added.
        if ($v !== null) {
            $v->addEmploye($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildUnite object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildUnite The associated ChildUnite object.
     * @throws PropelException
     */
    public function getUnite(ConnectionInterface $con = null)
    {
        if ($this->aUnite === null && ($this->unite_id != 0)) {
            $this->aUnite = ChildUniteQuery::create()->findPk($this->unite_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aUnite->addEmployes($this);
             */
        }

        return $this->aUnite;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('Absence' === $relationName) {
            $this->initAbsences();
            return;
        }
        if ('Conge' === $relationName) {
            $this->initConges();
            return;
        }
        if ('Pointage' === $relationName) {
            $this->initPointages();
            return;
        }
        if ('Retard' === $relationName) {
            $this->initRetards();
            return;
        }
    }

    /**
     * Clears out the collAbsences collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addAbsences()
     */
    public function clearAbsences()
    {
        $this->collAbsences = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collAbsences collection loaded partially.
     */
    public function resetPartialAbsences($v = true)
    {
        $this->collAbsencesPartial = $v;
    }

    /**
     * Initializes the collAbsences collection.
     *
     * By default this just sets the collAbsences collection to an empty array (like clearcollAbsences());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAbsences($overrideExisting = true)
    {
        if (null !== $this->collAbsences && !$overrideExisting) {
            return;
        }

        $collectionClassName = AbsenceTableMap::getTableMap()->getCollectionClassName();

        $this->collAbsences = new $collectionClassName;
        $this->collAbsences->setModel('\App\Models\Absence');
    }

    /**
     * Gets an array of ChildAbsence objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildEmploye is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildAbsence[] List of ChildAbsence objects
     * @throws PropelException
     */
    public function getAbsences(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collAbsencesPartial && !$this->isNew();
        if (null === $this->collAbsences || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collAbsences) {
                    $this->initAbsences();
                } else {
                    $collectionClassName = AbsenceTableMap::getTableMap()->getCollectionClassName();

                    $collAbsences = new $collectionClassName;
                    $collAbsences->setModel('\App\Models\Absence');

                    return $collAbsences;
                }
            } else {
                $collAbsences = ChildAbsenceQuery::create(null, $criteria)
                    ->filterByEmploye($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collAbsencesPartial && count($collAbsences)) {
                        $this->initAbsences(false);

                        foreach ($collAbsences as $obj) {
                            if (false == $this->collAbsences->contains($obj)) {
                                $this->collAbsences->append($obj);
                            }
                        }

                        $this->collAbsencesPartial = true;
                    }

                    return $collAbsences;
                }

                if ($partial && $this->collAbsences) {
                    foreach ($this->collAbsences as $obj) {
                        if ($obj->isNew()) {
                            $collAbsences[] = $obj;
                        }
                    }
                }

                $this->collAbsences = $collAbsences;
                $this->collAbsencesPartial = false;
            }
        }

        return $this->collAbsences;
    }

    /**
     * Sets a collection of ChildAbsence objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $absences A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildEmploye The current object (for fluent API support)
     */
    public function setAbsences(Collection $absences, ConnectionInterface $con = null)
    {
        /** @var ChildAbsence[] $absencesToDelete */
        $absencesToDelete = $this->getAbsences(new Criteria(), $con)->diff($absences);


        $this->absencesScheduledForDeletion = $absencesToDelete;

        foreach ($absencesToDelete as $absenceRemoved) {
            $absenceRemoved->setEmploye(null);
        }

        $this->collAbsences = null;
        foreach ($absences as $absence) {
            $this->addAbsence($absence);
        }

        $this->collAbsences = $absences;
        $this->collAbsencesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Absence objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Absence objects.
     * @throws PropelException
     */
    public function countAbsences(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collAbsencesPartial && !$this->isNew();
        if (null === $this->collAbsences || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAbsences) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAbsences());
            }

            $query = ChildAbsenceQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByEmploye($this)
                ->count($con);
        }

        return count($this->collAbsences);
    }

    /**
     * Method called to associate a ChildAbsence object to this object
     * through the ChildAbsence foreign key attribute.
     *
     * @param  ChildAbsence $l ChildAbsence
     * @return $this|\App\Models\Employe The current object (for fluent API support)
     */
    public function addAbsence(ChildAbsence $l)
    {
        if ($this->collAbsences === null) {
            $this->initAbsences();
            $this->collAbsencesPartial = true;
        }

        if (!$this->collAbsences->contains($l)) {
            $this->doAddAbsence($l);

            if ($this->absencesScheduledForDeletion and $this->absencesScheduledForDeletion->contains($l)) {
                $this->absencesScheduledForDeletion->remove($this->absencesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildAbsence $absence The ChildAbsence object to add.
     */
    protected function doAddAbsence(ChildAbsence $absence)
    {
        $this->collAbsences[]= $absence;
        $absence->setEmploye($this);
    }

    /**
     * @param  ChildAbsence $absence The ChildAbsence object to remove.
     * @return $this|ChildEmploye The current object (for fluent API support)
     */
    public function removeAbsence(ChildAbsence $absence)
    {
        if ($this->getAbsences()->contains($absence)) {
            $pos = $this->collAbsences->search($absence);
            $this->collAbsences->remove($pos);
            if (null === $this->absencesScheduledForDeletion) {
                $this->absencesScheduledForDeletion = clone $this->collAbsences;
                $this->absencesScheduledForDeletion->clear();
            }
            $this->absencesScheduledForDeletion[]= clone $absence;
            $absence->setEmploye(null);
        }

        return $this;
    }

    /**
     * Clears out the collConges collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addConges()
     */
    public function clearConges()
    {
        $this->collConges = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collConges collection loaded partially.
     */
    public function resetPartialConges($v = true)
    {
        $this->collCongesPartial = $v;
    }

    /**
     * Initializes the collConges collection.
     *
     * By default this just sets the collConges collection to an empty array (like clearcollConges());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initConges($overrideExisting = true)
    {
        if (null !== $this->collConges && !$overrideExisting) {
            return;
        }

        $collectionClassName = CongeTableMap::getTableMap()->getCollectionClassName();

        $this->collConges = new $collectionClassName;
        $this->collConges->setModel('\App\Models\Conge');
    }

    /**
     * Gets an array of ChildConge objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildEmploye is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildConge[] List of ChildConge objects
     * @throws PropelException
     */
    public function getConges(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collCongesPartial && !$this->isNew();
        if (null === $this->collConges || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collConges) {
                    $this->initConges();
                } else {
                    $collectionClassName = CongeTableMap::getTableMap()->getCollectionClassName();

                    $collConges = new $collectionClassName;
                    $collConges->setModel('\App\Models\Conge');

                    return $collConges;
                }
            } else {
                $collConges = ChildCongeQuery::create(null, $criteria)
                    ->filterByEmploye($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collCongesPartial && count($collConges)) {
                        $this->initConges(false);

                        foreach ($collConges as $obj) {
                            if (false == $this->collConges->contains($obj)) {
                                $this->collConges->append($obj);
                            }
                        }

                        $this->collCongesPartial = true;
                    }

                    return $collConges;
                }

                if ($partial && $this->collConges) {
                    foreach ($this->collConges as $obj) {
                        if ($obj->isNew()) {
                            $collConges[] = $obj;
                        }
                    }
                }

                $this->collConges = $collConges;
                $this->collCongesPartial = false;
            }
        }

        return $this->collConges;
    }

    /**
     * Sets a collection of ChildConge objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $conges A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildEmploye The current object (for fluent API support)
     */
    public function setConges(Collection $conges, ConnectionInterface $con = null)
    {
        /** @var ChildConge[] $congesToDelete */
        $congesToDelete = $this->getConges(new Criteria(), $con)->diff($conges);


        $this->congesScheduledForDeletion = $congesToDelete;

        foreach ($congesToDelete as $congeRemoved) {
            $congeRemoved->setEmploye(null);
        }

        $this->collConges = null;
        foreach ($conges as $conge) {
            $this->addConge($conge);
        }

        $this->collConges = $conges;
        $this->collCongesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Conge objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Conge objects.
     * @throws PropelException
     */
    public function countConges(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collCongesPartial && !$this->isNew();
        if (null === $this->collConges || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collConges) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getConges());
            }

            $query = ChildCongeQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByEmploye($this)
                ->count($con);
        }

        return count($this->collConges);
    }

    /**
     * Method called to associate a ChildConge object to this object
     * through the ChildConge foreign key attribute.
     *
     * @param  ChildConge $l ChildConge
     * @return $this|\App\Models\Employe The current object (for fluent API support)
     */
    public function addConge(ChildConge $l)
    {
        if ($this->collConges === null) {
            $this->initConges();
            $this->collCongesPartial = true;
        }

        if (!$this->collConges->contains($l)) {
            $this->doAddConge($l);

            if ($this->congesScheduledForDeletion and $this->congesScheduledForDeletion->contains($l)) {
                $this->congesScheduledForDeletion->remove($this->congesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildConge $conge The ChildConge object to add.
     */
    protected function doAddConge(ChildConge $conge)
    {
        $this->collConges[]= $conge;
        $conge->setEmploye($this);
    }

    /**
     * @param  ChildConge $conge The ChildConge object to remove.
     * @return $this|ChildEmploye The current object (for fluent API support)
     */
    public function removeConge(ChildConge $conge)
    {
        if ($this->getConges()->contains($conge)) {
            $pos = $this->collConges->search($conge);
            $this->collConges->remove($pos);
            if (null === $this->congesScheduledForDeletion) {
                $this->congesScheduledForDeletion = clone $this->collConges;
                $this->congesScheduledForDeletion->clear();
            }
            $this->congesScheduledForDeletion[]= clone $conge;
            $conge->setEmploye(null);
        }

        return $this;
    }

    /**
     * Clears out the collPointages collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPointages()
     */
    public function clearPointages()
    {
        $this->collPointages = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPointages collection loaded partially.
     */
    public function resetPartialPointages($v = true)
    {
        $this->collPointagesPartial = $v;
    }

    /**
     * Initializes the collPointages collection.
     *
     * By default this just sets the collPointages collection to an empty array (like clearcollPointages());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPointages($overrideExisting = true)
    {
        if (null !== $this->collPointages && !$overrideExisting) {
            return;
        }

        $collectionClassName = PointageTableMap::getTableMap()->getCollectionClassName();

        $this->collPointages = new $collectionClassName;
        $this->collPointages->setModel('\App\Models\Pointage');
    }

    /**
     * Gets an array of ChildPointage objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildEmploye is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPointage[] List of ChildPointage objects
     * @throws PropelException
     */
    public function getPointages(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPointagesPartial && !$this->isNew();
        if (null === $this->collPointages || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collPointages) {
                    $this->initPointages();
                } else {
                    $collectionClassName = PointageTableMap::getTableMap()->getCollectionClassName();

                    $collPointages = new $collectionClassName;
                    $collPointages->setModel('\App\Models\Pointage');

                    return $collPointages;
                }
            } else {
                $collPointages = ChildPointageQuery::create(null, $criteria)
                    ->filterByEmploye($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPointagesPartial && count($collPointages)) {
                        $this->initPointages(false);

                        foreach ($collPointages as $obj) {
                            if (false == $this->collPointages->contains($obj)) {
                                $this->collPointages->append($obj);
                            }
                        }

                        $this->collPointagesPartial = true;
                    }

                    return $collPointages;
                }

                if ($partial && $this->collPointages) {
                    foreach ($this->collPointages as $obj) {
                        if ($obj->isNew()) {
                            $collPointages[] = $obj;
                        }
                    }
                }

                $this->collPointages = $collPointages;
                $this->collPointagesPartial = false;
            }
        }

        return $this->collPointages;
    }

    /**
     * Sets a collection of ChildPointage objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $pointages A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildEmploye The current object (for fluent API support)
     */
    public function setPointages(Collection $pointages, ConnectionInterface $con = null)
    {
        /** @var ChildPointage[] $pointagesToDelete */
        $pointagesToDelete = $this->getPointages(new Criteria(), $con)->diff($pointages);


        $this->pointagesScheduledForDeletion = $pointagesToDelete;

        foreach ($pointagesToDelete as $pointageRemoved) {
            $pointageRemoved->setEmploye(null);
        }

        $this->collPointages = null;
        foreach ($pointages as $pointage) {
            $this->addPointage($pointage);
        }

        $this->collPointages = $pointages;
        $this->collPointagesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Pointage objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Pointage objects.
     * @throws PropelException
     */
    public function countPointages(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPointagesPartial && !$this->isNew();
        if (null === $this->collPointages || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPointages) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPointages());
            }

            $query = ChildPointageQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByEmploye($this)
                ->count($con);
        }

        return count($this->collPointages);
    }

    /**
     * Method called to associate a ChildPointage object to this object
     * through the ChildPointage foreign key attribute.
     *
     * @param  ChildPointage $l ChildPointage
     * @return $this|\App\Models\Employe The current object (for fluent API support)
     */
    public function addPointage(ChildPointage $l)
    {
        if ($this->collPointages === null) {
            $this->initPointages();
            $this->collPointagesPartial = true;
        }

        if (!$this->collPointages->contains($l)) {
            $this->doAddPointage($l);

            if ($this->pointagesScheduledForDeletion and $this->pointagesScheduledForDeletion->contains($l)) {
                $this->pointagesScheduledForDeletion->remove($this->pointagesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildPointage $pointage The ChildPointage object to add.
     */
    protected function doAddPointage(ChildPointage $pointage)
    {
        $this->collPointages[]= $pointage;
        $pointage->setEmploye($this);
    }

    /**
     * @param  ChildPointage $pointage The ChildPointage object to remove.
     * @return $this|ChildEmploye The current object (for fluent API support)
     */
    public function removePointage(ChildPointage $pointage)
    {
        if ($this->getPointages()->contains($pointage)) {
            $pos = $this->collPointages->search($pointage);
            $this->collPointages->remove($pos);
            if (null === $this->pointagesScheduledForDeletion) {
                $this->pointagesScheduledForDeletion = clone $this->collPointages;
                $this->pointagesScheduledForDeletion->clear();
            }
            $this->pointagesScheduledForDeletion[]= clone $pointage;
            $pointage->setEmploye(null);
        }

        return $this;
    }

    /**
     * Clears out the collRetards collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRetards()
     */
    public function clearRetards()
    {
        $this->collRetards = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collRetards collection loaded partially.
     */
    public function resetPartialRetards($v = true)
    {
        $this->collRetardsPartial = $v;
    }

    /**
     * Initializes the collRetards collection.
     *
     * By default this just sets the collRetards collection to an empty array (like clearcollRetards());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRetards($overrideExisting = true)
    {
        if (null !== $this->collRetards && !$overrideExisting) {
            return;
        }

        $collectionClassName = RetardTableMap::getTableMap()->getCollectionClassName();

        $this->collRetards = new $collectionClassName;
        $this->collRetards->setModel('\App\Models\Retard');
    }

    /**
     * Gets an array of ChildRetard objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildEmploye is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildRetard[] List of ChildRetard objects
     * @throws PropelException
     */
    public function getRetards(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRetardsPartial && !$this->isNew();
        if (null === $this->collRetards || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collRetards) {
                    $this->initRetards();
                } else {
                    $collectionClassName = RetardTableMap::getTableMap()->getCollectionClassName();

                    $collRetards = new $collectionClassName;
                    $collRetards->setModel('\App\Models\Retard');

                    return $collRetards;
                }
            } else {
                $collRetards = ChildRetardQuery::create(null, $criteria)
                    ->filterByEmploye($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collRetardsPartial && count($collRetards)) {
                        $this->initRetards(false);

                        foreach ($collRetards as $obj) {
                            if (false == $this->collRetards->contains($obj)) {
                                $this->collRetards->append($obj);
                            }
                        }

                        $this->collRetardsPartial = true;
                    }

                    return $collRetards;
                }

                if ($partial && $this->collRetards) {
                    foreach ($this->collRetards as $obj) {
                        if ($obj->isNew()) {
                            $collRetards[] = $obj;
                        }
                    }
                }

                $this->collRetards = $collRetards;
                $this->collRetardsPartial = false;
            }
        }

        return $this->collRetards;
    }

    /**
     * Sets a collection of ChildRetard objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $retards A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildEmploye The current object (for fluent API support)
     */
    public function setRetards(Collection $retards, ConnectionInterface $con = null)
    {
        /** @var ChildRetard[] $retardsToDelete */
        $retardsToDelete = $this->getRetards(new Criteria(), $con)->diff($retards);


        $this->retardsScheduledForDeletion = $retardsToDelete;

        foreach ($retardsToDelete as $retardRemoved) {
            $retardRemoved->setEmploye(null);
        }

        $this->collRetards = null;
        foreach ($retards as $retard) {
            $this->addRetard($retard);
        }

        $this->collRetards = $retards;
        $this->collRetardsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Retard objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Retard objects.
     * @throws PropelException
     */
    public function countRetards(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRetardsPartial && !$this->isNew();
        if (null === $this->collRetards || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRetards) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRetards());
            }

            $query = ChildRetardQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByEmploye($this)
                ->count($con);
        }

        return count($this->collRetards);
    }

    /**
     * Method called to associate a ChildRetard object to this object
     * through the ChildRetard foreign key attribute.
     *
     * @param  ChildRetard $l ChildRetard
     * @return $this|\App\Models\Employe The current object (for fluent API support)
     */
    public function addRetard(ChildRetard $l)
    {
        if ($this->collRetards === null) {
            $this->initRetards();
            $this->collRetardsPartial = true;
        }

        if (!$this->collRetards->contains($l)) {
            $this->doAddRetard($l);

            if ($this->retardsScheduledForDeletion and $this->retardsScheduledForDeletion->contains($l)) {
                $this->retardsScheduledForDeletion->remove($this->retardsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildRetard $retard The ChildRetard object to add.
     */
    protected function doAddRetard(ChildRetard $retard)
    {
        $this->collRetards[]= $retard;
        $retard->setEmploye($this);
    }

    /**
     * @param  ChildRetard $retard The ChildRetard object to remove.
     * @return $this|ChildEmploye The current object (for fluent API support)
     */
    public function removeRetard(ChildRetard $retard)
    {
        if ($this->getRetards()->contains($retard)) {
            $pos = $this->collRetards->search($retard);
            $this->collRetards->remove($pos);
            if (null === $this->retardsScheduledForDeletion) {
                $this->retardsScheduledForDeletion = clone $this->collRetards;
                $this->retardsScheduledForDeletion->clear();
            }
            $this->retardsScheduledForDeletion[]= clone $retard;
            $retard->setEmploye(null);
        }

        return $this;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aUnite) {
            $this->aUnite->removeEmploye($this);
        }
        $this->employe_id = null;
        $this->ref_interne = null;
        $this->unite_id = null;
        $this->nom_prenom = null;
        $this->poste = null;
        $this->genre = null;
        $this->date_embauche = null;
        $this->presence = null;
        $this->status = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collAbsences) {
                foreach ($this->collAbsences as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collConges) {
                foreach ($this->collConges as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPointages) {
                foreach ($this->collPointages as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRetards) {
                foreach ($this->collRetards as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collAbsences = null;
        $this->collConges = null;
        $this->collPointages = null;
        $this->collRetards = null;
        $this->aUnite = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(EmployeTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
                return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {
            }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
                return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {
            }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
                return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {
            }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
                return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {
            }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
