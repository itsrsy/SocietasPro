<?php
/**
 * Locations model
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Admin
 */

require_once("objects/location.php");

class LocationsModel extends BaseModel {

	protected $tableName = "locations";
	
	function __construct () {
		parent::__construct();
	}
	
	/**
	 * Get a list of locations
	 *
	 * @return array Locations
	 */
	public function get () {
	
		// initialise array
		$arr = array();
		
		// query the database
		$sql = "SELECT * FROM ".DB_PREFIX."locations ";
		$rec = $this->db->query($sql);
		
		// loop through records
		while ($row = $rec->fetch()) {
			$arr[] = new Location($row);
		}
		
		// return results
		return $arr;
	
	}
	
	/**
	 * Get a specific location
	 *
	 * @param int $id Location ID
	 * @return Location
	 */
	public function getById ($id) {
	
		$sql = "SELECT * FROM ".DB_PREFIX."locations WHERE locationID = " . $id;
		$rec = $this->db->query($sql);
		
		if ($row = $rec->fetch()) {
			return new Location($row);
		} else {
			return false;
		}
	
	}
	
	/**
	 * Edit or create a location
	 *
	 * @param array $d Data
	 * @param int $id ID or false if creating
	 * @return boolean Success
	 */
	public function write ($d, $id = false) {
	
		// get object
		if ($id) {
			$object = $this->getById($id);
			$auditAction = 4;
		} else {
			$object = new Location();
			$auditAction = 3;
		}
		
		// make modifications
		if (
			!$object->setName($d["name"]) ||
			!$object->setDescription($d["description"])
		) {
			$this->setMessage($object->getMessage());
			return false;
		}
		
		// record in audit trail
		auditTrail($auditAction, $object->original(), $object);
		
		// save object
		$this->setMessage(LANG_SUCCESS);
		return $this->save($object);
	
	}

}
