<?php

namespace Silicone\Component\FileReader;

/**
 * FileReader.
 *
 * @author Ayumu Sato <mail@ayumusato.com>
 */
interface FileReaderInterface
{
    /**
     * @abstract
     * @param string $filePath
     */
    public function load($filePath);

    /**
     * @abstract
     * @param string $context
     */
    public function dig($context);

    /**
     * @abstract
     */
    public function fetch();
}
