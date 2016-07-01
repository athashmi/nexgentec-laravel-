<?php namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class GoogleCalendar {

    protected $client;

    protected $service;
    protected $event;
    protected $calendarId;

    function __construct() {
        /* Get config variables */
        $client_id = Config::get('google.client_id');
        $this->calendarId = Config::get('google.calendar_id');
        $service_account_name = Config::get('google.service_account_name');
        $key_file_location = base_path() . Config::get('google.key_file_location');

        $this->client = new \Google_Client();
        $this->client->setApplicationName("google-calander");
        $this->service = new \Google_Service_Calendar($this->client);



        /* If we have an access token */
        if (Cache::has('service_token')) {
          $this->client->setAccessToken(Cache::get('service_token'));
        }

        $key = file_get_contents($key_file_location);
        /* Add the scopes you need */
        $scopes = array('https://www.googleapis.com/auth/calendar');
        $cred = new \Google_Auth_AssertionCredentials(
            $service_account_name,
            $scopes,
            $key
        );

        $this->client->setAssertionCredentials($cred);
        if ($this->client->getAuth()->isAccessTokenExpired()) {
          $this->client->getAuth()->refreshTokenWithAssertion($cred);
        }
        Cache::forever('service_token', $this->client->getAccessToken());
    }

    public function get()
    {
        $results = $this->service->calendars->get($this->calendarId);
        //dd($results);
        return($results);
    }

    function eventPost($data)
    {
        $event = new \Google_Service_Calendar_Event($data);
        
        $event = $this->service->events->insert($this->calendarId, $event);
        //printf('Event created: %s\n', $event->htmlLink);
        if($event)
        return $event;
        
    }
    function eventList()
    {
        $events = $this->service->events->listEvents($this->calendarId);

       return $events;
    }
    function eventDelete($event_id)
    {
        $this->service->events->delete($this->calendarId, $event_id);
        //$events = $this->service->events->listEvents($this->calendarId);

       return true;
    }
}