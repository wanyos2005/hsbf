<?php $i = 0; ?>
<?php foreach ($receipts as $receipt): ?>

    <?php if (++$i > 1): ?><div style="page-break-after: always"></div><?php endif; ?>

    <?php $this->renderPartial('application.views.pdf.receipt', array('receipt' => $receipt)); ?>

<?php endforeach; ?>