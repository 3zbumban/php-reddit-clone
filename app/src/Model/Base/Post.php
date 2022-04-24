<?php

namespace Model\Base;

use \DateTime;
use \Exception;
use \PDO;
use Model\Comment as ChildComment;
use Model\CommentQuery as ChildCommentQuery;
use Model\Post as ChildPost;
use Model\PostQuery as ChildPostQuery;
use Model\Thread as ChildThread;
use Model\ThreadQuery as ChildThreadQuery;
use Model\User as ChildUser;
use Model\UserQuery as ChildUserQuery;
use Model\Map\CommentTableMap;
use Model\Map\PostTableMap;
use Model\Map\ThreadTableMap;
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
 * Base class that represents a row from the 'post' table.
 *
 *
 *
 * @package    propel.generator.Model.Base
 */
abstract class Post implements ActiveRecordInterface
{
    /**
     * TableMap class name
     *
     * @var string
     */
    public const TABLE_MAP = '\\Model\\Map\\PostTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var bool
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var bool
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = [];

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = [];

    /**
     * The value for the id field.
     *
     * @var        int
     */
    protected $id;

    /**
     * The value for the uuid field.
     *
     * @var        string
     */
    protected $uuid;

    /**
     * The value for the threadid field.
     *
     * @var        int
     */
    protected $threadid;

    /**
     * The value for the title field.
     *
     * @var        string
     */
    protected $title;

    /**
     * The value for the text field.
     *
     * @var        string
     */
    protected $text;

    /**
     * The value for the createdat field.
     *
     * @var        DateTime
     */
    protected $createdat;

    /**
     * The value for the userid field.
     *
     * @var        int
     */
    protected $userid;

    /**
     * @var        ChildUser
     */
    protected $aUser;

    /**
     * @var        ChildThread
     */
    protected $aThreadRelatedByThreadid;

    /**
     * @var        ObjectCollection|ChildThread[] Collection to store aggregation of ChildThread objects.
     * @phpstan-var ObjectCollection&\Traversable<ChildThread> Collection to store aggregation of ChildThread objects.
     */
    protected $collThreadsRelatedByPostid;
    protected $collThreadsRelatedByPostidPartial;

    /**
     * @var        ObjectCollection|ChildComment[] Collection to store aggregation of ChildComment objects.
     * @phpstan-var ObjectCollection&\Traversable<ChildComment> Collection to store aggregation of ChildComment objects.
     */
    protected $collComments;
    protected $collCommentsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var bool
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildThread[]
     * @phpstan-var ObjectCollection&\Traversable<ChildThread>
     */
    protected $threadsRelatedByPostidScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildComment[]
     * @phpstan-var ObjectCollection&\Traversable<ChildComment>
     */
    protected $commentsScheduledForDeletion = null;

    /**
     * Initializes internal state of Model\Base\Post object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return bool True if the object has been modified.
     */
    public function isModified(): bool
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param string $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return bool True if $col has been modified.
     */
    public function isColumnModified(string $col): bool
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns(): array
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return bool True, if the object has never been persisted.
     */
    public function isNew(): bool
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param bool $b the state of the object.
     */
    public function setNew(bool $b)
    {
        $this->new = $b;
    }

    /**
     * Whether this object has been deleted.
     * @return bool The deleted state of this object.
     */
    public function isDeleted(): bool
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param bool $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b): void
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified(?string $col = null): void
    {
        if (null !== $col) {
            unset($this->modifiedColumns[$col]);
        } else {
            $this->modifiedColumns = [];
        }
    }

    /**
     * Compares this with another <code>Post</code> instance.  If
     * <code>obj</code> is an instance of <code>Post</code>, delegates to
     * <code>equals(Post)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param mixed $obj The object to compare to.
     * @return bool Whether equal to the object specified.
     */
    public function equals($obj): bool
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
    public function getVirtualColumns(): array
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param string $name The virtual column name
     * @return bool
     */
    public function hasVirtualColumn(string $name): bool
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param string $name The virtual column name
     * @return mixed
     *
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getVirtualColumn(string $name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of nonexistent virtual column `%s`.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name The virtual column name
     * @param mixed $value The value to give to the virtual column
     *
     * @return $this The current object, for fluid interface
     */
    public function setVirtualColumn(string $name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param string $msg
     * @param int $priority One of the Propel::LOG_* logging levels
     * @return void
     */
    protected function log(string $msg, int $priority = Propel::LOG_INFO): void
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
     * @param \Propel\Runtime\Parser\AbstractParser|string $parser An AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param bool $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @param string $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME, TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM. Defaults to TableMap::TYPE_PHPNAME.
     * @return string The exported data
     */
    public function exportTo($parser, bool $includeLazyLoadColumns = true, string $keyType = TableMap::TYPE_PHPNAME): string
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray($keyType, $includeLazyLoadColumns, array(), true));
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
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [uuid] column value.
     *
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Get the [threadid] column value.
     *
     * @return int
     */
    public function getThreadid()
    {
        return $this->threadid;
    }

    /**
     * Get the [title] column value.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get the [text] column value.
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Get the [optionally formatted] temporal [createdat] column value.
     *
     *
     * @param string|null $format The date/time format string (either date()-style or strftime()-style).
     *   If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws \Propel\Runtime\Exception\PropelException - if unable to parse/validate the date/time value.
     *
     * @psalm-return ($format is null ? DateTime : string)
     */
    public function getCreatedat($format = null)
    {
        if ($format === null) {
            return $this->createdat;
        } else {
            return $this->createdat instanceof \DateTimeInterface ? $this->createdat->format($format) : null;
        }
    }

    /**
     * Get the [userid] column value.
     *
     * @return int
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[PostTableMap::COL_ID] = true;
        }

        return $this;
    }

    /**
     * Set the value of [uuid] column.
     *
     * @param string $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setUuid($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->uuid !== $v) {
            $this->uuid = $v;
            $this->modifiedColumns[PostTableMap::COL_UUID] = true;
        }

        return $this;
    }

    /**
     * Set the value of [threadid] column.
     *
     * @param int $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setThreadid($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->threadid !== $v) {
            $this->threadid = $v;
            $this->modifiedColumns[PostTableMap::COL_THREADID] = true;
        }

        if ($this->aThreadRelatedByThreadid !== null && $this->aThreadRelatedByThreadid->getId() !== $v) {
            $this->aThreadRelatedByThreadid = null;
        }

        return $this;
    }

    /**
     * Set the value of [title] column.
     *
     * @param string $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setTitle($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->title !== $v) {
            $this->title = $v;
            $this->modifiedColumns[PostTableMap::COL_TITLE] = true;
        }

        return $this;
    }

    /**
     * Set the value of [text] column.
     *
     * @param string $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setText($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->text !== $v) {
            $this->text = $v;
            $this->modifiedColumns[PostTableMap::COL_TEXT] = true;
        }

        return $this;
    }

    /**
     * Sets the value of [createdat] column to a normalized version of the date/time value specified.
     *
     * @param string|integer|\DateTimeInterface $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this The current object (for fluent API support)
     */
    public function setCreatedat($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->createdat !== null || $dt !== null) {
            if ($this->createdat === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->createdat->format("Y-m-d H:i:s.u")) {
                $this->createdat = $dt === null ? null : clone $dt;
                $this->modifiedColumns[PostTableMap::COL_CREATEDAT] = true;
            }
        } // if either are not null

        return $this;
    }

    /**
     * Set the value of [userid] column.
     *
     * @param int $v New value
     * @return $this The current object (for fluent API support)
     */
    public function setUserid($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->userid !== $v) {
            $this->userid = $v;
            $this->modifiedColumns[PostTableMap::COL_USERID] = true;
        }

        if ($this->aUser !== null && $this->aUser->getId() !== $v) {
            $this->aUser = null;
        }

        return $this;
    }

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return bool Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues(): bool
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    }

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array $row The row returned by DataFetcher->fetch().
     * @param int $startcol 0-based offset column which indicates which resultset column to start with.
     * @param bool $rehydrate Whether this object is being re-hydrated from the database.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int next starting column
     * @throws \Propel\Runtime\Exception\PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate(array $row, int $startcol = 0, bool $rehydrate = false, string $indexType = TableMap::TYPE_NUM): int
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : PostTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : PostTableMap::translateFieldName('Uuid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->uuid = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : PostTableMap::translateFieldName('Threadid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->threadid = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : PostTableMap::translateFieldName('Title', TableMap::TYPE_PHPNAME, $indexType)];
            $this->title = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : PostTableMap::translateFieldName('Text', TableMap::TYPE_PHPNAME, $indexType)];
            $this->text = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : PostTableMap::translateFieldName('Createdat', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->createdat = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : PostTableMap::translateFieldName('Userid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->userid = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 7; // 7 = PostTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Model\\Post'), 0, $e);
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
     * @throws \Propel\Runtime\Exception\PropelException
     * @return void
     */
    public function ensureConsistency(): void
    {
        if ($this->aThreadRelatedByThreadid !== null && $this->threadid !== $this->aThreadRelatedByThreadid->getId()) {
            $this->aThreadRelatedByThreadid = null;
        }
        if ($this->aUser !== null && $this->userid !== $this->aUser->getId()) {
            $this->aUser = null;
        }
    }

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param bool $deep (optional) Whether to also de-associated any related objects.
     * @param ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws \Propel\Runtime\Exception\PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload(bool $deep = false, ?ConnectionInterface $con = null): void
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PostTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildPostQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aUser = null;
            $this->aThreadRelatedByThreadid = null;
            $this->collThreadsRelatedByPostid = null;

            $this->collComments = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param ConnectionInterface $con
     * @return void
     * @throws \Propel\Runtime\Exception\PropelException
     * @see Post::setDeleted()
     * @see Post::isDeleted()
     */
    public function delete(?ConnectionInterface $con = null): void
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PostTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildPostQuery::create()
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
     * @param ConnectionInterface $con
     * @return int The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws \Propel\Runtime\Exception\PropelException
     * @see doSave()
     */
    public function save(?ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($this->alreadyInSave) {
            return 0;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PostTableMap::DATABASE_NAME);
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
                PostTableMap::addInstanceToPool($this);
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
     * @param ConnectionInterface $con
     * @return int The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws \Propel\Runtime\Exception\PropelException
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

            if ($this->aUser !== null) {
                if ($this->aUser->isModified() || $this->aUser->isNew()) {
                    $affectedRows += $this->aUser->save($con);
                }
                $this->setUser($this->aUser);
            }

            if ($this->aThreadRelatedByThreadid !== null) {
                if ($this->aThreadRelatedByThreadid->isModified() || $this->aThreadRelatedByThreadid->isNew()) {
                    $affectedRows += $this->aThreadRelatedByThreadid->save($con);
                }
                $this->setThreadRelatedByThreadid($this->aThreadRelatedByThreadid);
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

            if ($this->threadsRelatedByPostidScheduledForDeletion !== null) {
                if (!$this->threadsRelatedByPostidScheduledForDeletion->isEmpty()) {
                    \Model\ThreadQuery::create()
                        ->filterByPrimaryKeys($this->threadsRelatedByPostidScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->threadsRelatedByPostidScheduledForDeletion = null;
                }
            }

            if ($this->collThreadsRelatedByPostid !== null) {
                foreach ($this->collThreadsRelatedByPostid as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->commentsScheduledForDeletion !== null) {
                if (!$this->commentsScheduledForDeletion->isEmpty()) {
                    \Model\CommentQuery::create()
                        ->filterByPrimaryKeys($this->commentsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->commentsScheduledForDeletion = null;
                }
            }

            if ($this->collComments !== null) {
                foreach ($this->collComments as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    }

    /**
     * Insert the row in the database.
     *
     * @param ConnectionInterface $con
     *
     * @throws \Propel\Runtime\Exception\PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = [];
        $index = 0;

        $this->modifiedColumns[PostTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . PostTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(PostTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(PostTableMap::COL_UUID)) {
            $modifiedColumns[':p' . $index++]  = 'uuid';
        }
        if ($this->isColumnModified(PostTableMap::COL_THREADID)) {
            $modifiedColumns[':p' . $index++]  = 'threadId';
        }
        if ($this->isColumnModified(PostTableMap::COL_TITLE)) {
            $modifiedColumns[':p' . $index++]  = 'title';
        }
        if ($this->isColumnModified(PostTableMap::COL_TEXT)) {
            $modifiedColumns[':p' . $index++]  = 'text';
        }
        if ($this->isColumnModified(PostTableMap::COL_CREATEDAT)) {
            $modifiedColumns[':p' . $index++]  = 'createdAt';
        }
        if ($this->isColumnModified(PostTableMap::COL_USERID)) {
            $modifiedColumns[':p' . $index++]  = 'userId';
        }

        $sql = sprintf(
            'INSERT INTO post (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'uuid':
                        $stmt->bindValue($identifier, $this->uuid, PDO::PARAM_STR);
                        break;
                    case 'threadId':
                        $stmt->bindValue($identifier, $this->threadid, PDO::PARAM_INT);
                        break;
                    case 'title':
                        $stmt->bindValue($identifier, $this->title, PDO::PARAM_STR);
                        break;
                    case 'text':
                        $stmt->bindValue($identifier, $this->text, PDO::PARAM_STR);
                        break;
                    case 'createdAt':
                        $stmt->bindValue($identifier, $this->createdat ? $this->createdat->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'userId':
                        $stmt->bindValue($identifier, $this->userid, PDO::PARAM_INT);
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
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param ConnectionInterface $con
     *
     * @return int Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con): int
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param string $name name
     * @param string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName(string $name, string $type = TableMap::TYPE_PHPNAME)
    {
        $pos = PostTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos Position in XML schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition(int $pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();

            case 1:
                return $this->getUuid();

            case 2:
                return $this->getThreadid();

            case 3:
                return $this->getTitle();

            case 4:
                return $this->getText();

            case 5:
                return $this->getCreatedat();

            case 6:
                return $this->getUserid();

            default:
                return null;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param string $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param bool $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param bool $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array An associative array containing the field names (as keys) and field values
     */
    public function toArray(string $keyType = TableMap::TYPE_PHPNAME, bool $includeLazyLoadColumns = true, array $alreadyDumpedObjects = [], bool $includeForeignObjects = false): array
    {
        if (isset($alreadyDumpedObjects['Post'][$this->hashCode()])) {
            return ['*RECURSION*'];
        }
        $alreadyDumpedObjects['Post'][$this->hashCode()] = true;
        $keys = PostTableMap::getFieldNames($keyType);
        $result = [
            $keys[0] => $this->getId(),
            $keys[1] => $this->getUuid(),
            $keys[2] => $this->getThreadid(),
            $keys[3] => $this->getTitle(),
            $keys[4] => $this->getText(),
            $keys[5] => $this->getCreatedat(),
            $keys[6] => $this->getUserid(),
        ];
        if ($result[$keys[5]] instanceof \DateTimeInterface) {
            $result[$keys[5]] = $result[$keys[5]]->format('Y-m-d H:i:s.u');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aUser) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'user';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'user';
                        break;
                    default:
                        $key = 'User';
                }

                $result[$key] = $this->aUser->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aThreadRelatedByThreadid) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'thread';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'thread';
                        break;
                    default:
                        $key = 'Thread';
                }

                $result[$key] = $this->aThreadRelatedByThreadid->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collThreadsRelatedByPostid) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'threads';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'threads';
                        break;
                    default:
                        $key = 'Threads';
                }

                $result[$key] = $this->collThreadsRelatedByPostid->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collComments) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'comments';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'comments';
                        break;
                    default:
                        $key = 'Comments';
                }

                $result[$key] = $this->collComments->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param string $name
     * @param mixed $value field value
     * @param string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this
     */
    public function setByName(string $name, $value, string $type = TableMap::TYPE_PHPNAME)
    {
        $pos = PostTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        $this->setByPosition($pos, $value);

        return $this;
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @param mixed $value field value
     * @return $this
     */
    public function setByPosition(int $pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setUuid($value);
                break;
            case 2:
                $this->setThreadid($value);
                break;
            case 3:
                $this->setTitle($value);
                break;
            case 4:
                $this->setText($value);
                break;
            case 5:
                $this->setCreatedat($value);
                break;
            case 6:
                $this->setUserid($value);
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
     * @param array $arr An array to populate the object from.
     * @param string $keyType The type of keys the array uses.
     * @return $this
     */
    public function fromArray(array $arr, string $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = PostTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setUuid($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setThreadid($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setTitle($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setText($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setCreatedat($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setUserid($arr[$keys[6]]);
        }

        return $this;
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
     * @return $this The current object, for fluid interface
     */
    public function importFrom($parser, string $data, string $keyType = TableMap::TYPE_PHPNAME)
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
     * @return \Propel\Runtime\ActiveQuery\Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria(): Criteria
    {
        $criteria = new Criteria(PostTableMap::DATABASE_NAME);

        if ($this->isColumnModified(PostTableMap::COL_ID)) {
            $criteria->add(PostTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(PostTableMap::COL_UUID)) {
            $criteria->add(PostTableMap::COL_UUID, $this->uuid);
        }
        if ($this->isColumnModified(PostTableMap::COL_THREADID)) {
            $criteria->add(PostTableMap::COL_THREADID, $this->threadid);
        }
        if ($this->isColumnModified(PostTableMap::COL_TITLE)) {
            $criteria->add(PostTableMap::COL_TITLE, $this->title);
        }
        if ($this->isColumnModified(PostTableMap::COL_TEXT)) {
            $criteria->add(PostTableMap::COL_TEXT, $this->text);
        }
        if ($this->isColumnModified(PostTableMap::COL_CREATEDAT)) {
            $criteria->add(PostTableMap::COL_CREATEDAT, $this->createdat);
        }
        if ($this->isColumnModified(PostTableMap::COL_USERID)) {
            $criteria->add(PostTableMap::COL_USERID, $this->userid);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return \Propel\Runtime\ActiveQuery\Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria(): Criteria
    {
        $criteria = ChildPostQuery::create();
        $criteria->add(PostTableMap::COL_ID, $this->id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int|string Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getId();

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
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key): void
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     *
     * @return bool
     */
    public function isPrimaryKeyNull(): bool
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of \Model\Post (or compatible) type.
     * @param bool $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param bool $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws \Propel\Runtime\Exception\PropelException
     * @return void
     */
    public function copyInto(object $copyObj, bool $deepCopy = false, bool $makeNew = true): void
    {
        $copyObj->setUuid($this->getUuid());
        $copyObj->setThreadid($this->getThreadid());
        $copyObj->setTitle($this->getTitle());
        $copyObj->setText($this->getText());
        $copyObj->setCreatedat($this->getCreatedat());
        $copyObj->setUserid($this->getUserid());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getThreadsRelatedByPostid() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addThreadRelatedByPostid($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getComments() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addComment($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
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
     * @param bool $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \Model\Post Clone of current object.
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function copy(bool $deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Declares an association between this object and a ChildUser object.
     *
     * @param ChildUser $v
     * @return $this The current object (for fluent API support)
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function setUser(ChildUser $v = null)
    {
        if ($v === null) {
            $this->setUserid(NULL);
        } else {
            $this->setUserid($v->getId());
        }

        $this->aUser = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildUser object, it will not be re-added.
        if ($v !== null) {
            $v->addPost($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildUser object
     *
     * @param ConnectionInterface $con Optional Connection object.
     * @return ChildUser The associated ChildUser object.
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getUser(?ConnectionInterface $con = null)
    {
        if ($this->aUser === null && ($this->userid != 0)) {
            $this->aUser = ChildUserQuery::create()->findPk($this->userid, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aUser->addPosts($this);
             */
        }

        return $this->aUser;
    }

    /**
     * Declares an association between this object and a ChildThread object.
     *
     * @param ChildThread $v
     * @return $this The current object (for fluent API support)
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function setThreadRelatedByThreadid(ChildThread $v = null)
    {
        if ($v === null) {
            $this->setThreadid(NULL);
        } else {
            $this->setThreadid($v->getId());
        }

        $this->aThreadRelatedByThreadid = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildThread object, it will not be re-added.
        if ($v !== null) {
            $v->addPostRelatedByThreadid($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildThread object
     *
     * @param ConnectionInterface $con Optional Connection object.
     * @return ChildThread The associated ChildThread object.
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getThreadRelatedByThreadid(?ConnectionInterface $con = null)
    {
        if ($this->aThreadRelatedByThreadid === null && ($this->threadid != 0)) {
            $this->aThreadRelatedByThreadid = ChildThreadQuery::create()->findPk($this->threadid, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aThreadRelatedByThreadid->addPostsRelatedByThreadid($this);
             */
        }

        return $this->aThreadRelatedByThreadid;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('ThreadRelatedByPostid' === $relationName) {
            $this->initThreadsRelatedByPostid();
            return;
        }
        if ('Comment' === $relationName) {
            $this->initComments();
            return;
        }
    }

    /**
     * Clears out the collThreadsRelatedByPostid collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return $this
     * @see addThreadsRelatedByPostid()
     */
    public function clearThreadsRelatedByPostid()
    {
        $this->collThreadsRelatedByPostid = null; // important to set this to NULL since that means it is uninitialized

        return $this;
    }

    /**
     * Reset is the collThreadsRelatedByPostid collection loaded partially.
     */
    public function resetPartialThreadsRelatedByPostid($v = true)
    {
        $this->collThreadsRelatedByPostidPartial = $v;
    }

    /**
     * Initializes the collThreadsRelatedByPostid collection.
     *
     * By default this just sets the collThreadsRelatedByPostid collection to an empty array (like clearcollThreadsRelatedByPostid());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param bool $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initThreadsRelatedByPostid(bool $overrideExisting = true): void
    {
        if (null !== $this->collThreadsRelatedByPostid && !$overrideExisting) {
            return;
        }

        $collectionClassName = ThreadTableMap::getTableMap()->getCollectionClassName();

        $this->collThreadsRelatedByPostid = new $collectionClassName;
        $this->collThreadsRelatedByPostid->setModel('\Model\Thread');
    }

    /**
     * Gets an array of ChildThread objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPost is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildThread[] List of ChildThread objects
     * @phpstan-return ObjectCollection&\Traversable<ChildThread> List of ChildThread objects
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getThreadsRelatedByPostid(?Criteria $criteria = null, ?ConnectionInterface $con = null)
    {
        $partial = $this->collThreadsRelatedByPostidPartial && !$this->isNew();
        if (null === $this->collThreadsRelatedByPostid || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collThreadsRelatedByPostid) {
                    $this->initThreadsRelatedByPostid();
                } else {
                    $collectionClassName = ThreadTableMap::getTableMap()->getCollectionClassName();

                    $collThreadsRelatedByPostid = new $collectionClassName;
                    $collThreadsRelatedByPostid->setModel('\Model\Thread');

                    return $collThreadsRelatedByPostid;
                }
            } else {
                $collThreadsRelatedByPostid = ChildThreadQuery::create(null, $criteria)
                    ->filterByPostRelatedByPostid($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collThreadsRelatedByPostidPartial && count($collThreadsRelatedByPostid)) {
                        $this->initThreadsRelatedByPostid(false);

                        foreach ($collThreadsRelatedByPostid as $obj) {
                            if (false == $this->collThreadsRelatedByPostid->contains($obj)) {
                                $this->collThreadsRelatedByPostid->append($obj);
                            }
                        }

                        $this->collThreadsRelatedByPostidPartial = true;
                    }

                    return $collThreadsRelatedByPostid;
                }

                if ($partial && $this->collThreadsRelatedByPostid) {
                    foreach ($this->collThreadsRelatedByPostid as $obj) {
                        if ($obj->isNew()) {
                            $collThreadsRelatedByPostid[] = $obj;
                        }
                    }
                }

                $this->collThreadsRelatedByPostid = $collThreadsRelatedByPostid;
                $this->collThreadsRelatedByPostidPartial = false;
            }
        }

        return $this->collThreadsRelatedByPostid;
    }

    /**
     * Sets a collection of ChildThread objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param Collection $threadsRelatedByPostid A Propel collection.
     * @param ConnectionInterface $con Optional connection object
     * @return $this The current object (for fluent API support)
     */
    public function setThreadsRelatedByPostid(Collection $threadsRelatedByPostid, ?ConnectionInterface $con = null)
    {
        /** @var ChildThread[] $threadsRelatedByPostidToDelete */
        $threadsRelatedByPostidToDelete = $this->getThreadsRelatedByPostid(new Criteria(), $con)->diff($threadsRelatedByPostid);


        $this->threadsRelatedByPostidScheduledForDeletion = $threadsRelatedByPostidToDelete;

        foreach ($threadsRelatedByPostidToDelete as $threadRelatedByPostidRemoved) {
            $threadRelatedByPostidRemoved->setPostRelatedByPostid(null);
        }

        $this->collThreadsRelatedByPostid = null;
        foreach ($threadsRelatedByPostid as $threadRelatedByPostid) {
            $this->addThreadRelatedByPostid($threadRelatedByPostid);
        }

        $this->collThreadsRelatedByPostid = $threadsRelatedByPostid;
        $this->collThreadsRelatedByPostidPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Thread objects.
     *
     * @param Criteria $criteria
     * @param bool $distinct
     * @param ConnectionInterface $con
     * @return int Count of related Thread objects.
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function countThreadsRelatedByPostid(?Criteria $criteria = null, bool $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collThreadsRelatedByPostidPartial && !$this->isNew();
        if (null === $this->collThreadsRelatedByPostid || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collThreadsRelatedByPostid) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getThreadsRelatedByPostid());
            }

            $query = ChildThreadQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPostRelatedByPostid($this)
                ->count($con);
        }

        return count($this->collThreadsRelatedByPostid);
    }

    /**
     * Method called to associate a ChildThread object to this object
     * through the ChildThread foreign key attribute.
     *
     * @param ChildThread $l ChildThread
     * @return $this The current object (for fluent API support)
     */
    public function addThreadRelatedByPostid(ChildThread $l)
    {
        if ($this->collThreadsRelatedByPostid === null) {
            $this->initThreadsRelatedByPostid();
            $this->collThreadsRelatedByPostidPartial = true;
        }

        if (!$this->collThreadsRelatedByPostid->contains($l)) {
            $this->doAddThreadRelatedByPostid($l);

            if ($this->threadsRelatedByPostidScheduledForDeletion and $this->threadsRelatedByPostidScheduledForDeletion->contains($l)) {
                $this->threadsRelatedByPostidScheduledForDeletion->remove($this->threadsRelatedByPostidScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildThread $threadRelatedByPostid The ChildThread object to add.
     */
    protected function doAddThreadRelatedByPostid(ChildThread $threadRelatedByPostid)
    {
        $this->collThreadsRelatedByPostid[]= $threadRelatedByPostid;
        $threadRelatedByPostid->setPostRelatedByPostid($this);
    }

    /**
     * @param ChildThread $threadRelatedByPostid The ChildThread object to remove.
     * @return $this The current object (for fluent API support)
     */
    public function removeThreadRelatedByPostid(ChildThread $threadRelatedByPostid)
    {
        if ($this->getThreadsRelatedByPostid()->contains($threadRelatedByPostid)) {
            $pos = $this->collThreadsRelatedByPostid->search($threadRelatedByPostid);
            $this->collThreadsRelatedByPostid->remove($pos);
            if (null === $this->threadsRelatedByPostidScheduledForDeletion) {
                $this->threadsRelatedByPostidScheduledForDeletion = clone $this->collThreadsRelatedByPostid;
                $this->threadsRelatedByPostidScheduledForDeletion->clear();
            }
            $this->threadsRelatedByPostidScheduledForDeletion[]= clone $threadRelatedByPostid;
            $threadRelatedByPostid->setPostRelatedByPostid(null);
        }

        return $this;
    }

    /**
     * Clears out the collComments collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return $this
     * @see addComments()
     */
    public function clearComments()
    {
        $this->collComments = null; // important to set this to NULL since that means it is uninitialized

        return $this;
    }

    /**
     * Reset is the collComments collection loaded partially.
     */
    public function resetPartialComments($v = true)
    {
        $this->collCommentsPartial = $v;
    }

    /**
     * Initializes the collComments collection.
     *
     * By default this just sets the collComments collection to an empty array (like clearcollComments());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param bool $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initComments(bool $overrideExisting = true): void
    {
        if (null !== $this->collComments && !$overrideExisting) {
            return;
        }

        $collectionClassName = CommentTableMap::getTableMap()->getCollectionClassName();

        $this->collComments = new $collectionClassName;
        $this->collComments->setModel('\Model\Comment');
    }

    /**
     * Gets an array of ChildComment objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPost is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildComment[] List of ChildComment objects
     * @phpstan-return ObjectCollection&\Traversable<ChildComment> List of ChildComment objects
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getComments(?Criteria $criteria = null, ?ConnectionInterface $con = null)
    {
        $partial = $this->collCommentsPartial && !$this->isNew();
        if (null === $this->collComments || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collComments) {
                    $this->initComments();
                } else {
                    $collectionClassName = CommentTableMap::getTableMap()->getCollectionClassName();

                    $collComments = new $collectionClassName;
                    $collComments->setModel('\Model\Comment');

                    return $collComments;
                }
            } else {
                $collComments = ChildCommentQuery::create(null, $criteria)
                    ->filterByPost($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collCommentsPartial && count($collComments)) {
                        $this->initComments(false);

                        foreach ($collComments as $obj) {
                            if (false == $this->collComments->contains($obj)) {
                                $this->collComments->append($obj);
                            }
                        }

                        $this->collCommentsPartial = true;
                    }

                    return $collComments;
                }

                if ($partial && $this->collComments) {
                    foreach ($this->collComments as $obj) {
                        if ($obj->isNew()) {
                            $collComments[] = $obj;
                        }
                    }
                }

                $this->collComments = $collComments;
                $this->collCommentsPartial = false;
            }
        }

        return $this->collComments;
    }

    /**
     * Sets a collection of ChildComment objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param Collection $comments A Propel collection.
     * @param ConnectionInterface $con Optional connection object
     * @return $this The current object (for fluent API support)
     */
    public function setComments(Collection $comments, ?ConnectionInterface $con = null)
    {
        /** @var ChildComment[] $commentsToDelete */
        $commentsToDelete = $this->getComments(new Criteria(), $con)->diff($comments);


        $this->commentsScheduledForDeletion = $commentsToDelete;

        foreach ($commentsToDelete as $commentRemoved) {
            $commentRemoved->setPost(null);
        }

        $this->collComments = null;
        foreach ($comments as $comment) {
            $this->addComment($comment);
        }

        $this->collComments = $comments;
        $this->collCommentsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Comment objects.
     *
     * @param Criteria $criteria
     * @param bool $distinct
     * @param ConnectionInterface $con
     * @return int Count of related Comment objects.
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function countComments(?Criteria $criteria = null, bool $distinct = false, ?ConnectionInterface $con = null): int
    {
        $partial = $this->collCommentsPartial && !$this->isNew();
        if (null === $this->collComments || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collComments) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getComments());
            }

            $query = ChildCommentQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPost($this)
                ->count($con);
        }

        return count($this->collComments);
    }

    /**
     * Method called to associate a ChildComment object to this object
     * through the ChildComment foreign key attribute.
     *
     * @param ChildComment $l ChildComment
     * @return $this The current object (for fluent API support)
     */
    public function addComment(ChildComment $l)
    {
        if ($this->collComments === null) {
            $this->initComments();
            $this->collCommentsPartial = true;
        }

        if (!$this->collComments->contains($l)) {
            $this->doAddComment($l);

            if ($this->commentsScheduledForDeletion and $this->commentsScheduledForDeletion->contains($l)) {
                $this->commentsScheduledForDeletion->remove($this->commentsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildComment $comment The ChildComment object to add.
     */
    protected function doAddComment(ChildComment $comment)
    {
        $this->collComments[]= $comment;
        $comment->setPost($this);
    }

    /**
     * @param ChildComment $comment The ChildComment object to remove.
     * @return $this The current object (for fluent API support)
     */
    public function removeComment(ChildComment $comment)
    {
        if ($this->getComments()->contains($comment)) {
            $pos = $this->collComments->search($comment);
            $this->collComments->remove($pos);
            if (null === $this->commentsScheduledForDeletion) {
                $this->commentsScheduledForDeletion = clone $this->collComments;
                $this->commentsScheduledForDeletion->clear();
            }
            $this->commentsScheduledForDeletion[]= clone $comment;
            $comment->setPost(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Post is new, it will return
     * an empty collection; or if this Post has previously
     * been saved, it will retrieve related Comments from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Post.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param ConnectionInterface $con optional connection object
     * @param string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildComment[] List of ChildComment objects
     * @phpstan-return ObjectCollection&\Traversable<ChildComment}> List of ChildComment objects
     */
    public function getCommentsJoinUser(?Criteria $criteria = null, ?ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCommentQuery::create(null, $criteria);
        $query->joinWith('User', $joinBehavior);

        return $this->getComments($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     *
     * @return $this
     */
    public function clear()
    {
        if (null !== $this->aUser) {
            $this->aUser->removePost($this);
        }
        if (null !== $this->aThreadRelatedByThreadid) {
            $this->aThreadRelatedByThreadid->removePostRelatedByThreadid($this);
        }
        $this->id = null;
        $this->uuid = null;
        $this->threadid = null;
        $this->title = null;
        $this->text = null;
        $this->createdat = null;
        $this->userid = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);

        return $this;
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param bool $deep Whether to also clear the references on all referrer objects.
     * @return $this
     */
    public function clearAllReferences(bool $deep = false)
    {
        if ($deep) {
            if ($this->collThreadsRelatedByPostid) {
                foreach ($this->collThreadsRelatedByPostid as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collComments) {
                foreach ($this->collComments as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collThreadsRelatedByPostid = null;
        $this->collComments = null;
        $this->aUser = null;
        $this->aThreadRelatedByThreadid = null;
        return $this;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(PostTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param ConnectionInterface|null $con
     * @return bool
     */
    public function preSave(?ConnectionInterface $con = null)
    {
                return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface|null $con
     * @return void
     */
    public function postSave(?ConnectionInterface $con = null): void
    {
            }

    /**
     * Code to be run before inserting to database
     * @param ConnectionInterface|null $con
     * @return bool
     */
    public function preInsert(?ConnectionInterface $con = null)
    {
                return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface|null $con
     * @return void
     */
    public function postInsert(?ConnectionInterface $con = null): void
    {
            }

    /**
     * Code to be run before updating the object in database
     * @param ConnectionInterface|null $con
     * @return bool
     */
    public function preUpdate(?ConnectionInterface $con = null)
    {
                return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface|null $con
     * @return void
     */
    public function postUpdate(?ConnectionInterface $con = null): void
    {
            }

    /**
     * Code to be run before deleting the object in database
     * @param ConnectionInterface|null $con
     * @return bool
     */
    public function preDelete(?ConnectionInterface $con = null)
    {
                return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface|null $con
     * @return void
     */
    public function postDelete(?ConnectionInterface $con = null): void
    {
            }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed $params
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
            $inputData = $params[0];
            $keyType = $params[1] ?? TableMap::TYPE_PHPNAME;

            return $this->importFrom($format, $inputData, $keyType);
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = $params[0] ?? true;
            $keyType = $params[1] ?? TableMap::TYPE_PHPNAME;

            return $this->exportTo($format, $includeLazyLoadColumns, $keyType);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
