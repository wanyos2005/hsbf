<div id="user-flash-messages">
        <?php if (Yii::app()->user->hasFlash('success')): ?>
                <div class="alert alert-block alert-success">
                        <button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>
                        <div><?php echo CHtml::decode(Yii::app()->user->getFlash('success')); ?></div>
                </div>
        <?php endif; ?>
        <?php if (Yii::app()->user->hasFlash('notice')): ?>
                <div class="alert alert-block alert-warning">
                        <button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>
                        <div><?php echo CHtml::decode(Yii::app()->user->getFlash('notice')); ?></div>
                </div>
        <?php endif; ?>
        <?php if (Yii::app()->user->hasFlash('info')): ?>
                <div class="alert alert-block alert-info">
                        <button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>
                        <div><?php echo CHtml::decode(Yii::app()->user->getFlash('info')); ?></div>
                </div>
        <?php endif; ?>
</div>
