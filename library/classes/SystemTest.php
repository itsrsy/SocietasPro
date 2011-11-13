<?php
/**
 * Check the system for minimum requirements
 *
 * All checks must return an array containing the following elements:
 *
 * [r] => 0 is fail, 1 is warning and 2 is pass
 * [i] => Information about the result
 *
 * As all checks must use the check() function, we can enforce this
 * data structure here.
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Utilities
 */

class SystemTest {

	const STATUS_FAIL = 0;
	const STATUS_WARN = 1;
	const STATUS_PASS = 2;
	
	/**
	 * Count the number of fails
	 */
	private $failCount = 0;
	
	/**
	 * Run a check. This should be the only public function and all
	 * checks should be forced to run through here.
	 *
	 * @param string $check Check name
	 * @return array Results, or false on failure to run test (not a test fail)
	 */
	public function check ($check) {
	
		// check the method exists
		$methodName = "check".$check;
		
		if (!method_exists($this, $methodName)) {
			return false;
		}
		
		// call the method
		$response = $this->$methodName();
		
		// validate repsonse array
		if (!is_array($response)) {
			return false;
		}
		
		if (!isset($response["r"])) {
			return false;
		}
		
		if (!isset($response["i"])) {
			return false;
		}
		
		// if fail, increment fail count
		if ($response["r"] == self::STATUS_FAIL) {
			$this->failCount++;
		}
		
		// return data
		return $response;
	
	}
	
	/**
	 * Check cURL is installed
	 *
	 * @return array Data
	 */
	private function checkCurl () {
	
		if (function_exists("curl_init")) {
			$data = array (
				"r" => self::STATUS_PASS,
				"i" => "Installed"
			);
		} else {
			$data = array (
				"r" => self::STATUS_WARN,
				"i" => "Missing"
			);
		}
		
		return $data;
	
	}
	
	/**
	 * Check we can set the include path at runtime
	 *
	 * @return array Data
	 */
	private function checkIncludePath () {
	
		if (set_include_path(get_include_path())) {
			$data = array (
				"r" => self::STATUS_PASS,
				"i" => "Can set"
			);
		} else {
			$data = array (
				"r" => self_STATUS_FAIL,
				"i" => "Can't set"
			);
		}
		
		return $data;
	
	}
	
	/**
	 * Check if magic quotes are disabled
	 *
	 * @return array Data
	 */
	private function checkMagicQuotes () {
	
		if (get_magic_quotes_gpc()) {
			$data = array (
				"r" => self::STATUS_WARN,
				"i" => "On"
			);
		} else {
			$data = array (
				"r" => self::STATUS_PASS,
				"i" => "Off"
			);
		}
		
		return $data;
	
	}
	
	/**
	 * Check the PHP version is recent enough
	 *
	 * @return array Data
	 */
	private function checkPhpVersion () {
	
		$version = floatval(phpVersion());
		
		if ($version >= 5.3) {
			$data = array (
				"r" => self::STATUS_PASS,
				"i" => phpVersion()
			);
		} else {
			$data = array (
				"r" => self::STATUS_FAIL,
				"i" => phpVersion()
			);
		}
		
		return $data;
	
	}
	
	/**
	 * Check if the tmp directory is writable
	 *
	 * @return array Data
	 */
	private function checkTmpDir () {
	
		if (is_writable(TEMP_DIR)) {
			$data = array (
				"r" => self::STATUS_PASS,
				"i" => "Writable"
			);
		} else {
			$data = array (
				"r" => self::STATUS_FAIL,
				"i" => "Not writable"
			);
		}
		
		return $data;
	
	}
	
	/**
	 * Get the number of tests which have failed
	 *
	 * @return int Failed tests
	 */
	public function getFailCount () {
		return $this->failCount;
	}

}
