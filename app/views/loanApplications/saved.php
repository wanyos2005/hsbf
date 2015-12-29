<?php if (Yii::app()->user->hasFlash('saved')): ?>
    <table>
        <tr>
            <td></td>
            <td></td>
            <td style="width: 100%; float: left; color: #00cccc; text-align: center">
                <?php echo Yii::app()->user->getFlash('saved'); ?>
            </td>
        </tr>
    </table>
<?php endif; ?>