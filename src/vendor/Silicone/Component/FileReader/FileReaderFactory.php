<?php

namespace Silicone\Component\FileReader;

/**
 * FileReader's Factory class.
 *
 * @author Ayumu Sato <mail@ayumusato.com>
 */
class FileReaderFactory
{
    /** @var array */
    private $_readerCollection;

    /**
     * Detecting file type and load.
     * Get initialized FileReader instance.
     *
     * @param string $filePath
     * @param string $type
     * @return bool|\Silicone\Component\FileReader\FileReaderInterface
     * @throws \Exception
     */
    public function call($filePath, $type = '')
    {
        if (!is_readable($filePath)) {
            throw new \Exception('is not readable');
        }

        // specified type
        if (!$reader = $this->getReaderClassName($type)) {

            // detect from mime types
            $mimeType = mime_content_type($filePath);
            $type     = substr($mimeType, strpos($mimeType, '/')+1);
            if (!$reader = $this->getReaderClassName($type)) {

                // detect from file name
                $type = substr($filePath, strpos($filePath, '.')+1);
                if (!$reader = $this->getReaderClassName($type)) {

                    throw new \Exception('invalid support type');
                }
            }
        }

        $reader = new $reader();
        $reader->load($filePath);
        return $reader;
    }

    /**
     * Get proper FileReader class name.
     *
     * @param string $type
     * @return bool|\Silicone\Component\FileReader\FileReaderInterface
     */
    public function getReaderClassName($type)
    {
        return isset($this->_readerCollection[$type]) ? $this->_readerCollection[$type] : false;
    }

    /**
     * Register FileReader class name.
     *
     * @param string $type
     * @param string $className
     * @throws \Exception
     */
    public function registerReader($type, $className)
    {
        if (!class_exists($className)) {
            throw new \Exception('not exists class');
        }

        $this->_readerCollection[$type] = $className;
    }
}
