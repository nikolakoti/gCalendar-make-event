<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\FormResponse;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Google_Service_Calendar_EventReminders;


class CalendarController extends Controller {

    public static function getClient() {

        $client = new Google_Client();
        $client->setApplicationName('Create Event With Reminder');
        $client->setScopes(Google_Service_Calendar::CALENDAR);
        $client->setAuthConfig('credentials.json');
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');



        // Load previously authorized token from a file, if it exists.
        // The file token.json stores the user's access and refresh tokens, and is
        // created automatically when the authorization flow completes for the first
        // time.
        $tokenPath = 'token.json';
        if (file_exists($tokenPath)) {
            $accessToken = json_decode(file_get_contents($tokenPath), true);
            //dd($accessToken);

            $client->setAccessToken($accessToken);
        }

        //dd($client->isAccessTokenExpired());
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
                    throw new Exception(join(', ', $accessToken));
                }
            }
            // Save the token to a file
            if (!file_exists(dirname($tokenPath))) {
                mkdir(dirname($tokenPath), 0700, true);
            }
            file_put_contents($tokenPath, json_encode($client->getAccessToken()));
        }
        return $client;
    }

    public function getEvents() {

        $client = self::getClient();

        $service = new Google_Service_Calendar($client);

        //Print the next 10 events on the user's calendar.
        $calendarId = 'primary';
        $optParams = [
            'maxResults' => 10,
            'orderBy' => 'startTime',
            'singleEvents' => true,
            'timeMin' => date('c'),
        ];
        $results = $service->events->listEvents($calendarId, $optParams);
        $events = $results->getItems();

        if (empty($events)) {
            print "No upcoming events found.\n";
        } else {
            print "Upcoming events:\n";
            foreach ($events as $event) {
                $start = $event->start->dateTime;
                if (empty($start)) {
                    $start = $event->start->date;
                }
                printf("%s (%s)\n", $event->getSummary(), $start);
            }
        }
    }

    public function createEvent() {

        $request = request();

        $formData = $request->validate([
            'name' => 'required|string|min:2|max:20',
            'surname' => 'required|string|min:2|max:20',
            'phone' => 'required|numeric',
            'email' => 'required|email',
            'time' => 'required|date_format:H:i:s',
            'date' => 'required|date_format:Y-m-d',
            'captcha' => 'required|captcha'
        ]);


        $client = self::getClient();

        $service = new Google_Service_Calendar($client);

        $event = new Google_Service_Calendar_Event();

        $event = new Google_Service_Calendar_Event([
            'summary' => $formData['name'] . " " . $formData['surname'],
            'description' => "Phone: " . $formData['phone'] . " " . "E-mail: " . $formData['email'],
            'start' => [
                'dateTime' => $formData['date'] . "T" . $formData['time'] . "+01:00",
                'timeZone' => 'Europe/Belgrade',
            ],
            'end' => [
                'dateTime' => $formData['date'] . "T" . $formData['time'] . "+01:00",
                'timeZone' => 'Europe/Belgrade',
            ],
            'attendees' => [
                ['email' => 'jdoe.task@gmail.com'],
                ['email' => $formData['email']],
            ],
            'reminders' => [
                'useDefault' => false,
                'overrides' => [
                    ['method' => 'email', 'minutes' => 30],
                    ['method' => 'email', 'minutes' => 15],
                    ['method' => 'email', 'minutes' => 30],
                    ['method' => 'email', 'minutes' => 15],
                ],
            ],
        ]);

        $optParams = [
            'sendNotifications' => true,
        ];

        $calendarId = 'primary';
        $event = $service->events->insert($calendarId, $event, $optParams);

        if (!$event) {

            return response()->json([
                        "state" => "error",
                        "message" => "Whoops... Something went wrong! \n Please, refresh page and try again."
            ]);
        }

        Mail::to($formData['email'])
                ->send(new FormResponse([
                    'name' => $formData['name'],
                    'surname' => $formData['surname'],
                    'phone' => $formData['phone'],
                    'email' => $formData['email'],
                    'date' => $formData['date'],
                    'time' => $formData['time'],
        ]));

        return response()->json([
                    "state" => "success",
                    "message" => "You have been successfully created event."
                        ], 200);
    }

}
