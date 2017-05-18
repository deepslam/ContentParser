<?php
namespace Deepslam\ContentParser;

use Graby\Graby;

final class ContentParserGraby extends ContentParser
{
    final protected function parse():ParsingResult
    {
        $result = new ParsingResult();
        $graby = new Graby(config('deepslam.graby'));
        $response = $graby->fetchContent($this->getURL());
        $result->setTitle($response["title"]);
        $result->setContent($response["html"]);
        return $result;
    }
}
?>