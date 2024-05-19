<?php 

namespace App\ApiCall;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiSpamCheckerCall 
{
    public function __construct(private HttpClientInterface $client)
    {}


    public function isSpam(string $email): bool
    {
        $response = $this->client->request(
            'POST',
            'https://api.apilayer.com/spamchecker?threshold=2.5',
            ['headers' => [
                'Content-Type'=> 'application/json',
                'apikey: S2xp1Odsd0xkovKvcT7jBy8D2RbXsUzC'
            ],
            'json' => [$email]
        ]);

        
        $result = $response->toArray();

        
        return $result['is_spam'] === 'true' ? true : false;

    }

}