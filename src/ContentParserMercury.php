<?php
namespace Deepslam\ContentParser;

use Curl;

final class ContentParserMercury extends ContentParser
{
    final protected function getData():bool
    {
        $result = $this->getResult();
        $response = Curl::to('https://mercury.postlight.com/parser?url='.urlencode($this->getURL()))
            ->withHeaders(array('x-api-key: '.config('deepslam.mercury.api_key')))
            ->asJson()
            ->get();
        if (!is_null($response)) {
            $result->setOriginal($response);
            $result->setTitle($response->title);
            $result->setContent($response->content);
        }
        return ($result->isEmpty());
    }
}
?>