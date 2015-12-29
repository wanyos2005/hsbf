<a class="btn btn-sm btn-primary" style="height: 8px; border: none; padding: 0; margin: 0; border-radius: 20px">
    <?php
    echo CHtml::ajaxSubmitButton('Delete', array('voteheads/deleteVotehead', 'id' => $id, 'field' => $field), array(
        'update' => "#delete_Voteheads$field",
        'type' => 'submit',
            ), array(
        'id' => "confirmDelete$field$id", 'name' => "confirmDelete$field$id",
        'style' => 'width:120%; height: 230%; font-size: 100%; font-weight: bold; background-color: inherit; border: none;  padding: 0; margin: 0; border-radius: 6px'
            )
    );
    ?>
</a>