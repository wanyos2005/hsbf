<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">
            <i class="fa fa-chevron-down"></i> <a data-toggle="collapse" data-parent="#accordion" href="#children_info"><?php echo Lang::t('Children') ?></a>
            <?php if ($can_update || Users::isMyAccount($model->primaryKey)): ?>
                <span><a class="pull-right" href="<?php echo $this->createUrl('/members/dependentmembers/create', array('id' => $model->primaryKey, 'rltn1' => 5, 'rltn2' => 10)) ?>"><i class="fa fa-edit"></i> <?php echo Lang::t('Edit') ?></a></span>
            <?php endif; ?>
        </h4>
    </div>

    <div id="children_info" class="panel-collapse collapse">
        <div class="panel-body">
            <div class="detail-view">
                <?php if ($child == true): ?>

                    <table style="width: 100%">
                        <tr style="font-weight: bold">
                            <td style="text-align: center">No.</td>
                            <td style="text-align: center">Name</td>
                            <td style="text-align: center">ID. No.</td>
                            <td style="text-align: center">Date of Birth</td>
                            <td style="text-align: center">Alive</td>
                            <td style="text-align: center">Relationship</td>
                        </tr>


                        <?php
                        $i = 0;
                        $gdrs = array(5, 10);
                        foreach ($gdrs as $gdr):
                            $children = DependentMembers::model()->returnDependentsOfMember($model->primaryKey, $gdr, $gdr);
                            ?>
                            <?php
                            foreach ($children as $child):
                                ?>
                                <tr>
                                    <td style="text-align: center"><?php echo ++$i; ?>. </td>
                                    <td style="text-align: justify"><?php echo $child->name; ?></td>
                                    <td style="text-align: center"><?php echo $child->idno; ?></td>
                                    <td style="text-align: center"><?php echo $child->dob; ?></td>
                                    <td style="text-align: center"><?php echo $child->alive == 1 ? "Yes" : "No"; ?></td>
                                    <td style="text-align: center"><?php echo Relationships::model()->returnRelationship($child->relationship); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endforeach; ?>

                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>