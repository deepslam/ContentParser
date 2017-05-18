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
    public function __construct($url, Array $params = []) {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new Exception(self::ERR_WRONG_URL);
        }
        $this->url = $url;
        $this->urlParams = parse_url($this->getURL());
        $this->parsingResult = $this->parse();
        if ($this->needsCodeStrip()) {
            $this->parsingResult->stripContent();
        }
        if ($this->needsCodeClean()) {
            $this->parsingResult->cleanContent();
        }
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
    public static function create(String $url,String $parser = '') {
        if (isset(self::$parsers[$parser])) {
            $workParser = self::$parsers[$parser];
        } else {
            $workParser = ContentParserGraby::class;
        }
        return new $workParser($url);
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

    /*** ABSTRACT LAYER ***/
    /**
     * Abstract function of parsing content
     *
     * @return mixed
     */
    abstract protected function parse():ParsingResult;
}
?>