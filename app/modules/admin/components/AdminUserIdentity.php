<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class AdminUserIdentity extends UserIdentity {

        /**
         * Flag on whether to log audit trail or not
         * @var type
         */
        public $auditTrail = true;

}

