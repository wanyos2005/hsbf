<tr <?php if (isset($hidden)): $model->witness = null; ?>hidden="1" <?php endif; ?>>
    <td><?php echo $form->labelEx($model, 'witness'); ?></td>
    <td>&nbsp;</td>
    <td>
        <?php if ($others['readOnly'] == true): ?>
            <?php
            $person = Person::model()->findByPk($model->witness);
            echo $form->textField($model, 'witness', array('value' => "$person->last_name $person->first_name $person->middle_name", 'style' => 'text-align:center', 'readonly' => $others['readOnly']));
            ?>
        <?php else: ?>
            <?php
            $cri = new CDbCriteria;
            $cri->condition = $others['readOnly'] == true ? 'id!=:id && id=:mbr' : 'id!=:id';
            $cri->params = $others['readOnly'] == true ? array(':id' => $model->member, ':mbr' => $model->witness) : array(':id' => $model->member);
            $cri->order = 'last_name ASC';
            $members = Person::model()->onlyActiveMembers(Person::model()->findAll($cri));


            foreach ($members as $i => $member) {
                $mbrshp = empty($member->membershipno) ? null : " - $member->membershipno";
                $members[$i]->last_name = "$member->last_name $member->first_name $member->middle_name$mbrshp";
            }

            if (!empty($members)) {

                $members = CHtml::listData($members, 'id', 'last_name');

                echo $form->dropDownList($model, 'witness', $members, array('prompt' => '-- Select A Member --', 'required' => true, 'ajax' => array('type' => 'POST',
                        'url' => CController::createUrl('loanApplications/guarantor'), 'update' => '#LoanApplications_guarantor1')));
            }
            ?>
        <?php endif; ?>
    </td>
    <td>&nbsp;</td>
    <td><?php if (!empty($model->witness_date)) echo $form->labelEx($model, 'witness_date'); ?></td>
    <td>&nbsp;</td>
    <td><?php if (!empty($model->witness_date)) echo $form->textField($model, 'witness_date', array('size' => 13, 'maxlength' => 10, 'readonly' => true, 'style' => 'text-align:center')); ?></td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2"><?php echo $form->error($model, 'witness'); ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2"><?php if (!empty($model->witness_date)) echo $form->error($model, 'witness_date'); ?></td>
</tr>
<tr><td>&nbsp;</td></tr>