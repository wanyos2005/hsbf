<div style="width: 40%; float: left; text-align: center"><?php echo CHtml::submitButton('Submit'); ?></div>

<div style="width: 60%; float: right; text-align: center"><?php echo CHtml::link('Back To Profile', array('/users/default/view', 'id' => $user->primaryKey)); ?> </div>