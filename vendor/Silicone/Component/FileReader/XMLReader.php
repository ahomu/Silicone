<?php

namespace Silicone\Component\FileReader;

/**
 * XML FileReader.
 *
 * @author Ayumu Sato <mail@ayumusato.com>
 */
class XMLReader implements FileReaderInterface
{
    /**
     * @var \XMLReader
     */
    private $_pointer;

    /**
     * @var string
     */
    private $_rootElement;

    /**
     * @var string
     */
    private $_readIter;

    /**
     * @var string
     */
    private $_currentIterElement;

    /**
     * Load XML file, and construct XMLReader.
     *
     * @param string $filePath
     */
    public function load($filePath)
    {
        $this->_pointer = new \XMLReader();
        $this->_pointer->open($filePath, null, LIBXML_NOBLANKS);

        // root
        $this->_pointer->read();
        $this->_rootElement = $this->_pointer->name;

        // detect iteration method
        $this->_readIter = method_exists($this->_pointer, 'readOuterXml') ? '_getObjectFromXmlString' : '_getObjectFromDomElement';
    }

    /**
     * Digging target of iteration Element.
     *
     * @param string $iterElementContext
     */
    public function dig($iterElementContext)
    {
        $tokens = explode('>', str_replace(' ', '', $iterElementContext));

        if ($this->_rootElement === reset($tokens)) {
            array_shift($tokens);
        }

        foreach ($tokens as $token) {
            // dig children
            do {
                if (!$this->_pointer->read()) {
                    // notFound
                    break;
                }
            } while($this->_pointer->nodeType !== \XMLReader::ELEMENT);

            // seek siblings
            while ($this->_pointer->name !== $token) {
                if (!$this->_pointer->next()) {
                    // notFound
                    break;
                }
            }
        }

        $this->_currentIterElement = end($tokens);
    }

    /**
     * Get current element and move to next point.
     *
     * @return bool|\SimpleXMLElement
     */
    public function fetch()
    {
        if ($this->_pointer->name !== $this->_currentIterElement) {
            return false;
        }

        $rv = $this->{$this->_readIter}();
        $this->_pointer->next();

        return $rv;
    }

    /**
     * If 'readOuterXml' method can use.
     * Get Object of SimpleXMLElement.
     *
     * @return \SimpleXMLElement
     */
    private function _getObjectFromXmlString()
    {
        $xml = $this->_pointer->readOuterXml();
        return simplexml_load_string($xml);
    }

    /**
     * If 'readOuterXml' method cannot use.
     * Get Object of SimpleXMLElement.
     *
     * @return \SimpleXMLElement
     */
    private function _getObjectFromDomElement()
    {
        $node = $this->_pointer->expand();
        $dom  = new \DomDocument();
        $dom->formatOutput = true;
        $assocNode = $dom->importNode($node, true);

        $rv  = simplexml_import_dom($assocNode);
        $dom = $node = $assocNode = null;
        return $rv;
    }

    /**
     * Alias of original XMLReader.
     *
     * @param string $method
     * @param array $args
     * @return mixed
     * @throws \Exception
     */
    public function __call($method, $args)
    {
        if (method_exists($this->_pointer, $method)) {
            return call_user_func(array($this->_pointer, $method), $args);
        } else {
            throw new \Exception('method is not exists');
        }
    }
}
