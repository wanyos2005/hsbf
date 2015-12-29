<?php

/**
 * Message controller
 * @author Fred <mconyango@gmail.com>
 */
class MessageController extends MsgModuleController {

        public function init()
        {
                $this->resourceLabel = 'Message';
                $this->resource = UserResources::RES_MESSAGE;
                parent::init();
        }

        /**
         * @return array action filters
         */
        public function filters()
        {
                return array(
                    'accessControl', // perform access control for CRUD operations
                    'postOnly + delete,deleteThreads,markInboxAs,markThreadAs', // we only allow deletion via POST request
                    'ajaxOnly + getNotifications',
                );
        }

        /**
         * Specifies the access control rules.
         * This method is used by the 'accessControl' filter.
         * @return array access control rules
         */
        public function accessRules()
        {
                return array(
                    array('allow',
                        'actions' => array('inbox', 'view', 'create', 'update', 'deleteInbox', 'deleteThreads', 'getNotifications', 'markInboxAs', 'markThreadAs'),
                        'users' => array('@'),
                    ),
                    array('deny', // deny all users
                        'users' => array('*'),
                    ),
                );
        }

        /**
         * Displays a particular model.
         * @param integer $id the ID of the model to be displayed
         */
        public function actionView($id)
        {
                $model = MsgMessageCopiesView::model()->loadModel($id);
                if ($model->user_id !== Yii::app()->user->id)
                        throw new CHttpException(403, Lang::t('403_error'));

                $this->showPageTitle = FALSE;
                $this->pageTitle = $model->topic;

                $search_model = MsgMessageCopiesView::model()->searchModel(array('conversation_id' => $model->conversation_id, 'user_id' => Yii::app()->user->id), FALSE, 'date_created');
                $search_model->enablePagination = false;
                $this->render('view', array(
                    'model' => $model,
                    'searchModel' => $search_model,
                ));
        }

        public function actionCreate($u_id, $cb = null)
        {
                $user = Users::model()->loadModel($u_id);
                $this->pageTitle = 'Send Message to ' . $user->name;

                $model = new MsgMessage(MsgMessage::SCENARIO_PRIVATE_MESSAGE);
                $model->to_ids = $user->id;
                $modelClassName = $model->getClassName();

                if (isset($_POST[$modelClassName])) {
                        $model->attributes = $_POST[$modelClassName];
                        $error_message = CActiveForm::validate($model);
                        $error_message_decoded = CJSON::decode($error_message);
                        $redirectLink = !empty($cb) ? $cb : $this->createUrl('index');

                        if (!empty($error_message_decoded)) {
                                echo CJSON::encode(array('success' => false, 'message' => $error_message));
                                Yii::app()->end();
                        }

                        $model->save(FALSE);
                        echo CJSON::encode(array('success' => true, 'message' => Lang::t('Message successfully sent.'), 'redirectUrl' => $redirectLink));
                        Yii::app()->end();
                }

                $this->renderPartial('_colorboxForm', array('model' => $model), FALSE, TRUE);
        }

        public function actionDeleteThreads()
        {
                $ids = $_POST['ids'];
                MsgMessageCopies::model()->deleteThreads($ids, Yii::app()->user->id);
                if (!isset($_GET['ajax']))
                        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('inbox'));
        }

        public function actionInbox()
        {
                $this->pageTitle = Lang::t('Messages');

                $search_model = MsgMessageCopiesView::model()->searchModel(array('user_id' => Yii::app()->user->id), $this->settings[Constants::KEY_PAGINATION], NULL);
                $search_model->default_group_by = 'conversation_id desc';
                $this->render('inbox', array(
                    'model' => $search_model,
                ));
        }

        public function actionGetNotifications($unread = NULL)
        {
                $conditions = '(`user_id`=:t1 and `read`=:t2)';
                $params = array(':t1' => Yii::app()->user->id, ':t2' => 0);
                $new_unread = MsgMessageCopies::model()->getTotals($conditions, $params);
                if ($unread == $new_unread) {
                        echo CJSON::encode(array('unread' => $new_unread, 'html' => FALSE));
                        Yii::app()->end();
                }
                $data = MsgMessageCopiesView::model()->getData('id,from_user_id,topic,message,from,date_created', $conditions, $params, 'id desc', 5);
                $html = $this->renderPartial('msg.views.layouts._topbar_messages_list', array('data' => $data, 'count' => $new_unread), TRUE, FALSE);

                echo CJSON::encode(array('unread' => $new_unread, 'html' => $html));
        }

        public function actionMarkThreadAs($key, $val)
        {
                $ids = $_POST['ids'];
                MsgMessageCopies::model()->markThreadAs($ids, Yii::app()->user->id, $key, $val);
                if (!isset($_GET['ajax']))
                        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('inbox'));
        }

        public function actionMarkInboxAs($id, $key, $val)
        {
                $model = MsgMessageCopies::model()->loadModel($id);
                if ($model->user_id !== Yii::app()->user->id)
                        throw new CHttpException(403, Lang::t('403_error'));
                $model->markAs($key, $val);
        }

}
