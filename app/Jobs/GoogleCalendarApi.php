<?php

namespace Delos\Dgp\Jobs;

use Illuminate\Database\Eloquent\Collection;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Google_Service_Calendar_Calendar;
use Google_Client;
use Storage;

trait GoogleCalendarApi 
{
    public function insertEvents(Collection $allocations): void
    {
        $client = $this->getClient();
        $this->setAccessToken($client);
        
        $service = new Google_Service_Calendar($client);
        
        $calendarId = $this->getCalendarIdFromSummary(env("CALENDAR_NAME"), $service); 
        
        foreach ($allocations as $allocation) {
            
            $finish = $allocation->finish;
            $start = $allocation->start;
            
            if ( $this->isSameDays($finish, $start) ) {
                $finish->addDays(1);
            }
            
            $event = new Google_Service_Calendar_Event(array(
                'summary' => "{$allocation->project->compiled_cod} - {$allocation->user->name} - {$allocation->task->name}",
                'description' => "<h3><strong>Descrição da Alocação - Delos Project</strong></h3>" . PHP_EOL .
                "<strong>Quantidade de horas:</strong> {$allocation->hours}" . PHP_EOL . PHP_EOL . 
                "<strong>Descrição:</strong> {$allocation->description}",
                'start' => array(
                    'date' => "{$start->format('Y-m-d')}",
                ),
                'end' => array(
                    'date' => "{$finish->format('Y-m-d')}",
                    )
                ));
                
                $calendarId = $calendarId;
                $event = $service->events->insert($calendarId, $event);
            }        
        }
        
        public function DestroyEvents(Collection $allocations): void
        {
            $client = $this->getClient();
            $this->setAccessToken($client);
            
            $service = new Google_Service_Calendar($client);
        }
        
        public function getAuthUrl()
        {
            $client = $this->getClient();
            $authUrl = $client->createAuthUrl();
            
            return $authUrl;
        }
        
        private function getClient(): Google_Client
        {
            Storage::disk('local')->put('gapi/client_id.json', $this->getContentOfClientId());
            $client = new Google_Client();
            $client->setApplicationName('Delos Project');
            $client->setScopes(Google_Service_Calendar::CALENDAR);
            $client->setAuthConfig(storage_path('app/gapi/client_id.json'));

            return $client;
        }
        
        private function getContentOfClientId(): string
        {
            $content = "{
                \"web\": {
                    \"client_id\": \"992551588166-rgris3ti6qnd9m2snntpsme61o4p1rr0.apps.googleusercontent.com\",
                    \"project_id\":\"delos-project\",
                    \"auth_uri\":\"https://accounts.google.com/o/oauth2/auth\",
                    \"token_uri\":\"https://accounts.google.com/o/oauth2/token\",
                    \"auth_provider_x509_cert_url\":\"https://www.googleapis.com/oauth2/v1/certs\",
                    \"client_secret\":\"e9Aswm4uIPtMsFvwviaPAwIp\",
                    \"redirect_uris\":[\"" . env('APP_URL') . "/allocations/google/callback\"],
                    \"javascript_origins\":[
                        \"https://app.delosproject.com\",
                        \"http://localhost:8000\"
                        ]
                    }
                }";
                
                return $content;
            }
            
            private function setAccessToken($client): void
            {
                if ( !session('accessToken') ) {
                    $accessToken = $client->fetchAccessTokenWithAuthCode(session('crentials_token_gcalendar'));
                    session(['accessToken' => $accessToken]);
                } else {
                    $accessToken = session('accessToken');
                }
                
                $client->setAccessToken($accessToken);
                
                if ($client->isAccessTokenExpired()) {
                    $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
                    file_put_contents($credentialsPath, json_encode($client->getAccessToken()));
                }
            }
            
            private function isSameDays($finish, $start): bool
            {
                return $finish->format('Y-m-d') !== $start->format('Y-m-d');
            }
            
            private function getCalendarIdFromSummary(string $summary, $service) 
            {
                $calendars  = $service->calendarList->listCalendarList();

                $calendarId = ""; 
                
                foreach ($calendars as $calendar) {
                    $calendarName = $calendar->summary;
                    if ($calendarName == $summary) {
                        $calendarId = $calendar->id;
                    }
                }
                
                if ($calendarId) {
                    $service->calendars->delete($calendarId);
                }
                
                $calendar = new Google_Service_Calendar_Calendar();
                $calendar->setSummary($summary);
                $calendar->setTimeZone('America/Sao_Paulo');
                
                $createdCalendar = $service->calendars->insert($calendar);
                $calendarId = $createdCalendar->getId();
                
                return $calendarId;
            }
        }