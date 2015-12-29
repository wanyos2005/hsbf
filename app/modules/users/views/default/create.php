<?php

$this->breadcrumbs = array(
    Lang::t(Common::pluralize($this->resourceLabel)) => array('index'),
    $this->pageTitle,
);
?>
<?php $this->renderPartial('_form', array('user_model' => $user_model, 'person_model' => $person_model)); ?>