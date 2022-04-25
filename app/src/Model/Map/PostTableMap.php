<?php

namespace Model\Map;

use Model\Post;
use Model\PostQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'post' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class PostTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    public const CLASS_NAME = 'Model.Map.PostTableMap';

    /**
     * The default database name for this class
     */
    public const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    public const TABLE_NAME = 'post';

    /**
     * The related Propel class for this table
     */
    public const OM_CLASS = '\\Model\\Post';

    /**
     * A class that can be returned by this tableMap
     */
    public const CLASS_DEFAULT = 'Model.Post';

    /**
     * The total number of columns
     */
    public const NUM_COLUMNS = 7;

    /**
     * The number of lazy-loaded columns
     */
    public const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    public const NUM_HYDRATE_COLUMNS = 7;

    /**
     * the column name for the id field
     */
    public const COL_ID = 'post.id';

    /**
     * the column name for the uid field
     */
    public const COL_UID = 'post.uid';

    /**
     * the column name for the title field
     */
    public const COL_TITLE = 'post.title';

    /**
     * the column name for the text field
     */
    public const COL_TEXT = 'post.text';

    /**
     * the column name for the createdAt field
     */
    public const COL_CREATEDAT = 'post.createdAt';

    /**
     * the column name for the threadId field
     */
    public const COL_THREADID = 'post.threadId';

    /**
     * the column name for the userId field
     */
    public const COL_USERID = 'post.userId';

    /**
     * The default string format for model objects of the related table
     */
    public const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     *
     * @var array<string, mixed>
     */
    protected static $fieldNames = [
        self::TYPE_PHPNAME       => ['Id', 'Uid', 'Title', 'Text', 'Createdat', 'Threadid', 'Userid', ],
        self::TYPE_CAMELNAME     => ['id', 'uid', 'title', 'text', 'createdat', 'threadid', 'userid', ],
        self::TYPE_COLNAME       => [PostTableMap::COL_ID, PostTableMap::COL_UID, PostTableMap::COL_TITLE, PostTableMap::COL_TEXT, PostTableMap::COL_CREATEDAT, PostTableMap::COL_THREADID, PostTableMap::COL_USERID, ],
        self::TYPE_FIELDNAME     => ['id', 'uid', 'title', 'text', 'createdAt', 'threadId', 'userId', ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, 6, ]
    ];

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     *
     * @var array<string, mixed>
     */
    protected static $fieldKeys = [
        self::TYPE_PHPNAME       => ['Id' => 0, 'Uid' => 1, 'Title' => 2, 'Text' => 3, 'Createdat' => 4, 'Threadid' => 5, 'Userid' => 6, ],
        self::TYPE_CAMELNAME     => ['id' => 0, 'uid' => 1, 'title' => 2, 'text' => 3, 'createdat' => 4, 'threadid' => 5, 'userid' => 6, ],
        self::TYPE_COLNAME       => [PostTableMap::COL_ID => 0, PostTableMap::COL_UID => 1, PostTableMap::COL_TITLE => 2, PostTableMap::COL_TEXT => 3, PostTableMap::COL_CREATEDAT => 4, PostTableMap::COL_THREADID => 5, PostTableMap::COL_USERID => 6, ],
        self::TYPE_FIELDNAME     => ['id' => 0, 'uid' => 1, 'title' => 2, 'text' => 3, 'createdAt' => 4, 'threadId' => 5, 'userId' => 6, ],
        self::TYPE_NUM           => [0, 1, 2, 3, 4, 5, 6, ]
    ];

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var array<string>
     */
    protected $normalizedColumnNameMap = [
        'Id' => 'ID',
        'Post.Id' => 'ID',
        'id' => 'ID',
        'post.id' => 'ID',
        'PostTableMap::COL_ID' => 'ID',
        'COL_ID' => 'ID',
        'Uid' => 'UID',
        'Post.Uid' => 'UID',
        'uid' => 'UID',
        'post.uid' => 'UID',
        'PostTableMap::COL_UID' => 'UID',
        'COL_UID' => 'UID',
        'Title' => 'TITLE',
        'Post.Title' => 'TITLE',
        'title' => 'TITLE',
        'post.title' => 'TITLE',
        'PostTableMap::COL_TITLE' => 'TITLE',
        'COL_TITLE' => 'TITLE',
        'Text' => 'TEXT',
        'Post.Text' => 'TEXT',
        'text' => 'TEXT',
        'post.text' => 'TEXT',
        'PostTableMap::COL_TEXT' => 'TEXT',
        'COL_TEXT' => 'TEXT',
        'Createdat' => 'CREATEDAT',
        'Post.Createdat' => 'CREATEDAT',
        'createdat' => 'CREATEDAT',
        'post.createdat' => 'CREATEDAT',
        'PostTableMap::COL_CREATEDAT' => 'CREATEDAT',
        'COL_CREATEDAT' => 'CREATEDAT',
        'createdAt' => 'CREATEDAT',
        'post.createdAt' => 'CREATEDAT',
        'Threadid' => 'THREADID',
        'Post.Threadid' => 'THREADID',
        'threadid' => 'THREADID',
        'post.threadid' => 'THREADID',
        'PostTableMap::COL_THREADID' => 'THREADID',
        'COL_THREADID' => 'THREADID',
        'threadId' => 'THREADID',
        'post.threadId' => 'THREADID',
        'Userid' => 'USERID',
        'Post.Userid' => 'USERID',
        'userid' => 'USERID',
        'post.userid' => 'USERID',
        'PostTableMap::COL_USERID' => 'USERID',
        'COL_USERID' => 'USERID',
        'userId' => 'USERID',
        'post.userId' => 'USERID',
    ];

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function initialize(): void
    {
        // attributes
        $this->setName('post');
        $this->setPhpName('Post');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Model\\Post');
        $this->setPackage('Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('uid', 'Uid', 'CHAR', true, 39, null);
        $this->addColumn('title', 'Title', 'VARCHAR', true, 140, null);
        $this->addColumn('text', 'Text', 'LONGVARCHAR', true, null, null);
        $this->addColumn('createdAt', 'Createdat', 'TIMESTAMP', true, null, null);
        $this->addForeignKey('threadId', 'Threadid', 'INTEGER', 'thread', 'id', true, null, null);
        $this->addForeignKey('userId', 'Userid', 'INTEGER', 'user', 'id', true, null, null);
    }

    /**
     * Build the RelationMap objects for this table relationships
     *
     * @return void
     */
    public function buildRelations(): void
    {
        $this->addRelation('User', '\\Model\\User', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':userId',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('Thread', '\\Model\\Thread', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':threadId',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('Comment', '\\Model\\Comment', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':postId',
    1 => ':id',
  ),
), null, null, 'Comments', false);
        $this->addRelation('Vote', '\\Model\\Vote', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':postId',
    1 => ':id',
  ),
), null, null, 'Votes', false);
    }

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array $row Resultset row.
     * @param int $offset The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string|null The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): ?string
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array $row Resultset row.
     * @param int $offset The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param bool $withPrefix Whether to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass(bool $withPrefix = true): string
    {
        return $withPrefix ? PostTableMap::CLASS_DEFAULT : PostTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array $row Row returned by DataFetcher->fetch().
     * @param int $offset The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array (Post object, last column rank)
     */
    public static function populateObject(array $row, int $offset = 0, string $indexType = TableMap::TYPE_NUM): array
    {
        $key = PostTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = PostTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + PostTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PostTableMap::OM_CLASS;
            /** @var Post $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            PostTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array<object>
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher): array
    {
        $results = [];

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = PostTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = PostTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Post $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                PostTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria Object containing the columns to add.
     * @param string|null $alias Optional table alias
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return void
     */
    public static function addSelectColumns(Criteria $criteria, ?string $alias = null): void
    {
        if (null === $alias) {
            $criteria->addSelectColumn(PostTableMap::COL_ID);
            $criteria->addSelectColumn(PostTableMap::COL_UID);
            $criteria->addSelectColumn(PostTableMap::COL_TITLE);
            $criteria->addSelectColumn(PostTableMap::COL_TEXT);
            $criteria->addSelectColumn(PostTableMap::COL_CREATEDAT);
            $criteria->addSelectColumn(PostTableMap::COL_THREADID);
            $criteria->addSelectColumn(PostTableMap::COL_USERID);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.uid');
            $criteria->addSelectColumn($alias . '.title');
            $criteria->addSelectColumn($alias . '.text');
            $criteria->addSelectColumn($alias . '.createdAt');
            $criteria->addSelectColumn($alias . '.threadId');
            $criteria->addSelectColumn($alias . '.userId');
        }
    }

    /**
     * Remove all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be removed as they are only loaded on demand.
     *
     * @param Criteria $criteria Object containing the columns to remove.
     * @param string|null $alias Optional table alias
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return void
     */
    public static function removeSelectColumns(Criteria $criteria, ?string $alias = null): void
    {
        if (null === $alias) {
            $criteria->removeSelectColumn(PostTableMap::COL_ID);
            $criteria->removeSelectColumn(PostTableMap::COL_UID);
            $criteria->removeSelectColumn(PostTableMap::COL_TITLE);
            $criteria->removeSelectColumn(PostTableMap::COL_TEXT);
            $criteria->removeSelectColumn(PostTableMap::COL_CREATEDAT);
            $criteria->removeSelectColumn(PostTableMap::COL_THREADID);
            $criteria->removeSelectColumn(PostTableMap::COL_USERID);
        } else {
            $criteria->removeSelectColumn($alias . '.id');
            $criteria->removeSelectColumn($alias . '.uid');
            $criteria->removeSelectColumn($alias . '.title');
            $criteria->removeSelectColumn($alias . '.text');
            $criteria->removeSelectColumn($alias . '.createdAt');
            $criteria->removeSelectColumn($alias . '.threadId');
            $criteria->removeSelectColumn($alias . '.userId');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap(): TableMap
    {
        return Propel::getServiceContainer()->getDatabaseMap(PostTableMap::DATABASE_NAME)->getTable(PostTableMap::TABLE_NAME);
    }

    /**
     * Performs a DELETE on the database, given a Post or Criteria object OR a primary key value.
     *
     * @param mixed $values Criteria or Post object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ?ConnectionInterface $con = null): int
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PostTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Model\Post) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PostTableMap::DATABASE_NAME);
            $criteria->add(PostTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = PostQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            PostTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                PostTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the post table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(?ConnectionInterface $con = null): int
    {
        return PostQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Post or Criteria object.
     *
     * @param mixed $criteria Criteria or Post object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed The new primary key.
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ?ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PostTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Post object
        }

        if ($criteria->containsKey(PostTableMap::COL_ID) && $criteria->keyContainsValue(PostTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.PostTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = PostQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

}
