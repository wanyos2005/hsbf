<?php

$ajax = array('type' => 'POST',
    'url' => CController::createUrl(
            'voteheads/votehead', array(
        'type' => $field
            )
    ),
    'update' => "#id$field"
);

if (
        $fieldType == Voteheads::SELECT &&
        count(
                $voteHeads = Voteheads::model()->voteHeadDropDowns($field)
        ) > 1
)
    echo $form->dropDownList(
            $model, 'votehead', $voteHeads, array(
        'prompt' => '-- Select Item --',
        'style' => 'text-align:center',
        'ajax' => $ajax
            )
    );
else {
    $fieldType = Voteheads::TEXT;

    echo $form->textField(
            $model, 'votehead', array(
        'size' => 20, 'maxlength' => 30,
        'placeholder' => Voteheads::NEW_VOTEHEAD,
        'style' => 'text-align:center',
        'ajax' => $ajax
            )
    );
}

echo CHtml::hiddenField($field, $fieldType);
