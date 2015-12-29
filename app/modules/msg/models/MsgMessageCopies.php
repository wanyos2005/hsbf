<?php

/**
 * This is the model class for table "msg_message_copies".
 *
 * The followings are the available columns in table 'msg_message_copies':
 * @property integer $id
 * @property integer $message_id
 * @property integer $user_id
 * @property integer $read
 * @property string $date_read
 * @property integer $notified
 * @property string $owner
 * @property string $date_created
 */
class MsgMessageCopies extends ActiveRecord {
        //message copy owners

        const OWNER_SENDER = 'Sender';
        const OWNER_RECIPIENT = 'Recipient';

        /**
         * @return string the associated database table name
         */
        public function tableName()
        {
                return 'msg_message_copies';
        }

        /**
         * @return array validation rules for model attributes.
         */
        public function rules()
        {
                return array(
                    array('message_id, user_id', 'required'),
                    array('message_id, user_id, read, notified', 'numerical', 'integerOnly' => true),
                    array('date_read,date_created,owner', 'safe'),
                    array('id,' . self::SEARCH_FIELD, 'safe', 'on' => self::SCENARIO_SEARCH),
                );
        }

        /**
         * @return array relational rules.
         */
        public function relations()
        {
                return array(
                );
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
         * @return MsgMessageCopies the static model class
         */
        public static function model($className = __CLASS__)
        {
                return parent::model($className);
        }

        /**
         * Delete message threads
         * @param type $ids
         * @param type $user_id
         */
        public function deleteThreads($ids, $user_id)
        {
                $msg_ids = implode(',', $this->getThreadMsgIds($ids));
                Yii::app()->db->createCommand("DELETE FROM `" . $this->tableName() . "` WHERE `user_id`=:t1 AND `message_id` IN ($msg_ids)")
                        ->bindValue(':t1', $user_id)
                        ->execute();
        }

        /**
         * Mark as e.g mark as read,unread or anything else
         * @param type $ids
         * @param type $user_id
         * @param type $key
         * @param type $value
         */
        public function markThreadAs($ids, $user_id, $key, $value)
        {
                Yii::app()->db->createCommand("UPDATE `" . $this->tableName() . "` SET `{$key}`=:t1 WHERE (`user_id`=:t2 AND `id` IN ($ids))")
                        ->bindValues(array(':t1' => $value, ':t2' => $user_id))
                        ->execute();
        }

        /**
         * Get msg_ids for a conversation thread given any thread message id
         * @param type $ids
         * @return type
         */
        public function getThreadMsgIds($ids)
        {
                $ids = explode(',', $ids);
                $msg_ids = array();
                foreach ($ids as $id) {
                        $msg_id = $this->get($id, 'message_id');
                        array_push($msg_ids, $msg_id);
                }
                return $msg_ids;
        }

        /**
         * Marks inbox as
         * @param type $key
         * @param type $value
         * @param type $id
         * @return type
         */
        public function markAs($key, $value, $id = null)
        {
                if (!empty($this->id))
                        $model = $this;
                else
                        $model = $this->loadModel($id);
                $model->{$key} = $value;
                return $model->save(FALSE);
        }

        /**
         * Get recipient list for a message
         */
        public function getRecipientList()
        {
                $recipient_ids = MsgMessage::model()->getScaler('to_ids', '`id`=:t1', array(':t1' => $this->message_id));
                if (!empty($recipient_ids)) {
                        $recipient = Users::model()->getColumnData("concat(`first_name`,' ',`last_name`)", "`id` IN({$recipient_ids})");
                        if (!empty($recipient_ids))
                                return implode(',', $recipient);
                }
                return FALSE;
        }

}
