<div style="height: 400px; overflow-y: scroll">
    <table style="width: 100%">

        <tr style="text-align: center; position: relative">
            <td><h6>No.</h6></td><td><h6>Member</h6></td><td><h6><?php echo $authority == 'treasurer' ? 'Effect' : $authority == 'chairman' ? 'Approve' : 'Receive' ?></h6></td>
        </tr>

        <?php foreach ($models as $i => $model): ?>
            <?php $member = Person::model()->findByPk($model->member); ?>
            <tr>
                <td style="text-align: center"><?php echo $i + 1; ?>.</td>
                <td><?php echo CHtml::link("$member->last_name $member->first_name $member->middle_name", array('/cashWithdrawals/approveWithdrawals', 'id' => $model->primaryKey, 'active' => 'towachi')); ?></td>
                <td style="text-align: center"><?php echo $model->$attribute['authority']; ?></td>
            </tr>
        <?php endforeach; ?>

    </table>
</div>
