<?php
namespace Deepslam\ContentParser;

use Curl;

final class ContentParserMercury extends ContentParser
{
    final protected function parse():ParsingResult
    {
        $result = new ParsingResult();
        $response = Curl::to('https://mercury.postlight.com/parser?url='.urlencode($this->getURL()))
            ->withHeaders(array('x-api-key: '.config('deepslam.mercury.api-key')))
            ->asJson()
            ->get();
        if (!is_null($response)) {
            $result->setTitle($response->title);
            $result->setContent($response->content);
        }
        return $result;
    }
}
?>