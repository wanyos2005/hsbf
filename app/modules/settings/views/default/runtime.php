<?php
$this->breadcrumbs = array(
    $this->pageTitle,
);
?>
<div class="panel panel-default">
        <div class="panel-body">
                <?php echo CHtml::beginForm(Yii::app()->createUrl($this->route), 'post', array('id' => 'log_file_form', 'class' => '', 'onchange' => 'MyUtils.triggerSubmit("#log_file_form")')) ?>
                <?php echo CHtml::dropDownList('log_file', $log_file, $log_files, array('class' => 'uk-form-width-large')) ?>
                <button class="btn btn-danger btn-sm" name="clear">Clear this log</button>
                <?php echo CHtml::endForm() ?>
                <hr/>
                <pre style="max-height: 500px;overflow-y: auto">
                                <code><?php echo file_exists($log_file) ? CHtml::encode(trim(file_get_contents($log_file))) : '' ?></code>
                </pre>
        </div>
</div>
