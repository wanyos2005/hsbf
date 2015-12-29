<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">
            <i class="fa fa-chevron-down"></i> <a data-toggle="collapse" data-parent="#accordion" href="#spouse_info"><?php echo Lang::t('Spouse') ?></a>
            <?php if ($can_update || Users::isMyAccount($model->primaryKey)): ?>
                <span><a class="pull-right" href="<?php echo $this->createUrl('/members/dependentmembers/create', array('id' => $model->primaryKey, 'rltn1' => 4, 'rltn2' => 9)) ?>"><i class="fa fa-edit"></i> <?php echo Lang::t('Edit') ?></a></span>
            <?php endif; ?>
        </h4>
    </div>
    <div id="spouse_info" class="panel-collapse collapse">
        <div class="panel-body">
            <div class="detail-view">
                <?php if ($spouse == true): ?>
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
                        $gdrs = array(4, 9);
                        foreach ($gdrs as $gdr):
                            $spouses = DependentMembers::model()->returnDependentsOfMember($model->primaryKey, $gdr, $gdr);
                            ?>
                            <?php
                            foreach ($spouses as $spouse):
                                ?>
                                <tr>
                                    <td style="text-align: center"><?php echo ++$i; ?>. </td>
                                    <td style="text-align: justify"><?php echo $spouse->name; ?></td>
                                    <td style="text-align: center"><?php echo $spouse->idno; ?></td>
                                    <td style="text-align: center"><?php echo $spouse->alive == 1 ? 'Yes' : 'No'; ?></td>
                                    <td style="text-align: center"><?php echo Relationships::model()->returnRelationship($spouse->relationship); ?></td>
                                    <td style="text-align: center"><?php echo $spouse->mobileno; ?></td>
                                    <td style="text-align: justify"><?php echo $spouse->postaladdress; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endforeach; ?>

                    </table>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>