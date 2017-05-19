<?php
namespace Deepslam\ContentParser;

use Graby\Graby;

final class ContentParserGraby extends ContentParser
{
    final protected function getData():bool
    {
        $result = $this->getResult();
        $graby = new Graby(config('deepslam.graby'));
        $response = $graby->fetchContent($this->getURL());
        if (isset($response["status"]) && (int)$response["status"] == 200) {
            $result->setTitle($response["title"]);
            $result->setContent($response["html"]);
        }
        return $result->isEmpty();
    }
}
?>