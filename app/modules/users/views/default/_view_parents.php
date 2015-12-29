<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">
            <i class="fa fa-chevron-down"></i> <a data-toggle="collapse" data-parent="#accordion" href="<?php echo Lang::t(isset($prnts) ? '#parents_info' : '#inlaws_info'); ?>"><?php echo Lang::t(isset($prnts) ? 'Parents' : 'Parents-In-Law') ?></a>
            <?php if ($can_update || Users::isMyAccount($model->primaryKey)): ?>
                <span><a class="pull-right" href="<?php echo $this->createUrl('/members/dependentmembers/create', array('id' => $model->primaryKey, 'rltn1' => isset($prnts) ? 1 : 2, 'rltn2' => isset($prnts) ? 6 : 7)) ?>"><i class="fa fa-edit"></i> <?php echo Lang::t('Edit') ?></a></span>
            <?php endif; ?>
        </h4>
    </div>

    <div id="<?php echo Lang::t(isset($prnts) ? 'parents_info' : 'inlaws_info'); ?>" class="panel-collapse collapse">
        <div class="panel-body">
            <div class="detail-view">

                <?php if ((isset($prnts) && $prnts == true) || (isset($inlaws) && $inlaws == true)): ?>
                    <table style="width: 100%">
                        <tr style="font-weight: bold">
                            <td style="text-align: center">No.</td>
                            <td style="text-align: center">Name</td>
                            <td style="text-align: center">ID. No.</td>
                            <td style="text-align: center">Alive</td>
                            <td style="text-align: center">Relationship</td>
                            <td style="text-align: center">Mobile No.</td>
                            <td style="text-align: justify">Postal Address</td>
                        </tr>


                        <?php
                        $i = 0;
                        $gdrs = isset($prnts) ? array(1, 6) : array(2, 7);
                        foreach ($gdrs as $gdr):
                            $parents = DependentMembers::model()->returnDependentsOfMember($model->primaryKey, $gdr, $gdr);
                            ?>
                            <?php
                            foreach ($parents as $parent):
                                ?>
                                <tr>
                                    <td style="text-align: center"><?php echo ++$i; ?>. </td>
                                    <td style="text-align: justify"><?php echo $parent->name; ?></td>
                                    <td style="text-align: center"><?php echo $parent->idno; ?></td>
                                    <td style="text-align: center"><?php echo $parent->alive == 1 ? 'Yes' : 'No'; ?></td>
                                    <td style="text-align: center"><?php echo Relationships::model()->returnRelationship($parent->relationship); ?></td>
                                    <td style="text-align: center"><?php echo $parent->mobileno; ?></td>
                                    <td style="text-align: justify"><?php echo $parent->postaladdress; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endforeach; ?>

                    </table>
                <?php endif; ?>

            </div>

        </div>
    </div>
</div>