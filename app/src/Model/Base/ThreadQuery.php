<?php

namespace Model\Base;

use \Exception;
use \PDO;
use Model\Thread as ChildThread;
use Model\ThreadQuery as ChildThreadQuery;
use Model\Map\ThreadTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'thread' table.
 *
 *
 *
 * @method     ChildThreadQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildThreadQuery orderByUuid($order = Criteria::ASC) Order by the uuid column
 * @method     ChildThreadQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildThreadQuery orderByPostid($order = Criteria::ASC) Order by the postId column
 *
 * @method     ChildThreadQuery groupById() Group by the id column
 * @method     ChildThreadQuery groupByUuid() Group by the uuid column
 * @method     ChildThreadQuery groupByName() Group by the name column
 * @method     ChildThreadQuery groupByPostid() Group by the postId column
 *
 * @method     ChildThreadQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildThreadQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildThreadQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildThreadQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildThreadQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildThreadQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildThreadQuery leftJoinPostRelatedByPostid($relationAlias = null) Adds a LEFT JOIN clause to the query using the PostRelatedByPostid relation
 * @method     ChildThreadQuery rightJoinPostRelatedByPostid($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PostRelatedByPostid relation
 * @method     ChildThreadQuery innerJoinPostRelatedByPostid($relationAlias = null) Adds a INNER JOIN clause to the query using the PostRelatedByPostid relation
 *
 * @method     ChildThreadQuery joinWithPostRelatedByPostid($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the PostRelatedByPostid relation
 *
 * @method     ChildThreadQuery leftJoinWithPostRelatedByPostid() Adds a LEFT JOIN clause and with to the query using the PostRelatedByPostid relation
 * @method     ChildThreadQuery rightJoinWithPostRelatedByPostid() Adds a RIGHT JOIN clause and with to the query using the PostRelatedByPostid relation
 * @method     ChildThreadQuery innerJoinWithPostRelatedByPostid() Adds a INNER JOIN clause and with to the query using the PostRelatedByPostid relation
 *
 * @method     ChildThreadQuery leftJoinPostRelatedByThreadid($relationAlias = null) Adds a LEFT JOIN clause to the query using the PostRelatedByThreadid relation
 * @method     ChildThreadQuery rightJoinPostRelatedByThreadid($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PostRelatedByThreadid relation
 * @method     ChildThreadQuery innerJoinPostRelatedByThreadid($relationAlias = null) Adds a INNER JOIN clause to the query using the PostRelatedByThreadid relation
 *
 * @method     ChildThreadQuery joinWithPostRelatedByThreadid($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the PostRelatedByThreadid relation
 *
 * @method     ChildThreadQuery leftJoinWithPostRelatedByThreadid() Adds a LEFT JOIN clause and with to the query using the PostRelatedByThreadid relation
 * @method     ChildThreadQuery rightJoinWithPostRelatedByThreadid() Adds a RIGHT JOIN clause and with to the query using the PostRelatedByThreadid relation
 * @method     ChildThreadQuery innerJoinWithPostRelatedByThreadid() Adds a INNER JOIN clause and with to the query using the PostRelatedByThreadid relation
 *
 * @method     \Model\PostQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildThread|null findOne(?ConnectionInterface $con = null) Return the first ChildThread matching the query
 * @method     ChildThread findOneOrCreate(?ConnectionInterface $con = null) Return the first ChildThread matching the query, or a new ChildThread object populated from the query conditions when no match is found
 *
 * @method     ChildThread|null findOneById(int $id) Return the first ChildThread filtered by the id column
 * @method     ChildThread|null findOneByUuid(string $uuid) Return the first ChildThread filtered by the uuid column
 * @method     ChildThread|null findOneByName(string $name) Return the first ChildThread filtered by the name column
 * @method     ChildThread|null findOneByPostid(int $postId) Return the first ChildThread filtered by the postId column *

 * @method     ChildThread requirePk($key, ?ConnectionInterface $con = null) Return the ChildThread by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildThread requireOne(?ConnectionInterface $con = null) Return the first ChildThread matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildThread requireOneById(int $id) Return the first ChildThread filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildThread requireOneByUuid(string $uuid) Return the first ChildThread filtered by the uuid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildThread requireOneByName(string $name) Return the first ChildThread filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildThread requireOneByPostid(int $postId) Return the first ChildThread filtered by the postId column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildThread[]|ObjectCollection find(?ConnectionInterface $con = null) Return ChildThread objects based on current ModelCriteria
 * @psalm-method ObjectCollection&\Traversable<ChildThread> find(?ConnectionInterface $con = null) Return ChildThread objects based on current ModelCriteria
 * @method     ChildThread[]|ObjectCollection findById(int $id) Return ChildThread objects filtered by the id column
 * @psalm-method ObjectCollection&\Traversable<ChildThread> findById(int $id) Return ChildThread objects filtered by the id column
 * @method     ChildThread[]|ObjectCollection findByUuid(string $uuid) Return ChildThread objects filtered by the uuid column
 * @psalm-method ObjectCollection&\Traversable<ChildThread> findByUuid(string $uuid) Return ChildThread objects filtered by the uuid column
 * @method     ChildThread[]|ObjectCollection findByName(string $name) Return ChildThread objects filtered by the name column
 * @psalm-method ObjectCollection&\Traversable<ChildThread> findByName(string $name) Return ChildThread objects filtered by the name column
 * @method     ChildThread[]|ObjectCollection findByPostid(int $postId) Return ChildThread objects filtered by the postId column
 * @psalm-method ObjectCollection&\Traversable<ChildThread> findByPostid(int $postId) Return ChildThread objects filtered by the postId column
 * @method     ChildThread[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 * @psalm-method \Propel\Runtime\Util\PropelModelPager&\Traversable<ChildThread> paginate($page = 1, $maxPerPage = 10, ?ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ThreadQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Model\Base\ThreadQuery object.
     *
     * @param string $dbName The database name
     * @param string $modelName The phpName of a model, e.g. 'Book'
     * @param string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Model\\Thread', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildThreadQuery object.
     *
     * @param string $modelAlias The alias of a model in the query
     * @param Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildThreadQuery
     */
    public static function create(?string $modelAlias = null, ?Criteria $criteria = null): Criteria
    {
        if ($criteria instanceof ChildThreadQuery) {
            return $criteria;
        }
        $query = new ChildThreadQuery();
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
     * @return ChildThread|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ?ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ThreadTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = ThreadTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildThread A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, uuid, name, postId FROM thread WHERE id = :p0';
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
            /** @var ChildThread $obj */
            $obj = new ChildThread();
            $obj->hydrate($row);
            ThreadTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildThread|array|mixed the result, formatted by the current formatter
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

        $this->addUsingAlias(ThreadTableMap::COL_ID, $key, Criteria::EQUAL);

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

        $this->addUsingAlias(ThreadTableMap::COL_ID, $keys, Criteria::IN);

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
                $this->addUsingAlias(ThreadTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ThreadTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(ThreadTableMap::COL_ID, $id, $comparison);

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

        $this->addUsingAlias(ThreadTableMap::COL_UUID, $uuid, $comparison);

        return $this;
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%', Criteria::LIKE); // WHERE name LIKE '%fooValue%'
     * $query->filterByName(['foo', 'bar']); // WHERE name IN ('foo', 'bar')
     * </code>
     *
     * @param string|string[] $name The value to use as filter.
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByName($name = null, ?string $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(ThreadTableMap::COL_NAME, $name, $comparison);

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
     * @see       filterByPostRelatedByPostid()
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
                $this->addUsingAlias(ThreadTableMap::COL_POSTID, $postid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($postid['max'])) {
                $this->addUsingAlias(ThreadTableMap::COL_POSTID, $postid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        $this->addUsingAlias(ThreadTableMap::COL_POSTID, $postid, $comparison);

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
    public function filterByPostRelatedByPostid($post, ?string $comparison = null)
    {
        if ($post instanceof \Model\Post) {
            return $this
                ->addUsingAlias(ThreadTableMap::COL_POSTID, $post->getId(), $comparison);
        } elseif ($post instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            $this
                ->addUsingAlias(ThreadTableMap::COL_POSTID, $post->toKeyValue('PrimaryKey', 'Id'), $comparison);

            return $this;
        } else {
            throw new PropelException('filterByPostRelatedByPostid() only accepts arguments of type \Model\Post or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PostRelatedByPostid relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinPostRelatedByPostid(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PostRelatedByPostid');

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
            $this->addJoinObject($join, 'PostRelatedByPostid');
        }

        return $this;
    }

    /**
     * Use the PostRelatedByPostid relation Post object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Model\PostQuery A secondary query class using the current class as primary query
     */
    public function usePostRelatedByPostidQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPostRelatedByPostid($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PostRelatedByPostid', '\Model\PostQuery');
    }

    /**
     * Use the PostRelatedByPostid relation Post object
     *
     * @param callable(\Model\PostQuery):\Model\PostQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withPostRelatedByPostidQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->usePostRelatedByPostidQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }
    /**
     * Use the PostRelatedByPostid relation to the Post table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string $typeOfExists Either ExistsCriterion::TYPE_EXISTS or ExistsCriterion::TYPE_NOT_EXISTS
     *
     * @return \Model\PostQuery The inner query object of the EXISTS statement
     */
    public function usePostRelatedByPostidExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        return $this->useExistsQuery('PostRelatedByPostid', $modelAlias, $queryClass, $typeOfExists);
    }

    /**
     * Use the PostRelatedByPostid relation to the Post table for a NOT EXISTS query.
     *
     * @see usePostRelatedByPostidExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Model\PostQuery The inner query object of the NOT EXISTS statement
     */
    public function usePostRelatedByPostidNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        return $this->useExistsQuery('PostRelatedByPostid', $modelAlias, $queryClass, 'NOT EXISTS');
    }
    /**
     * Filter the query by a related \Model\Post object
     *
     * @param \Model\Post|ObjectCollection $post the related object to use as filter
     * @param string|null $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this The current query, for fluid interface
     */
    public function filterByPostRelatedByThreadid($post, ?string $comparison = null)
    {
        if ($post instanceof \Model\Post) {
            $this
                ->addUsingAlias(ThreadTableMap::COL_ID, $post->getThreadid(), $comparison);

            return $this;
        } elseif ($post instanceof ObjectCollection) {
            $this
                ->usePostRelatedByThreadidQuery()
                ->filterByPrimaryKeys($post->getPrimaryKeys())
                ->endUse();

            return $this;
        } else {
            throw new PropelException('filterByPostRelatedByThreadid() only accepts arguments of type \Model\Post or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PostRelatedByThreadid relation
     *
     * @param string|null $relationAlias Optional alias for the relation
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this The current query, for fluid interface
     */
    public function joinPostRelatedByThreadid(?string $relationAlias = null, ?string $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PostRelatedByThreadid');

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
            $this->addJoinObject($join, 'PostRelatedByThreadid');
        }

        return $this;
    }

    /**
     * Use the PostRelatedByThreadid relation Post object
     *
     * @see useQuery()
     *
     * @param string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Model\PostQuery A secondary query class using the current class as primary query
     */
    public function usePostRelatedByThreadidQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPostRelatedByThreadid($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PostRelatedByThreadid', '\Model\PostQuery');
    }

    /**
     * Use the PostRelatedByThreadid relation Post object
     *
     * @param callable(\Model\PostQuery):\Model\PostQuery $callable A function working on the related query
     *
     * @param string|null $relationAlias optional alias for the relation
     *
     * @param string|null $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this
     */
    public function withPostRelatedByThreadidQuery(
        callable $callable,
        string $relationAlias = null,
        ?string $joinType = Criteria::INNER_JOIN
    ) {
        $relatedQuery = $this->usePostRelatedByThreadidQuery(
            $relationAlias,
            $joinType
        );
        $callable($relatedQuery);
        $relatedQuery->endUse();

        return $this;
    }
    /**
     * Use the PostRelatedByThreadid relation to the Post table for an EXISTS query.
     *
     * @see \Propel\Runtime\ActiveQuery\ModelCriteria::useExistsQuery()
     *
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string $typeOfExists Either ExistsCriterion::TYPE_EXISTS or ExistsCriterion::TYPE_NOT_EXISTS
     *
     * @return \Model\PostQuery The inner query object of the EXISTS statement
     */
    public function usePostRelatedByThreadidExistsQuery($modelAlias = null, $queryClass = null, $typeOfExists = 'EXISTS')
    {
        return $this->useExistsQuery('PostRelatedByThreadid', $modelAlias, $queryClass, $typeOfExists);
    }

    /**
     * Use the PostRelatedByThreadid relation to the Post table for a NOT EXISTS query.
     *
     * @see usePostRelatedByThreadidExistsQuery()
     *
     * @param string|null $modelAlias sets an alias for the nested query
     * @param string|null $queryClass Allows to use a custom query class for the exists query, like ExtendedBookQuery::class
     *
     * @return \Model\PostQuery The inner query object of the NOT EXISTS statement
     */
    public function usePostRelatedByThreadidNotExistsQuery($modelAlias = null, $queryClass = null)
    {
        return $this->useExistsQuery('PostRelatedByThreadid', $modelAlias, $queryClass, 'NOT EXISTS');
    }
    /**
     * Exclude object from result
     *
     * @param ChildThread $thread Object to remove from the list of results
     *
     * @return $this The current query, for fluid interface
     */
    public function prune($thread = null)
    {
        if ($thread) {
            $this->addUsingAlias(ThreadTableMap::COL_ID, $thread->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the thread table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(?ConnectionInterface $con = null): int
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ThreadTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ThreadTableMap::clearInstancePool();
            ThreadTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ThreadTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ThreadTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ThreadTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ThreadTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

}
