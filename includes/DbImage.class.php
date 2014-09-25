<?php
/**
 * Charger/enregistrer une image dans une BD MySQL
 * @author Fobec 2011
 */
class DBImage {
    //identifiant de connection
    private $DB=array('server'=>'','user'=>'', 'password'=>'', 'db'=>'');
 
    /**
     * Fixer les identifiants de connection
     * @param  $server
     * @param  $user
     * @param  $password
     * @param  $db
     */
    public function setLogin($server, $user, $password, $db) {
        $this->DB['server']=$server;
        $this->DB['user']=$user;
        $this->DB['password']=$password;
        $this->DB['db']=$db;
    }
    /**
     * Sauver une image
     * @param string $filename nom du fichier image
     * @param string $name nom de l'image dans la table
     */
    public function write($filename, $name) {
        /**
         * Charger le fichier
         */
        if (!file_exists($filename)) {
            throw new Exception("File $filename not found !!!");
        }
        $fp      = fopen($filename, 'r');
        $data = fread($fp, filesize($filename));
        $buf = addslashes($data);
        fclose($fp);
        /**
         * Enregistrer dans la table
         */
        mysql_connect($this->DB['server'], $this->DB['user'], $this->DB['password']);
        mysql_select_db($this->DB['db']);
        mysql_query("INSERT INTO tbl_image (IMG_NAME, IMG_STREAM) VALUES ('".$name."','".$buf."')");
 
        $error=mysql_error();
        if (!empty($error)) {
            throw new Exception($error);
        }
    }
    /**
     * Charger une image
     * @param string $name nom de l'image dans la table
     * @return 
     */
    public function read($name) {
        mysql_connect($this->DB['server'], $this->DB['user'], $this->DB['password']);
        mysql_select_db($this->DB['db']);
        $q=mysql_query("SELECT IMG_STREAM from tbl_image WHERE IMG_NAME='".$name."'");
        if (mysql_num_rows($q)==0) {
          throw new Exception($name.' not found');  
        }
        $rows=mysql_fetch_array($q);
        return $rows['IMG_STREAM'];        
    }
}
?>
