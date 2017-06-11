<?php
/**
 * Content parser and detector from different webservices
 */
namespace Deepslam\ContentParser;

abstract class ContentParser {
    /**
     * Error constants
     *
     * @const string
     */
    const ERR_WRONG_URL = 'No URL has been received';

    /**
     * Parsing constants
     *
     * @const boolean
     */
    const PARSING_DONE = true;
    const PARSING_FAIL = false;

    /**
     * Registered parsers
     *
     * @var array
     */
    private static $parsers = [];

    /**
     * Url for parse
     *
     * @var string
     */
    private $url = '';

    /**
     * These are received URL params.
     *
     * @var array
     */
    private $urlParams = [];

    /**
     * Stored latest parsing result
     *
     * @var array
     */
    private $parsingResult = [];

    /**
     * Object constructor
     *
     * @return ContentParser
     * @throw new Exception if no url has been received
     */
    public function __construct() {
        $this->parsingResult = new ParsingResult();
    }

    /**
     * Returns URL
     *
     * @return string Working URL
     */
    public function getURL() {
        return $this->url;
    }

    /**
     * Returns parsed URL params such as host, path etc...
     *
     * @return array
     */
    public function getURLParams() {
        return $this->urlParams;
    }

    /**
     * Returns parsing result
     *
     * @return ParsingResult Link to the instance of parsing result
     */
    public function getResult() {
        return $this->parsingResult;
    }

    /*** PROTECTED LAYER ***/

    /**
     * Checks whether have to do clean code or not.
     *
     * @return bool True - need to clean code, false - needn't to clean code
     */
    final protected function needsCodeClean() {
        return ((bool)config('deepslam.parser.clean_code'));
    }

    /**
     * Checks whether have to strip tags or not.
     *
     * @return bool True - need to strip tags, false - needn't to strip tags
     */
    final protected function needsCodeStrip() {
        return ((bool)config('deepslam.parser.strip_tags'));
    }

    /*** STATIC LAYER ***/

    /**
     * Factory method for creation needle parser class
     *
     * @param String $url
     * @param $parser
     *
     * @return ContentParserMercury The link to the created instance
     */
    public static function create(String $parser = '') {
        if (isset(self::$parsers[$parser])) {
            $workParser = self::$parsers[$parser];
        } else {
            $workParser = ContentParserGraby::class;
        }
        return new $workParser();
    }

    /**
     * Registers new grabber
     *
     * @param String $alias
     * @param String $className
     *
     * @return nothing
     */
    public static function register(Array $params) {
        if (count($params) == 0) {
            return ;
        }
        foreach ($params as $alias => $className) {
            self::$parsers[$alias] = $className;
        }
    }

    /**
     * Parses the needle URL
     * Throws exception if has been received wrong URL
     *
     * @param String $url URL for parsing
     *
     * @return @ParsingResult Link to the parsing result
     */
    public function parse($url) {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new Exception(self::ERR_WRONG_URL);
        }
        $this->url = $url;
        $this->urlParams = parse_url($this->getURL());
        if ($this->needsCodeStrip()) {
            $this->parsingResult->stripContent();
        }
        if ($this->needsCodeClean()) {
            $this->parsingResult->cleanContent();
        }
        $this->resetParsingResult();
        $this->getData();
        return $this->getResult();
    }

    /*** PRIVATE LAYER ***/
    /**
     * Resets parsing result
     *
     * @return nothing
     */
    private function resetParsingResult() {
        if ($this->parsingResult instanceof ParsingResult) {
            unset($this->parsingResult);
        }
        $this->parsingResult = new ParsingResult();
    }

    /*** ABSTRACT LAYER ***/
    /**
     * Abstract function of parsing content
     *
     * @return mixed
     */
    abstract protected function getData():bool;
}
?>