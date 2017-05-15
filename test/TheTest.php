<?php

use PHPUnit\Framework\TestCase;

class TheTest extends TestCase {

    protected $cmd;

    public function setUp() {
        $this->cmd = "php " . dirname(__DIR__) . "/php-brackets-downgrade ";
    }

    public function theProvider() {
        $dataPath = __DIR__ .'/data';
        $files = glob("{$dataPath}/origin/*.php");

        $data = array_map(function($file) use ($dataPath) {
            $filename = pathinfo($file, PATHINFO_FILENAME);
            return [$file, "{$dataPath}/expect/{$filename}.php"];
        }, $files);

        return $data;
    }

    /**
     * @dataProvider theProvider
     */
    public function testIt($originFile, $expectFile) {
        $output = shell_exec($this->cmd . $originFile);
        $this->assertEquals(rtrim($output), rtrim(file_get_contents($expectFile)));
    }

}