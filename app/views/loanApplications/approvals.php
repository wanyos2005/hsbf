<?php if ($others['readOnly'] == true): ?>
    <?php if ($model->forwarded_by_secretary != 'Pending'): ?>
        <tr>
            <td colspan="8">
                Secretary's Comment: 
                <?php
                $bln = $model->forwarded_by_secretary == 'Yes' ? 'Forwaded' : 'Not Forwarded';
                echo "$bln On $model->secretary_date"
                ?>
            </td>
        </tr>
        <tr><td>&nbsp;</td></tr>
    <?php endif; ?>

    <?php if ($model->forwarded_by_treasurer != 'Pending'): ?>
        <tr>
            <td colspan="8">
                Treasurer's Comment: 
                <?php
                $bln = $model->forwarded_by_treasurer == 'Yes' ? 'Forwaded' : 'Not Forwarded';
                echo "$bln On $model->treasurer_date"
                ?>
            </td>
        </tr>
        <tr><td>&nbsp;</td></tr>
    <?php endif; ?>

    <?php if ($model->approved_by_chairman != 'Pending'): ?>
        <tr>
            <td colspan="8">
                Chairperson's Comment: 
                <?php
                $bln = $model->approved_by_chairman == 'Yes' ? 'Approved' : 'Not Approved';
                echo "$bln On $model->chairman_date"
                ?>
            </td>
        </tr>
        <tr><td>&nbsp;</td></tr>
    <?php endif; ?>

<?php endif; ?>