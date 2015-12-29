<div style="height: 400px; border-right: 3px solid #4f99c6">
    <?php
    $this->renderpartial('create', array(
        'model' => $model,
        'user' => Users::model()->loadModel(Yii::app()->user->id),
        'readOnly' => true
            )
    );
    ?>
</div>