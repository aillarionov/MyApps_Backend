<?php
namespace Informer\Utils;

use Doctrine\DBAL\Logging\SQLLogger;

class Logger implements SQLLogger
{
    private $sql;
    private $params;
    private $types;
    private $start;
    private $file_name;
    
    public function __construct($file_name)
    {
        $this->file_name = $file_name;
    }

    
    /**
     * {@inheritdoc}
     */
    public function startQuery($sql, array $params = null, array $types = null)
    {
    	$this->sql = $sql;
        $this->params = $params;
        $this->types = $types;
        $this->start = microtime(true);
    }

    /**
     * {@inheritdoc}
     */
    public function stopQuery()
    {
        $file = fopen($this->file_name, "a");
        fputs($file, '['.date('d.m.Y H:i:s').'][SQL]['.round((microtime(true) - $this->start)*1000, 3).'us]: '.$this->sql.PHP_EOL);
        fclose($file);
  
        ; 
    }
} 

?>