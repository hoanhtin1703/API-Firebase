<?php

declare(strict_types=1);

namespace Kreait\Firebase\Auth\SendActionLink;

use Beste\Json;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Utils;
use Kreait\Firebase\Auth\SendActionLink;
use Kreait\Firebase\Http\WrappedPsr7Request;
use Psr\Http\Message\RequestInterface;

use const JSON_FORCE_OBJECT;

use function array_filter;

/**
 * @deprecated 6.0.1
 * @codeCoverageIgnore
 */
final class ApiRequest implements RequestInterface
{
    use WrappedPsr7Request;

    public function __construct(SendActionLink $action)
    {
        $uri = Utils::uriFor('https://identitytoolkit.googleapis.com/v1/accounts:sendOobCode');

        $data = array_filter([
            'requestType' => $action->type(),
            'email' => $action->email(),
            'tenantId' => $action->tenantId(),
        ]) + $action->settings()->toArray();

        if ($idTokenString = $action->idTokenString()) {
            $data['idToken'] = $idTokenString;
        }

        $body = Utils::streamFor(Json::encode($data, JSON_FORCE_OBJECT));

        $headers = array_filter([
            'Content-Type' => 'application/json; charset=UTF-8',
            'Content-Length' => (string) $body->getSize(),
            'X-Firebase-Locale' => $action->locale(),
        ]);

        $this->wrappedRequest = new Request('POST', $uri, $headers, $body);
    }
}
