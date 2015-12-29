<?php

/**
 * This is the model class for table "msg_message_copies_view".
 *
 * The followings are the available columns in table 'msg_message_copies_view':
 * @property integer $id
 * @property integer $message_id
 * @property integer $user_id
 * @property integer $read
 * @property string $date_read
 * @property integer $notified
 * @property string $owner
 * @property string $date_created
 * @property integer $from_user_id
 * @property string $topic
 * @property string $message
 * @property integer $conversation_id
 * @property string $message_type
 * @property string $message_status
 * @property string $message_date_created
 * @property string $from
 * @property string $to
 */
class MsgMessageCopiesView extends MsgMessageCopies implements IMyActiveSearch {

        /**
         * @return string the associated database table name
         */
        public function tableName()
        {
                return 'msg_message_copies_view';
        }

        /**
         * @return array validation rules for model attributes.
         */
        public function rules()
        {
                return array_merge(parent::rules(), array(
                    array('id, message_id, user_id, read,notified,owner, from_user_id, topic, message, conversation_id, message_type, message_status,from, to,date_created,' . self::SEARCH_FIELD, 'safe', 'on' => self::SCENARIO_SEARCH),
                ));
        }

        public function primaryKey()
        {
                return 'id';
        }

        /**
         * @return array customized attribute labels (name=>label)
         */
        public function attributeLabels()
        {
                return array(
                );
        }

        /**
         * Returns the static model of the specified AR class.
         * Please note that you should have this exact method in all your CActiveRecord descendants!
         * @param string $className active record class name.
         * @return MsgMessageCopiesView the static model class
         */
        public static function model($className = __CLASS__)
        {
                return parent::model($className);
        }

        public function searchParams()
        {
                return array(
                    array('topic', self::SEARCH_FIELD, true, 'OR'),
                    array('message', self::SEARCH_FIELD, true, 'OR'),
                    array('from', self::SEARCH_FIELD, true, 'OR'),
                    array('to', self::SEARCH_FIELD, true, 'OR'),
                    'message_id',
                    'from_user_id',
                    'user_id',
                    'conversation_id',
                    'message_type',
                    'message_status',
                    'read',
                    'owner',
                );
        }

        /**
         * Get the thread count of a given message
         * @param type $user_id
         * @param type $conv_id conversation_id
         * @return type
         */
        public function getThreadCount($user_id = null, $conv_id = null)
        {
                if ($conv_id === NULL)
                        $conv_id = $this->conversation_id;
                if ($user_id === NULL)
                        $user_id = Yii::app()->user->id;
                return MsgMessageCopiesView::model()->getTotals('(`conversation_id`=:t1 AND `user_id`=:t2)', array(':t1' => $conv_id, ':t2' => $user_id));
        }

        public function getLatestThread()
        {
                $data = $this->getData('*', '`conversation_id`=:t1 AND `user_id`=:t2', array(':t1' => $this->conversation_id, ':t2' => $this->user_id), 'id desc', 1);
                return $data[0];
        }

}
