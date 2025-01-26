<?php
class GoogleCloud{
    public static function getAuthUrl(){
        $client = self::setupClient();
        $auth_url = $client->createAuthUrl();
        return $auth_url;
    }

    public static function getAccessToken($code){
        $client = self::setupClient();
        $client->fetchAccessTokenWithAuthCode($code);
        $access_token = $client->getAccessToken();
        return $access_token;
    }

    public static function setupClient(){
        $client = new Google\Client();
        $client->setAuthConfig(GOOGLE_CLIENT_SECRET);
        $client->addScope(Google\Service\Drive::DRIVE);
        $client->addScope(Google\Service\Calendar::CALENDAR);
        $client->addScope(Google\Service\Gmail::GMAIL_READONLY);
        $client->setRedirectUri(GOOGLE_REDIRECT_URI);
        $client->setAccessType('offline'); 
        $client->setIncludeGrantedScopes(true);   
        $client->setPrompt('consent');

        return $client;
    }

    public static function setupClientConfigured(){
        $client = new Google\Client();
        $client->setAuthConfig(GOOGLE_CLIENT_SECRET);
        $client->addScope(Google\Service\Drive::DRIVE);
        $client->addScope(Google\Service\Calendar::CALENDAR);
        $client->addScope(Google\Service\Gmail::GMAIL_READONLY);
        $client->setRedirectUri(GOOGLE_REDIRECT_URI);
        $client->setAccessType('offline'); 
        $client->setIncludeGrantedScopes(true);   
        $client->setPrompt('none');

        return $client;
    }

    // public function storeAccessToken($user_id, $access_token, $code){
    //     $connection = DatabaseConnection::connect();
    //     $query = $connection->prepare("INSERT INTO `api_access_tokens`(access_token, code, user_id) VALUES(?, ?, ?, ?, ?)");
    //     $query->execute(array(json_encode($access_token), $code, $user_id, date("d-m-Y H:i"), date("d-m-Y H:i")));
    //     $connection = null;
    // }

    // public function retrieveStoredAccessToken($user_id){
    //     $connection = DatabaseConnection::connect();
    //     $query = $connection->prepare("SELECT api_access_tokens.access_token FROM api_access_tokens WHERE user_id = ?");
    //     $query->execute(array($user_id));
    //     $connection = null;
    //     return $query->fetch(PDO::FETCH_OBJ);
    // }

    // public function deleteStoredAccessToken($user_id, $refresh_token){
    //     $client = $this->setupClientConfigured();
    //     $access_token = $client->refreshToken($refresh_token);

    //     $client->setAccessToken($access_token);
    //     $client->revokeToken();

    //     $connection = DatabaseConnection::connect();
    //     $query = $connection->prepare("DELETE FROM api_access_tokens WHERE user_id = ?");
    //     $query->execute(array($user_id));
    //     $connection = null;
    // }

    public static function storeAccessToken($user_id, $access_token){
        $connection =  DatabaseController::connect();
        try {
            $query = $connection->prepare("INSERT INTO api_access_tokens(access_token, user_id) VALUES(?, ?)");
            $query->execute(array(json_encode($access_token), $user_id));
             DatabaseController::disconnect();

        } catch (PDOException $e) {
            error_log($e->getMessage());
        }
    }

    public static function retrieveStoredAccessToken($user_id){
        $connection =  DatabaseController::connect();
        $query = $connection->prepare("SELECT api_access_tokens.access_token FROM api_access_tokens WHERE user_id = ?");
        $query->execute(array($user_id));
         DatabaseController::disconnect();
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public static function deleteStoredAccessToken($user_id, $refresh_token){
        $client = self::setupClientConfigured();
        $access_token = $client->refreshToken($refresh_token);

        $client->setAccessToken($access_token);
        $client->revokeToken();

        $connection =  DatabaseController::connect();
        $query = $connection->prepare("DELETE FROM api_access_tokens WHERE user_id = ?");
        $query->execute(array($user_id));
        $connection = null;
    }

    public function testCalendar($access_token){
        $client = $this->setupClient();
        $client->setAccessToken($access_token);

        $service = new Google\Service\Calendar($client);
        $calendar = $service->events->get('primary');

        return json_encode($calendar->getSummary());
    }

    public function addEventBackup($access_token){
        $client = $this->setupClient();
        $client->setAccessToken($access_token);

        $service = new Google\Service\Calendar($client);

        $event = new Google_Service_Calendar_Event(array(
            'summary' => 'Phoebe Demo',
            'location' => 'Property Agents Network Office',
            'description' => 'A chance to hear more about Google\'s developer products.',
            'start' => array(
                'dateTime' => '2022-11-19T09:00:00-07:00',
                'timeZone' => 'America/Los_Angeles',
            ),
            'end' => array(
                'dateTime' => '2022-11-19T17:00:00-07:00',
                'timeZone' => 'America/Los_Angeles',
            ),
            'recurrence' => array(
                'RRULE:FREQ=DAILY;COUNT=2'
            ),
            'attendees' => array(
                array('email' => 'lpage@example.com'),
                array('email' => 'sbrin@example.com'),
            ),
            'reminders' => array(
                'useDefault' => FALSE,
                'overrides' => array(
                    array('method' => 'email', 'minutes' => 24 * 60),
                    array('method' => 'popup', 'minutes' => 10),
                ),
            ),
        ));

        $calendarId = 'primary';
        $event = $service->events->insert($calendarId, $event);
        printf('Event created: %s\n', $event->htmlLink);

    }

    public function addEvent($refresh_token, $event_details){
        $client = $this->setupClientConfigured();
        $access_token = $client->refreshToken($refresh_token);

        $client->setAccessToken($access_token);
        $service = new Google\Service\Calendar($client);


        try {
            $start_date = Carbon::createFromFormat('Y-m-d H:i', date('Y-m-d H:i', strtotime($event_details['start_date'])))->format(DateTime::ISO8601);
            $stop_date = Carbon::createFromFormat('Y-m-d H:i', date('Y-m-d H:i', strtotime($event_details['stop_date'])))->format(DateTime::ISO8601);
    
            $event = new Google_Service_Calendar_Event(array(
                'summary' => $event_details['title'],
                'location' => $event_details['location'],
                'description' => $event_details['description'],
                'start' => array(
                    'dateTime' => $start_date,
                    'timeZone' => 'Africa/Nairobi',
                ),
                'end' => array(
                    'dateTime' => $stop_date,
                    'timeZone' => 'Africa/Nairobi',
                ),
                'attendees' => array(
                    array('email' => $event_details['attendee'],
                ),
                'reminders' => array(
                    'useDefault' => FALSE,
                    'overrides' => array(
                        array('method' => 'email', 'minutes' => 24 * 60),
                        array('method' => 'popup', 'minutes' => 10),
                    ),
                ),
            )));
    
            $calendarId = 'primary';
            $event = $service->events->insert($calendarId, $event);
            
            header('Location: dashboard.php?success=Event created successfully');
        } catch (\Throwable $th) {
            header('Location: dashboard.php?error=An error occurred');
        }

    }

    public function getEvents($refresh_token){
        $client = $this->setupClientConfigured();

        $access_token = $client->refreshToken($refresh_token);

        $client->setAccessToken($access_token);

        $service = new Google\Service\Calendar($client);

        $events = $service->events->listEvents('primary');
        // $events_array = (array)$events;
        // $sorted_events = ksort($events_array);
        // return json_decode(json_encode($sorted_events));
        return $events;
    }

    private function addScopes($client){
        $client->addScope(Google\Service\Drive::DRIVE_METADATA_READONLY);
    }
}