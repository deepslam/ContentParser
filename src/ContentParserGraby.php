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
        $result->setOriginal($response);
        if (isset($response["status"]) && (int)$response["status"] == 200) {
            $result->setTitle($response["title"]);
            $result->setContent($response["html"]);
            $isOGImage = ((isset($response["open_graph"])) && (isset($response["open_graph"]["og_image"])));
            if ($isOGImage) {
                $result->setImage($response["open_graph"]["og_image"]);
            }
        }
        return $result->isEmpty();
    }
}
?>