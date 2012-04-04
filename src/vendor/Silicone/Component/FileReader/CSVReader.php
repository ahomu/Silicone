<?php

namespace Silicone\Component\FileReader;

/**
 * CSV FileReader.
 *
 * @author Ayumu Sato <mail@ayumusato.com>
 */
class CSVReader implements FileReaderInterface
{
    /**
     * @var resource
     */
    private $_pointer;

    /**
     * Load CSV file, and keep the file pointer.
     *
     * @param string $filePath
     */
    public function load($filePath)
    {
        $this->_pointer = fopen($filePath, 'r');
    }

    /**
     * Moving pointer to number of row.
     *
     * @param int $context
     * @param bool $rewind
     * @return bool
     */
    public function dig($context, $rewind = false)
    {
        if (!!$rewind) {
            rewind($this->_pointer);
        }

        $i = 0;
        for (; $i < $context; $i++) {
            if (false === fgets($this->_pointer) ) {
                break;
            }
        }

        return feof($this->_pointer) ? false : true;
    }

    /**
     * Get a data of row as array.
     *
     * @return array|bool
     */
    public function fetch()
    {
        return fgetcsv($this->_pointer);
    }
}