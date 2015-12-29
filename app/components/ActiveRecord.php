<?php

/**
 * ActiveRecord is the customized base activeRecord class.
 * All Model classes for this application should extend from this base class.
 * @author Fred <mconyango@gmail.com>
 */
abstract class ActiveRecord extends CActiveRecord {

        /**
         * The default page size of search model
         * @see {@link searchModel()}
         * @var string
         */
        public $defaultPageSize = 10;

        /**
         * Default sort by for search model.
         * @see {@link searchModel()}
         * @var string
         */
        public $default_order_by = null;

        /**
         * Default search condition for search model.
         * @see {@link searchModel()}
         * @var string
         */
        public $default_search_condition = null;

        /**
         * Default  sort attributes for search model.
         * @see {@link searchModel()}
         * @var array
         */
        public $default_sort_attributes = array();

        /**
         * Default  groub by criteria for search model.
         * @see {@link searchModel()}
         * @var array
         */
        public $default_group_by;

        /**
         * Whether to enable pagination or not. Default is TRUE
         * This value is passed to the {@link GridView}
         * @var boolean
         */
        public $enablePagination = true;

        /**
         * Whether to enable summary text or not. Default is TRUE
         * This value is passed to the {@link GridView}
         * @var boolean
         */
        public $enableSummary = true;

        /**
         * Gridview search field
         * @var type
         */
        public $_search;

        const SEARCH_FIELD = '_search';

        /**
         * May temporarily store any data
         * @var mixed
         */
        public $genericField;

        /**
         * A flag to show whether a model's audit trail should be logged
         * @var type
         */
        public $logUserActivity = false;

        /**
         * All models that have this scenario will not have audit logs
         */
        const SCENARIO_CREATE = 'insert';
        const SCENARIO_UPDATE = 'update';
        const SCENARIO_SEARCH = 'search';
        //stats constants
        const STATS_TODAY = 'today';
        const STATS_THIS_WEEK = 'this_week';
        const STATS_LAST_WEEK = 'last_week';
        const STATS_THIS_MONTH = 'this_month';
        const STATS_LAST_MONTH = 'last_month';
        const STATS_THIS_YEAR = 'this_year';
        const STATS_LAST_YEAR = 'last_year';
        const STATS_ALL_TIME = 'all_time';
        const STATS_DATE_RANGE = 'date_range';

        public function behaviors()
        {
                $behaviors = array();
                if ($this->logUserActivity && Yii::app() instanceof CWebApplication) {
                        //audit trail behavior
                        $behaviors['AuditTrailBehavior'] = array(
                            'class' => 'application.modules.users.components.behaviors.AuditTrailBehavior',
                        );
                }

                return array_merge(parent::behaviors(), $behaviors);
        }

        public function beforeSave()
        {
                if (Yii::app() instanceof CWebApplication) {
                        foreach ($this->dateTimeFields() as $dateTimeField) {
                                if ($this->hasAttribute($dateTimeField) && !empty($this->{$dateTimeField}) && !$dateTimeField instanceof CDbExpression) {
                                        $this->{$dateTimeField} = Yii::app()->localtime->fromLocalDateTime($this->{$dateTimeField});
                                }
                        }
                        //add created by
                        if ($this->hasAttribute('created_by') && $this->getIsNewRecord())
                                $this->created_by = Yii::app()->user->id;
                        //modified by
                        if ($this->hasAttribute('last_modified_by') && !$this->getIsNewRecord())
                                $this->last_modified_by = Yii::app()->user->id;
                }
                if ($this->getIsNewRecord()) {
                        if ($this->hasAttribute('date_created'))
                                $this->date_created = new CDbExpression('NOW()');
                }
                if (!$this->getIsNewRecord()) {
                        if ($this->hasAttribute('last_modified'))
                                $this->last_modified = new CDbExpression('NOW()');
                }
                return parent::beforeSave();
        }

        /**
         * Load model function
         * @param mixed $id The Primary Key of the model table
         * @return CActiveRecord CActiveRecordObject
         * @throws CHttpException when the model is not found
         */
        public function loadModel($id)
        {
                $model = $this->findByPk($id);
                if ($model === null)
                        throw new CHttpException(404, Lang::t('404_error'));
                return $model;
        }

        /**
         * Gets a particular field of a table
         * @param mixed $id The Primary Key of the model table
         * @param string $field The field to be returned
         * @return boolean Returns the field if found else returns false
         */
        public function get($id, $field)
        {
                $primary_key = $this->getThePrimaryKeyField();
                $value = $this->getScaler($field, '`' . $primary_key . '`=:t1', array(':t1' => $id));
                if (empty($value))
                        return NULL;
                return $value;
        }

        /**
         * delete many records
         * @param type $ids
         * @param type $deleteModel
         */
        public function deleteMany($ids, $deleteModel = FALSE)
        {
                if (!is_array($ids))
                        $ids = explode(',', $ids);
                if (!$deleteModel) {
                        $primary_key = $this->getThePrimaryKeyField();
                        Yii::app()->db->createCommand()
                                ->delete($this->tableName(), array('in', $primary_key, $ids));
                } else {
                        foreach ($ids as $id) {
                                $this->loadModel($id)->delete();
                        }
                }
        }

        /**
         *
         * @param type $valueField
         * @param string $conditions
         * @param array $params
         * @return type
         */
        public function typeAhead($valueField, $conditions = null, $params = array())
        {
                $data = $this->getColumnData($valueField, $conditions, $params);
                $results = array();
                foreach ($data as $r)
                        array_push($results, $r);
                return CJSON::encode($results);
        }

        /**
         * Creates the basic CRUD URLS e.g view,update,delete,etc for a model
         * @tutorial NOTE: The controller class name should be the same as the model name e.g UsersController (the controller) and Users (the model)
         * @param type $action
         * @return type
         */
        public function getUrl($action = 'view')
        {
                $params = array('id' => $this->id);
                return Yii::app()->controller->createUrl(lcfirst($this->getClassName()) . '/' . $action, $params);
        }

        /**
         * Get the name of the current class and then convert to lower case
         * @return type
         */
        public function getClassNameTolower()
        {
                return strtolower($this->getClassName());
        }

        /**
         * Get class name of a model
         * @return string $class_name;
         */
        public function getClassName()
        {
                return get_class($this);
        }

        /**
         * Adds a new model
         * @param array $params $key=>$value pairs where the $key corresponds to a column of the model table and $value is the value of the column
         * @param boolean $validate Default is TRUE {@see CactiveRecord::validate()}
         * @return type
         */
        public function addRecord($params, $validate = true)
        {
                $model = new $this;
                foreach ($params as $k => $v) {
                        if ($this->hasAttribute($k))
                                $model->$k = $v;
                }
                return $model->save($validate);
        }

        /**
         * Get the row counts
         * @param type $conditions
         * @param type $params
         * @return type
         */
        public function getTotals($conditions = null, $params = array())
        {
                return $this->getScaler('count(*)', $conditions, $params);
        }

        /**
         * Get the sum of rows
         * @param string $field Field to be summed
         * @param string $conditions
         * @param array $params
         * @param string $group_by
         * @return mixed
         */
        public function getSum($field, $conditions = '', $params = array(), $group_by = null)
        {
                return $this->getScaler('SUM(`' . $field . '`)', $conditions, $params, $group_by);
        }

        /**
         * Get stats
         * @param string $durationType e.g today,this_week,this_month,this_year, defaults to null (all time)
         * @param array $filters $key=>$value pair where the $key is the table field and $value is the table value: empty by default
         * @param mixed $sum if false then the count is return else returns the sum of the $sum field: defaults to FALSE
         * @param string $dateField The date field of the table to be queried for duration stats. defaults to "date_created"
         * @param string $from date_range from
         * @param string $to date_range to
         * @param type $conditions
         * @return integer count or sum
         */
        public function getStats($durationType = '', $filters = array(), $sum = false, $dateField = 'date_created', $from = null, $to = null, $conditions = '')
        {
                $today = date('Y-m-d');
                $this_month = date('m');
                $this_year = date('Y');
                $params = array();
                foreach ($filters as $k => $v) {
                        if ($this->hasAttribute($k)) {
                                if (!empty($conditions))
                                        $conditions.=' AND ';
                                $conditions.='`' . $k . '`=:' . $k;
                                $params[':' . $k] = $v;
                        }
                }
                switch ($durationType) {
                        case self::STATS_TODAY:
                                if (!empty($conditions))
                                        $conditions.=' AND ';
                                $conditions.='DATE(`' . $dateField . '`)=:' . $dateField;
                                $params[':' . $dateField] = $today;
                                break;
                        case self::STATS_THIS_WEEK:
                                if (!empty($conditions))
                                        $conditions.=' AND ';
                                $conditions.='YEARWEEK(`' . $dateField . '`,1)=YEARWEEK(:' . $dateField . ',1)';
                                $params[':' . $dateField] = $today;
                                break;
                        case self::STATS_LAST_WEEK:
                                if (!empty($conditions))
                                        $conditions.=' AND ';
                                $conditions.='YEARWEEK(`' . $dateField . '`,1)=YEARWEEK(:' . $dateField . ',1)';
                                $params[':' . $dateField] = Common::addDate($today, '-7', 'day');
                                break;
                        case self::STATS_THIS_MONTH:
                                if (!empty($conditions))
                                        $conditions.=' AND ';
                                $conditions.='YEAR(`' . $dateField . '`)=:' . $dateField . '_Y AND MONTH(`' . $dateField . '`)=:' . $dateField . '_M';
                                $params[':' . $dateField . '_Y'] = $this_year;
                                $params[':' . $dateField . '_M'] = $this_month;
                                break;
                        case self::STATS_LAST_MONTH:
                                if (!empty($conditions))
                                        $conditions.=' AND ';
                                $conditions.='YEAR(`' . $dateField . '`)=:' . $dateField . '_Y AND MONTH(`' . $dateField . '`)=:' . $dateField . '_M';
                                $date = Common::addDate($today, '-1', 'month');
                                $year = Common::formatDate($date, 'Y', false);
                                $month = Common::formatDate($date, 'm', false);
                                $params[':' . $dateField . '_Y'] = $year;
                                $params[':' . $dateField . '_M'] = $month;
                                break;
                        case self::STATS_THIS_YEAR:
                                if (!empty($conditions))
                                        $conditions.=' AND ';
                                $conditions.='YEAR(`' . $dateField . '`)=:' . $dateField . '_Y';
                                $params[':' . $dateField . '_Y'] = $this_year;
                                break;
                        case self::STATS_LAST_YEAR:
                                if (!empty($conditions))
                                        $conditions.=' AND ';
                                $conditions.='YEAR(`' . $dateField . '`)=:' . $dateField . '_Y';
                                $date = Common::addDate($today, '-1', 'year');
                                $params[':' . $dateField . '_Y'] = Common::formatDate($date, 'Y', false);
                                break;
                        case self::STATS_DATE_RANGE:
                                if (empty($from) || empty($to))
                                        throw new CHttpException(500, '$from and $to params not given.');
                                if (!empty($conditions))
                                        $conditions.=' AND ';
                                $conditions.='(DATE(`' . $dateField . '`)>=:from AND DATE(`' . $dateField . '`)<=:to)';
                                $params[':from'] = $from;
                                $params[':to'] = $to;
                                break;
                }

                if ($sum)
                        return $this->getSum($sum, $conditions, $params);
                else
                        return $this->getTotals($conditions, $params);
        }

        /**
         * Get all stats
         * @param array $filters key=>value pair of filters where $key is the column name and $value is the column value
         * @param mixed $sum if set will get the sum of the column else if false will count the rows
         * @param string $date_field default is "date_created"
         * @return type
         */
        public function getAllStats($filters = array(), $sum = false, $date_field = 'date_created')
        {
                return array(
                    self::STATS_TODAY => $this->getStats(self::STATS_TODAY, $filters, $sum, $date_field),
                    self::STATS_THIS_WEEK => $this->getStats(self::STATS_THIS_WEEK, $filters, $sum, $date_field),
                    self::STATS_LAST_WEEK => $this->getStats(self::STATS_LAST_WEEK, $filters, $sum, $date_field),
                    self::STATS_THIS_MONTH => $this->getStats(self::STATS_THIS_MONTH, $filters, $sum, $date_field),
                    self::STATS_LAST_MONTH => $this->getStats(self::STATS_LAST_MONTH, $filters, $sum, $date_field),
                    self::STATS_THIS_YEAR => $this->getStats(self::STATS_THIS_YEAR, $filters, $sum, $date_field),
                    self::STATS_LAST_YEAR => $this->getStats(self::STATS_LAST_YEAR, $filters, $sum, $date_field),
                    self::STATS_ALL_TIME => $this->getStats(self::STATS_ALL_TIME, $filters, $sum, $date_field),
                );
        }

        /**
         * Get rowset using the query builder e.g Yii::app()->db->createCommand()
         * @param string $columns comma separated columns
         * @param string $conditions
         * @param array $params
         * @param string $order
         * @param integer $limit
         * @param integer $offset
         * @param string $group_by
         * @return type
         */
        public function getData($columns = '*', $conditions = '', $params = array(), $order = null, $limit = null, $offset = null, $group_by = null)
        {
                $command = Yii::app()->db->createCommand()
                        ->select($columns)
                        ->from($this->tableName())
                        ->where($conditions, $params);
                if (!empty($order))
                        $command->order($order);
                if (!empty($group_by))
                        $command->group($group_by);
                if (!empty($limit))
                        $command->limit($limit, $offset);
                return $command->queryAll();
        }

        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function search()
        {
                $searchData = array(
                    'pagination' => array(
                        'pageSize' => $this->defaultPageSize,
                    )
                );
                $searchData['criteria'] = $this->createSearchCriteria($this->default_search_condition);
                if (!empty($this->default_order_by)) {
                        $sort = new CSort();
                        $sort->defaultOrder = $this->default_order_by;
                }
                if (!empty($this->default_sort_attributes)) {
                        if (!isset($sort))
                                $sort = new CSort();
                        $sort->attributes = array();
                }
                if (isset($sort))
                        $searchData['sort'] = $sort;
                return new CActiveDataProvider($this, $searchData);
        }

        /**
         * Get Search model
         * @param array $filters $key=>$value pair where $key is the table column and $value is the value of the columns (e.g id=2 AND ...)
         * @param integer $pageSize
         * @param string $orderBy
         * @param string $condition any valid condition e.g (name IS NOT NULL, name<>"Fred")
         * @param boolean $enablePagination
         * @param boolean $enableSummary
         * @param array $sortAttributes
         * @return ActiveRecord $model
         */
        public function searchModel($filters = array(), $pageSize = null, $orderBy = null, $condition = null, $enablePagination = true, $enableSummary = true, $sortAttributes = array())
        {
                $model = new $this;
                $model->setScenario(self::SCENARIO_SEARCH);
                if ($pageSize === null)
                        $pageSize = Yii::app()->settings->get(Constants::CATEGORY_GENERAL, Constants::KEY_PAGINATION, 10);
                $model->defaultPageSize = $pageSize;
                $model->default_order_by = $orderBy;
                $model->default_search_condition = $condition;
                $model->default_sort_attributes = $sortAttributes;
                $model->enablePagination = $enablePagination;
                $model->enableSummary = $enableSummary;

                $class_name = $this->getClassName();

                $model->unsetAttributes();  // clear any default values

                if (isset($_GET[$class_name]))
                        $model->attributes = $_GET[$class_name];

                if (!empty($filters)) {
                        foreach ($filters as $k => $v) {
                                if ($model->hasAttribute($k))
                                        $model->$k = $v;
                        }
                }
                return $model;
        }

        /**
         * Check whether a class has a child
         * @param type $childModelClassName
         * @param string $foreign_key foreign key column name
         * @param string $name Primary key value
         * @return boolean true or false
         */
        public function hasChild($childModelClassName, $foreign_key, $primary_key_value = null)
        {
                if (empty($primary_key_value)) {
                        $primary_key = $this->getThePrimaryKeyField();
                        $primary_key_value = $this->$primary_key;
                }
                return $childModelClassName::model()->exists('`' . $foreign_key . '`=:t1', array(':t1' => $primary_key_value));
        }

        /**
         * Gets the primary key column name of a table
         * @return string Primary key
         */
        public function getThePrimaryKeyField()
        {
                return $this->tableSchema->primaryKey;
        }

        /**
         * Get a scalar value from the table e.g select `column` from `table_name` where condition=params
         * @param string $column
         * @param string $conditions
         * @param array $params
         * @param string $group_by
         * @param string $order_by
         * @return type
         */
        public function getScaler($column, $conditions = '', $params = array(), $group_by = null, $order_by = null)
        {
                $command = Yii::app()->db->createCommand()
                        ->select($column)
                        ->from($this->tableName())
                        ->where($conditions, $params);
                if (!empty($group_by))
                        $command->group($group_by);
                if (!empty($order_by))
                        $command->order($order_by);
                return $command->queryScalar();
        }

        /**
         * Get a row of a table
         * @param type $columns
         * @param type $conditions
         * @param type $params
         * @return type
         */
        public function getRow($columns = '*', $conditions = '', $params = array())
        {
                return Yii::app()->db->createCommand()
                                ->select($columns)
                                ->from($this->tableName())
                                ->where($conditions, $params)
                                ->queryRow();
        }

        /**
         * Get average
         * @param type $field
         * @param type $conditions
         * @param type $params
         * @return type
         */
        public function getAverage($field, $conditions = '', $params = array())
        {
                $avg = Yii::app()->db->createCommand()
                        ->select('AVG(`' . $field . '`)')
                        ->from($this->tableName())
                        ->where($conditions, $params)
                        ->queryScalar();
                if (empty($avg))
                        return 0;
                return $avg;
        }

        /**
         * get Sql Data provider for Cgridview
         * @param type $sql
         * @param integer $count
         * @param type $pageSize
         * @param type $sortAttributes
         * @param type $defaulOrder
         * @return \CSqlDataProvider
         */
        public function getSqlDataPrivider($sql, $count, $pageSize = 10, $sortAttributes = array(), $defaulOrder = '')
        {
                $dataProvider = new CSqlDataProvider($sql, array(
                    'totalItemCount' => $count,
                    'sort' => array(
                        'attributes' => $sortAttributes,
                        'defaultOrder' => $defaulOrder,
                    ),
                    'pagination' => array(
                        'pageSize' => $pageSize,
                    ),
                ));
                return $dataProvider;
        }

        /**
         * get column data of a table
         * @param type $column
         * @param type $conditions
         * @param type $params
         * @param type $order
         * @param type $limit
         * @param type $offset
         * @return array 1D Array of columns
         */
        public function getColumnData($column, $conditions = '', $params = array(), $order = null, $limit = null, $offset = null)
        {
                $command = Yii::app()->db->createCommand()
                        ->select($column)
                        ->from($this->tableName())
                        ->where($conditions, $params);
                if (!empty($order))
                        $command->order($order);
                if (!empty($limit))
                        $command->limit($limit, $offset);
                return $command->queryColumn();
        }

        /**
         * get count distinct
         * @param type $column
         * @param type $conditions
         * @param type $params
         * @return type
         */
        public function getCountDistinct($column, $conditions = '', $params = array())
        {
                return $this->getScaler('count(distinct `' . $column . '`)', $conditions, $params);
        }

        /**
         * Create search criteria
         * @param type $conditions
         * @return \CDbCriteria
         */
        public function createSearchCriteria($conditions = null)
        {
                $criteria = new CDbCriteria;
                if ($this->default_group_by !== NULL)
                        $criteria->group = $this->default_group_by;
                //start with search params
                if (method_exists($this, 'searchParams')) {
                        foreach ($this->searchParams() as $s) {
                                if (is_array($s)) {
                                        if (count($s) > 3)
                                                $criteria->compare('`' . $s[0] . '`', $this->$s[1], $s[2], $s[3]);
                                        else if (count($s) > 2)
                                                $criteria->compare('`' . $s[0] . '`', $this->$s[1], $s[2]);
                                        else if (count($s) > 1)
                                                $criteria->compare('`' . $s[0] . '`', $this->$s[1]);
                                        else
                                                $criteria->compare('`' . $s[0] . '`', $this->$s[0]);
                                } else
                                        $criteria->compare('`' . $s . '`', $this->$s);
                        }
                }
                if (!empty($conditions))
                        $criteria->addCondition($conditions);
                return $criteria;
        }

        /**
         * Check whether a model can be deleted
         * @param type $id
         * @return boolean
         */
        public function canDelete($id = null)
        {
                if (!empty($this->id))
                        $id = $this->id;

                $relations = $this->relations();
                $canDelete = true;
                foreach ($relations as $r) {
                        if ($r[0] === self::HAS_MANY) {
                                $class = $r[1];
                                $foreign_key = $r[2];
                                if ($class::model()->exists('`' . $foreign_key . '`=:t1', array(':t1' => $id))) {
                                        $canDelete = false;
                                        break;
                                }
                        }
                }
                return $canDelete;
        }

        /**
         * Get model errors to string
         * @param string $delimiter
         * @return boolean
         */
        public function errorsToString($delimiter = ',')
        {
                $errorArr = array();
                foreach ($this->getErrors() as $error) {
                        foreach ($error as $er)
                                array_push($errorArr, $er);
                }
                if (!empty($errorArr))
                        return implode($delimiter, $errorArr);
                return false;
        }

        /**
         * composes drop-down list data from a model using CHtml::listData function
         * @see CHtml::listData();
         * @param string $valueField
         * @param string $textField
         * @param boolean $add_tip
         * @param string $conditions
         * @param array $params
         * @param string $order
         * @param string $groupField
         * @return array
         */
        public function getListData($valueField, $textField, $add_tip = true, $conditions = '', $params = array(), $order = null, $groupField = '')
        {
                $valueFieldAlias = 'id';
                $textFieldAlias = 'name';

                $data = $this->getData("{$valueField} as {$valueFieldAlias},{$textField} as {$textFieldAlias}", $conditions, $params, $order);
                if ($add_tip) {
                        $tip = $add_tip === true ? "[select one]" : $add_tip;
                        $data = array_merge(array(array($valueFieldAlias => '', $textFieldAlias => $tip)), $data);
                }
                return CHtml::listData($data, $valueFieldAlias, $textFieldAlias, $groupField);
        }

        /**
         * Generate primary key for a given model
         * @param string $prefix
         * @param integer $length
         * @param string $case Which case to return. can be "upper" or "lower"
         * @param string $unique_column The column to check for uniqueness. default is the primary key
         * @return string The generated ID
         */
        public function generateUniqueString($prefix = '', $length = 8, $case = null, $unique_column = NULL)
        {
                if (empty($unique_column))
                        $unique_column = $this->getThePrimaryKeyField();

                //generate a random string
                $key_string = $prefix . Common::generateRandomString($length);

                if ($case === 'upper')
                        $key_string = strtoupper($key_string);
                elseif ($case === 'lower')
                        $key_string = strtolower($key_string);

                //check if the string is unique. if the string is not unique call the function again
                if ($this->exists("{$unique_column}=:t1", array(':t1' => $key_string))) {
                        $this->generateUniqueString($prefix, $length, $case, $unique_column);
                }

                return $key_string;
        }

        /**
         * Gets the next Integer  ID for non-auto_increment integer keys
         * @param string $column the id column. default is the primary key column
         * @param int $start_from start ID
         * @return int the next integer id
         */
        public function getNextIntegerID($column = NULL, $start_from = 0)
        {
                if (empty($column))
                        $column = $this->getThePrimaryKeyField();
                $max_id = $this->getScaler("MAX(`{$column}`)");
                if (empty($max_id))
                        $max_id = $start_from;
                return (int) $max_id + 1;
        }

        /**
         * Set the default datetime fields.
         * Override the function in respective models in order to add or remove datetime fields
         * @return type
         *
         */
        public function dateTimeFields()
        {
                return array(
                );
        }

        /**
         * Set the default date fields.
         * Override the function in respective models in order to add or remove date fields
         * @return type
         *
         */
        public function dateFields()
        {
                return array(
                );
        }

        /**
         * Insert multiple records is the db
         * Note: No validation done here
         * @param array $data
         * @return type
         */
        public function insertMultiple(array $data)
        {
                $builder = Yii::app()->db->schema->commandBuilder;
                $command = $builder->createMultipleInsertCommand($this->tableName(), $data);
                return $command->execute();
        }

}

/**
 * All models that have search should implement this inteface
 */
interface IMyActiveSearch {

        /**
         * This functions gets search params for search
         * To be implemented by each model
         * @return array
         *  e.g array(
         *          array('key'=>'table_column_name','value'=>'model_property_name','partialSearch'=>true),
         *          array('key'=>'table_column_name','value'=>'model_property_name'),// 'partialSearch' value defaults to false
         *          array('key'=>'table_column_name'), //'value' value defaults to the 'key' value ,'partialSearch' value defaults to false
         * )
         */
        public function searchParams();
}
