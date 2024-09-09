<?php

namespace App\Services;

use GuzzleHttp\Client;

class ExternalJobService
{
    protected $client;
    protected $url;

    public function __construct()
    {
        $this->client = new Client();
        $this->url = env('EXTERNAL_JOB_SERVICE_URL') ?? '';
    }

    /**
     * @return array
     */
    public function fetchExternalJobs($queryParams = '')
    {
        try {

            if (!empty($queryParams)) {
                $this->url .= '?' . http_build_query($queryParams);
            }

            $response = $this->client->get($this->url);
            $externalJobs = json_decode($response->getBody()->getContents(), true);

            return $this->transformExternalJobs($externalJobs);

        } catch (\Exception $e) {
            return [];
        }
    }

    protected function transformExternalJobs(array $externalJobs)
    {
        $jobs = [];

        foreach ($externalJobs as $country => $jobsInCountry) {
            foreach ($jobsInCountry as $jobData) {
                $title = $jobData[0];
                $salary = $jobData[1];
                $skillsXml = $jobData[2];

                $skills = $this->parseSkillsFromXml($skillsXml);

                $jobs[] = [
                    'title' => $title,
                    'salary' => $salary,
                    'skills' => $skills,
                    'location' => $country
                ];
            }
        }

        return $jobs;
    }

    protected function parseSkillsFromXml(string $xml)
    {
        $skills = [];
        $xmlObject = simplexml_load_string($xml);
        if ($xmlObject && isset($xmlObject->skill)) {
            foreach ($xmlObject->skill as $skill) {
                $skills[] = (string) $skill;
            }
        }
        return $skills;
    }

}
