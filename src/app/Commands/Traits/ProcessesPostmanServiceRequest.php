<?php

namespace Lionix\LaravelPostmanRoutes\Commands\Traits;

use GuzzleHttp\Exception\RequestException;
use Lionix\LaravelPostmanRoutes\Exceptions\PostmanApiUnexpectedResponseException;

trait ProcessesPostmanServiceRequest
{
    public function processPostmanServiceRequest(callable $callback)
    {
        try {
            $response = $callback();
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $body = json_decode($e->getResponse()->getBody());

                if ($error = $body->error) {
                    $this->error($error->name);
                    $this->comment($error->message);

                    if (isset($error->details)) {
                        foreach ($error->details as $key => $message) {
                            $this->comment($key . ': ' . $message);
                        }
                    }

                }

            } else {
                $this->error($e->getMessage());
            }

            exit(1);

        } catch (PostmanApiUnexpectedResponseException $e) {
            $this->error($e->getMessage());

            exit(1);

        }

        return $response;
    }
}
