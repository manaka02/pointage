<?php

namespace App\Models\Base;

use \Exception;
use \PDO;
use App\Models\Debauche as ChildDebauche;
use App\Models\DebaucheQuery as ChildDebaucheQuery;
use App\Models\Departement as ChildDepartement;
use App\Models\DepartementQuery as ChildDepartementQuery;
use App\Models\Direction as ChildDirection;
use App\Models\DirectionQuery as ChildDirectionQuery;
use App\Models\Embauche as ChildEmbauche;
use App\Models\EmbaucheQuery as ChildEmbaucheQuery;
use App\Models\Service as ChildService;
use App\Models\ServiceQuery as ChildServiceQuery;
use App\Models\Map\DebaucheTableMap;
use App\Models\Map\DepartementTableMap;
use App\Models\Map\EmbaucheTableMap;
use App\Models\Map\ServiceTableMap;
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

/**
 * Base class that represents a row from the 'departement' table.
 *
 *
 *
 * @package    propel.generator..Base
 */
abstract class Departement implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\App\\Models\\Map\\DepartementTableMap';


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
     * The value for the departement_id field.
     *
     * @var        int
     */
    protected $departement_id;

    /**
     * The value for the direction_id field.
     *
     * @var        int
     */
    protected $direction_id;

    /**
     * The value for the designation field.
     *
     * @var        string
     */
    protected $designation;

    /**
     * The value for the description field.
     *
     * @var        string
     */
    protected $description;

    /**
     * @var        ChildDirection
     */
    protected $aDirection;

    /**
     * @var        ObjectCollection|ChildDebauche[] Collection to store aggregation of ChildDebauche objects.
     */
    protected $collDebauches;
    protected $collDebauchesPartial;

    /**
     * @var        ObjectCollection|ChildEmbauche[] Collection to store aggregation of ChildEmbauche objects.
     */
    protected $collEmbauches;
    protected $collEmbauchesPartial;

    /**
     * @var        ObjectCollection|ChildService[] Collection to store aggregation of ChildService objects.
     */
    protected $collServices;
    protected $collServicesPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildDebauche[]
     */
    protected $debauchesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildEmbauche[]
     */
    protected $embauchesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildService[]
     */
    protected $servicesScheduledForDeletion = null;

    /**
     * Initializes internal state of App\Models\Base\Departement object.
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
     * Compares this with another <code>Departement</code> instance.  If
     * <code>obj</code> is an instance of <code>Departement</code>, delegates to
     * <code>equals(Departement)</code>.  Otherwise, returns <code>false</code>.
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
     * Get the [departement_id] column value.
     *
     * @return int
     */
    public function getDepartementId()
    {
        return $this->departement_id;
    }

    /**
     * Get the [direction_id] column value.
     *
     * @return int
     */
    public function getDirectionId()
    {
        return $this->direction_id;
    }

    /**
     * Get the [designation] column value.
     *
     * @return string
     */
    public function getDesignation()
    {
        return $this->designation;
    }

    /**
     * Get the [description] column value.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of [departement_id] column.
     *
     * @param int $v New value
     * @return $this|\App\Models\Departement The current object (for fluent API support)
     */
    public function setDepartementId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->departement_id !== $v) {
            $this->departement_id = $v;
            $this->modifiedColumns[DepartementTableMap::COL_DEPARTEMENT_ID] = true;
        }

        return $this;
    } // setDepartementId()

    /**
     * Set the value of [direction_id] column.
     *
     * @param int $v New value
     * @return $this|\App\Models\Departement The current object (for fluent API support)
     */
    public function setDirectionId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->direction_id !== $v) {
            $this->direction_id = $v;
            $this->modifiedColumns[DepartementTableMap::COL_DIRECTION_ID] = true;
        }

        if ($this->aDirection !== null && $this->aDirection->getDirectionId() !== $v) {
            $this->aDirection = null;
        }

        return $this;
    } // setDirectionId()

    /**
     * Set the value of [designation] column.
     *
     * @param string|null $v New value
     * @return $this|\App\Models\Departement The current object (for fluent API support)
     */
    public function setDesignation($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->designation !== $v) {
            $this->designation = $v;
            $this->modifiedColumns[DepartementTableMap::COL_DESIGNATION] = true;
        }

        return $this;
    } // setDesignation()

    /**
     * Set the value of [description] column.
     *
     * @param string|null $v New value
     * @return $this|\App\Models\Departement The current object (for fluent API support)
     */
    public function setDescription($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->description !== $v) {
            $this->description = $v;
            $this->modifiedColumns[DepartementTableMap::COL_DESCRIPTION] = true;
        }

        return $this;
    } // setDescription()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : DepartementTableMap::translateFieldName('DepartementId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->departement_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : DepartementTableMap::translateFieldName('DirectionId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->direction_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : DepartementTableMap::translateFieldName('Designation', TableMap::TYPE_PHPNAME, $indexType)];
            $this->designation = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : DepartementTableMap::translateFieldName('Description', TableMap::TYPE_PHPNAME, $indexType)];
            $this->description = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 4; // 4 = DepartementTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\App\\Models\\Departement'), 0, $e);
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
        if ($this->aDirection !== null && $this->direction_id !== $this->aDirection->getDirectionId()) {
            $this->aDirection = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(DepartementTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildDepartementQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aDirection = null;
            $this->collDebauches = null;

            $this->collEmbauches = null;

            $this->collServices = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Departement::setDeleted()
     * @see Departement::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(DepartementTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildDepartementQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(DepartementTableMap::DATABASE_NAME);
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
                DepartementTableMap::addInstanceToPool($this);
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

            if ($this->aDirection !== null) {
                if ($this->aDirection->isModified() || $this->aDirection->isNew()) {
                    $affectedRows += $this->aDirection->save($con);
                }
                $this->setDirection($this->aDirection);
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

            if ($this->debauchesScheduledForDeletion !== null) {
                if (!$this->debauchesScheduledForDeletion->isEmpty()) {
                    foreach ($this->debauchesScheduledForDeletion as $debauche) {
                        // need to save related object because we set the relation to null
                        $debauche->save($con);
                    }
                    $this->debauchesScheduledForDeletion = null;
                }
            }

            if ($this->collDebauches !== null) {
                foreach ($this->collDebauches as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->embauchesScheduledForDeletion !== null) {
                if (!$this->embauchesScheduledForDeletion->isEmpty()) {
                    foreach ($this->embauchesScheduledForDeletion as $embauche) {
                        // need to save related object because we set the relation to null
                        $embauche->save($con);
                    }
                    $this->embauchesScheduledForDeletion = null;
                }
            }

            if ($this->collEmbauches !== null) {
                foreach ($this->collEmbauches as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->servicesScheduledForDeletion !== null) {
                if (!$this->servicesScheduledForDeletion->isEmpty()) {
                    \App\Models\ServiceQuery::create()
                        ->filterByPrimaryKeys($this->servicesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->servicesScheduledForDeletion = null;
                }
            }

            if ($this->collServices !== null) {
                foreach ($this->collServices as $referrerFK) {
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

        $this->modifiedColumns[DepartementTableMap::COL_DEPARTEMENT_ID] = true;
        if (null !== $this->departement_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . DepartementTableMap::COL_DEPARTEMENT_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(DepartementTableMap::COL_DEPARTEMENT_ID)) {
            $modifiedColumns[':p' . $index++]  = 'departement_id';
        }
        if ($this->isColumnModified(DepartementTableMap::COL_DIRECTION_ID)) {
            $modifiedColumns[':p' . $index++]  = 'direction_id';
        }
        if ($this->isColumnModified(DepartementTableMap::COL_DESIGNATION)) {
            $modifiedColumns[':p' . $index++]  = 'designation';
        }
        if ($this->isColumnModified(DepartementTableMap::COL_DESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = 'description';
        }

        $sql = sprintf(
            'INSERT INTO departement (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'departement_id':
                        $stmt->bindValue($identifier, $this->departement_id, PDO::PARAM_INT);
                        break;
                    case 'direction_id':
                        $stmt->bindValue($identifier, $this->direction_id, PDO::PARAM_INT);
                        break;
                    case 'designation':
                        $stmt->bindValue($identifier, $this->designation, PDO::PARAM_STR);
                        break;
                    case 'description':
                        $stmt->bindValue($identifier, $this->description, PDO::PARAM_STR);
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
        $this->setDepartementId($pk);

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
        $pos = DepartementTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getDepartementId();
                break;
            case 1:
                return $this->getDirectionId();
                break;
            case 2:
                return $this->getDesignation();
                break;
            case 3:
                return $this->getDescription();
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

        if (isset($alreadyDumpedObjects['Departement'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Departement'][$this->hashCode()] = true;
        $keys = DepartementTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getDepartementId(),
            $keys[1] => $this->getDirectionId(),
            $keys[2] => $this->getDesignation(),
            $keys[3] => $this->getDescription(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aDirection) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'direction';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'direction';
                        break;
                    default:
                        $key = 'Direction';
                }

                $result[$key] = $this->aDirection->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collDebauches) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'debauches';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'debauches';
                        break;
                    default:
                        $key = 'Debauches';
                }

                $result[$key] = $this->collDebauches->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collEmbauches) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'embauches';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'embauches';
                        break;
                    default:
                        $key = 'Embauches';
                }

                $result[$key] = $this->collEmbauches->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collServices) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'services';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'services';
                        break;
                    default:
                        $key = 'Services';
                }

                $result[$key] = $this->collServices->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\App\Models\Departement
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = DepartementTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\App\Models\Departement
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setDepartementId($value);
                break;
            case 1:
                $this->setDirectionId($value);
                break;
            case 2:
                $this->setDesignation($value);
                break;
            case 3:
                $this->setDescription($value);
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
        $keys = DepartementTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setDepartementId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setDirectionId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setDesignation($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setDescription($arr[$keys[3]]);
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
     * @return $this|\App\Models\Departement The current object, for fluid interface
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
        $criteria = new Criteria(DepartementTableMap::DATABASE_NAME);

        if ($this->isColumnModified(DepartementTableMap::COL_DEPARTEMENT_ID)) {
            $criteria->add(DepartementTableMap::COL_DEPARTEMENT_ID, $this->departement_id);
        }
        if ($this->isColumnModified(DepartementTableMap::COL_DIRECTION_ID)) {
            $criteria->add(DepartementTableMap::COL_DIRECTION_ID, $this->direction_id);
        }
        if ($this->isColumnModified(DepartementTableMap::COL_DESIGNATION)) {
            $criteria->add(DepartementTableMap::COL_DESIGNATION, $this->designation);
        }
        if ($this->isColumnModified(DepartementTableMap::COL_DESCRIPTION)) {
            $criteria->add(DepartementTableMap::COL_DESCRIPTION, $this->description);
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
        $criteria = ChildDepartementQuery::create();
        $criteria->add(DepartementTableMap::COL_DEPARTEMENT_ID, $this->departement_id);

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
        $validPk = null !== $this->getDepartementId();

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
        return $this->getDepartementId();
    }

    /**
     * Generic method to set the primary key (departement_id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setDepartementId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getDepartementId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \App\Models\Departement (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setDirectionId($this->getDirectionId());
        $copyObj->setDesignation($this->getDesignation());
        $copyObj->setDescription($this->getDescription());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getDebauches() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addDebauche($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getEmbauches() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addEmbauche($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getServices() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addService($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setDepartementId(NULL); // this is a auto-increment column, so set to default value
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
     * @return \App\Models\Departement Clone of current object.
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
     * Declares an association between this object and a ChildDirection object.
     *
     * @param  ChildDirection $v
     * @return $this|\App\Models\Departement The current object (for fluent API support)
     * @throws PropelException
     */
    public function setDirection(ChildDirection $v = null)
    {
        if ($v === null) {
            $this->setDirectionId(NULL);
        } else {
            $this->setDirectionId($v->getDirectionId());
        }

        $this->aDirection = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildDirection object, it will not be re-added.
        if ($v !== null) {
            $v->addDepartement($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildDirection object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildDirection The associated ChildDirection object.
     * @throws PropelException
     */
    public function getDirection(ConnectionInterface $con = null)
    {
        if ($this->aDirection === null && ($this->direction_id != 0)) {
            $this->aDirection = ChildDirectionQuery::create()->findPk($this->direction_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aDirection->addDepartements($this);
             */
        }

        return $this->aDirection;
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
        if ('Debauche' === $relationName) {
            $this->initDebauches();
            return;
        }
        if ('Embauche' === $relationName) {
            $this->initEmbauches();
            return;
        }
        if ('Service' === $relationName) {
            $this->initServices();
            return;
        }
    }

    /**
     * Clears out the collDebauches collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addDebauches()
     */
    public function clearDebauches()
    {
        $this->collDebauches = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collDebauches collection loaded partially.
     */
    public function resetPartialDebauches($v = true)
    {
        $this->collDebauchesPartial = $v;
    }

    /**
     * Initializes the collDebauches collection.
     *
     * By default this just sets the collDebauches collection to an empty array (like clearcollDebauches());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initDebauches($overrideExisting = true)
    {
        if (null !== $this->collDebauches && !$overrideExisting) {
            return;
        }

        $collectionClassName = DebaucheTableMap::getTableMap()->getCollectionClassName();

        $this->collDebauches = new $collectionClassName;
        $this->collDebauches->setModel('\App\Models\Debauche');
    }

    /**
     * Gets an array of ChildDebauche objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildDepartement is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildDebauche[] List of ChildDebauche objects
     * @throws PropelException
     */
    public function getDebauches(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collDebauchesPartial && !$this->isNew();
        if (null === $this->collDebauches || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collDebauches) {
                    $this->initDebauches();
                } else {
                    $collectionClassName = DebaucheTableMap::getTableMap()->getCollectionClassName();

                    $collDebauches = new $collectionClassName;
                    $collDebauches->setModel('\App\Models\Debauche');

                    return $collDebauches;
                }
            } else {
                $collDebauches = ChildDebaucheQuery::create(null, $criteria)
                    ->filterByDepartement($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collDebauchesPartial && count($collDebauches)) {
                        $this->initDebauches(false);

                        foreach ($collDebauches as $obj) {
                            if (false == $this->collDebauches->contains($obj)) {
                                $this->collDebauches->append($obj);
                            }
                        }

                        $this->collDebauchesPartial = true;
                    }

                    return $collDebauches;
                }

                if ($partial && $this->collDebauches) {
                    foreach ($this->collDebauches as $obj) {
                        if ($obj->isNew()) {
                            $collDebauches[] = $obj;
                        }
                    }
                }

                $this->collDebauches = $collDebauches;
                $this->collDebauchesPartial = false;
            }
        }

        return $this->collDebauches;
    }

    /**
     * Sets a collection of ChildDebauche objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $debauches A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildDepartement The current object (for fluent API support)
     */
    public function setDebauches(Collection $debauches, ConnectionInterface $con = null)
    {
        /** @var ChildDebauche[] $debauchesToDelete */
        $debauchesToDelete = $this->getDebauches(new Criteria(), $con)->diff($debauches);


        $this->debauchesScheduledForDeletion = $debauchesToDelete;

        foreach ($debauchesToDelete as $debaucheRemoved) {
            $debaucheRemoved->setDepartement(null);
        }

        $this->collDebauches = null;
        foreach ($debauches as $debauche) {
            $this->addDebauche($debauche);
        }

        $this->collDebauches = $debauches;
        $this->collDebauchesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Debauche objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Debauche objects.
     * @throws PropelException
     */
    public function countDebauches(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collDebauchesPartial && !$this->isNew();
        if (null === $this->collDebauches || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collDebauches) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getDebauches());
            }

            $query = ChildDebaucheQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByDepartement($this)
                ->count($con);
        }

        return count($this->collDebauches);
    }

    /**
     * Method called to associate a ChildDebauche object to this object
     * through the ChildDebauche foreign key attribute.
     *
     * @param  ChildDebauche $l ChildDebauche
     * @return $this|\App\Models\Departement The current object (for fluent API support)
     */
    public function addDebauche(ChildDebauche $l)
    {
        if ($this->collDebauches === null) {
            $this->initDebauches();
            $this->collDebauchesPartial = true;
        }

        if (!$this->collDebauches->contains($l)) {
            $this->doAddDebauche($l);

            if ($this->debauchesScheduledForDeletion and $this->debauchesScheduledForDeletion->contains($l)) {
                $this->debauchesScheduledForDeletion->remove($this->debauchesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildDebauche $debauche The ChildDebauche object to add.
     */
    protected function doAddDebauche(ChildDebauche $debauche)
    {
        $this->collDebauches[]= $debauche;
        $debauche->setDepartement($this);
    }

    /**
     * @param  ChildDebauche $debauche The ChildDebauche object to remove.
     * @return $this|ChildDepartement The current object (for fluent API support)
     */
    public function removeDebauche(ChildDebauche $debauche)
    {
        if ($this->getDebauches()->contains($debauche)) {
            $pos = $this->collDebauches->search($debauche);
            $this->collDebauches->remove($pos);
            if (null === $this->debauchesScheduledForDeletion) {
                $this->debauchesScheduledForDeletion = clone $this->collDebauches;
                $this->debauchesScheduledForDeletion->clear();
            }
            $this->debauchesScheduledForDeletion[]= $debauche;
            $debauche->setDepartement(null);
        }

        return $this;
    }

    /**
     * Clears out the collEmbauches collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addEmbauches()
     */
    public function clearEmbauches()
    {
        $this->collEmbauches = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collEmbauches collection loaded partially.
     */
    public function resetPartialEmbauches($v = true)
    {
        $this->collEmbauchesPartial = $v;
    }

    /**
     * Initializes the collEmbauches collection.
     *
     * By default this just sets the collEmbauches collection to an empty array (like clearcollEmbauches());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initEmbauches($overrideExisting = true)
    {
        if (null !== $this->collEmbauches && !$overrideExisting) {
            return;
        }

        $collectionClassName = EmbaucheTableMap::getTableMap()->getCollectionClassName();

        $this->collEmbauches = new $collectionClassName;
        $this->collEmbauches->setModel('\App\Models\Embauche');
    }

    /**
     * Gets an array of ChildEmbauche objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildDepartement is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildEmbauche[] List of ChildEmbauche objects
     * @throws PropelException
     */
    public function getEmbauches(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collEmbauchesPartial && !$this->isNew();
        if (null === $this->collEmbauches || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collEmbauches) {
                    $this->initEmbauches();
                } else {
                    $collectionClassName = EmbaucheTableMap::getTableMap()->getCollectionClassName();

                    $collEmbauches = new $collectionClassName;
                    $collEmbauches->setModel('\App\Models\Embauche');

                    return $collEmbauches;
                }
            } else {
                $collEmbauches = ChildEmbaucheQuery::create(null, $criteria)
                    ->filterByDepartement($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collEmbauchesPartial && count($collEmbauches)) {
                        $this->initEmbauches(false);

                        foreach ($collEmbauches as $obj) {
                            if (false == $this->collEmbauches->contains($obj)) {
                                $this->collEmbauches->append($obj);
                            }
                        }

                        $this->collEmbauchesPartial = true;
                    }

                    return $collEmbauches;
                }

                if ($partial && $this->collEmbauches) {
                    foreach ($this->collEmbauches as $obj) {
                        if ($obj->isNew()) {
                            $collEmbauches[] = $obj;
                        }
                    }
                }

                $this->collEmbauches = $collEmbauches;
                $this->collEmbauchesPartial = false;
            }
        }

        return $this->collEmbauches;
    }

    /**
     * Sets a collection of ChildEmbauche objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $embauches A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildDepartement The current object (for fluent API support)
     */
    public function setEmbauches(Collection $embauches, ConnectionInterface $con = null)
    {
        /** @var ChildEmbauche[] $embauchesToDelete */
        $embauchesToDelete = $this->getEmbauches(new Criteria(), $con)->diff($embauches);


        $this->embauchesScheduledForDeletion = $embauchesToDelete;

        foreach ($embauchesToDelete as $embaucheRemoved) {
            $embaucheRemoved->setDepartement(null);
        }

        $this->collEmbauches = null;
        foreach ($embauches as $embauche) {
            $this->addEmbauche($embauche);
        }

        $this->collEmbauches = $embauches;
        $this->collEmbauchesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Embauche objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Embauche objects.
     * @throws PropelException
     */
    public function countEmbauches(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collEmbauchesPartial && !$this->isNew();
        if (null === $this->collEmbauches || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collEmbauches) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getEmbauches());
            }

            $query = ChildEmbaucheQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByDepartement($this)
                ->count($con);
        }

        return count($this->collEmbauches);
    }

    /**
     * Method called to associate a ChildEmbauche object to this object
     * through the ChildEmbauche foreign key attribute.
     *
     * @param  ChildEmbauche $l ChildEmbauche
     * @return $this|\App\Models\Departement The current object (for fluent API support)
     */
    public function addEmbauche(ChildEmbauche $l)
    {
        if ($this->collEmbauches === null) {
            $this->initEmbauches();
            $this->collEmbauchesPartial = true;
        }

        if (!$this->collEmbauches->contains($l)) {
            $this->doAddEmbauche($l);

            if ($this->embauchesScheduledForDeletion and $this->embauchesScheduledForDeletion->contains($l)) {
                $this->embauchesScheduledForDeletion->remove($this->embauchesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildEmbauche $embauche The ChildEmbauche object to add.
     */
    protected function doAddEmbauche(ChildEmbauche $embauche)
    {
        $this->collEmbauches[]= $embauche;
        $embauche->setDepartement($this);
    }

    /**
     * @param  ChildEmbauche $embauche The ChildEmbauche object to remove.
     * @return $this|ChildDepartement The current object (for fluent API support)
     */
    public function removeEmbauche(ChildEmbauche $embauche)
    {
        if ($this->getEmbauches()->contains($embauche)) {
            $pos = $this->collEmbauches->search($embauche);
            $this->collEmbauches->remove($pos);
            if (null === $this->embauchesScheduledForDeletion) {
                $this->embauchesScheduledForDeletion = clone $this->collEmbauches;
                $this->embauchesScheduledForDeletion->clear();
            }
            $this->embauchesScheduledForDeletion[]= $embauche;
            $embauche->setDepartement(null);
        }

        return $this;
    }

    /**
     * Clears out the collServices collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addServices()
     */
    public function clearServices()
    {
        $this->collServices = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collServices collection loaded partially.
     */
    public function resetPartialServices($v = true)
    {
        $this->collServicesPartial = $v;
    }

    /**
     * Initializes the collServices collection.
     *
     * By default this just sets the collServices collection to an empty array (like clearcollServices());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initServices($overrideExisting = true)
    {
        if (null !== $this->collServices && !$overrideExisting) {
            return;
        }

        $collectionClassName = ServiceTableMap::getTableMap()->getCollectionClassName();

        $this->collServices = new $collectionClassName;
        $this->collServices->setModel('\App\Models\Service');
    }

    /**
     * Gets an array of ChildService objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildDepartement is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildService[] List of ChildService objects
     * @throws PropelException
     */
    public function getServices(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collServicesPartial && !$this->isNew();
        if (null === $this->collServices || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collServices) {
                    $this->initServices();
                } else {
                    $collectionClassName = ServiceTableMap::getTableMap()->getCollectionClassName();

                    $collServices = new $collectionClassName;
                    $collServices->setModel('\App\Models\Service');

                    return $collServices;
                }
            } else {
                $collServices = ChildServiceQuery::create(null, $criteria)
                    ->filterByDepartement($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collServicesPartial && count($collServices)) {
                        $this->initServices(false);

                        foreach ($collServices as $obj) {
                            if (false == $this->collServices->contains($obj)) {
                                $this->collServices->append($obj);
                            }
                        }

                        $this->collServicesPartial = true;
                    }

                    return $collServices;
                }

                if ($partial && $this->collServices) {
                    foreach ($this->collServices as $obj) {
                        if ($obj->isNew()) {
                            $collServices[] = $obj;
                        }
                    }
                }

                $this->collServices = $collServices;
                $this->collServicesPartial = false;
            }
        }

        return $this->collServices;
    }

    /**
     * Sets a collection of ChildService objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $services A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildDepartement The current object (for fluent API support)
     */
    public function setServices(Collection $services, ConnectionInterface $con = null)
    {
        /** @var ChildService[] $servicesToDelete */
        $servicesToDelete = $this->getServices(new Criteria(), $con)->diff($services);


        $this->servicesScheduledForDeletion = $servicesToDelete;

        foreach ($servicesToDelete as $serviceRemoved) {
            $serviceRemoved->setDepartement(null);
        }

        $this->collServices = null;
        foreach ($services as $service) {
            $this->addService($service);
        }

        $this->collServices = $services;
        $this->collServicesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Service objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Service objects.
     * @throws PropelException
     */
    public function countServices(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collServicesPartial && !$this->isNew();
        if (null === $this->collServices || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collServices) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getServices());
            }

            $query = ChildServiceQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByDepartement($this)
                ->count($con);
        }

        return count($this->collServices);
    }

    /**
     * Method called to associate a ChildService object to this object
     * through the ChildService foreign key attribute.
     *
     * @param  ChildService $l ChildService
     * @return $this|\App\Models\Departement The current object (for fluent API support)
     */
    public function addService(ChildService $l)
    {
        if ($this->collServices === null) {
            $this->initServices();
            $this->collServicesPartial = true;
        }

        if (!$this->collServices->contains($l)) {
            $this->doAddService($l);

            if ($this->servicesScheduledForDeletion and $this->servicesScheduledForDeletion->contains($l)) {
                $this->servicesScheduledForDeletion->remove($this->servicesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildService $service The ChildService object to add.
     */
    protected function doAddService(ChildService $service)
    {
        $this->collServices[]= $service;
        $service->setDepartement($this);
    }

    /**
     * @param  ChildService $service The ChildService object to remove.
     * @return $this|ChildDepartement The current object (for fluent API support)
     */
    public function removeService(ChildService $service)
    {
        if ($this->getServices()->contains($service)) {
            $pos = $this->collServices->search($service);
            $this->collServices->remove($pos);
            if (null === $this->servicesScheduledForDeletion) {
                $this->servicesScheduledForDeletion = clone $this->collServices;
                $this->servicesScheduledForDeletion->clear();
            }
            $this->servicesScheduledForDeletion[]= clone $service;
            $service->setDepartement(null);
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
        if (null !== $this->aDirection) {
            $this->aDirection->removeDepartement($this);
        }
        $this->departement_id = null;
        $this->direction_id = null;
        $this->designation = null;
        $this->description = null;
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
            if ($this->collDebauches) {
                foreach ($this->collDebauches as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collEmbauches) {
                foreach ($this->collEmbauches as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collServices) {
                foreach ($this->collServices as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collDebauches = null;
        $this->collEmbauches = null;
        $this->collServices = null;
        $this->aDirection = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(DepartementTableMap::DEFAULT_STRING_FORMAT);
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
