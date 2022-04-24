<?php

namespace Model\Base;

use \Exception;
use \PDO;
use Model\Comment as ChildComment;
use Model\CommentQuery as ChildCommentQuery;
use Model\Map\CommentTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'comment' table.
 *
 *
 *
 * @method     ChildCommentQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildCommentQuery orderByUuid($order = Criteria::ASC) Order by the uuid column
 * @method     ChildCommentQuery orderByText($order = Criteria::ASC) Order by the text column
 * @method     ChildCommentQuery orderByCreatedat($order = Criteria::ASC) Order by the createdAt column
 * @method     ChildCommentQuery orderByPostid($order = Criteria::ASC) Order by the postId column
 * @method     ChildCommentQuery orderByUserid($order = Criteria::ASC) Order by the userId column
 *
 * @method     ChildCommentQuery groupById() Group by the id column
 * @method     ChildCommentQuery groupByUuid() Group by the uuid column
 * @method     ChildCommentQuery groupByText() Group by the text column
 * @method     ChildCommentQuery groupByCreatedat() Group by the createdAt column
 * @method     ChildCommentQuery groupByPostid() Group by the postId column
 * @method     ChildCommentQuery groupByUserid() Group by the userId column
 *
 * @method     ChildCommentQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCommentQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCommentQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCommentQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildCommentQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildCommentQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildCommentQuery leftJoinPost($relationAlias = null) Adds a LEFT JOIN clause to the query using the Post relation
 * @method     ChildCommentQuery rightJoinPost($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Post relation
 * @method     ChildCommentQuery innerJoinPost($relationAlias = null) Adds a INNER JOIN clause to the query using the Post relation
 *
 * @method     ChildCommentQuery joinWithPost($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Post relation
 *
 * @method     ChildCommentQuery leftJoinWithPost() Adds a LEFT JOIN clause and with to the query using the Post relation
 * @method     ChildCommentQuery rightJoinWithPost() Adds a RIGHT JOIN clause and with to the query using the Post relation
 * @method     ChildCommentQuery innerJoinWithPost() Adds a INNER JOIN clause and with to the query using the Post relation
 *
 * @method     ChildCommentQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method     ChildCommentQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method     ChildCommentQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method     ChildCommentQuery joinWithUser($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the User relation
 *
 * @method     ChildCommentQuery leftJoinWithUser() Adds a LEFT JOIN clause and with to the query using the User relation
 * @method     ChildCommentQuery rightJoinWithUser() Adds a RIGHT JOIN clause and with to the query using the User relation
 * @method     ChildCommentQuery innerJoinWithUser() Adds a INNER JOIN clause and with to the query using the User relation
 *
 * @method     \Model\PostQuery|\Model\UserQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildComment|null findOne(?ConnectionInterface $con = null) Return the first ChildComment matching the query
 * @method     ChildComment findOneOrCreate(?ConnectionInterface $con = null) Return the first ChildComment matching the query, or a new ChildComment object populated from the query conditions when no match is found
 *
 * @method     ChildComment|null findOneById(int $id) Return the first ChildComment filtered by the id column
 * @method     ChildComment|null findOneByUuid(string $uuid) Return the first ChildComment filtered by the uuid column
 * @method     ChildComment|null findOneByText(string $text) Return the first ChildComment filtered by the text column
 * @method     ChildComment|null findOneByCreatedat(string $createdAt) Return the first ChildComment filtered by the createdAt column
 * @method     ChildComment|null findOneByPostid(int $postId) Return the first ChildComment filtered by the postId column
 * @method     ChildComment|null findOneByUserid(int $userId) Return the first ChildComment filtered by the userId column *

 * @method     ChildComment requirePk($key, ?ConnectionInterface $con = null) Return the ChildComment by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildComment requireOne(?ConnectionInterface $con = null) Return the first ChildComment matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildComment requireOneById(int $id) Return the first ChildComment filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildComment requireOneByUuid(string $uuid) Return the first ChildComment filtered by the uuid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildComment requireOneByText(string $text) Return the first ChildComment filtered by the text column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildComment requireOneByCreatedat(string $createdAt) Return the first ChildComment filtered by the createdAt column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildComment requireOneByPostid(int $postId) Return the first ChildComment filtered by the postId column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildComment requireOneByUserid(int $userId) Return the first ChildComment filtered by the userId column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildComment[]|ObjectCollection find(?ConnectionInterface $con = null) Return ChildComment objects based on current ModelCriteria
 * @psalm-method ObjectCollection&\Traversable<ChildComment> find(?ConnectionInterface $con = null) Return ChildComment objects based on current ModelCriteria
 * @method     ChildComment[]|ObjectCollection findById(int $id) Return ChildComment objects filtered by the id column
 * @psalm-method ObjectCollection&\Traversable<ChildComment> findById(int $id) Return ChildComment objects filtered by the id column
 * @method     ChildComment[]|ObjectCollection findByUuid(string $uuid) Return ChildComment objects filtered by the uuid column
 * @psalm-method ObjectCollection&\Traversable<ChildComment> findByUuid(string $uuid) Return ChildComment objects filtered by the uuid column
 * @method     ChildComment[]|ObjectCollection findByText(string $text) Return ChildComment objects filtered by the text column
 * @psalm-method ObjectCollection&\Traversable<ChildComment> findByText(string $text) Return ChildComment objects filtered by the text column
 * @method     ChildComment[]|ObjectCollection findByCreatedat(string $createdAt) Return ChildComment objects filtered by the createdAt column
 * @psalm-method ObjectCollection&\Traversable<ChildComment> findByCreatedat(string $createdAt) Return ChildComment objects filtered by the createdAt column
 * @method     ChildComment[]|ObjectCollection findByPostid(int $postId) Return ChildComment objects filtered by the postId column
 * @psalm-method ObjectCollection&\Traversable<ChildComment> findByPostid(int $postId) Return ChildComment objects filtered by the postId column
 * @method     ChildComment[]|ObjectCollection findByUserid(int $userId) Return ChildComment objects filtered by the userId column
 * @psalm-method ObjectCollection&\Traversable<ChildComment> findByUserid(int $userId) Return ChildComment objects filtered by the userId column
 * @method     ChildComment[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 * @psalm-method \Propel\Runtime\Util\PropelModelPager&\Traversable<ChildComment> paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class CommentQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Model\Base\CommentQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Model\\Comment', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCommentQuery object.
     *
     * @param string $modelAlias The alias of a model in the query
     * @param Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCommentQuery
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildCommentQuery) {
            return $criteria;
        }
        $query = new ChildCommentQuery();
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
     * @return ChildComment|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CommentTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = CommentTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
            // the object is already in the instance pool
            return $obj;
        }

        return $this->findPkSimple($key, $con);
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildComment A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, uuid, text, createdAt, postId, userId FROM comment WHERE id = :p0';
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
            /** @var ChildComment $obj */
            $obj = new ChildComment();
            $obj->hydrate($row);
            CommentTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con A connection object
     *
     * @return ChildComment|array|mixed the result, formatted by the current formatter
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
     * @param array $keys Primary keys to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ?ConnectionInterface $con = null)
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
     * @param mixed $key Primary key to use for the query
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        $this->addUsingAlias(CommentTableMap::COL_ID, $key, Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param array|int $keys The list of primary key to use for the query
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        $this->addUsingAlias(CommentTableMap::COL_ID, $keys, Criteria::IN);

        return $this;
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterById($id = null, ?string $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(CommentTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(CommentTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(CommentTableMap::COL_ID, $id, $comparison);

        return $this;
    }

    /**
     * Filter the query on the uuid column
     *
     * Example usage:
     * <code>
     * $query->filterByUuid('fooValue');   // WHERE uuid = 'fooValue'
     * $query->filterByUuid('%fooValue%', Criteria::LIKE); // WHERE uuid LIKE '%fooValue%'
     * $query->filterByUuid(['foo', 'bar']); // WHERE uuid IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $uuid The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByUuid($uuid = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($uuid)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(CommentTableMap::COL_UUID, $uuid, $comparison);

        return $this;
    }

    /**
     * Filter the query on the text column
     *
     * Example usage:
     * <code>
     * $query->filterByText('fooValue');   // WHERE text = 'fooValue'
     * $query->filterByText('%fooValue%', Criteria::LIKE); // WHERE text LIKE '%fooValue%'
     * $query->filterByText(['foo', 'bar']); // WHERE text IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $text The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByText($text = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($text)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(CommentTableMap::COL_TEXT, $text, $comparison);

        return $this;
    }

    /**
     * Filter the query on the createdAt column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatedat('2011-03-14'); // WHERE createdAt = '2011-03-14'
     * $query->filterByCreatedat('now'); // WHERE createdAt = '2011-03-14'
     * $query->filterByCreatedat(array('max' => 'yesterday')); // WHERE createdAt > '2011-03-13'
     * </code>
     *
     * @param mixed $createdat The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByCreatedat($createdat = null, ?string $comparison = null)
    {
        if (is_array($createdat)) {
            $useMinMax = false;
            if (isset($createdat['min'])) {
                $this->addUsingAlias(CommentTableMap::COL_CREATEDAT, $createdat['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdat['max'])) {
                $this->addUsingAlias(CommentTableMap::COL_CREATEDAT, $createdat['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(CommentTableMap::COL_CREATEDAT, $createdat, $comparison);

        return $this;
    }

    /**
     * Filter the query on the postId column
     *
     * Example usage:
     * <code>
     * $query->filterByPostid(1234); // WHERE postId = 1234
     * $query->filterByPostid(array(12, 34)); // WHERE postId IN (12, 34)
     * $query->filterByPostid(array('min' => 12)); // WHERE postId > 12
     * </code>
     *
     * @see       filterByPost()
     *
     * @param mixed $postid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByPostid($postid = null, ?string $comparison = null)
    {
        if (is_array($postid)) {
            $useMinMax = false;
            if (isset($postid['min'])) {
                $this->addUsingAlias(CommentTableMap::COL_POSTID, $postid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($postid['max'])) {
                $this->addUsingAlias(CommentTableMap::COL_POSTID, $postid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(CommentTableMap::COL_POSTID, $postid, $comparison);

        return $this;
    }

    /**
     * Filter the query on the userId column
     *
     * Example usage:
     * <code>
     * $query->filterByUserid(1234); // WHERE userId = 1234
     * $query->filterByUserid(array(12, 34)); // WHERE userId IN (12, 34)
     * $query->filterByUserid(array('min' => 12)); // WHERE userId > 12
     * </code>
     *
     * @see       filterByUser()
     *
     * @param mixed $userid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByUserid($userid = null, ?string $comparison = null)
    {
        if (is_array($userid)) {
            $useMinMax = false;
            if (isset($userid['min'])) {
                $this->addUsingAlias(CommentTableMap::COL_USERID, $userid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userid['max'])) {
                $this->addUsingAlias(CommentTableMap::COL_USERID, $userid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(CommentTableMap::COL_USERID, $userid, $comparison);

        return $this;
    }

    /**
     * Filter the query by a related \Model\Post object
     *
     * @param \Model\Post|ObjectCollection $post The related object(s) to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByPost($post, ?string $comparison = null)
    {
        if ($post instanceof \Model\Post) {
            return $this
                ->addUsingAlias(CommentTableMap::COL_POSTID, $post->getId(), $comparison);
        } elseif ($post instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingAlias(CommentTableMap::COL_POSTID, $post->toKeyValue('PrimaryKey', 'Id'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByPost() only accepts arguments of type \Model\Post or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Post relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinPost(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Post');

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
            $this->addJoinObject($join, 'Post');
        }

        return $this;
    }

    /**
     * Use the Post relation Post object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Model\PostQuery A secondary query class using the current class as primary query
     */
    public function usePostQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPost($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Post', '\Model\PostQuery');
    }

    /**
     * Use the Post relation Post object
     *
     * @param callable(\Model\PostQuery):\Model\PostQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withPostQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->usePostQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }
    /**
     * Use the relation to Post table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string $typeOfExists Either ExistsCriterion::TYPE_EXISTS or ExistsCriterion::TYPE_NOT_EXISTS
     *
     * @return \Model\PostQuery The inner query object of the EXISTS statement
     */
    public function usePostExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        return $this->useExistsQuery('Post', $modelAlias, $queryClass, $typeOfExists);
    }

    /**
     * Use the relation to Post table for a NOT EXISTS query.
     *
     * @see usePostExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Model\PostQuery The inner query object of the NOT EXISTS statement
     */
    public function usePostNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        return $this->useExistsQuery('Post', $modelAlias, $queryClass, 'NOT EXISTS');
    }
    /**
     * Filter the query by a related \Model\User object
     *
     * @param \Model\User|ObjectCollection $user The related object(s) to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByUser($user, ?string $comparison = null)
    {
        if ($user instanceof \Model\User) {
            return $this
                ->addUsingAlias(CommentTableMap::COL_USERID, $user->getId(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingAlias(CommentTableMap::COL_USERID, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByUser() only accepts arguments of type \Model\User or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the User relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinUser(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('User');

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
            $this->addJoinObject($join, 'User');
        }

        return $this;
    }

    /**
     * Use the User relation User object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Model\UserQuery A secondary query class using the current class as primary query
     */
    public function useUserQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUser($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'User', '\Model\UserQuery');
    }

    /**
     * Use the User relation User object
     *
     * @param callable(\Model\UserQuery):\Model\UserQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withUserQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->useUserQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }
    /**
     * Use the relation to User table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string $typeOfExists Either ExistsCriterion::TYPE_EXISTS or ExistsCriterion::TYPE_NOT_EXISTS
     *
     * @return \Model\UserQuery The inner query object of the EXISTS statement
     */
    public function useUserExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        return $this->useExistsQuery('User', $modelAlias, $queryClass, $typeOfExists);
    }

    /**
     * Use the relation to User table for a NOT EXISTS query.
     *
     * @see useUserExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Model\UserQuery The inner query object of the NOT EXISTS statement
     */
    public function useUserNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        return $this->useExistsQuery('User', $modelAlias, $queryClass, 'NOT EXISTS');
    }
    /**
     * Exclude object from result
     *
     * @param ChildComment $comment Object to remove from the list of results
     *
     * @return $this The current query, for fluid interface
     */
    public function prune($comment = null)
    {
        if ($comment) {
            $this->addUsingAlias(CommentTableMap::COL_ID, $comment->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the comment table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CommentTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CommentTableMap::clearInstancePool();
            CommentTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws \Propel\Runtime\Exception\PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(?ConnectionInterface $con = null): int
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CommentTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CommentTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            CommentTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            CommentTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

}
