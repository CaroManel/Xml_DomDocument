<?php

class XmlDomClass extends DomDocument {
	var $root;
	var $node;

    /**
     * Constructor
     * 
     * Call the parent constructor and set the root and node name
     *
     * @param string $root name
     * @param string $node name
     *
     */
    public function __construct($root='root', $node='node') {
        parent::__construct();
        $this->encoding = "utf-8";
        $this->formatOutput = true;
        $this->node = $node;
        $this->root = $this->appendChild($this->createElement( $root ));
   }

    /*
     * BuildXml 
     * 
     * Recursive function to create XML nodes
     *
     * @param array $array 
     * @aparam string $node
     *
     */
    private function buildXml( $array, $node = null) {
        if (is_null($node)) {
            $node = $this->root;
        }
        foreach($array as $element => $value) {
            $element = is_numeric( $element ) ? $this->node : $element;

            $child = $this->createElement($element, (is_array($value) ? null : $value));
            $node->appendChild($child);

            if (is_array($value)) {
                $this->buildXml($value, $child);
            }
        }
    }
    
    
    public function getXml( $array ) {
    	try { 
    		$this->buildXml( $array );
		    header ("content-type: text/xml");
		    echo $this->saveXml(); 
		} catch (Exception $e) {
			
		    echo $e->getMessage();
		}
    	
    }


} // end of class

$array = array(
        array(
            'id'=>'00100',
            'fullname'=>
                array('firstname'=>'Brittany', 'lastname'=>'Mainly'),
            'email'=>'brittany@test.com'),
        array(
           'id'=>'00200',
            'fullname'=>
                array('firstname'=>'Louis', 'lastname'=>'Arca'),
            'email'=>'Louis@test.com'),
        array(
            'id'=>'00300',
            'fullname'=>
                array('firstname'=>'Samuel', 'lastname'=>'Black'),
            'email'=>'Samuel@test.com'),
        array(
            'id'=>'00400',
            'fullname'=>
                array('firstname'=>'Tracy', 'lastname'=>'White'),
            'email'=>'Tracy@test.com'),
    );


    $xml = new XmlDomClass();
    $xml->getXml( $array );

?>

