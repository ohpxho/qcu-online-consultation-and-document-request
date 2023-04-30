<!-- header -->
<div class="flex justify-between items-center">
	<div class="flex flex-col w-full text-start md:w-max">
		<p class="text-2xl font-bold">Good Moral Certificate</p>
		<p class="text-sm text-slate-500">Review and manage your good moral document requests</p>
	</div>
	<div >
		
	</div>
</div>

<div class="flex flex-col mt-5 gap-2 pb-24">
	
	<?php
		require APPROOT.'/views/flash/fail.php';
		require APPROOT.'/views/flash/success.php';
	?>

	<div class="flex flex-col gap-2 px-4 py-2 border bg-white rounded-md mt-5">
		<div class="flex flex-col md:flex-row md:justify-between py-2">
			<p class="p-2 font-semibold">Ongoing</p>
			<div id="add-request-btn-con" class="flex flex-col gap-2 items-start md:items-end mt-3 md:mt-0">
				<a id="add-request-btn" class="w-max">
					<li class="flex gap-1 items-center bg-blue-700 text-white rounded-md px-4 py-1"> 
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
							<path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
						</svg>
						<span>New Request</span> 
					</li>
				</a>
			</div>
		</div>
		<div class="overflow-x-scroll pb-4">
			<table id="ongoing-table" class="text-sm bg-slate-50">
				<thead class="bg-slate-100 text-slate-900 font-medium">
					<tr>
						<th class="hidden">Request ID</th>
						<th>Date Requested</th>
						<th>Date Completed</th>
						<th>Purpose</th>
						<th>Quantity</th>
						<th>Status</th>
						<th>Tag</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					
					<?php
						foreach ($data['ongoing'] as $key => $row):
							$date_created = new DateTime($row->date_created);
							if(empty($row->date_created)) {
								$date_created = '---- -- --';
							} else {
								$date_created = $date_created->format('m/d/Y');
							}

							$date_completed = new DateTime($row->date_completed);
							if(empty($row->date_completed)) {
								$date_completed = '---- -- --';
							} else {
								$date_completed = $date_completed->format('m/d/Y');
							}

					?>
							<tr class="border-b border-slate-200">
								<td class="font-semibold hidden"><?php echo $row->id; ?></td>
								<td><?php echo $date_created; ?></td>
								<td><?php echo $date_completed; ?></td>

								<td><?php echo $row->purpose; ?></td>
								<td><?php echo $row->quantity; ?></td>
								
								<?php if($row->status == 'pending'): ?>
									<td>
										<span class="bg-yellow-500 text-white rounded-md px-1 py-1 status-btn cursor-pointer">pending</span>
									</td>
								<?php endif; ?>

								<?php if($row->status == 'awaiting payment confirmation'): ?>
									<td>
										<span class="bg-yellow-500 text-white rounded-md px-1 py-1 status-btn cursor-pointer">awaiting payment confirmation</span>
									</td>
								<?php endif; ?>

								<?php if($row->status == 'accepted'): ?>
									<td>
										<span class="bg-cyan-500 text-white rounded-md px-1 py-1 status-btn cursor-pointer">accepted</span>
									</td>
								<?php endif; ?>

								<?php if($row->status == 'rejected'): ?>
									<td>
										<span class="bg-red-500 text-white rounded-md px-1 py-1 status-btn cursor-pointer">declined</span>
									</td>
								<?php endif; ?>

								<?php if($row->status == 'for process'): ?>
									<td>
										<span class="bg-orange-500 text-white rounded-md px-1 py-1 status-btn cursor-pointer">for process</span>
									</td>
								<?php endif; ?>

								<?php if($row->status == 'for claiming'): ?>
									<td>
										<span class="bg-sky-500 text-white rounded-md px-1 py-1 status-btn cursor-pointer">for claiming</span>
									</td>
								<?php endif; ?>

								<?php if($row->status == 'cancelled'): ?>
									<td>
										<span class="bg-red-500 text-white rounded-md px-1 py-1 status-btn cursor-pointer">cancelled</span>
									</td>
								<?php endif; ?>

								<?php if($row->status == 'completed'): ?>
									<td>
										<span class="bg-green-500 text-white rounded-md px-1 py-1 status-btn cursor-pointer">completed</span>
									</td>
								<?php endif; ?>
								
								
								<?php if($row->price <= 0): ?>
									<td>
										<span class="bg-green-500 text-white rounded-md px-1 py-1 status-btn cursor-pointer">no payment</span>
									</td>
								<?php else: ?>
									<td>
										<span class="bg-orange-500 text-white rounded-md px-1 py-1 status-btn cursor-pointer">with payment</span>
									</td>
								<?php endif; ?>	
								
								<td class="text-center">
									<div class="flex gap-1 items-center justify-center">
										<!--<?php //echo URLROOT.'/good_moral/show/'.$row->id ;?>-->
										<a class="hover:text-blue-700 view-btn" class="text-blue-700" href="#">view</a>
										
										<?php if($row->status == 'pending'): ?>
											<a class="hover:text-blue-700 edit-btn cursor-pointer">edit</a>
										<?php endif; ?>

										<?php if($row->status == 'awaiting payment confirmation'): ?>
											<a class="hover:text-blue-700 confirm-payment-btn" href="<?php echo URLROOT.'/good_moral/confirm_payment/'.$row->id ;?>" >confirm</a>
										<?php endif; ?>

										<?php if($row->status == 'pending' || $row->status == 'awaiting payment confirmation'): ?>
											<a class="text-red-700 drop-btn" href="<?php echo URLROOT.'/good_moral/cancel/'.$row->id ;?>" >cancel</a>
										<?php endif; ?>

										<?php if($row->price > 0): ?>
											<a href="" data-request="<?php echo $row->id ?>" title="generate order of payment" class="generate-oop-btn text-blue-700">
												<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
												  	<path d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0016.5 9h-1.875a1.875 1.875 0 01-1.875-1.875V5.25A3.75 3.75 0 009 1.5H5.625z" />
												  <path d="M12.971 1.816A5.23 5.23 0 0114.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 013.434 1.279 9.768 9.768 0 00-6.963-6.963z" />
												</svg>

											</a>
										<?php endif; ?>
									</div>
								</td>
							</tr>
					<?php
						endforeach;
					?>
				
				</tbody>
			</table>
		</div>
	</div>

	<div class="flex gap-2 w-full bg-blue-500 text-white rounded-md p-2 mt-16 ">
		<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
		  <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
		</svg>

		<p>The table below displays your past records</p>	
	</div>

		<div class="grid w-full md:justify-items-end mt-5">
		<div class="flex flex-col md:flex-row w-full gap-2 border p-4 bg-white rounded-md md:items-end">
			<div class="flex flex-col gap-1 w-full">
				<p class="font-semibold">Search History</p>
				<input id="search" class="border rounded-sm bg-slate-100 border-slate-300 py-2 sm:py-1 px-2 outline-1 outline-blue-500 caret-blue-500" type="text" />
			</div>
		</div>	
	</div>

	<div class="flex flex-col gap-2 px-4 py-2 border bg-white rounded-md mt-5">
		<div class="flex flex-col md:flex-row md:justify-between py-2">
			<p class="p-2 font-semibold">History</p>
		</div>
		<div class="overflow-x-scroll pb-4">
			<table id="history-table" class="text-sm bg-slate-50">
				<thead class="bg-slate-100 text-slate-900 font-medium">
					<tr>
						<th class="hidden">Request ID</th>
						<th>Date Requested</th>
						<th>Date Completed</th>
						<th>Purpose</th>
						<th>Quantity</th>
						<th>Status</th>
						<th>Tag</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					
					<?php
						foreach ($data['history'] as $key => $row):
							$date_created = new DateTime($row->date_created);
							if(empty($row->date_created)) {
								$date_created = '---- -- --';
							} else {
								$date_created = $date_created->format('m/d/Y');
							}

							$date_completed = new DateTime($row->date_completed);
							if(empty($row->date_completed)) {
								$date_completed = '---- -- --';
							} else {
								$date_completed = $date_completed->format('m/d/Y');
							}

					?>
							<tr class="border-b border-slate-200">
								<td class="font-semibold hidden"><?php echo $row->id; ?></td>
								<td><?php echo $date_created; ?></td>
								<td><?php echo $date_completed; ?></td>

								<td><?php echo $row->purpose; ?></td>
								<td><?php echo $row->quantity; ?></td>
								
								<?php if($row->status == 'pending'): ?>
									<td>
										<span class="bg-yellow-500 text-white rounded-md px-1 py-1 status-btn cursor-pointer">pending</span>
									</td>
								<?php endif; ?>

								<?php if($row->status == 'awaiting payment confirmation'): ?>
									<td>
										<span class="bg-yellow-500 text-white rounded-md px-1 py-1 status-btn cursor-pointer">awaiting payment confirmation</span>
									</td>
								<?php endif; ?>

								<?php if($row->status == 'accepted'): ?>
									<td>
										<span class="bg-cyan-500 text-white rounded-md px-1 py-1 status-btn cursor-pointer">accepted</span>
									</td>
								<?php endif; ?>

								<?php if($row->status == 'rejected'): ?>
									<td>
										<span class="bg-red-500 text-white rounded-md px-1 py-1 status-btn cursor-pointer">declined</span>
									</td>
								<?php endif; ?>

								<?php if($row->status == 'for process'): ?>
									<td>
										<span class="bg-orange-500 text-white rounded-md px-1 py-1 status-btn cursor-pointer">for process</span>
									</td>
								<?php endif; ?>

								<?php if($row->status == 'for claiming'): ?>
									<td>
										<span class="bg-sky-500 text-white rounded-md px-1 py-1 status-btn cursor-pointer">for claiming</span>
									</td>
								<?php endif; ?>

								<?php if($row->status == 'cancelled'): ?>
									<td>
										<span class="bg-red-500 text-white rounded-md px-1 py-1 status-btn cursor-pointer">cancelled</span>
									</td>
								<?php endif; ?>

								<?php if($row->status == 'completed'): ?>
									<td>
										<span class="bg-green-500 text-white rounded-md px-1 py-1 status-btn cursor-pointer">completed</span>
									</td>
								<?php endif; ?>
								
								
								<?php if($row->price <= 0): ?>
									<td>
										<span class="bg-green-500 text-white rounded-md px-1 py-1 status-btn cursor-pointer">no payment</span>
									</td>
								<?php else: ?>
									<td>
										<span class="bg-orange-500 text-white rounded-md px-1 py-1 status-btn cursor-pointer">with payment</span>
									</td>
								<?php endif; ?>	
								
								<td class="text-center">
									<div class="flex gap-1 items-center justify-center">
										<!--<?php //echo URLROOT.'/good_moral/show/'.$row->id ;?>-->
										<a class="hover:text-blue-700 view-btn" class="text-blue-700" href="#">view</a>
										
										<?php if($row->status == 'pending'): ?>
											<a class="hover:text-blue-700 edit-btn cursor-pointer">edit</a>
										<?php endif; ?>

										<?php if($row->status == 'awaiting payment confirmation'): ?>
											<a class="hover:text-blue-700 confirm-payment-btn" href="<?php echo URLROOT.'/good_moral/confirm_payment/'.$row->id ;?>" >confirm</a>
										<?php endif; ?>

										<?php if($row->status == 'pending' || $row->status == 'awaiting payment confirmation'): ?>
											<a class="text-red-700 drop-btn" href="<?php echo URLROOT.'/good_moral/cancel/'.$row->id ;?>" >cancel</a>
										<?php endif; ?>

										<?php if($row->price > 0): ?>
											<a href="" data-request="<?php echo $row->id ?>" title="generate order of payment" class="generate-oop-btn text-blue-700">
												<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
												  	<path d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0016.5 9h-1.875a1.875 1.875 0 01-1.875-1.875V5.25A3.75 3.75 0 009 1.5H5.625z" />
												  <path d="M12.971 1.816A5.23 5.23 0 0114.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 013.434 1.279 9.768 9.768 0 00-6.963-6.963z" />
												</svg>

											</a>
										<?php endif; ?>
									</div>
								</td>
							</tr>
					<?php
						endforeach;
					?>
				
				</tbody>
			</table>
		</div>
	</div>
</div>


<!-------------------------------------- view panel ---------------------------------->

<div id="view-panel" class="fixed z-30 top-0 w-full md:w-1/2 h-full bg-white card-box-shadow -right-full transition-all ease-in-out delay-250 overflow-y-scroll pt-16">
	<div class="flex gap-2">
		<a id="view-exit-btn" class="m-2 p-1 hover:bg-slate-100">
			<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-slate-400">
				<path stroke-linecap="round" stroke-linejoin="round" d="M11.25 4.5l7.5 7.5-7.5 7.5m-6-15l7.5 7.5-7.5 7.5" />
			</svg>
		</a>
	</div>

	<div class="flex justify-center w-full h-max">
		<div class="flex flex-col w-10/12 pt-10 pb-20">
			<div class="flex flex-col gap2 w-full">
				<p class="text-2xl font-bold">REQUEST ID <span class="font-normal" id="request-id"></span></p>
				<p class="text-sm text-slate-500">If the below information is not accurate, please contact an admin to address the problem.</p>
			</div>

			<div class="flex flex-col gap2 w-full mt-6">
				<table class="w-full table-fixed">
					<tr>
						<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="30">Status</td>
						<td width="70" class="hover:bg-slate-100 p-1 pl-2"><span id="status"></span></td>
					</tr>

					<tr>
						<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="30">Document Requested</td>
						<td width="70" class="hover:bg-slate-100 p-1 pl-2"><span id="documents" ></span></td>
					</tr>
					
					<tr>
						<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="20">Date Created</td>
						<td width="80" class="hover:bg-slate-100 p-1 pl-2"><span id="date-created" class=""></span></td>
					</tr>
					
					<tr>
						<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="20">Date Completed</td>
						<td width="80" class="hover:bg-slate-100 p-1 pl-2"><span id="date-completed" class=""></span></td>
					</tr>

					<tr>
						<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="20">Quantity</td>
						<td width="80" class="hover:bg-slate-100 p-1 pl-2"><span id="quantity" class=""></span></td>
					</tr>

					<tr>
						<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="20">Purpose</td>
						<td width="80" class="hover:bg-slate-100 p-1 pl-2">
							<p id="purpose"></p>
						</td>
					</tr>
				</table>	
			</div>

			<div id="payment-info" class="flex flex-col gap-2 w-full mt-2 hidden">
				<p class="pl-2 pt-2 font-semibold">Payment Information</p>
				<table class="w-full table-fixed">
					<tr>
						<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="30">Price</td>
						<td width="70" class="hover:bg-slate-100 p-1 pl-2"><a class="cursor-pointer" id="price"></a></td>
					</tr>
				</table>
			</div>

			<div class="flex flex-col gap2 w-full mt-2">
				<p class="pl-2 pt-2 pb-4 font-semibold">Remarks</p>
				<div class="w-full pl-2">
					<p id="remarks">...</p>
				</div>
			</div>

		</div>
	</div>
</div>

<!-------------------------------------- edit panel ---------------------------------->


<div id="edit-panel" class="fixed z-35 top-0 w-full md:w-1/2 h-full bg-white card-box-shadow -right-full transition-all ease-in-out delay-250 overflow-y-scroll pt-16">
	<div class="flex gap-2">
		<a id="edit-exit-btn" class="m-2 p-1 hover:bg-slate-100">
			<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-slate-400">
				<path stroke-linecap="round" stroke-linejoin="round" d="M11.25 4.5l7.5 7.5-7.5 7.5m-6-15l7.5 7.5-7.5 7.5" />
			</svg>
		</a>
	</div>
	<div class="flex justify-center w-full h-max">
		<div class="flex flex-col w-10/12 pt-10 pb-20">
			<div class="flex flex-col gap2 w-full">
				<a class="text-2xl cursor-pointer font-bold">REQUEST ID <span class="font-normal" id="request-id"></span></a>
				<p class="text-sm text-slate-500">Update your good moral certificate request</p>
			</div>

			<div class="w-full">
				<form action="<?php echo URLROOT; ?>/good_moral/edit" enctype="multipart/form-data" method="POST" class="w-full">
					<input name="request-id" type="hidden" value="" />
					
					<div class="flex flex-col mt-5">
						<div class="flex flex-col gap2 w-full">
							<p class="font-semibold">Quantity<span class="text-sm font-normal"> (required)</span></p>
							<p class="text-sm text-slate-500"></p>
						</div>
						<input name="quantity" class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-400 mt-4" type="number" min="1" max="5" value="1" required>
					</div>

					<div class="flex flex-col mt-5">
						<div class="flex flex-col gap2 w-full">
							<p class="font-semibold">Purpose<span class="text-sm font-normal"> (required)</span></p>
						</div>
						<select name="purpose" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-4 text-neutral-700" required>
							<option value="">Choose Option</option>
							<option value="Work / Employment">Work / Employment</option>
							<option value="Masteral / Graduate Studies">Masteral / Graduate Studies</option>
							<option value="PNP Application">PNP Application</option>
							<option value="Application For Second Course (for graduate only)">Application For Second Course (for graduate only)</option>
							<option value="Others">Others</option>
						</select>
					</div>

					<div id="others-hidden-input" class="flex flex-col mt-5 hidden">
						<div class="flex flex-col gap2 w-full">
							<p class="font-semibold">Please Specify<span class="text-sm font-normal"> (required)</span></p>
							<p class="text-sm text-slate-500"></p>
						</div>
						<input name="other-purpose" class="border rounded-sm border-slate-300  py-1 px-2 outline-1 outline-blue-400 mt-4" type="text">
					</div>

					<input class=" mt-10 rounded-sm bg-blue-700 text-white border w-max px-5 py-1 rounded-md cursor-pointer" type="submit" value="Submit Request"/>
					<p class="text-sm text-slate-500 mt-2">Upon submission, request will be reviewed by an authorized personnel. An SMS or Email Notification will be sent to you in regards to your request status.</p>
				</form>

			</div>
		</div>
	</div>
</div>

<!-------------------------------------- add panel ---------------------------------->

<div id="add-panel" class="fixed z-35 top-0 w-full md:w-1/2 h-full bg-white card-box-shadow -right-full transition-all ease-in-out delay-250 overflow-y-scroll pt-16">
	<div class="flex gap-2">
		<a id="add-exit-btn" class="m-2 p-1 hover:bg-slate-100">
			<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-slate-400">
				<path stroke-linecap="round" stroke-linejoin="round" d="M11.25 4.5l7.5 7.5-7.5 7.5m-6-15l7.5 7.5-7.5 7.5" />
			</svg>
		</a>
	</div>
	<div class="flex justify-center w-full h-max">
		<div class="flex flex-col w-10/12 pt-10 pb-20">
			<div class="flex flex-col gap2 w-full">
				<a class="text-2xl cursor-pointer font-bold">New Request</a>
				<p class="text-sm text-slate-500">Create new request for good moral certificate</p>
			</div>

			<div class="w-full">
				<form id="add-request-form" action="<?php echo URLROOT; ?>/good_moral/add" enctype="multipart/form-data" method="POST" class="w-full">
					<input name="student-id" type="hidden" value="<?php echo $_SESSION['id']?>"/>
					<input name="type" type="hidden" value="alumni">

					<div class="flex flex-col mt-5">
						<div class="flex flex-col gap2 w-full">
							<p class="font-semibold">Quantity<span class="text-sm font-normal"> (required)</span></p>
							<p class="text-sm text-slate-500"></p>
						</div>
						<input name="quantity" class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-400 mt-4" type="number" min="1" max="5" value="1" required>
					</div>
					
					<div class="flex flex-col mt-5">
						<div class="flex flex-col gap2 w-full">
							<p class="font-semibold">Purpose<span class="text-sm font-normal"> (required)</span></p>
						</div>
						<select name="purpose" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-4 text-neutral-700" required>
							<option value="">Choose Option</option>
							<option value="Work / Employment">Work / Employment</option>
							<option value="Masteral / Graduate Studies">Masteral / Graduate Studies</option>
							<option value="PNP Application">PNP Application</option>
							<option value="Application For Second Course (for graduate only)">Application For Second Course (for graduate only)</option>
							<option value="Others">Others</option>
						</select>
					</div>

					<div id="others-hidden-input" class="flex flex-col mt-5 hidden">
						<div class="flex flex-col gap2 w-full">
							<p class="font-semibold">Please Specify<span class="text-sm font-normal"> (required)</span></p>
							<p class="text-sm text-slate-500"></p>
						</div>
						<input name="other-purpose" class="border rounded-sm border-slate-300  py-1 px-2 outline-1 outline-blue-400 mt-4" type="text">
					</div>

					<input class=" mt-10 rounded-sm bg-blue-700 text-white border w-max px-5 py-1 rounded-md cursor-pointer" type="submit" value="Submit"/>
					<p class="text-sm text-slate-500 mt-2">Upon submission, request will be reviewed by an authorized personnel. An SMS or Email Notification will be sent to you in regards to your request status.</p>
				</form>

			</div>
		</div>
	</div>
</div>

<div id="oop-modal" style="background-color: rgba(255, 255, 255, 0.5);" class="fixed flex flex-col gap-2 items-center w-full h-full z-50 top-0 left-0 hidden">
	<div class="w-96 flex items-end justify-end p-4 rounded-md mt-20">
		<a id="upload-oop" class="p-2 h-max w-max bg-blue-700 text-white rounded-full flex justify-center items-center">
			<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
					<path stroke-linecap="round" stroke-linejoin="round" d="M9 13.5l3 3m0 0l3-3m-3 3v-6m1.06-4.19l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
			</svg>
		</a>
	</div>

	<div id="oop-body" class="bg-white w-96 border rounded-md p-6">
		<a class="absolute right-2 top-2 cursor-pointer" id="oop-exit-btn">
			<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
			  <path stroke-linecap="round" stroke-linejoin="round" d="M18 12H6" />
			</svg>
		</a>

		<div class="flex flex-col items-center gap-1 w-full">
			<img class="w-20 aspect-square" src="<?php echo URLROOT; ?>/public/assets/img/logo.png"/>
			<p class="text-xl font-bold">QUEZON CITY UNIVERSITY</p>
			<p>Online Consultation and Document Request</p>
			<p class="mt-5 font-medium text-lg">ORDER OF PAYMENT</span></p>
		</div>

		<div class="mt-5">
			<table class="border border-collapse w-full text-sm">
				<tr class="border">
					<td width="40%" class="border p-2">Transaction No.<td>
					<td width="60%" class="p-2"><p id="oop-no"></p><td>
				</tr>
				
				<tr class="border">
					<td width="40%" class="border p-2">Student ID<td>
					<td width="60%" class="p-2"><p id="oop-id"></p><td>
				</tr>

				<tr class="border">
					<td width="40%" class="border p-2">Name<td>
					<td width="60%" class="p-2"><p id="oop-name"></p><td>
				</tr>

				<tr class="border">
					<td class="border p-2">Amount Due in PHP<td>
					<td class="p-2"><p id="oop-price"></p><td>
				</tr>

				<tr class="border">
					<td class="border p-2">Document<td>
					<td class="p-2"><p id="oop-doc">Good Moral Certificate</p><td>
				</tr>				
			</table>
		</div>

		<div class="mt-5 text-sm">
			<p>When you come to make your payment, please bring a copy of this document and a valid university ID. This will help us verify the amount due and ensure that your payment is processed correctly.</p>
		</div>
	</div>
</div>

<div id="changes-notice-modal"  class="fixed h-full w-full top-0 left-0 z-50 hidden">
	<div class="fixed bottom-10 right-10 h-max flex flex-col p-4 rounded-md gap-2 border bg-orange-200 text-orange-500 z-50">
		<div class="flex gap-2 items-center">
			<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
				<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
			</svg>

			<p class="font-medium">Records has changes</p>
		</div>
		<p>Plese click the link below to reload the page</p>
		<a class="underline" href="<?php echo URLROOT?>/good_moral">show</a>
	</div>
</div>
<!-------------------------------------- script ---------------------------------->

<script>
	<?php
		require APPROOT.'/views/good-moral/index/alumni/alumni.js';
	?>
</script>



