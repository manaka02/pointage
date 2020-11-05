<?php

namespace App\Models\Base;

use \DateTime;
use \Exception;
use \PDO;
use App\Models\Employe as ChildEmploye;
use App\Models\EmployeQuery as ChildEmployeQuery;
use App\Models\HeureSupQuery as ChildHeureSupQuery;
use App\Models\Map\HeureSupTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'heure_sup' table.
 *
 *
 *
 * @package    propel.generator..Base
 */
abstract class HeureSup implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\App\\Models\\Map\\HeureSupTableMap';


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
     * The value for the heure_sup_id field.
     *
     * @var        int
     */
    protected $heure_sup_id;

    /**
     * The value for the employe_id field.
     *
     * @var        int
     */
    protected $employe_id;

    /**
     * The value for the date_heure_sup field.
     *
     * @var        DateTime
     */
    protected $date_heure_sup;

    /**
     * The value for the heure_entree field.
     *
     * @var        DateTime
     */
    protected $heure_entree;

    /**
     * The value for the heure_sortie field.
     *
     * @var        DateTime
     */
    protected $heure_sortie;

    /**
     * The value for the heure_travail field.
     *
     * @var        DateTime
     */
    protected $heure_travail;

    /**
     * The value for the heure_supp field.
     *
     * @var        DateTime
     */
    protected $heure_supp;

    /**
     * The value for the heure_sup_normal field.
     *
     * @var        DateTime
     */
    protected $heure_sup_normal;

    /**
     * The value for the heure_sup_extra field.
     *
     * @var        DateTime
     */
    protected $heure_sup_extra;

    /**
     * The value for the heure_sup_samedi field.
     *
     * @var        DateTime
     */
    protected $heure_sup_samedi;

    /**
     * @var        ChildEmploye
     */
    protected $aEmploye;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * Initializes internal state of App\Models\Base\HeureSup object.
     */
    public function __construct()
    {
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
     * Compares this with another <code>HeureSup</code> instance.  If
     * <code>obj</code> is an instance of <code>HeureSup</code>, delegates to
     * <code>equals(HeureSup)</code>.  Otherwise, returns <code>false</code>.
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
     * Get the [heure_sup_id] column value.
     *
     * @return int
     */
    public function getHeureSupId()
    {
        return $this->heure_sup_id;
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
     * Get the [optionally formatted] temporal [date_heure_sup] column value.
     *
     *
     * @param      string|null $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDateHeureSup($format = NULL)
    {
        if ($format === null) {
            return $this->date_heure_sup;
        } else {
            return $this->date_heure_sup instanceof \DateTimeInterface ? $this->date_heure_sup->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [heure_entree] column value.
     *
     *
     * @param      string|null $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getHeureEntree($format = NULL)
    {
        if ($format === null) {
            return $this->heure_entree;
        } else {
            return $this->heure_entree instanceof \DateTimeInterface ? $this->heure_entree->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [heure_sortie] column value.
     *
     *
     * @param      string|null $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getHeureSortie($format = NULL)
    {
        if ($format === null) {
            return $this->heure_sortie;
        } else {
            return $this->heure_sortie instanceof \DateTimeInterface ? $this->heure_sortie->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [heure_travail] column value.
     *
     *
     * @param      string|null $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getHeureTravail($format = NULL)
    {
        if ($format === null) {
            return $this->heure_travail;
        } else {
            return $this->heure_travail instanceof \DateTimeInterface ? $this->heure_travail->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [heure_supp] column value.
     *
     *
     * @param      string|null $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getHeureSupp($format = NULL)
    {
        if ($format === null) {
            return $this->heure_supp;
        } else {
            return $this->heure_supp instanceof \DateTimeInterface ? $this->heure_supp->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [heure_sup_normal] column value.
     *
     *
     * @param      string|null $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getHeureSupNormal($format = NULL)
    {
        if ($format === null) {
            return $this->heure_sup_normal;
        } else {
            return $this->heure_sup_normal instanceof \DateTimeInterface ? $this->heure_sup_normal->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [heure_sup_extra] column value.
     *
     *
     * @param      string|null $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getHeureSupExtra($format = NULL)
    {
        if ($format === null) {
            return $this->heure_sup_extra;
        } else {
            return $this->heure_sup_extra instanceof \DateTimeInterface ? $this->heure_sup_extra->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [heure_sup_samedi] column value.
     *
     *
     * @param      string|null $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getHeureSupSamedi($format = NULL)
    {
        if ($format === null) {
            return $this->heure_sup_samedi;
        } else {
            return $this->heure_sup_samedi instanceof \DateTimeInterface ? $this->heure_sup_samedi->format($format) : null;
        }
    }

    /**
     * Set the value of [heure_sup_id] column.
     *
     * @param int $v New value
     * @return $this|\App\Models\HeureSup The current object (for fluent API support)
     */
    public function setHeureSupId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->heure_sup_id !== $v) {
            $this->heure_sup_id = $v;
            $this->modifiedColumns[HeureSupTableMap::COL_HEURE_SUP_ID] = true;
        }

        return $this;
    } // setHeureSupId()

    /**
     * Set the value of [employe_id] column.
     *
     * @param int $v New value
     * @return $this|\App\Models\HeureSup The current object (for fluent API support)
     */
    public function setEmployeId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->employe_id !== $v) {
            $this->employe_id = $v;
            $this->modifiedColumns[HeureSupTableMap::COL_EMPLOYE_ID] = true;
        }

        if ($this->aEmploye !== null && $this->aEmploye->getEmployeId() !== $v) {
            $this->aEmploye = null;
        }

        return $this;
    } // setEmployeId()

    /**
     * Sets the value of [date_heure_sup] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\App\Models\HeureSup The current object (for fluent API support)
     */
    public function setDateHeureSup($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->date_heure_sup !== null || $dt !== null) {
            if ($this->date_heure_sup === null || $dt === null || $dt->format("Y-m-d") !== $this->date_heure_sup->format("Y-m-d")) {
                $this->date_heure_sup = $dt === null ? null : clone $dt;
                $this->modifiedColumns[HeureSupTableMap::COL_DATE_HEURE_SUP] = true;
            }
        } // if either are not null

        return $this;
    } // setDateHeureSup()

    /**
     * Sets the value of [heure_entree] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\App\Models\HeureSup The current object (for fluent API support)
     */
    public function setHeureEntree($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->heure_entree !== null || $dt !== null) {
            if ($this->heure_entree === null || $dt === null || $dt->format("H:i:s.u") !== $this->heure_entree->format("H:i:s.u")) {
                $this->heure_entree = $dt === null ? null : clone $dt;
                $this->modifiedColumns[HeureSupTableMap::COL_HEURE_ENTREE] = true;
            }
        } // if either are not null

        return $this;
    } // setHeureEntree()

    /**
     * Sets the value of [heure_sortie] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\App\Models\HeureSup The current object (for fluent API support)
     */
    public function setHeureSortie($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->heure_sortie !== null || $dt !== null) {
            if ($this->heure_sortie === null || $dt === null || $dt->format("H:i:s.u") !== $this->heure_sortie->format("H:i:s.u")) {
                $this->heure_sortie = $dt === null ? null : clone $dt;
                $this->modifiedColumns[HeureSupTableMap::COL_HEURE_SORTIE] = true;
            }
        } // if either are not null

        return $this;
    } // setHeureSortie()

    /**
     * Sets the value of [heure_travail] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\App\Models\HeureSup The current object (for fluent API support)
     */
    public function setHeureTravail($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->heure_travail !== null || $dt !== null) {
            if ($this->heure_travail === null || $dt === null || $dt->format("H:i:s.u") !== $this->heure_travail->format("H:i:s.u")) {
                $this->heure_travail = $dt === null ? null : clone $dt;
                $this->modifiedColumns[HeureSupTableMap::COL_HEURE_TRAVAIL] = true;
            }
        } // if either are not null

        return $this;
    } // setHeureTravail()

    /**
     * Sets the value of [heure_supp] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\App\Models\HeureSup The current object (for fluent API support)
     */
    public function setHeureSupp($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->heure_supp !== null || $dt !== null) {
            if ($this->heure_supp === null || $dt === null || $dt->format("H:i:s.u") !== $this->heure_supp->format("H:i:s.u")) {
                $this->heure_supp = $dt === null ? null : clone $dt;
                $this->modifiedColumns[HeureSupTableMap::COL_HEURE_SUPP] = true;
            }
        } // if either are not null

        return $this;
    } // setHeureSupp()

    /**
     * Sets the value of [heure_sup_normal] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\App\Models\HeureSup The current object (for fluent API support)
     */
    public function setHeureSupNormal($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->heure_sup_normal !== null || $dt !== null) {
            if ($this->heure_sup_normal === null || $dt === null || $dt->format("H:i:s.u") !== $this->heure_sup_normal->format("H:i:s.u")) {
                $this->heure_sup_normal = $dt === null ? null : clone $dt;
                $this->modifiedColumns[HeureSupTableMap::COL_HEURE_SUP_NORMAL] = true;
            }
        } // if either are not null

        return $this;
    } // setHeureSupNormal()

    /**
     * Sets the value of [heure_sup_extra] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\App\Models\HeureSup The current object (for fluent API support)
     */
    public function setHeureSupExtra($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->heure_sup_extra !== null || $dt !== null) {
            if ($this->heure_sup_extra === null || $dt === null || $dt->format("H:i:s.u") !== $this->heure_sup_extra->format("H:i:s.u")) {
                $this->heure_sup_extra = $dt === null ? null : clone $dt;
                $this->modifiedColumns[HeureSupTableMap::COL_HEURE_SUP_EXTRA] = true;
            }
        } // if either are not null

        return $this;
    } // setHeureSupExtra()

    /**
     * Sets the value of [heure_sup_samedi] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\App\Models\HeureSup The current object (for fluent API support)
     */
    public function setHeureSupSamedi($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->heure_sup_samedi !== null || $dt !== null) {
            if ($this->heure_sup_samedi === null || $dt === null || $dt->format("H:i:s.u") !== $this->heure_sup_samedi->format("H:i:s.u")) {
                $this->heure_sup_samedi = $dt === null ? null : clone $dt;
                $this->modifiedColumns[HeureSupTableMap::COL_HEURE_SUP_SAMEDI] = true;
            }
        } // if either are not null

        return $this;
    } // setHeureSupSamedi()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : HeureSupTableMap::translateFieldName('HeureSupId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->heure_sup_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : HeureSupTableMap::translateFieldName('EmployeId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->employe_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : HeureSupTableMap::translateFieldName('DateHeureSup', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00') {
                $col = null;
            }
            $this->date_heure_sup = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : HeureSupTableMap::translateFieldName('HeureEntree', TableMap::TYPE_PHPNAME, $indexType)];
            $this->heure_entree = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : HeureSupTableMap::translateFieldName('HeureSortie', TableMap::TYPE_PHPNAME, $indexType)];
            $this->heure_sortie = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : HeureSupTableMap::translateFieldName('HeureTravail', TableMap::TYPE_PHPNAME, $indexType)];
            $this->heure_travail = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : HeureSupTableMap::translateFieldName('HeureSupp', TableMap::TYPE_PHPNAME, $indexType)];
            $this->heure_supp = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : HeureSupTableMap::translateFieldName('HeureSupNormal', TableMap::TYPE_PHPNAME, $indexType)];
            $this->heure_sup_normal = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : HeureSupTableMap::translateFieldName('HeureSupExtra', TableMap::TYPE_PHPNAME, $indexType)];
            $this->heure_sup_extra = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : HeureSupTableMap::translateFieldName('HeureSupSamedi', TableMap::TYPE_PHPNAME, $indexType)];
            $this->heure_sup_samedi = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 10; // 10 = HeureSupTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\App\\Models\\HeureSup'), 0, $e);
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
        if ($this->aEmploye !== null && $this->employe_id !== $this->aEmploye->getEmployeId()) {
            $this->aEmploye = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(HeureSupTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildHeureSupQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aEmploye = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see HeureSup::setDeleted()
     * @see HeureSup::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(HeureSupTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildHeureSupQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(HeureSupTableMap::DATABASE_NAME);
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
                HeureSupTableMap::addInstanceToPool($this);
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

            if ($this->aEmploye !== null) {
                if ($this->aEmploye->isModified() || $this->aEmploye->isNew()) {
                    $affectedRows += $this->aEmploye->save($con);
                }
                $this->setEmploye($this->aEmploye);
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

        $this->modifiedColumns[HeureSupTableMap::COL_HEURE_SUP_ID] = true;
        if (null !== $this->heure_sup_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . HeureSupTableMap::COL_HEURE_SUP_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(HeureSupTableMap::COL_HEURE_SUP_ID)) {
            $modifiedColumns[':p' . $index++]  = 'heure_sup_id';
        }
        if ($this->isColumnModified(HeureSupTableMap::COL_EMPLOYE_ID)) {
            $modifiedColumns[':p' . $index++]  = 'employe_id';
        }
        if ($this->isColumnModified(HeureSupTableMap::COL_DATE_HEURE_SUP)) {
            $modifiedColumns[':p' . $index++]  = 'date_heure_sup';
        }
        if ($this->isColumnModified(HeureSupTableMap::COL_HEURE_ENTREE)) {
            $modifiedColumns[':p' . $index++]  = 'heure_entree';
        }
        if ($this->isColumnModified(HeureSupTableMap::COL_HEURE_SORTIE)) {
            $modifiedColumns[':p' . $index++]  = 'heure_sortie';
        }
        if ($this->isColumnModified(HeureSupTableMap::COL_HEURE_TRAVAIL)) {
            $modifiedColumns[':p' . $index++]  = 'heure_travail';
        }
        if ($this->isColumnModified(HeureSupTableMap::COL_HEURE_SUPP)) {
            $modifiedColumns[':p' . $index++]  = 'heure_supp';
        }
        if ($this->isColumnModified(HeureSupTableMap::COL_HEURE_SUP_NORMAL)) {
            $modifiedColumns[':p' . $index++]  = 'heure_sup_normal';
        }
        if ($this->isColumnModified(HeureSupTableMap::COL_HEURE_SUP_EXTRA)) {
            $modifiedColumns[':p' . $index++]  = 'heure_sup_extra';
        }
        if ($this->isColumnModified(HeureSupTableMap::COL_HEURE_SUP_SAMEDI)) {
            $modifiedColumns[':p' . $index++]  = 'heure_sup_samedi';
        }

        $sql = sprintf(
            'INSERT INTO heure_sup (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'heure_sup_id':
                        $stmt->bindValue($identifier, $this->heure_sup_id, PDO::PARAM_INT);
                        break;
                    case 'employe_id':
                        $stmt->bindValue($identifier, $this->employe_id, PDO::PARAM_INT);
                        break;
                    case 'date_heure_sup':
                        $stmt->bindValue($identifier, $this->date_heure_sup ? $this->date_heure_sup->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'heure_entree':
                        $stmt->bindValue($identifier, $this->heure_entree ? $this->heure_entree->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'heure_sortie':
                        $stmt->bindValue($identifier, $this->heure_sortie ? $this->heure_sortie->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'heure_travail':
                        $stmt->bindValue($identifier, $this->heure_travail ? $this->heure_travail->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'heure_supp':
                        $stmt->bindValue($identifier, $this->heure_supp ? $this->heure_supp->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'heure_sup_normal':
                        $stmt->bindValue($identifier, $this->heure_sup_normal ? $this->heure_sup_normal->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'heure_sup_extra':
                        $stmt->bindValue($identifier, $this->heure_sup_extra ? $this->heure_sup_extra->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'heure_sup_samedi':
                        $stmt->bindValue($identifier, $this->heure_sup_samedi ? $this->heure_sup_samedi->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
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
        $this->setHeureSupId($pk);

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
        $pos = HeureSupTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getHeureSupId();
                break;
            case 1:
                return $this->getEmployeId();
                break;
            case 2:
                return $this->getDateHeureSup();
                break;
            case 3:
                return $this->getHeureEntree();
                break;
            case 4:
                return $this->getHeureSortie();
                break;
            case 5:
                return $this->getHeureTravail();
                break;
            case 6:
                return $this->getHeureSupp();
                break;
            case 7:
                return $this->getHeureSupNormal();
                break;
            case 8:
                return $this->getHeureSupExtra();
                break;
            case 9:
                return $this->getHeureSupSamedi();
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

        if (isset($alreadyDumpedObjects['HeureSup'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['HeureSup'][$this->hashCode()] = true;
        $keys = HeureSupTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getHeureSupId(),
            $keys[1] => $this->getEmployeId(),
            $keys[2] => $this->getDateHeureSup(),
            $keys[3] => $this->getHeureEntree(),
            $keys[4] => $this->getHeureSortie(),
            $keys[5] => $this->getHeureTravail(),
            $keys[6] => $this->getHeureSupp(),
            $keys[7] => $this->getHeureSupNormal(),
            $keys[8] => $this->getHeureSupExtra(),
            $keys[9] => $this->getHeureSupSamedi(),
        );
        if ($result[$keys[2]] instanceof \DateTimeInterface) {
            $result[$keys[2]] = $result[$keys[2]]->format('c');
        }

        if ($result[$keys[3]] instanceof \DateTimeInterface) {
            $result[$keys[3]] = $result[$keys[3]]->format('c');
        }

        if ($result[$keys[4]] instanceof \DateTimeInterface) {
            $result[$keys[4]] = $result[$keys[4]]->format('c');
        }

        if ($result[$keys[5]] instanceof \DateTimeInterface) {
            $result[$keys[5]] = $result[$keys[5]]->format('c');
        }

        if ($result[$keys[6]] instanceof \DateTimeInterface) {
            $result[$keys[6]] = $result[$keys[6]]->format('c');
        }

        if ($result[$keys[7]] instanceof \DateTimeInterface) {
            $result[$keys[7]] = $result[$keys[7]]->format('c');
        }

        if ($result[$keys[8]] instanceof \DateTimeInterface) {
            $result[$keys[8]] = $result[$keys[8]]->format('c');
        }

        if ($result[$keys[9]] instanceof \DateTimeInterface) {
            $result[$keys[9]] = $result[$keys[9]]->format('c');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aEmploye) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'employe';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'employe';
                        break;
                    default:
                        $key = 'Employe';
                }

                $result[$key] = $this->aEmploye->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
     * @return $this|\App\Models\HeureSup
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = HeureSupTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\App\Models\HeureSup
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setHeureSupId($value);
                break;
            case 1:
                $this->setEmployeId($value);
                break;
            case 2:
                $this->setDateHeureSup($value);
                break;
            case 3:
                $this->setHeureEntree($value);
                break;
            case 4:
                $this->setHeureSortie($value);
                break;
            case 5:
                $this->setHeureTravail($value);
                break;
            case 6:
                $this->setHeureSupp($value);
                break;
            case 7:
                $this->setHeureSupNormal($value);
                break;
            case 8:
                $this->setHeureSupExtra($value);
                break;
            case 9:
                $this->setHeureSupSamedi($value);
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
        $keys = HeureSupTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setHeureSupId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setEmployeId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setDateHeureSup($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setHeureEntree($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setHeureSortie($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setHeureTravail($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setHeureSupp($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setHeureSupNormal($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setHeureSupExtra($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setHeureSupSamedi($arr[$keys[9]]);
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
     * @return $this|\App\Models\HeureSup The current object, for fluid interface
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
        $criteria = new Criteria(HeureSupTableMap::DATABASE_NAME);

        if ($this->isColumnModified(HeureSupTableMap::COL_HEURE_SUP_ID)) {
            $criteria->add(HeureSupTableMap::COL_HEURE_SUP_ID, $this->heure_sup_id);
        }
        if ($this->isColumnModified(HeureSupTableMap::COL_EMPLOYE_ID)) {
            $criteria->add(HeureSupTableMap::COL_EMPLOYE_ID, $this->employe_id);
        }
        if ($this->isColumnModified(HeureSupTableMap::COL_DATE_HEURE_SUP)) {
            $criteria->add(HeureSupTableMap::COL_DATE_HEURE_SUP, $this->date_heure_sup);
        }
        if ($this->isColumnModified(HeureSupTableMap::COL_HEURE_ENTREE)) {
            $criteria->add(HeureSupTableMap::COL_HEURE_ENTREE, $this->heure_entree);
        }
        if ($this->isColumnModified(HeureSupTableMap::COL_HEURE_SORTIE)) {
            $criteria->add(HeureSupTableMap::COL_HEURE_SORTIE, $this->heure_sortie);
        }
        if ($this->isColumnModified(HeureSupTableMap::COL_HEURE_TRAVAIL)) {
            $criteria->add(HeureSupTableMap::COL_HEURE_TRAVAIL, $this->heure_travail);
        }
        if ($this->isColumnModified(HeureSupTableMap::COL_HEURE_SUPP)) {
            $criteria->add(HeureSupTableMap::COL_HEURE_SUPP, $this->heure_supp);
        }
        if ($this->isColumnModified(HeureSupTableMap::COL_HEURE_SUP_NORMAL)) {
            $criteria->add(HeureSupTableMap::COL_HEURE_SUP_NORMAL, $this->heure_sup_normal);
        }
        if ($this->isColumnModified(HeureSupTableMap::COL_HEURE_SUP_EXTRA)) {
            $criteria->add(HeureSupTableMap::COL_HEURE_SUP_EXTRA, $this->heure_sup_extra);
        }
        if ($this->isColumnModified(HeureSupTableMap::COL_HEURE_SUP_SAMEDI)) {
            $criteria->add(HeureSupTableMap::COL_HEURE_SUP_SAMEDI, $this->heure_sup_samedi);
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
        $criteria = ChildHeureSupQuery::create();
        $criteria->add(HeureSupTableMap::COL_HEURE_SUP_ID, $this->heure_sup_id);

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
        $validPk = null !== $this->getHeureSupId();

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
        return $this->getHeureSupId();
    }

    /**
     * Generic method to set the primary key (heure_sup_id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setHeureSupId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getHeureSupId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \App\Models\HeureSup (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setEmployeId($this->getEmployeId());
        $copyObj->setDateHeureSup($this->getDateHeureSup());
        $copyObj->setHeureEntree($this->getHeureEntree());
        $copyObj->setHeureSortie($this->getHeureSortie());
        $copyObj->setHeureTravail($this->getHeureTravail());
        $copyObj->setHeureSupp($this->getHeureSupp());
        $copyObj->setHeureSupNormal($this->getHeureSupNormal());
        $copyObj->setHeureSupExtra($this->getHeureSupExtra());
        $copyObj->setHeureSupSamedi($this->getHeureSupSamedi());
        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setHeureSupId(NULL); // this is a auto-increment column, so set to default value
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
     * @return \App\Models\HeureSup Clone of current object.
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
     * Declares an association between this object and a ChildEmploye object.
     *
     * @param  ChildEmploye $v
     * @return $this|\App\Models\HeureSup The current object (for fluent API support)
     * @throws PropelException
     */
    public function setEmploye(ChildEmploye $v = null)
    {
        if ($v === null) {
            $this->setEmployeId(NULL);
        } else {
            $this->setEmployeId($v->getEmployeId());
        }

        $this->aEmploye = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildEmploye object, it will not be re-added.
        if ($v !== null) {
            $v->addHeureSup($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildEmploye object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildEmploye The associated ChildEmploye object.
     * @throws PropelException
     */
    public function getEmploye(ConnectionInterface $con = null)
    {
        if ($this->aEmploye === null && ($this->employe_id != 0)) {
            $this->aEmploye = ChildEmployeQuery::create()->findPk($this->employe_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aEmploye->addHeureSups($this);
             */
        }

        return $this->aEmploye;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aEmploye) {
            $this->aEmploye->removeHeureSup($this);
        }
        $this->heure_sup_id = null;
        $this->employe_id = null;
        $this->date_heure_sup = null;
        $this->heure_entree = null;
        $this->heure_sortie = null;
        $this->heure_travail = null;
        $this->heure_supp = null;
        $this->heure_sup_normal = null;
        $this->heure_sup_extra = null;
        $this->heure_sup_samedi = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
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
        } // if ($deep)

        $this->aEmploye = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(HeureSupTableMap::DEFAULT_STRING_FORMAT);
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
