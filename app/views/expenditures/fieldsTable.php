<?php
echo $form->hiddenField($model, 'date', array('value' => date('Y') . '-' . date('m') . '-' . date('d')));
echo $form->hiddenField($model, 'member', array('value' => $user->id));
?>
<table style="width: 100%">
    <tr><td></td><td><h3 style="margin: 0"><?php echo $heading; ?></h3></td></tr>

    <tr><td colspan="2">&nbsp;</td></tr>

    <tr>
        <td><?php echo $form->labelEx($model, 'votehead'); ?></td>
        <td id="<?php echo "id$field" ?>">
            <?php
            $this->renderPartial('voteHead', array(
                'field' => $field, 'model' => $model, 'form' => $form, 'fieldType' => $fieldType
                    )
            );
            ?>
        </td>
        <td><?php echo $form->error($model, 'votehead'); ?></td>
    </tr>

    <tr><td colspan="2">&nbsp;</td></tr>

    <tr>
        <td><?php echo $form->labelEx($model, 'amount'); ?></td>
        <td><?php echo $form->textField($model, 'amount', array('size' => 10, 'maxlength' => 10, 'numeric' => true, 'min' => 0)); ?></td>
        <td><?php echo $form->error($model, 'amount'); ?></td>
    </tr>

    <tr><td colspan="2">&nbsp;</td></tr>

    <tr>
        <td><?php echo $form->labelEx($model, 'cask_or_bank'); ?></td>
        <td><?php echo $form->dropDownList($model, 'cask_or_bank', Incomes::toBankOrCash()); ?></td>
        <td><?php echo $form->error($model, 'cask_or_bank'); ?></td>
    </tr>

    <tr><td colspan="2">&nbsp;</td></tr>

    <tr>
        <td><?php echo $form->labelEx($model, 'description'); ?></td>
        <td><?php echo $form->textArea($model, 'description', array('rows' => 2, 'cols' => 20)); ?></td>
        <td><?php echo $form->error($model, 'description'); ?></td>
    </tr>

    <tr><td colspan="2">&nbsp;</td></tr>

    <tr>
        <td></td>
        <td>
            <a class="btn btn-sm btn-primary"><i class="icon-ok bigger-110"></i>
                <?php
                echo CHtml::ajaxSubmitButton("Save $field", array("expenditures/incomeOrExpense", 'member' => $user->id, 'type' => $field, 'heading' => $heading), array(
                    'update' => "#div$field",
                    'type' => 'submit',
                        ), array(
                    'id' => "button$field", 'name' => "button$field",
                    'style' => 'background-color: inherit; border: none'
                        )
                );
                ?>
            </a>
        </td>
        <td></td>
    </tr>

    <tr><td colspan="2">&nbsp;</td></tr>

</table>

<?php $this->renderPartial('deleteVoteheads', array('field' => $field)); ?>