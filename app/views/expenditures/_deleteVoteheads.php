<?php if (count($deleteVoteheads = Voteheads::model()->voteHeadsForType($field)) > 0) : ?>
    You may want to remove some vote heads:

    <div style="height: 120px; overflow-x: hidden">
        <table style="width: 100%">

            <tr><td colspan="3">&nbsp;</td></tr>
            <?php
            $d = 0;
            foreach ($deleteVoteheads as $deleteVotehead)
                if ($deleteVotehead->votehead != Expenditures::DEPOSIT_TO_BANK && $deleteVotehead->votehead != Incomes::WITHDRAWAL_FROM_BANK) :
                    ?>
                    <tr id="<?php echo "row$deleteVotehead->primaryKey"; ?>">
                        <?php $this->renderPartial('application.views.expenditures.deleteRow', array('deleteVotehead' => $deleteVotehead, 'field' => $field, 'd' => ++$d)); ?>
                    </tr>
            <?php  endif; ?>
        </table>
    </div>
<?php endif; ?>