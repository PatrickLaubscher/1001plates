<?php 

namespace App\Mail;

use App\Exception\ApiException;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class ApiSpamCheckerEmail
{
    public function __construct(
        private HttpClientInterface $client,
        #[Autowire('%env(APILAYER_KEY)%')] private string $apikey
    )
    {
    }


    public function checkEmailIfSpam(string $email): bool
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Format d\'email invalide');
        }

        $response = $this->client->request(
            'POST',
            'https://api.apilayer.com/spamchecker?threshold=2.5',
            ['headers' => [
                'apikey' => $this->apikey,
                'Content-Type' => 'text/plain'], 
                'body' => $email
        ]);

        $status = $response->getStatusCode();
        $result = $response->toArray();


        if($status === 200) {
            return $result['is_spam'];
        } else {
            throw new ApiException ('La vérification de votre email a échoué');
        }

    }

}