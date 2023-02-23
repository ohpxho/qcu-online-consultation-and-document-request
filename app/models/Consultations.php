<?php


class Consultations {
	public function __construct() {
		$this->db = new Database();
	}

	public function add($request) {
		
		$validate = $this->validateAddRequest($request);

		if(empty($validate)) {

			$this->db->query("INSERT INTO consultations (creator, creator_name, purpose, problem, department, subject, adviser_id, adviser_name, preferred_date_for_gmeet, preferred_time_for_gmeet, shared_file_from_student) VALUES (:creator, :creator_name, :purpose, :problem, :department, :subject, :adviser_id, :adviser_name, :preferred_date, :preferred_time, :shared_file)");
			
			$this->db->bind(':creator', $request['creator']);
			$this->db->bind(':creator_name', ucwords($request['creator-name']));
			$this->db->bind(':purpose', $request['purpose']);
			$this->db->bind(':problem', $request['problem']);
			$this->db->bind(':department', $request['department']);
			$this->db->bind(':subject', $request['subject']);
			$this->db->bind(':adviser_id', $request['adviser-id']);
			$this->db->bind(':adviser_name', ucwords($request['adviser-name']));
			$this->db->bind(':preferred_date', $request['preferred-date']);
			$this->db->bind(':preferred_time', $request['preferred-time']);
			$this->db->bind(':shared_file', $request['document']);

			$result = $this->db->execute();

			if($result) {
				return '';
			}

			return 'Something went wrong, please try again.';

		} else {
			return $validate;
		}
	}
	
	public function edit($request) {
		$validate = $this->validateEditRequest($request);

		if(empty($validate)) {

			if(empty($request['document'])) {
				$this->db->query("UPDATE consultations SET purpose=:purpose, problem=:problem, department=:department, subject=:subject, adviser_id=:adviser_id, adviser_name=:adviser_name, preferred_date_for_gmeet=:preferred_date, preferred_time_for_gmeet=:preferred_time WHERE id=:id");
				
			} else {
				$this->db->query("UPDATE consultations SET purpose=:purpose, problem=:problem, department=:department, subject=:subject, adviser_id=:adviser_id, adviser_name=:adviser_name, preferred_date_for_gmeet=:preferred_date, preferred_time_for_gmeet=:preferred_time, shared_file_from_student=:shared_file WHERE id=:id");
				$this->db->bind(':shared_file', $request['document']);
			}

			$this->db->bind(':id', $request['id']);
			$this->db->bind(':purpose', $request['purpose']);
			$this->db->bind(':problem', $request['problem']);
			$this->db->bind(':department', $request['department']);
			$this->db->bind(':subject', $request['subject']);
			$this->db->bind(':adviser_id', $request['adviser-id']);
			$this->db->bind(':adviser_name', $request['adviser-name']);
			$this->db->bind(':preferred_date', $request['preferred-date']);
			$this->db->bind(':preferred_time', $request['preferred-time']);
			

			$result = $this->db->execute();

			if($result) {
				return '';
			}

			return 'Something went wrong, please try again.';

		} else {
			return $validate;
		}
	}

	public function update($request) {
		if(!empty($request['status'])) {
			$this->db->query("UPDATE consultations SET status=:status, remarks=:remarks WHERE id=:id");
			$this->db->bind(':status', $request['status']);
			$this->db->bind(':remarks', $request['remarks']);
			$this->db->bind(':id', $request['request-id']);

			$result = $this->db->execute();

			if($result) return '';
			else return 'Something went wrong, please try again.';

		} else {
			return 'You need to accept/reject the request of the student.';
		}
	}

	public function updateSchedule($request) {
		$this->db->query("UPDATE consultations SET schedule_for_gmeet=:sched, gmeet_link=:link WHERE id=:id");
		$this->db->bind(':id', $request['id']);
		$this->db->bind(':sched', $request['sched']);
		$this->db->bind(':link', $request['link']);

		$result = $this->db->execute();

		if($result) return true;

		return false;
	}

	public function drop($id) {
		$this->db->query("DELETE FROM consultations WHERE id=:id");
		$this->db->bind(':id', $id);

		$result = $this->db->execute();
		
		if($result) {
			return true;
		}

		return false;
	}

	public function findAllPendingRequestByStudentId($id) {
		$this->db->query("SELECT * FROM consultations WHERE creator=:id AND status='pending'");
		$this->db->bind(':id', $id);

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;
		return false;
	}

	public function findAllPendingRequestByProfessorId($id) {
		$this->db->query("SELECT * FROM consultations WHERE adviser_id=:id AND status='pending'");
		$this->db->bind(':id', $id);

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;
		return false;		
	}

	public function findAllPendingRequestOfGuidance() {
		$this->db->query("SELECT * FROM consultations WHERE department='guidance' AND status='pending'");

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;
		return false;		
	}

	public function findAllActiveRequestByStudentId($id) {
		$this->db->query("SELECT * FROM consultations WHERE creator=:id AND status='active'");
		$this->db->bind(':id', $id);

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;
		return false;
	}

	public function findAllActiveRequestByProfessorId($id) {
		$this->db->query("SELECT * FROM consultations WHERE adviser_id=:id AND status='active'");
		$this->db->bind(':id', $id);

		$result = $this->db->getAllResult();

		if(is_array($result)) return $result;
		return false;
	}

	public function findRequestById($id) {
		$this->db->query("SELECT * FROM consultations WHERE id=:id");
		$this->db->bind(':id', $id);

		$result = $this->db->getSingleResult();

		if(is_object($result)) return $result;
		return false;
	}

	public function uploadDocumentsFromAdviser($request) {
		$this->db->query("UPDATE consultations SET shared_file_from_advisor=:documents WHERE id=:id");
		$this->db->bind(':id', $request['id']);
		$this->db->bind(':documents', $request['documents']);

		$result = $this->db->execute();

		if($result) return true;

		return false;
	}

	public function uploadDocumentsFromStudent($request) {
		$this->db->query("UPDATE consultations SET shared_file_from_student=:documents WHERE id=:id");
		$this->db->bind(':id', $request['id']);
		$this->db->bind(':documents', $request['documents']);

		$result = $this->db->execute();

		if($result) return true;

		return false;
	}

	public function deleteDocumentFromStudent($request) {
		$leftover = $this->removeFileFromExisting($request['file-to-delete'], $request['existing-documents']);

		$this->db->query("UPDATE consultations SET shared_file_from_student=:documents WHERE id=:id");
		$this->db->bind(':documents', $leftover);
		$this->db->bind(':id', $request['id']);

		$result = $this->db->execute();

		if($result) return true;

		return false;
	}

	public function deleteDocumentFromAdviser($request) {
		$leftover = $this->removeFileFromExisting($request['file-to-delete'], $request['existing-documents']);
		
		$this->db->query("UPDATE consultations SET shared_file_from_advisor=:documents WHERE id=:id");
		$this->db->bind(':documents', $leftover);
		$this->db->bind(':id', $request['id']);

		$result = $this->db->execute();

		if($result) return true;

		return false;
	}

	private function removeFileFromExisting($fileToDelete, $existing) {
		$existing = explode(',', $existing);

		foreach($existing as $key => &$filepath) {
			$file = explode('/', $filepath);
			$filename = end($file);

			if($filename === $fileToDelete) {	
				unset($existing[$key]);
			}
		} 
		return implode(',', $existing);
	}

	private function validateAddRequest($request) {
		if(empty($request['creator'])) {
			return 'We cannot find your Student ID';
		}

		if(empty($request['purpose'])) {
			return 'Purpose is required';
		}

		if(empty($request['problem'])) {
			return 'Problem is required';
		}

		if(empty($request['department'])) {
			return 'Department is required';
		}

		if(($request['department'] != 'Guidance' && $request['department'] != 'Clinic') && empty($request['subject'])) {
			return 'Subject Code is required';
		}

		if(($request['department'] != 'Guidance' && $request['department'] != 'Clinic') && empty($request['adviser-id'])) {
			return 'Adviser is required';
		}

		if(empty($request['preferred-date'])) {
			return 'Preferred Date is required';
		} 

		if(empty($request['preferred-time'])) {
			return 'Preferred Time is required';
		}
	}

	private function validateEditRequest($request) {

		if(empty($request['purpose'])) {
			return 'Purpose is required';
		}

		if(empty($request['problem'])) {
			return 'Problem is required';
		}

		if(empty($request['department'])) {
			return 'Department is required';
		}

		if(($request['department'] != 'Guidance' && $request['department'] != 'Clinic') && empty($request['subject'])) {
			return 'Subject Code is required';
		}

		if(($request['department'] != 'Guidance' && $request['department'] != 'Clinic') && empty($request['adviser-id'])) {
			return 'Adviser is required';
		}

		if(empty($request['preferred-date'])) {
			return 'Preferred Date is required';
		} 

		if(empty($request['preferred-time'])) {
			return 'Preferred Time is required';
		}
	}
}

?>