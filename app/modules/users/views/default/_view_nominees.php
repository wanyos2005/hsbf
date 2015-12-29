<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">
            <i class="fa fa-chevron-down"></i> <a data-toggle="collapse" data-parent="#accordion" href="#nominee_info"><?php echo Lang::t('Nominees') ?></a>
            <?php if ($can_update || Users::isMyAccount($model->primaryKey)): ?>
                <span><a class="pull-right" href="<?php echo $this->createUrl('/kinsAndNominees/create', array('id' => $model->primaryKey, 'kiNom' => 'nom')) ?>"><i class="fa fa-edit"></i> <?php echo Lang::t('Edit') ?></a></span>
            <?php endif; ?>
        </h4>
    </div>
<div id="nominee_info" class="panel-collapse collapse">
        <div class="panel-body">
            <div class="detail-view">
    <table style="width: 100%">
        <tr style="font-weight: bold">
            <td style="text-align: center">No.</td>
            <td style="text-align: center">Name</td>
            <td style="text-align: center">ID. No.</td>
            <td style="text-align: center">Mobile No.</td>
            <td style="text-align: center">Relationship</td>
            <td style="text-align: center">Percent</td>
            <td style="text-align: justify">Postal Address</td>
        </tr>

        <?php
        $i = 0;
        foreach ($nominees as $rltnshps):
            ?>
            <?php
            foreach ($rltnshps as $nominee):
                $dependent = DependentMembers::model()->findByPk($nominee->dependent_member);
                ?>
                <tr>
                    <td style="text-align: center"><?php echo ++$i; ?>. </td>
                    <td style="text-align: justify"><?php echo $dependent->name; ?></td>
                    <td style="text-align: center"><?php echo $dependent->idno; ?></td>
                    <td style="text-align: center"><?php echo $dependent->mobileno; ?></td>
                    <td style="text-align: center"><?php echo Relationships::model()->returnRelationship($dependent->relationship); ?></td>
                    <td style="text-align: center"><?php echo $nominee->percent; ?></td>
                    <td style="text-align: justify"><?php echo $dependent->postaladdress; ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endforeach; ?>

    </table>

</div>
 </div>
        </div>
    </div>