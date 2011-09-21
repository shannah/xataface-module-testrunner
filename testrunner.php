<?php
import('PHPUnit.php');
class modules_testrunner {
	
	private $testSuite;
	
	public function getTestSuite(){
		if ( !isset($this->testSuite) ){
			$this->testSuite = new PHPUnit_TestSuite();
		}
		return $this->testSuite;
	}
	
	public function addTest($classname){
		
		$suite = new PHPUnit_TestSuite($classname);
		foreach ($suite->tests() as $test){
			$this->getTestSuite()->addTest($test);
		}
	}
	

}