<?php

namespace App\Mail;

use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\AbstractTransport;
use Symfony\Component\Mime\MessageConverter;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MailerooTransport extends AbstractTransport
{
    protected string $apiKey;
    protected string $baseUrl;

    public function __construct(string $apiKey, string $baseUrl)
    {
        parent::__construct();
        $this->apiKey = $apiKey;
        $this->baseUrl = rtrim($baseUrl, '/');
    }

    protected function doSend(SentMessage $message): void
    {
        $email = MessageConverter::toEmail($message->getOriginalMessage());

        $from = $email->getFrom()[0] ?? null;
        $toList = [];
        foreach ($email->getTo() as $address) {
            $entry = ['address' => $address->getAddress()];
            if ($address->getName()) {
                $entry['display_name'] = $address->getName();
            }
            $toList[] = $entry;
        }

        $payload = [
            'from' => [
                'address'      => $from?->getAddress(),
                'display_name' => $from?->getName() ?: config('app.name'),
            ],
            'to'      => $toList,
            'subject' => $email->getSubject(),
        ];

        $htmlBody = $email->getHtmlBody();
        $textBody = $email->getTextBody();

        if ($htmlBody) {
            $payload['html'] = $htmlBody;
        }
        if ($textBody) {
            $payload['plain'] = $textBody;
        }

        // Add CC if present
        if ($email->getCc()) {
            $ccList = [];
            foreach ($email->getCc() as $address) {
                $entry = ['address' => $address->getAddress()];
                if ($address->getName()) {
                    $entry['display_name'] = $address->getName();
                }
                $ccList[] = $entry;
            }
            if (!empty($ccList)) {
                $payload['cc'] = $ccList;
            }
        }

        // Add Reply-To if present
        if ($email->getReplyTo()) {
            $replyToList = [];
            foreach ($email->getReplyTo() as $address) {
                $entry = ['address' => $address->getAddress()];
                if ($address->getName()) {
                    $entry['display_name'] = $address->getName();
                }
                $replyToList[] = $entry;
            }
            if (!empty($replyToList)) {
                $payload['reply_to'] = count($replyToList) === 1 ? $replyToList[0] : $replyToList;
            }
        }

        $response = Http::withHeaders([
            'X-API-Key' => $this->apiKey,
        ])->post($this->baseUrl . '/emails', $payload);

        if ($response->failed()) {
            Log::error('Maileroo API error', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);
            throw new \RuntimeException('Maileroo API returned status ' . $response->status() . ': ' . $response->body());
        }

        Log::info('Maileroo email sent', [
            'to'      => array_column($toList, 'address'),
            'subject' => $email->getSubject(),
        ]);
    }

    public function __toString(): string
    {
        return 'maileroo';
    }
}
