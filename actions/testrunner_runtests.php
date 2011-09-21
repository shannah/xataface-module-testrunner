<?php
class actions_testrunner_runtests {
	function handle($params){
		$app = Dataface_Application::getInstance();
		
		
		$testdirs = array(
			DATAFACE_SITE_PATH.'/tests',
			DATAFACE_PATH.'/tests'
		);
		
		if ( @$app->_conf['_modules'] and is_array($app->_conf['_modules'])){
			//print_r($app->_conf['_modules']);exit;
			foreach ($app->_conf['_modules'] as $name=>$path){
				$path = dirname($path);
				if ( is_dir(DATAFACE_SITE_PATH.DIRECTORY_SEPARATOR.$path.DIRECTORY_SEPARATOR.'tests') ){
					$testdirs[] = DATAFACE_SITE_PATH.DIRECTORY_SEPARATOR.$path.DIRECTORY_SEPARATOR.'tests';
				} else if ( is_dir(DATAFACE_PATH.DIRECTORY_SEPARATOR.$path.DIRECTORY_SEPARATOR.'tests') ){
					$testdirs[] = DATAFACE_PATH.DIRECTORY_SEPARATOR.$path.DIRECTORY_SEPARATOR.'tests';
				}
			}
		}
		
		$tests = array();
		
		foreach ($testdirs as $dir){
			foreach ( glob($dir.DIRECTORY_SEPARATOR.'test_*.php') as $file){
				$tests[] = $file;
			}
		}
		//print_r($tests);exit;
		
		foreach ($tests as $test){
			include($test);
		}
		
		
		$result = new PHPUnit_TestResult;
		Dataface_ModuleTool::getInstance()
			->loadModule('modules_testrunner')
			->getTestSuite()->run($result);
		print $result->toHtml();
	}
}