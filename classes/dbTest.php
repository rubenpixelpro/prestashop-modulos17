<?php
class dbTest extends Module {
    
    public function __construct() {
        
    }
   
    public function select() {
        //$db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        
        $sql = 'SELECT * FROM '._DB_PREFIX_.'test;';
        $result1 = Db::getInstance()->executeS($sql);
        // Array
        //$this->pre($result1, 'executeS');
       
        $sql = 'SELECT value FROM '._DB_PREFIX_.'test;';
        $result2 = Db::getInstance()->getValue($sql);
        
        // String
        //$this->printScreen($result2, 'Get Value');
       
        $result3 = Db::getInstance()->getRow('SELECT * FROM '._DB_PREFIX_.'test WHERE id = 1');
        //$this->pre($result3, 'getRow');
       
        $query = new DbQuery();
        $query->select('p.*, pl.*')
            ->from('product', 'p')
            ->leftJoin('product_lang', 'pl', 'p.id_product = pl.id_product')
            ->where('p.id_product > 3')
            ->where('pl.id_lang = 1')
            ->groupBy('p.id_product')
            ->limit(5);
        $result3 = Db::getInstance()->executeS($query);
        $this->pre($result3, 'Inner Join');
    }
    
    public function insert() {        
        $sql = 'INSERT INTO `ps_test`
            (`id`, `key`, `value`)
            VALUES (Null, "Nombre", "María");';        
        //Db::getInstance()->execute($sql);
        //$this->printScreen(Db::getInstance()->Insert_ID(), 'Last ID');
        //$this->printScreen(Db::getInstance()->Affected_Rows(), 'Get Row');
        
        $data = array(
            'id' => Null,
            'key' => "nombre",
            'value' => "Laura"           
        );
        Db::getInstance()->insert('test', $data);
        $this->printScreen(Db::getInstance()->Insert_ID(), 'Last ID');
        $this->printScreen(Db::getInstance()->Affected_Rows(), 'Get Row');
    }
    
    public function update() {        
       $data = array(
            'value' => "Cristina"
        );
        Db::getInstance()->update('test', $data, 'value = "Maria"');
        $this->printScreen(Db::getInstance()->Affected_Rows(), 'Get Row');
    }
    
    public function delete() {
        Db::getInstance()->delete('test', 'value = "Cristina"');
        $this->printScreen(Db::getInstance()->Affected_Rows(), 'Get Row');
    }
    
    public function sanitize() {
        $sanitized = Db::getInstance()->escape('<div class="test">Hello World!<div>', true);
        $this->printScreen($sanitized, 'Sanitize');
    }
    
    public function sprintF() {
        $cadena = 'Hola %s, ¿te gusta el curso %s %0.1f?';
        //echo sprintf($cadena, 'Rubén', 'Módulos Prestashop', 1.7);
        
        $cadena = 'Hola %2$s, ¿te gusta el curso %1$s? %3$0.1f';
        echo sprintf($cadena, 'Módulos Prestashop', 'Rubén', 1.7);
    }
    
    public function printScreen($_string, $_type = null) {
        echo '<strong>' . $_type . '</strong> : ' . $_string . '<br><br>';
    }
    
    public function pre(array $_array, $_type = null) {
        echo '<pre>';
        echo '<strong>' . $_type . '</strong>:<br><br>';
        var_dump($_array);
        echo '</pre>';
        echo '<br>';
    }
}
// getMsgError: muestra el último mensaje de error si una consulta ha fracasado.
// getNumberError: muestra el último número de error si una consulta ha fracasado.