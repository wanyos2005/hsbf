<?php

$this->renderPartial($others['render'], array(
    'user_model' => $others['user_model'],
    'person_model' => $others['person_model'],
    'person_address' => $others['person_address'],
    'verifyPhoneCode' => $others['verifyPhoneCode'],
    'verifyMailCode' => $others['verifyMailCode'],
    'contribution' => $others['contribution']
        )
);
?>