<?php
/**
 * This class describes a parsing result including such options as:
 *
 * Parsed URL
 * Detected title, description and SEO information such as meta description, meta keywords and meta title.
 *
 * @author Ivanov Dmitry <me@ivanovdmitry.com>
 */
namespace Deepslam\ContentParser;

use stdClass;
use Deepslam\ContentParser\Encoding;

final class ParsingResult {
    /**
     * Stored params
     *
     * @var array
     */
    private $params = [
        'title' => '',
        'content' => ''
    ];

    /**
     * Magic method for get and sets values
     *
     * @param $name
     * @param $params
     *
     * @return mixed
     */
    public function __call($name, $params) {
        $result = false;
        $action = strtoupper(substr($name,0,3));
        $param = strtolower(substr($name,3));
        switch ($action) {
            case "SET":
                    if (isset($this->params[$param]) && is_array($params) && isset($params[0])) {
                        $this->params[$param] = $params[0];
                        $result = true;
                    }
                break;
            case "GET":
                    if (isset($this->params[$param])) {
                        return $this->params[$param];
                    } else {
                        return null;
                    }
                break;
        }
        return $result;
    }

    /**
     * Is it empty or not?
     *
     * @return boolean True - yes, it's empty, false - no, it isn't empty
     */
    public function isEmpty() {
        return (
            empty($this->getTitle()) &&
            empty($this->getContent())
        );
    }

    /**
     * Let's clean content from HTML entities such as classes, id etc.
     *
     * @return String Cleaned content
     */
    public function cleanContent() {
        $this->params["content"] = preg_replace( '/\s?(style|class|id)=[\'"]{1}.*[\'"]{1}/sUi', '', $this->params["content"], -1 );
    }
}
?>