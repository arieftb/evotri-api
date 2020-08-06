<?php
    define('HEADER_TOKEN_KEY', 'x-token-api');
    define('HEADER_TOKEN_VALUE', '7tNu6V8QXTQ017Z7sUyWh6De47QgZ1TwKd1ahXFEDsa51jcrrfDWdzWq7u9x9RZzhfkq21HcszXDou2cZ08KHhJMyfVHs9Audodx');
    define('HEADER_AUTH_KEY', 'auth');

    define('CREATED_AT_FIELD', 'created_at');
    define('MODIFIED_AT_FIELD', 'updated_at');
    define('ID_FIELD', 'id');

    define('USER_TABLE', 'users');
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
    define('CANDIDATE_ID_FOREIGN_FIELD', 'candidate_id');


    define('CREDENTIAL_TOKEN_FIELD', 'token');
    define('CREDENTIAL_LOGIN_DATETIME_FILED', 'login_datetime');


    define('EVENT_ID_FIELD', 'id');
    define('EVENT_CODE_FIELD', 'code');
    define('EVENT_NAME_FIELD', 'name');
    define('EVENT_IS_ACTIVE_FIELD', 'active');   
    define('EVENT_REGISTRATION_OPEN_FIELD', 'registration_open_date');
    define('EVENT_REGISTRATION_CLOSE_FIELD', 'registration_close_date');
    define('EVENT_DATE_FIELD', 'date');
    define('EVENT_IS_PUBLIC', 'public');


    define('EVENT_ADMIN_VOTER_ID_FIELD', 'voter_id');
    define('EVENT_ADMIN_IS_ACTIVE_FIELD', 'is_active');


    define('VOTER_TABLE', 'voters');
    define('VOTER_ID_FIELD', 'id');
    define('VOTER_EVENT_ID_FIELD', 'event_id');
    define('VOTER_IS_ACTIVE_FIELD', 'active');
    define('VOTER_IS_ADMIN_FIELD', 'admin');

    define('CANDIDATE_TABLE', 'candidates');
    define('CANDIDATE_ID_FIELD', 'id');
    define('CANDIDATE_VOTER_ID_FIELD', 'voter_id');
    define('CANDIDATE_VISION_FIELD', 'vision');
    define('CANDIDATE_MISSION_FIELD', 'mission');
    define('CANDIDATE_ACTIVE_FIELD', 'active');
    define('CANDIDATE_NUMBER_FIELD', 'number');
    define('CANDIDATE_IMAGE_FIELD', 'image');

    define('VOTE_TABLE', 'votes');
    define('VOTE_ID_FIELD', 'id');


    define('RESPONSE_USER_FIELD', 'user');
    define('RESPONSE_IS_SUPERADMIN_FIELD', 'is_superadmin');
    define('RESPONSE_IS_ADMIN_FIELD', 'is_admin');
    define('RESPONSE_IS_JOINED_FIELD', 'is_joined');
    define('RESPONSE_IS_PUBLIC_FIELD', 'is_public');
    define('RESPONSE_IS_ACTIVE_FIELD', 'is_active');
    define('RESPONSE_VOTES_COUNT_FIELD', 'vote_count');

    define('MESSAGE_ERROR_USER_FAILED_LOGIN', 'Email and password that you entered don\'t match. Please check and try again.');
    define('MESSAGE_ERROR_EVENT_FAILED_POST', 'Event that you entered dont\'t completed. Please check and try again.');
    define('MESSAGE_ERROR_CANDIDATE_FAILED_POST', 'Candidate form that you entered dont\'t completed. Please check and try again.');
    
    define('MESSAGE_ERROR_EVENT_NOT_FOUND', 'Event that you seek not found');
    define('MESSAGE_ERROR_VOTER_NOT_FOUND', 'Voter that you seek not found');
    define('MESSAGE_ERROR_CANDIDATE_NOT_FOUND', 'Candidate that you seek not found');
?>