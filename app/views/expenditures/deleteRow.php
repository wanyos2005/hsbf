<td><?php echo $d; ?>. </td>

<td style="margin: 0; padding: 0">
    <a style="height: 10px; border: none; padding: 0; margin: 0">
        <?php
        echo CHtml::ajaxSubmitButton("$deleteVotehead->votehead", array("voteheads/confirmDelete", 'id' => $deleteVotehead->primaryKey, 'field' => $field), array(
            'update' => "#delete$deleteVotehead->primaryKey",
            'type' => 'submit',
                ), array(
            'id' => "deleteButton$field$deleteVotehead->primaryKey", 'name' => "deleteButton$field$deleteVotehead->primaryKey",
            'style' => 'height: 90%; background-color: inherit; border: none;  padding: 0; margin: 0'
                )
        );
        ?>
    </a> 
</td>

<td id="<?php echo "delete$deleteVotehead->primaryKey"; ?>">
    <text  hidden="<?php echo true ?>">
    <?php $this->renderPartial('application.views.expenditures.confirmDelete', array('id' => $deleteVotehead->primaryKey, 'field' => $field)); ?>
    </text>
</td>