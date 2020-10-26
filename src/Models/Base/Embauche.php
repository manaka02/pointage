<?php

namespace App\Models\Base;

use \DateTime;
use \Exception;
use \PDO;
use App\Models\Departement as ChildDepartement;
use App\Models\DepartementQuery as ChildDepartementQuery;
use App\Models\EmbaucheQuery as ChildEmbaucheQuery;
use App\Models\Map\EmbaucheTableMap;
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
 * Base class that represents a row from the 'embauche' table.
 *
 *
 *
 * @package    propel.generator..Base
 */
abstract class Embauche implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\App\\Models\\Map\\EmbaucheTableMap';


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
     * The value for the embauche_id field.
     *
     * @var        int
     */
    protected $embauche_id;

    /**
     * The value for the civilite field.
     *
     * @var        string
     */
    protected $civilite;

    /**
     * The value for the ref_interne field.
     *
     * @var        string
     */
    protected $ref_interne;

    /**
     * The value for the nom_prenom field.
     *
     * @var        string
     */
    protected $nom_prenom;

    /**
     * The value for the photo_link field.
     *
     * @var        string
     */
    protected $photo_link;

    /**
     * The value for the fonction field.
     *
     * @var        string
     */
    protected $fonction;

    /**
     * The value for the departement_id field.
     *
     * @var        int
     */
    protected $departement_id;

    /**
     * The value for the date_debut field.
     *
     * @var        DateTime
     */
    protected $date_debut;

    /**
     * The value for the date_fin field.
     *
     * @var        DateTime
     */
    protected $date_fin;

    /**
     * The value for the status field.
     *
     * Note: this column has a database default value of: 1
     * @var        int
     */
    protected $status;

    /**
     * @var        ChildDepartement
     */
    protected $aDepartement;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->status = 1;
    }

    /**
     * Initializes internal state of App\Models\Base\Embauche object.
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
     * Compares this with another <code>Embauche</code> instance.  If
     * <code>obj</code> is an instance of <code>Embauche</code>, delegates to
     * <code>equals(Embauche)</code>.  Otherwise, returns <code>false</code>.
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
     * Get the [embauche_id] column value.
     *
     * @return int
     */
    public function getEmbaucheId()
    {
        return $this->embauche_id;
    }

    /**
     * Get the [civilite] column value.
     *
     * @return string
     */
    public function getCivilite()
    {
        return $this->civilite;
    }

    /**
     * Get the [ref_interne] column value.
     *
     * @return string
     */
    public function getRefInterne()
    {
        return $this->ref_interne;
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
     * Get the [photo_link] column value.
     *
     * @return string
     */
    public function getPhotoLink()
    {
        return $this->photo_link;
    }

    /**
     * Get the [fonction] column value.
     *
     * @return string
     */
    public function getFonction()
    {
        return $this->fonction;
    }

    /**
     * Get the [departement_id] column value.
     *
     * @return int
     */
    public function getDepartementId()
    {
        return $this->departement_id;
    }

    /**
     * Get the [optionally formatted] temporal [date_debut] column value.
     *
     *
     * @param      string|null $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDateDebut($format = NULL)
    {
        if ($format === null) {
            return $this->date_debut;
        } else {
            return $this->date_debut instanceof \DateTimeInterface ? $this->date_debut->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [date_fin] column value.
     *
     *
     * @param      string|null $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDateFin($format = NULL)
    {
        if ($format === null) {
            return $this->date_fin;
        } else {
            return $this->date_fin instanceof \DateTimeInterface ? $this->date_fin->format($format) : null;
        }
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
     * Set the value of [embauche_id] column.
     *
     * @param int $v New value
     * @return $this|\App\Models\Embauche The current object (for fluent API support)
     */
    public function setEmbaucheId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->embauche_id !== $v) {
            $this->embauche_id = $v;
            $this->modifiedColumns[EmbaucheTableMap::COL_EMBAUCHE_ID] = true;
        }

        return $this;
    } // setEmbaucheId()

    /**
     * Set the value of [civilite] column.
     *
     * @param string|null $v New value
     * @return $this|\App\Models\Embauche The current object (for fluent API support)
     */
    public function setCivilite($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->civilite !== $v) {
            $this->civilite = $v;
            $this->modifiedColumns[EmbaucheTableMap::COL_CIVILITE] = true;
        }

        return $this;
    } // setCivilite()

    /**
     * Set the value of [ref_interne] column.
     *
     * @param string $v New value
     * @return $this|\App\Models\Embauche The current object (for fluent API support)
     */
    public function setRefInterne($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->ref_interne !== $v) {
            $this->ref_interne = $v;
            $this->modifiedColumns[EmbaucheTableMap::COL_REF_INTERNE] = true;
        }

        return $this;
    } // setRefInterne()

    /**
     * Set the value of [nom_prenom] column.
     *
     * @param string $v New value
     * @return $this|\App\Models\Embauche The current object (for fluent API support)
     */
    public function setNomPrenom($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->nom_prenom !== $v) {
            $this->nom_prenom = $v;
            $this->modifiedColumns[EmbaucheTableMap::COL_NOM_PRENOM] = true;
        }

        return $this;
    } // setNomPrenom()

    /**
     * Set the value of [photo_link] column.
     *
     * @param string|null $v New value
     * @return $this|\App\Models\Embauche The current object (for fluent API support)
     */
    public function setPhotoLink($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->photo_link !== $v) {
            $this->photo_link = $v;
            $this->modifiedColumns[EmbaucheTableMap::COL_PHOTO_LINK] = true;
        }

        return $this;
    } // setPhotoLink()

    /**
     * Set the value of [fonction] column.
     *
     * @param string $v New value
     * @return $this|\App\Models\Embauche The current object (for fluent API support)
     */
    public function setFonction($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->fonction !== $v) {
            $this->fonction = $v;
            $this->modifiedColumns[EmbaucheTableMap::COL_FONCTION] = true;
        }

        return $this;
    } // setFonction()

    /**
     * Set the value of [departement_id] column.
     *
     * @param int|null $v New value
     * @return $this|\App\Models\Embauche The current object (for fluent API support)
     */
    public function setDepartementId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->departement_id !== $v) {
            $this->departement_id = $v;
            $this->modifiedColumns[EmbaucheTableMap::COL_DEPARTEMENT_ID] = true;
        }

        if ($this->aDepartement !== null && $this->aDepartement->getDepartementId() !== $v) {
            $this->aDepartement = null;
        }

        return $this;
    } // setDepartementId()

    /**
     * Sets the value of [date_debut] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\App\Models\Embauche The current object (for fluent API support)
     */
    public function setDateDebut($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->date_debut !== null || $dt !== null) {
            if ($this->date_debut === null || $dt === null || $dt->format("Y-m-d") !== $this->date_debut->format("Y-m-d")) {
                $this->date_debut = $dt === null ? null : clone $dt;
                $this->modifiedColumns[EmbaucheTableMap::COL_DATE_DEBUT] = true;
            }
        } // if either are not null

        return $this;
    } // setDateDebut()

    /**
     * Sets the value of [date_fin] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\App\Models\Embauche The current object (for fluent API support)
     */
    public function setDateFin($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->date_fin !== null || $dt !== null) {
            if ($this->date_fin === null || $dt === null || $dt->format("Y-m-d") !== $this->date_fin->format("Y-m-d")) {
                $this->date_fin = $dt === null ? null : clone $dt;
                $this->modifiedColumns[EmbaucheTableMap::COL_DATE_FIN] = true;
            }
        } // if either are not null

        return $this;
    } // setDateFin()

    /**
     * Set the value of [status] column.
     *
     * @param int $v New value
     * @return $this|\App\Models\Embauche The current object (for fluent API support)
     */
    public function setStatus($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->status !== $v) {
            $this->status = $v;
            $this->modifiedColumns[EmbaucheTableMap::COL_STATUS] = true;
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : EmbaucheTableMap::translateFieldName('EmbaucheId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->embauche_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : EmbaucheTableMap::translateFieldName('Civilite', TableMap::TYPE_PHPNAME, $indexType)];
            $this->civilite = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : EmbaucheTableMap::translateFieldName('RefInterne', TableMap::TYPE_PHPNAME, $indexType)];
            $this->ref_interne = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : EmbaucheTableMap::translateFieldName('NomPrenom', TableMap::TYPE_PHPNAME, $indexType)];
            $this->nom_prenom = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : EmbaucheTableMap::translateFieldName('PhotoLink', TableMap::TYPE_PHPNAME, $indexType)];
            $this->photo_link = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : EmbaucheTableMap::translateFieldName('Fonction', TableMap::TYPE_PHPNAME, $indexType)];
            $this->fonction = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : EmbaucheTableMap::translateFieldName('DepartementId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->departement_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : EmbaucheTableMap::translateFieldName('DateDebut', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00') {
                $col = null;
            }
            $this->date_debut = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : EmbaucheTableMap::translateFieldName('DateFin', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00') {
                $col = null;
            }
            $this->date_fin = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : EmbaucheTableMap::translateFieldName('Status', TableMap::TYPE_PHPNAME, $indexType)];
            $this->status = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 10; // 10 = EmbaucheTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\App\\Models\\Embauche'), 0, $e);
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
        if ($this->aDepartement !== null && $this->departement_id !== $this->aDepartement->getDepartementId()) {
            $this->aDepartement = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(EmbaucheTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildEmbaucheQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aDepartement = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Embauche::setDeleted()
     * @see Embauche::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(EmbaucheTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildEmbaucheQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(EmbaucheTableMap::DATABASE_NAME);
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
                EmbaucheTableMap::addInstanceToPool($this);
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

            if ($this->aDepartement !== null) {
                if ($this->aDepartement->isModified() || $this->aDepartement->isNew()) {
                    $affectedRows += $this->aDepartement->save($con);
                }
                $this->setDepartement($this->aDepartement);
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

        $this->modifiedColumns[EmbaucheTableMap::COL_EMBAUCHE_ID] = true;
        if (null !== $this->embauche_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . EmbaucheTableMap::COL_EMBAUCHE_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(EmbaucheTableMap::COL_EMBAUCHE_ID)) {
            $modifiedColumns[':p' . $index++]  = 'embauche_id';
        }
        if ($this->isColumnModified(EmbaucheTableMap::COL_CIVILITE)) {
            $modifiedColumns[':p' . $index++]  = 'civilite';
        }
        if ($this->isColumnModified(EmbaucheTableMap::COL_REF_INTERNE)) {
            $modifiedColumns[':p' . $index++]  = 'ref_interne';
        }
        if ($this->isColumnModified(EmbaucheTableMap::COL_NOM_PRENOM)) {
            $modifiedColumns[':p' . $index++]  = 'nom_prenom';
        }
        if ($this->isColumnModified(EmbaucheTableMap::COL_PHOTO_LINK)) {
            $modifiedColumns[':p' . $index++]  = 'photo_link';
        }
        if ($this->isColumnModified(EmbaucheTableMap::COL_FONCTION)) {
            $modifiedColumns[':p' . $index++]  = 'fonction';
        }
        if ($this->isColumnModified(EmbaucheTableMap::COL_DEPARTEMENT_ID)) {
            $modifiedColumns[':p' . $index++]  = 'departement_id';
        }
        if ($this->isColumnModified(EmbaucheTableMap::COL_DATE_DEBUT)) {
            $modifiedColumns[':p' . $index++]  = 'date_debut';
        }
        if ($this->isColumnModified(EmbaucheTableMap::COL_DATE_FIN)) {
            $modifiedColumns[':p' . $index++]  = 'date_fin';
        }
        if ($this->isColumnModified(EmbaucheTableMap::COL_STATUS)) {
            $modifiedColumns[':p' . $index++]  = 'status';
        }

        $sql = sprintf(
            'INSERT INTO embauche (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'embauche_id':
                        $stmt->bindValue($identifier, $this->embauche_id, PDO::PARAM_INT);
                        break;
                    case 'civilite':
                        $stmt->bindValue($identifier, $this->civilite, PDO::PARAM_STR);
                        break;
                    case 'ref_interne':
                        $stmt->bindValue($identifier, $this->ref_interne, PDO::PARAM_STR);
                        break;
                    case 'nom_prenom':
                        $stmt->bindValue($identifier, $this->nom_prenom, PDO::PARAM_STR);
                        break;
                    case 'photo_link':
                        $stmt->bindValue($identifier, $this->photo_link, PDO::PARAM_STR);
                        break;
                    case 'fonction':
                        $stmt->bindValue($identifier, $this->fonction, PDO::PARAM_STR);
                        break;
                    case 'departement_id':
                        $stmt->bindValue($identifier, $this->departement_id, PDO::PARAM_INT);
                        break;
                    case 'date_debut':
                        $stmt->bindValue($identifier, $this->date_debut ? $this->date_debut->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'date_fin':
                        $stmt->bindValue($identifier, $this->date_fin ? $this->date_fin->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
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
        $this->setEmbaucheId($pk);

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
        $pos = EmbaucheTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getEmbaucheId();
                break;
            case 1:
                return $this->getCivilite();
                break;
            case 2:
                return $this->getRefInterne();
                break;
            case 3:
                return $this->getNomPrenom();
                break;
            case 4:
                return $this->getPhotoLink();
                break;
            case 5:
                return $this->getFonction();
                break;
            case 6:
                return $this->getDepartementId();
                break;
            case 7:
                return $this->getDateDebut();
                break;
            case 8:
                return $this->getDateFin();
                break;
            case 9:
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

        if (isset($alreadyDumpedObjects['Embauche'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Embauche'][$this->hashCode()] = true;
        $keys = EmbaucheTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getEmbaucheId(),
            $keys[1] => $this->getCivilite(),
            $keys[2] => $this->getRefInterne(),
            $keys[3] => $this->getNomPrenom(),
            $keys[4] => $this->getPhotoLink(),
            $keys[5] => $this->getFonction(),
            $keys[6] => $this->getDepartementId(),
            $keys[7] => $this->getDateDebut(),
            $keys[8] => $this->getDateFin(),
            $keys[9] => $this->getStatus(),
        );
        if ($result[$keys[7]] instanceof \DateTimeInterface) {
            $result[$keys[7]] = $result[$keys[7]]->format('c');
        }

        if ($result[$keys[8]] instanceof \DateTimeInterface) {
            $result[$keys[8]] = $result[$keys[8]]->format('c');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aDepartement) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'departement';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'departement';
                        break;
                    default:
                        $key = 'Departement';
                }

                $result[$key] = $this->aDepartement->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
     * @return $this|\App\Models\Embauche
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = EmbaucheTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\App\Models\Embauche
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setEmbaucheId($value);
                break;
            case 1:
                $this->setCivilite($value);
                break;
            case 2:
                $this->setRefInterne($value);
                break;
            case 3:
                $this->setNomPrenom($value);
                break;
            case 4:
                $this->setPhotoLink($value);
                break;
            case 5:
                $this->setFonction($value);
                break;
            case 6:
                $this->setDepartementId($value);
                break;
            case 7:
                $this->setDateDebut($value);
                break;
            case 8:
                $this->setDateFin($value);
                break;
            case 9:
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
        $keys = EmbaucheTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setEmbaucheId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setCivilite($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setRefInterne($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setNomPrenom($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setPhotoLink($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setFonction($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setDepartementId($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setDateDebut($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setDateFin($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setStatus($arr[$keys[9]]);
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
     * @return $this|\App\Models\Embauche The current object, for fluid interface
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
        $criteria = new Criteria(EmbaucheTableMap::DATABASE_NAME);

        if ($this->isColumnModified(EmbaucheTableMap::COL_EMBAUCHE_ID)) {
            $criteria->add(EmbaucheTableMap::COL_EMBAUCHE_ID, $this->embauche_id);
        }
        if ($this->isColumnModified(EmbaucheTableMap::COL_CIVILITE)) {
            $criteria->add(EmbaucheTableMap::COL_CIVILITE, $this->civilite);
        }
        if ($this->isColumnModified(EmbaucheTableMap::COL_REF_INTERNE)) {
            $criteria->add(EmbaucheTableMap::COL_REF_INTERNE, $this->ref_interne);
        }
        if ($this->isColumnModified(EmbaucheTableMap::COL_NOM_PRENOM)) {
            $criteria->add(EmbaucheTableMap::COL_NOM_PRENOM, $this->nom_prenom);
        }
        if ($this->isColumnModified(EmbaucheTableMap::COL_PHOTO_LINK)) {
            $criteria->add(EmbaucheTableMap::COL_PHOTO_LINK, $this->photo_link);
        }
        if ($this->isColumnModified(EmbaucheTableMap::COL_FONCTION)) {
            $criteria->add(EmbaucheTableMap::COL_FONCTION, $this->fonction);
        }
        if ($this->isColumnModified(EmbaucheTableMap::COL_DEPARTEMENT_ID)) {
            $criteria->add(EmbaucheTableMap::COL_DEPARTEMENT_ID, $this->departement_id);
        }
        if ($this->isColumnModified(EmbaucheTableMap::COL_DATE_DEBUT)) {
            $criteria->add(EmbaucheTableMap::COL_DATE_DEBUT, $this->date_debut);
        }
        if ($this->isColumnModified(EmbaucheTableMap::COL_DATE_FIN)) {
            $criteria->add(EmbaucheTableMap::COL_DATE_FIN, $this->date_fin);
        }
        if ($this->isColumnModified(EmbaucheTableMap::COL_STATUS)) {
            $criteria->add(EmbaucheTableMap::COL_STATUS, $this->status);
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
        $criteria = ChildEmbaucheQuery::create();
        $criteria->add(EmbaucheTableMap::COL_EMBAUCHE_ID, $this->embauche_id);

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
        $validPk = null !== $this->getEmbaucheId();

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
        return $this->getEmbaucheId();
    }

    /**
     * Generic method to set the primary key (embauche_id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setEmbaucheId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getEmbaucheId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \App\Models\Embauche (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setCivilite($this->getCivilite());
        $copyObj->setRefInterne($this->getRefInterne());
        $copyObj->setNomPrenom($this->getNomPrenom());
        $copyObj->setPhotoLink($this->getPhotoLink());
        $copyObj->setFonction($this->getFonction());
        $copyObj->setDepartementId($this->getDepartementId());
        $copyObj->setDateDebut($this->getDateDebut());
        $copyObj->setDateFin($this->getDateFin());
        $copyObj->setStatus($this->getStatus());
        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setEmbaucheId(NULL); // this is a auto-increment column, so set to default value
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
     * @return \App\Models\Embauche Clone of current object.
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
     * Declares an association between this object and a ChildDepartement object.
     *
     * @param  ChildDepartement $v
     * @return $this|\App\Models\Embauche The current object (for fluent API support)
     * @throws PropelException
     */
    public function setDepartement(ChildDepartement $v = null)
    {
        if ($v === null) {
            $this->setDepartementId(NULL);
        } else {
            $this->setDepartementId($v->getDepartementId());
        }

        $this->aDepartement = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildDepartement object, it will not be re-added.
        if ($v !== null) {
            $v->addEmbauche($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildDepartement object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildDepartement The associated ChildDepartement object.
     * @throws PropelException
     */
    public function getDepartement(ConnectionInterface $con = null)
    {
        if ($this->aDepartement === null && ($this->departement_id != 0)) {
            $this->aDepartement = ChildDepartementQuery::create()->findPk($this->departement_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aDepartement->addEmbauches($this);
             */
        }

        return $this->aDepartement;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aDepartement) {
            $this->aDepartement->removeEmbauche($this);
        }
        $this->embauche_id = null;
        $this->civilite = null;
        $this->ref_interne = null;
        $this->nom_prenom = null;
        $this->photo_link = null;
        $this->fonction = null;
        $this->departement_id = null;
        $this->date_debut = null;
        $this->date_fin = null;
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
        } // if ($deep)

        $this->aDepartement = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(EmbaucheTableMap::DEFAULT_STRING_FORMAT);
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
