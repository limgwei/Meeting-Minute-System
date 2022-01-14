<?php

namespace App\Providers;

require '../vendor/autoload.php';

class GoogleCalendarService
{

  static function getClient()
  {
    define('STDIN', fopen("php://stdin", "r"));
    $client = new \Google_Client();
    $client->setApplicationName('Google Calendar API PHP Quickstart');
    $client->setScopes(\Google_Service_Calendar::CALENDAR);
    $client->setAuthConfig(storage_path('app/public/calendar/credential.json'));
    $client->setAccessType('offline');
    $client->setPrompt('select_account consent');
    $client->revokeToken();
    // Load previously authorized token from a file, if it exists.
    // The file token.json stores the user's access and refresh tokens, and is
    // created automatically when the authorization flow completes for the first
    // time.
    $tokenPath = storage_path('app/public/calendar/token.json');

    if (file_exists($tokenPath)) {
      $accessToken = json_decode(file_get_contents($tokenPath), true);
      $client->setAccessToken($accessToken);
    }

    // If there is no previous token or it's expired.
    if ($client->isAccessTokenExpired()) {
      // Refresh the token if possible, else fetch a new one.
      if ($client->getRefreshToken()) {
        $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
      } else {
        // Request authorization from the user.
        $authUrl = $client->createAuthUrl();
        printf("Open the following link in your browser:\n%s\n", $authUrl);
        print 'Enter verification code: ';
        $authCode = trim(fgets(STDIN));

        // Exchange authorization code for an access token.
        $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
        $client->setAccessToken($accessToken);

        // Check to see if there was an error.
        if (array_key_exists('error', $accessToken)) {
          throw new \Exception(join(', ', $accessToken));
        }
      }
      // Save the token to a file.
      if (!file_exists(dirname($tokenPath))) {
        mkdir(dirname($tokenPath), 0700, true);
      }
      file_put_contents($tokenPath, json_encode($client->getAccessToken()));
    }
    return $client;
  }

  static function delete()
  {
  }

  static function update($eventId, $title, $venue, $date, $time, $end_date, $end_time)
  {
    $calendarId = 'r8pce5m9uti2cts7ve5i2u8cmk@group.calendar.google.com';
    $client = self::getClient();
    $service = new \Google_Service_Calendar($client);
    $calendarList = $service->calendarList->listCalendarList();
    return $calendarList;
    $event = $service->events->get($calendarId, $eventId);
    return 0;
    $event->setSummary(array(
      'summary' => $title,
      'location' => $venue,
      'description' => '',
      'start' => array(
        'dateTime' => $date . 'T' . $time,
        'timeZone' => 'Asia/Kuala_Lumpur',
      ),
      'end' => array(
        'dateTime' => $end_date . 'T' . $end_time,
        'timeZone' => 'Asia/Kuala_Lumpur',
      ),
      'conferenceData' => [
        'createRequest' => [
          'requestId' => 'randomString' . time()
        ]
      ]
    ));

    $updatedEvent = $service->events->update($calendarId, $event->getId(), $event);
    return $updatedEvent->getUpdated();
    // Print the updated date.
    // echo $updatedEvent->getUpdated();
  }

  static function insert($title, $venue, $date, $time, $end_date, $end_time, $users)
  {
    $user_array = array();
    foreach ($users as $user) {
      array_push($user_array, array("email" => $user));
    }

    $calendarId = 'r8pce5m9uti2cts7ve5i2u8cmk@group.calendar.google.com';
    $client = self::getClient();
    $service = new \Google_Service_Calendar($client);
    $event = new \Google_Service_Calendar_Event(array(
      'summary' => $title,
      'location' => $venue,
      'start' => array(
        'dateTime' => $date . 'T' . $time,
        'timeZone' => 'Asia/Kuala_Lumpur',
      ),
      'end' => array(
        'dateTime' => $end_date . 'T' . $end_time,
        'timeZone' => 'Asia/Kuala_Lumpur',
      ),
      'attendees' => $user_array,
      'conferenceData' => [
        'createRequest' => [
          'requestId' => 'randomString' . time()
        ]
      ]
    ));

    $event = $service->events->insert($calendarId, $event, [
      'conferenceDataVersion' => 1,
      "sendUpdates" => "all",
    ]);
    $position = strpos($event->htmlLink, "eid=") + 4;

    return [$event->hangoutLink, substr($event->htmlLink, $position)];
  }
}
