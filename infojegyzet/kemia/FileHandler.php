<?php
class FileHandler 
{
    private $fileName = NULL;
    
    public function __construct($fileName = NULL)
    {
       if(file_exists($fileName)) {
            $this->fileName = $fileName;
       }
    }
    
    public function getFileName() 
    {
        return $this->fileName;
    }

    public function setFileName($fileName): void 
    {
        if(file_exists($fileName)) {
            $this->fileName = $fileName;
        }
    }

    public function beolvas($header = false) : array
    {
        $resultArray = [];
        
        if($this->fileName !== NULL) {
            $handler = fopen($this->fileName, 'r');
            if($handler) {
                $lineCount = 0;
                while(($line = fgets($handler)) !== false) {
                    if(!$header && $lineCount === 0) {
                        $lineCount++;
                        continue;
                    }
                    $resultArray[] = explode(';', $line);
                    $lineCount++;
                }
                fclose($handler);
            }
        }
        return $resultArray;
    }
}

$fileHandler = new FileHandler('felfedezesek.csv');
$resultArray = $fileHandler->beolvas();
//print('<pre>');
//var_dump($resultArray);
