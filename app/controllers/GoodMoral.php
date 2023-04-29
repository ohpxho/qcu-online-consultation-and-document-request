<?php

class GoodMoral extends Controller {
	public function __construct() {
		$this->Request = $this->model('GoodMoralRequests');
		$this->Student = $this->model('Students');
		$this->Alumni = $this->model('Alumnis');
		$this->Activity = $this->model('Activities');
		$this->RequestedDocument = $this->model('RequestedDocuments');
		$this->OOP = $this->model('OrderOfPayments');

		$this->data = [
			'flash-error-message' => '',
			'flash-success-message' => '',
			'profile-nav-active' => '',
			'notification-nav-active' => '',
			'dashboard-nav-active' => '',
			'document-nav-active' => '',
			'document-pending-nav-active' => '',
			'document-accepted-nav-active' => '',
			'document-inprocess-nav-active' => '',
			'document-forclaiming-nav-active' => '',
			'document-declined-nav-active' => '',
			'document-completed-nav-active' => '',
			'document-cancelled-nav-active' => '',
			'document-records-nav-active' => '',
			'moral-nav-active' => 'bg-slate-600',
			'student-records-nav-active' => '',
			'soa-nav-active' => '',
			'consultation-request-nav-active' => '',
			'consultation-active-nav-active' => '',
			'consultation-records-nav-active' => '',
			'consultation-resolved-nav-active' => '',
			'consultation-declined-nav-active' => '',
			'consultation-cancelled-nav-active' => '',
			'consultation-schedule-nav-active' => '',
			'record-nav-active' => '',
			'student-nav-active' => '',
			'alumni-nav-active' => '',
			'professor-nav-active' => '',
			'admin-nav-active' => '',
			'audit-trail-nav-active' => '',
			'setting-nav-active' => '',
			'data-changes-flag' => false
		];

	}	

	public function index() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['requests-data'] = $this->getAllRequest();
		$this->data['request-frequency'] = $this->getRequestFrequency($_SESSION['id']);
		$this->data['status-frequency'] = $this->getStatusFrequency($_SESSION['id']);
		$this->data['request-availability'] = $this->getRequestAvailability($_SESSION['id']);
		$this->data['activity'] = $this->getAllActivities();
		$this->data['history'] = $this->getHistory($_SESSION['id']);
		$this->data['ongoing'] = $this->getOngoingRequest($_SESSION['id']);

		$this->view('good-moral/index/index', $this->data);
	}

	private function getOngoingRequest($id) {
		if($_SESSION['type'] == 'student' || $_SESSION['type'] == 'alumni') {
			$result = $this->Request->findAllInProgressRequest($id);
			if(is_array($result)) return $result;
		}

		return [];
	}

	private function getAllActivities() {
		$details = [
			'actor' => $_SESSION['id'],
			'action' => 'GOOD_MORAL_DOCUMENT_REQUEST'
		];

		$activities = $this->Activity->findAllActivitiesByActorAndAction($details);

		if(is_array($activities)) return $activities;

		return [];
	}

	public function records() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['document-records-nav-active'] = 'bg-slate-600';
		$this->data['requests-data'] = $this->getAllRecords();
		$this->data['request-frequency'] = $this->getRequestFrequencyOfGuidance();
		$this->data['status-frequency'] = $this->getStatusFrequencyOfGuidance();
		$this->data['annual-request-status-frequency'] = $this->getAnnualRequestStatusFrequency($_SESSION['id']);
		$this->data['day-request-status-frequency'] = $this->getDayRequestStatusFrequency($_SESSION['id']);
		$this->data['history'] = $this->getHistory($_SESSION['id']);
		$this->view('good-moral/records/index', $this->data);
	}

	private function getRequestFrequencyOfGuidance() {
		$freq = $this->RequestedDocument->getRequestFrequencyOfGuidance();

		if(is_object($freq)) return $freq;

		return false;
	}

	private function getStatusFrequencyOfGuidance() {
		$freq = $this->RequestedDocument->getStatusFrequencyOfGuidance();

		if(is_object($freq)) return $freq;

		return false;
	}

	public function pending($action = '') {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['document-pending-nav-active'] = 'bg-slate-600';
		
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			switch($action) {
				case 'single':
					$request = [
						'student-id' => trim($post['student-id']),
						'request-id' => trim($post['request-id']),
						'status' => trim($post['status']),
						'remarks' => trim($post['remarks']),
						'email' => trim($post['email']),
						'contact' => trim($post['contact']),
						'message' => trim($post['message']),
						'price' => trim($post['price']),
						'type' => trim($post['type'])
					];

					$this->update($request);
					break;

				case 'multiple':
					$request = [
						'student-ids' => trim($post['student-ids']),
						'request-ids' => trim($post['request-ids']),
						'status' => trim($post['multiple-update-status']),
						'remarks' => trim($post['multiple-update-remarks']),
						'emails' => trim($post['emails']),
						'contacts' => trim($post['contacts']),
						'messages' => trim($post['messages']),
						'types' => trim($post['types'])
					];

					$this->multiple_update($request);
					break;
			}	

		}

		$this->data['requests-data'] = $this->findAllPendingRequest();

		$this->view('good-moral/pending/index', $this->data);
	}

	public function accepted($action = '') {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['document-accepted-nav-active'] = 'bg-slate-600';
		
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			switch($action) {
				case 'single':
					$request = [
						'student-id' => trim($post['student-id']),
						'request-id' => trim($post['request-id']),
						'status' => trim($post['status']),
						'remarks' => trim($post['remarks']),
						'email' => trim($post['email']),
						'contact' => trim($post['contact']),
						'message' => trim($post['message']),
						'type' => trim($post['type'])
					];

					$this->update($request);
					break;

				case 'multiple':
					$request = [
						'student-ids' => trim($post['student-ids']),
						'request-ids' => trim($post['request-ids']),
						'status' => trim($post['multiple-update-status']),
						'remarks' => trim($post['multiple-update-remarks']),
						'emails' => trim($post['emails']),
						'contacts' => trim($post['contacts']),
						'messages' => trim($post['messages']),
						'types' => trim($post['types'])
					];

					$this->multiple_update($request);
					break;
			}	

		}

		$this->data['requests-data'] = $this->findAllAcceptedRequest();

		$this->view('good-moral/accepted/index', $this->data);
	}

	public function forprocess($action = '') {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['document-inprocess-nav-active'] = 'bg-slate-600';
		
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			switch($action) {
				case 'single':
					$request = [
						'student-id' => trim($post['student-id']),
						'request-id' => trim($post['request-id']),
						'status' => trim($post['status']),
						'remarks' => trim($post['remarks']),
						'email' => trim($post['email']),
						'contact' => trim($post['contact']),
						'message' => trim($post['message']),
						'type' => trim($post['type'])
					];

					$this->update($request);
					break;

				case 'multiple':
					$request = [
						'student-ids' => trim($post['student-ids']),
						'request-ids' => trim($post['request-ids']),
						'status' => trim($post['multiple-update-status']),
						'remarks' => trim($post['multiple-update-remarks']),
						'emails' => trim($post['emails']),
						'contacts' => trim($post['contacts']),
						'messages' => trim($post['messages']),
						'types' => trim($post['types'])
					];

					$this->multiple_update($request);
					break;
			}	

		}

		$this->data['requests-data'] = $this->findAllInProcessRequest();

		$this->view('good-moral/in-process/index', $this->data);
	}

	public function forclaiming($action = '') {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['document-forclaiming-nav-active'] = 'bg-slate-600';
		
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			switch($action) {
				case 'single':
					$request = [
						'student-id' => trim($post['student-id']),
						'request-id' => trim($post['request-id']),
						'status' => trim($post['status']),
						'remarks' => trim($post['remarks']),
						'email' => trim($post['email']),
						'contact' => trim($post['contact']),
						'message' => trim($post['message']),
						'type' => trim($post['type'])
					];

					$this->update($request);
					break;

				case 'multiple':
					$request = [
						'student-ids' => trim($post['student-ids']),
						'request-ids' => trim($post['request-ids']),
						'status' => trim($post['multiple-update-status']),
						'remarks' => trim($post['multiple-update-remarks']),
						'emails' => trim($post['emails']),
						'contacts' => trim($post['contacts']),
						'messages' => trim($post['messages']),
						'types' => trim($post['types'])
					];

					$this->multiple_update($request);
					break;
			}	

		}

		$this->data['requests-data'] = $this->findAllForClaimingRequest();

		$this->view('good-moral/for-claiming/index', $this->data);
	}

	public function completed($action = '') {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['document-completed-nav-active'] = 'bg-slate-600';
		
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
		}

		$this->data['requests-data'] = $this->findAllCompletedRequest();

		$this->view('good-moral/completed/index', $this->data);
	}

	public function declined($action = '') {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['document-declined-nav-active'] = 'bg-slate-600';
		
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
		}

		$this->data['requests-data'] = $this->findAllRejectedRequest();

		$this->view('good-moral/declined/index', $this->data);
	}

	public function cancelled($action = '') {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['document-cancelled-nav-active'] = 'bg-slate-600';
		
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
		}

		$this->data['requests-data'] = $this->findAllCancelledRequest();

		$this->view('good-moral/cancelled/index', $this->data);
	}

	public function details() {
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			
			$result = $this->Request->findRequestById($post['id']);

			if(is_object($result)) {
				echo json_encode($result);
				return;
			}
		}

		echo '';
	}

	public function oop() {
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			
			$result = $this->Request->findOrderOfPayment($post['id'], 'GOOD_MORAL_REQUEST');

			if(is_object($result)) {
				echo json_encode($result);
				return;
			}
		}
		echo '';
	}

	public function add() {
		redirect('PAGE_THAT_NEED_USER_SESSION');
		
		$this->data['requests-data'] = [];
		$this->data['student-details'] = $this->getStudentDetails();
		$this->data['request-availability'] = [];
		$this->data['request-frequency'] = [];

		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			$request = [
				'student-id' => trim($post['student-id']),
				'purpose' => trim($post['purpose']),
				'other-purpose' => trim($post['other-purpose']),
				'quantity' => trim($post['quantity']),
				'type' => trim($post['type'])
			];

			$result = $this->Request->add($request);
			
			if(empty($result)) {
				$action = [
					'actor' => $_SESSION['id'],
					'name' => $_SESSION['fname'].' '.$_SESSION['lname'],
					'type' => $_SESSION['type'],
					'action' => 'GOOD_MORAL_DOCUMENT_REQUEST',
					'description' => 'created new good moral document request'
				];

				$this->addActionToActivities($action);

				$this->data['data-changes-flag'] = true;
				$this->data['flash-success-message'] = 'Request has been submitted';
			} else {
				$this->data['flash-error-message'] = $result;
			}
		}

		$this->data['requests-data'] = $this->getAllRequest();
		$this->data['history'] = $this->getHistory($_SESSION['id']);
		$this->data['ongoing'] = $this->getOngoingRequest($_SESSION['id']);
		$this->data['request-availability'] = $this->getRequestAvailability($_SESSION['id']);
		$this->date['request-frequency'] = $this->getRequestFrequency($_SESSION['id']);
		$this->data['status-frequency'] = $this->getStatusFrequency($_SESSION['id']);
		$this->data['activity'] = $this->getAllActivities();

		$this->view('good-moral/index/index', $this->data);
	}

	public function edit() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['requests-data'] = [];
		$this->data['student-details'] = $this->getStudentDetails();
		$this->data['request-availability'] = [];
		$this->data['request-frequency'] = [];

		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

			$request = [
				'request-id' => trim($post['request-id']),
				'purpose' => trim($post['purpose']),
				'other-purpose' => trim($post['other-purpose']),
				'quantity' => trim($post['quantity'])
			];

			$result = $this->Request->edit($request);
			
			if(empty($result)) {
				$action = [
					'actor' => $_SESSION['id'],
					'name' => $_SESSION['fname'].' '.$_SESSION['lname'],
					'type' => $_SESSION['type'],
					'action' => 'GOOD_MORAL_DOCUMENT_REQUEST',
					'description' => 'updated good moral document request'
				];

				$this->addActionToActivities($action);

				$this->data['data-changes-flag'] = true;
				$this->data['flash-success-message'] = 'Request has been updated';
			} else {
				$this->data['flash-error-message'] = $result;
			}
		}

		$this->data['requests-data'] = $this->getAllRequest();
		$this->data['history'] = $this->getHistory($_SESSION['id']);
		$this->data['ongoing'] = $this->getOngoingRequest($_SESSION['id']);
		$this->data['request-availability'] = $this->getRequestAvailability($_SESSION['id']);
		$this->data['request-frequency'] = $this->getRequestFrequency($_SESSION['id']);
		$this->data['status-frequency'] = $this->getStatusFrequency($_SESSION['id']);
		$this->data['activity'] = $this->getAllActivities();

		$this->view('good-moral/index/index', $this->data);
	}

	public function cancel($id) {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['request-availability'] = [];
		$this->data['request-frequency'] = [];

		$drop = $this->Request->cancel($id);

		if($drop) {
			$action = [
				'actor' => $_SESSION['id'],
				'action' => 'GOOD_MORAL_DOCUMENT_REQUEST',
				'description' => 'cancelled a good moral document request'
			];

			$this->addActionToActivities($action);

			$this->data['data-changes-flag'] = true;
			$this->data['flash-success-message'] = 'Request has been cancelled';
		} else {
			$this->data['flash-error-message'] = 'Some error occurred while cancelling request, please try again';
		}

		$this->data['requests-data'] = $this->getAllRequest();
		$this->data['history'] = $this->getHistory($_SESSION['id']);
		$this->data['ongoing'] = $this->getOngoingRequest($_SESSION['id']);
		$this->data['request-availability'] = $this->getRequestAvailability($_SESSION['id']);
		$this->data['request-frequency'] = $this->getRequestFrequency($_SESSION['id']);
		$this->data['status-frequency'] = $this->getStatusFrequency($_SESSION['id']);
		$this->data['activity'] = $this->getAllActivities();
		
		$this->view('good-moral/index/index', $this->data);
	}

	public function confirm_payment($id) {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['moral-nav-active'] = 'bg-slate-600';	
		
		$result = $this->Request->confirmPayment($id);

		if($result) {
			$action = [
				'actor' => $_SESSION['id'],
				'action' => 'GOOD_MORAL_DOCUMENT_REQUEST',
				'description' => 'confirmed payment for requesting a good moral certificate'
			];

			$this->addActionToActivities($action);

			$this->data['flash-success-message'] = 'Payment has been confirmed';
		} else {
			$this->data['flash-error-message'] = 'Some error occured while confirming payment, please try again';
		}

		$this->data['requests-data'] = $this->getAllRequest();
		$this->data['history'] = $this->getHistory($_SESSION['id']);
		$this->data['ongoing'] = $this->getOngoingRequest($_SESSION['id']);
		$this->data['request-frequency'] = $this->getRequestFrequency($_SESSION['id']);
		$this->data['status-frequency'] = $this->getStatusFrequency($_SESSION['id']);
		$this->data['request-availability'] = $this->getRequestAvailability($_SESSION['id']);
		$this->data['activity'] = $this->getAllActivities();
		
		
		$this->view('good-moral/index/index', $this->data);
	}

	public function delete($id) {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['document-records-nav-active'] = 'bg-slate-600';

		$drop = $this->Request->drop($id);

		if($drop) {
			$action = [
				'actor' => $_SESSION['id'],
				'action' => 'GOOD_MORAL_DOCUMENT_REQUEST',
				'description' => 'deleted a good moral document request'
			];

			$this->addActionToActivities($action);

			$this->data['flash-success-message'] = 'Request has been deleted';
		} else {
			$this->data['flash-error-message'] = 'Some error occurred while deleting request, please try again';
		}

		$this->data['requests-data'] = $this->getAllRecords();
		$this->data['status-frequency'] = $this->getStatusFrequencyOfGuidance();
		$this->data['request-frequency'] = $this->getRequestFrequencyOfGuidance();
		$this->data['annual-request-status-frequency'] = $this->getAnnualRequestStatusFrequency($_SESSION['id']);
		$this->data['day-request-status-frequency'] = $this->getDayRequestStatusFrequency($_SESSION['id']);
		$this->data['history'] = $this->getHistory($_SESSION['id']);
		
		$this->view('good-moral/records/index', $this->data);
	} 

	public function multiple_delete() {
		redirect('PAGE_THAT_NEED_USER_SESSION');

		$this->data['document-records-nav-active'] = 'bg-slate-600';

		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			$ids = explode(',', trim($post['request-ids-to-drop']));

			foreach($ids as $id) {
				$drop = $this->Request->drop($id);
				if($drop) {
					$action = [
						'actor' => $_SESSION['id'],
						'action' => 'GOOD_MORAL_DOCUMENT_REQUEST',
						'description' => 'deleted multiple good moral document request'
					];

					$this->addActionToActivities($action);

					$this->data['flash-success-message'] = 'Requests has been deleted';
				} else {
					$this->data['flash-success-message'] = '';
					$this->data['flash-error-message'] = 'Some error occurred while deleting requests, please try again';
					break;
				}
			}
		}

		$this->data['requests-data'] = $this->getAllRecords();
		$this->data['status-frequency'] = $this->getStatusFrequencyOfGuidance();
		$this->data['request-frequency'] = $this->getRequestFrequencyOfGuidance();
		$this->data['annual-request-status-frequency'] = $this->getAnnualRequestStatusFrequency($_SESSION['id']);
		$this->data['day-request-status-frequency'] = $this->getDayRequestStatusFrequency($_SESSION['id']);
		$this->data['history'] = $this->getHistory($_SESSION['id']);
		
		$this->view('good-moral/records/index', $this->data);
	}
	

	public function update($request) {
		$result = $this->Request->updateStatusAndRemarks($request);
		
		if(empty($result)) {
			if($request['status'] == 'awaiting payment confirmation') {
				$this->createOrderOfPayment($request['request-id']);
			}

			$action = [
				'actor' => $_SESSION['id'],
				'action' => 'GOOD_MORAL_DOCUMENT_REQUEST',
				'description' => 'updated a good moral document request'
			];

			$this->addActionToActivities($action);

			$this->data['flash-success-message'] = 'Request has been updated';
			
			$student = $this->Student->findStudentById($request['student-id']);
			
			$this->setupEmailThenSend($request);

		} else {
			$this->data['flash-error-message'] = $result;
		}
	}

	public function multiple_update($request) {
		$requestIDs =  explode(',', trim($request['request-ids']));
		$studentIDs = explode(',', trim($request['student-ids']));
		$emails = explode(' & ', trim($request['emails']));
		$contacts = explode(' & ', trim($request['contacts']));
		$messages = explode(' & ', trim($request['messages']));
		$types = explode(',', trim($request['types']));
		
		foreach($requestIDs as $key => $id) {
			$request = [
				'student-id' => $studentIDs[$key],
				'request-id' => $id,
				'status' => trim($request['status']),
				'remarks' => trim($request['remarks']),
				'email' => trim($emails[$key]),
				'message' => trim($messages[$key]),
				'contact' => trim($contacts[$key]),
				'type' => trim($types[$key])
			];

			$result = $this->Request->updateStatusAndRemarks($request);
		
			if(empty($result)) {
				if($request['status'] == 'awaiting payment confirmation') {
					$this->createOrderOfPayment($request['request-id']);
				}

				$action = [
					'actor' => $_SESSION['id'],
					'name' => $_SESSION['fname'].' '.$_SESSION['lname'],
					'type' => $_SESSION['type'],
					'action' => 'GOOD_MORAL_DOCUMENT_REQUEST',
					'description' => 'updated a multiple good moral document request'
				];

				$this->addActionToActivities($action);

				$this->data['flash-success-message'] = 'Requests has been updated';
				
				$student = $this->Student->findStudentById($request['student-id']);
				
				$this->setupEmailThenSend($request);
			} else {
				$this->data['flash-success-message'] = '';
				$this->data['flash-error-message'] = $result;
				break;
			}
		}
	}

	private function createOrderOfPayment($id) {
		$details = [
			'transaction-no' => $this->generateOrderOfPaymentNumber(),
			'type' => 'GOOD_MORAL_REQUEST',
			'request-id' => $id
		];

		$this->OOP->add($details);
	}

	private function generateOrderOfPaymentNumber() {
		$date = date('Ymd');

		$random_number = rand(1, 999);
		$transaction_number = 'OP-' . $date . '-' . sprintf('%03d', $random_number);

		while($this->checkIfOOPNumberExist($transaction_number)) {
			$random_number = rand(1, 999);
			$transaction_number = 'OP-' . $date . '-' . sprintf('%03d', $random_number);
		}
		
		return $transaction_number;
		
	}

	private function checkIfOOPNumberExist($no) {
		$result = $this->OOP->findOrderOfPayment($no);
		
		if(is_object($result)) return true;
		return false;
	}

	public function get_requests_count() {
		$result = $this->Request->getRequestsCount();
	
		if(is_object($result)) {
			echo json_encode($result);
			return;
		}

		echo json_encode('');

	}

	public function check_if_needed_alert() {
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			
			$id = trim($post['id']);

			$result = $this->Request->checkIfNeededAlert($id);
		
			if($result) {
				echo json_encode(true);
				return;
			}
		}

		echo json_encode(false);
	}

	private function setupEmailThenSend($details) {
		if($details['type'] == 'student') $user = $this->Student->findStudentById($details['student-id']);
		else $user = $this->Alumni->findAlumniById($details['student-id']);	

		$mail = [
			'email' => $details['email'],
			'name' => $user->fname.' '.$user->lname,
			'message' => $details['message'],
			'link' => URLROOT.'/academic_document'
		];

		$this->createAndSendEmail($mail);

		$sms = [
			'contact' => $user->contact,
			'message' => $details['message']
		];

		$this->createAndSendSMS($sms);
	}

	private function createAndSendEmail($details) {
		$email = [
			'recipient' => $details['email'],
			'name' => $details['name'],
			'message' => $details['message'],
			'link' => $details['link']
		];

		$contentOfEmail = formatEmailForConsultation($email);

		$email['message'] = $contentOfEmail;

		sendEmail($email);
	}

	private function createAndSendSMS($details) {
		$sms = [
			'to' => $details['contact'],
			'message' => $details['message'] 
		];

		sendSMS($sms);
	}

	private function addActionToActivities($details) {
		$this->Activity->add($details);
	}

	private function getStudentDetails() {
		if(isset($_SESSION['id'])) {
			$details = $this->Student->findStudentById($_SESSION['id']); 
			if(is_object($details)) {
				return $details;
			}
		}
		return [];
	}

	private function getAllRecords() {
		if($_SESSION['type'] == 'student') {
			$result = $this->Request->findAllRecordsByStudentId($_SESSION['id']);
		} elseif($_SESSION['type'] == 'sysadmin') { 
			$result = $this->Request->findAllRecordsOfStudentsForSystemAdmin();
		} else {
			$result = $this->Request->findAllRecordsOfStudentsForAdmin();
		}

		if(is_array($result)) return $result;

		return [];
	}

	private function uploadAndGetPathOfIndetificationDocument() {
		$path = '';
		
		if(isset($_FILES['identification-document'])) {
			$path = uploadDocument($_FILES['identification-document']);
		}

		return $path;
	}

	private function getAllRequest() {
		if($_SESSION['type'] == 'student' || $_SESSION['type'] == 'alumni') {
			$result = $this->Request->findAllRequestByStudentId($_SESSION['id']);	
		} else {
			$result = $this->Request->findAllRequest();
		}
		
		if(is_array($result)) {
			return $result;
		}

		return [];
	}

	private function findAllPendingRequest() {
		$result  = $this->Request->findAllPendingRequest();

		if(is_array($result)) return $result;

		return [];
	}

	private function findAllAcceptedRequest() {
		$result  = $this->Request->findAllAcceptedRequest();

		if(is_array($result)) return $result;

		return [];
	}

	private function findAllInProcessRequest() {
		$result  = $this->Request->findAllInProcessRequest();

		if(is_array($result)) return $result;

		return [];
	}

	private function findAllForClaimingRequest() {
		$result  = $this->Request->findAllForClaimingRequest();

		if(is_array($result)) return $result;

		return [];
	}

	private function findAllCompletedRequest() {
		$result  = $this->Request->findAllCompletedRequest();

		if(is_array($result)) return $result;

		return [];
	}

	private function findAllRejectedRequest() {
		$result  = $this->Request->findAllRejectedRequest();

		if(is_array($result)) return $result;

		return [];
	}

	private function findAllCancelledRequest() {
		$result  = $this->Request->findAllCancelledRequest();

		if(is_array($result)) return $result;

		return [];
	}

	private function getRequestFrequency($id) {
		$freq = $this->Request->getRequestFrequency($id);

		if(is_object($freq)) return $freq;

		return [];	
	}

	private function getStatusFrequency($id) {
		$freq = $this->Request->getStatusFrequency($id);

		if(is_object($freq)) return $freq;

		return [];	
	}

	private function getRequestAvailability($id) {
		$freq = $this->Request->getRequestAvailability($id);

		if(is_object($freq)) return $freq;

		return [];
	}

	private function getAnnualRequestStatusFrequency($id) {
		if($_SESSION['type'] == 'student') {
			$freq = $this->Request->getAnnualRequestStatusFrequencyOfStudent($id);
		} elseif($_SESSION['type'] == 'sysadmin') {
			$freq = $this->Request->getAnnualRequestStatusFrequencyOfSysAdmin();
		} else {
			$freq = $this->Request->getAnnualRequestStatusFrequencyOfAdviser($id);
		}

		if(is_array($freq)) return $freq;

		return [];
	}

	private function getDayRequestStatusFrequency($id) {
		if($_SESSION['type'] == 'student') {
			$freq = $this->Request->getDayRequestStatusFrequencyOfStudent($id);
		} elseif($_SESSION['type'] == 'sysadmin') {
			$freq = $this->Request->getDayRequestStatusFrequencyOfSysAdmin();
		} else {
			$freq = $this->Request->getDayRequestStatusFrequencyOfAdviser($id);
		}

		if(is_array($freq)) return $freq;

		return [];
	}

	private function getHistory($id) {
		if($_SESSION['type'] == 'student') {
			$freq = $this->Request->getHistoryOfStudent($id);
		} elseif($_SESSION['type'] == 'alumni') {
			$freq = $this->Request->getHistoryOfStudent($id);
		} elseif($_SESSION['type'] == 'sysadmin') {
			$freq = $this->Request->getHistoryOfSysAdmin();
		} else {
			$freq = $this->Request->getHistoryOfAdviser($id);
		}

		if(is_array($freq)) return $freq;

		return [];
	}

}


?>