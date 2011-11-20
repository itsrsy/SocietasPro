<?php
/**
 * Reporting controller
 *
 * @author Chris Worfolk <chris@societaspro.org>
 * @package SocietasPro
 * @subpackage Admin
 *
 * @todo Make actions and members clickable
 * @todo Review navigation
 */

namespace admin;

class ReportingController extends \BaseController implements \iController {

	function __construct () {
		parent::__construct();
	}
	
	/**
	 * Display audit logs
	 */
	public function auditlogs () {
	
		// get a database instance
		$db = \Database::getInstance();
		
		// get a list of actions
		$sql = "SELECT * FROM ".DB_PREFIX."audit_actions ORDER BY actionName ASC ";
		$rec = $db->query($sql);
		
		$actions = array();
		
		while ($row = $rec->fetch()) {
			$actions[$row["actionID"]] = $row["actionLocalised"];
		}
		
		// get a list of members
		$sql = "SELECT * FROM ".DB_PREFIX."members
				WHERE memberPrivileges > 1
				ORDER BY memberSurname ASC, memberForename ASC ";
		$rec = $db->query($sql);
		
		$members = array();
		
		while ($row = $rec->fetch()) {
			$members[$row["memberID"]] = $row["memberSurname"].", ".$row["memberForename"];
		}
		
		// invoke a model
		require_once("models/AuditEntriesModel.php");
		$auditEntriesModel = new \AuditEntriesModel();
		
		// gather variables for page
		$actionID = (isset($_REQUEST["action"])) ? $_REQUEST["action"] : 0;
		$memberID = (isset($_REQUEST["member"])) ? $_REQUEST["member"] : 0;
		$pageNum = \FrontController::getParam(0);
		$totalPages = totalPages($auditEntriesModel->count($actionID, $memberID));
		
		// output the page
		$this->engine->assign("actionID", $actionID);
		$this->engine->assign("memberID", $memberID);
		$this->engine->assign("actions", $actions);
		$this->engine->assign("members", $members);
		$this->engine->assign("logs", $auditEntriesModel->get($pageNum, $actionID, $memberID));
		$this->engine->assign("totalPages", $totalPages);
		$this->engine->display("reporting/auditlogs.tpl");
	
	}
	
	/**
	 * Display error logs
	 */
	public function errorlogs () {
	
		// invoke a model
		require_once("models/ErrorLogsModel.php");
		$errorLogsModel = new \ErrorLogsModel();
		
		// gather variables for page
		$pageNum = \FrontController::getParam(0);
		$totalPages = totalPages($errorLogsModel->count());
		
		// output the page
		$this->engine->assign("logs", $errorLogsModel->get($pageNum));
		$this->engine->assign("totalPages", $totalPages);
		$this->engine->display("reporting/errorlogs.tpl");
	
	}
	
	public function index () {
	
		$this->engine->display("reporting/index.tpl");
	
	}

}
