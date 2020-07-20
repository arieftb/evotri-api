<?php
    define('HEADER_TOKEN_KEY', 'x-token-api');
    define('HEADER_TOKEN_VALUE', '7tNu6V8QXTQ017Z7sUyWh6De47QgZ1TwKd1ahXFEDsa51jcrrfDWdzWq7u9x9RZzhfkq21HcszXDou2cZ08KHhJMyfVHs9Audodx');
    define('HEADER_AUTH_KEY', 'auth');

    define('CREATED_AT_FIELD', 'created_at');
    define('MODIFIED_AT_FIELD', 'modified_at');
    define('ID_FIELD', 'id');

    define('USER_ID_FIELD', 'id');
    define('USER_CODE_FIELD', 'code');
    define('USER_EMAIL_FIELD', 'email');
    define('USER_NAME_FIELD', 'name');
    define('USER_BIRTHDATE_FIELD', 'birthdate');
    define('USER_PHONE_FIELD', 'phone');
    define('USER_PASSWORD_FIELD', 'password');
    define('USER_IMAGE_FIELD', 'image');

    define('USER_ID_FOREIGN_FIELD', 'user_id');
    define('VOTER_ID_FOREIGN_FIELD', 'voter_id');
    define('EVENT_ID_FOREIGN_FIELD', 'event_id');


    define('CREDENTIAL_TOKEN_FIELD', 'token');
    define('CREDENTIAL_LOGIN_DATETIME_FILED', 'login_datetime');


    define('EVENT_ID_FIELD', 'id');
    define('EVENT_CODE_FIELD', 'code');
    define('EVENT_NAME_FIELD', 'name');
    define('EVENT_IS_ACTIVE_FIELD', 'is_active');   
    define('EVENT_REGISTRATION_OPEN_FIELD', 'registration_open_date');
    define('EVENT_REGISTRATION_CLOSE_FIELD', 'registration_close_date');
    define('EVENT_DATE_FIELD', 'date');


    define('EVENT_ADMIN_VOTER_ID_FIELD', 'voter_id');
    define('EVENT_ADMIN_IS_ACTIVE_FIELD', 'is_active');


    define('VOTER_EVENT_ID_FIELD', 'event_id');
    define('VOTER_IS_ACTIVE_FIELD', 'is_active');


    define('RESPONSE_IS_SUPERADMIN_FIELD', 'is_superadmin');

    define('MESSAGE_ERROR_USER_FAILED_LOGIN', 'Email and password that you entered don\'t match. Please check and try again.');
    define('MESSAGE_ERROR_EVENT_FAILED_POST', 'Event that you entered dont\'t completed.');
?>