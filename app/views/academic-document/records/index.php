<?php
	require APPROOT.'/views/layout/header.php';
?>
<main class="flex flex-con h-full w-full overflow-hidden">

	<!-------------------------------------- side navigation ----------------------------------------------------------------->
	
	<?php
		require APPROOT.'/views/layout/side-navigation/index.php';
	?>

	<!-------------------------------------- main content -------------------------------------------------------------------->
	
	<div class="w-full h-full">
		<?php
			require APPROOT.'/views/layout/horizontal-navigation/index.php';
		?>

		<div class="flex justify-center w-full h-full overflow-y-scroll">
			<div class="min-h-full w-10/12 py-14">
				<!-- header -->
				<div class="flex justify-between items-center">
					<div class="flex flex-col">
						<p class="text-3xl font-bold">Good Moral Records</p>
						<p class="text-sm text-slate-500">Review and manage document request records</p>
					</div>
				</div>

				<div class="flex flex-col mt-5 gap-2 pb-24">
					
					<?php
						require APPROOT.'/views/flash/fail.php';
						require APPROOT.'/views/flash/success.php';
					?>

					<div class="grid w-full mt-5 justify-items-end">
						<div class="flex w-full gap-2 items-end">
							<div class="flex flex-col gap-1 w-1/2">
								<p class="font-semibold">What are you looking for?</p>
								<input id="search" class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 caret-blue-500" type="text" />
							</div>

							<div class="flex flex-col gap-1 w-1/4">
								<p class="font-semibold">Type</p>
								<select id="type-filter" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 text-neutral-700">
									<option value="">All</option>
									<option value="student">Student</option>
									<option value="alumni">Alumni</option>
								</select>
							</div>

							<div class="flex flex-col gap-1 w-1/4">
								<p class="font-semibold">Documents</p>
								<select id="document-filter" class="border rouded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 text-neutral-700">
									<option value="">All</option>
									<option value="tor">TOR(undergraduate)</option>
									<option value="diploma">TOR/Diploma</option>
									<option value="ctc">CTC</option>
									<option value="gradeslip">Gradeslip</option>
									<option value="others">Others</option>
								</select>
							</div>

							<a id="search-btn" class="flex bg-blue-700 text-white rounded-md px-4 py-1 h-max cursor-pointer">Search</a>
						</div>	
					</div>
					
					<div class="flex flex-col gap-2 px-4 py-2 border rounded-md mt-5">
						<div class="flex items-center justify-between py-2">
							<p class="p-2 text-lg font-semibold">Request Summary</p>
							<div class="flex gap-2 items">
								<button id="export-table-btn" class="flex bg-blue-700 text-white rounded-md px-4 py-1 h-max">
									<!--<div class="flex items-center text-blue-700 gap-1">
										<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
					 						 <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
										</svg>
									</div>-->
									Export Table
								</button>

								<form action="<?php echo URLROOT;?>/academic_document/multiple_delete" method="POST" id="multiple-drop-form" class="hidden">
									<input name="request-ids-to-drop" type="hidden">
								</form>

								<button id="drop-multiple-row-selection-btn" class="flex bg-red-500 text-white rounded-md px-4 py-1 h-max opacity-50 cursor-not-allowed" disabled>
									<!--<div class="flex items-center text-red-700 gap-1">
										<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
				  							<path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
										</svg>
									</div>-->
									Delete Selected
								</button>
							</div>
						</div>

						<table id="request-table" class="bg-white text-sm overflow-x-scroll">
							<thead class="bg-slate-100 text-slate-900 font-medium">
								<tr>
									<th class="hidden">Request ID</th>
									<th class="flex gap-2 items-center"><input id="select-all-row-checkbox" type="checkbox">Student ID</th>
									<th>Date Requested</th>
									<th>Date Completed</th>
									<th>Requested Document</th>
									<th>Type</th>
									<th>Status</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php
									foreach ($data['requests-data'] as $key => $row):
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
											<td class="flex gap-2 items-center"><input class="row-checkbox" type="checkbox"><?php echo $row->student_id; ?></td>
											<td><?php echo $date_created; ?></td>
											<td><?php echo $date_completed; ?></td>
											<td class="flex gap-1 text-sm">
												
												<?php

													$documents = [];
													if($row->is_tor_included) array_push($documents, 'TOR');
													if($row->is_gradeslip_included) array_push($documents, 'Gradeslip');
													if($row->is_ctc_included) array_push($documents, 'CTC');
													if($row->is_diploma_included) array_push($documents, 'Diploma');
													if(!empty($row->other_requested_document)) array_push($documents, 'Others');

													$documents = implode(' + ', $documents);
												?>

												<p><?php echo $documents; ?></p>
												
											</td>

											<td><?php echo $row->type ?></td>
											
											<?php if($row->status == 'pending'): ?>
												<td>
													<span class="bg-yellow-100 text-yellow-700 rounded-full px-5 text-sm py-1 status-btn cursor-pointer">pending</span>
												</td>
											<?php endif; ?>

											<?php if($row->status == 'accepted'): ?>
												<td>
													<span class="bg-cyan-100 text-cyan-700 rounded-full px-5 text-sm py-1 status-btn cursor-pointer">accepted</span>
												</td>
											<?php endif; ?>

											<?php if($row->status == 'rejected'): ?>
												<td>
													<span class="bg-red-100 text-red-700 rounded-full px-5 text-sm py-1 status-btn cursor-pointer">rejected</span>
												</td>
											<?php endif; ?>

											<?php if($row->status == 'in process'): ?>
												<td>
													<span class="bg-yellow-100 text-yellow-700 rounded-full px-5 text-sm py-1 status-btn cursor-pointer">in process</span>
												</td>
											<?php endif; ?>

											<?php if($row->status == 'for claiming'): ?>
												<td>
													<span class="bg-sky-100 text-sky-700 rounded-full px-5 text-sm py-1 status-btn cursor-pointer">for claiming</span>
												</td>
											<?php endif; ?>

											<?php if($row->status == 'completed'): ?>
												<td>
													<span class="bg-green-100 text-green-700 rounded-full px-5 text-sm py-1 status-btn cursor-pointer">completed</span>
												</td>
											<?php endif; ?>
											
											<td class="text-center">
												<!--<?php //echo URLROOT.'/academic_document/show/'.$row->id ;?>-->
												<a class="view-btn" class="hover:text-blue-700 text-blue-700" href="#">view</a>
												<a class="text-red-500 drop-btn" href="<?php echo URLROOT.'/academic_document/delete/'.$row->id?>">delete</a>
											</td>
											
										</tr>
								<?php
									endforeach;
								?>
							</tbody>
						</table>
					</div>
				</div>

				<!-------------------------------------- view panel ---------------------------------->

				<div id="view-panel" class="fixed z-30 top-0 w-1/2 h-full bg-white card-box-shadow -right-full transition-all ease-in-out delay-250 overflow-y-scroll pt-16">
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
								<p class="text-2xl font-bold">Document Request <span class="text-sm font-normal" id="request-id"></span></p>
								<p class="text-sm text-slate-500">If the below information is not accurate, please contact an admin to address the problem.</p>
							</div>

							<div class="flex flex-col gap2 w-full mt-6">
								<table class="w-full table-fixed">
									<tr>
										<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="30">Student ID</td>
										<td width="70" class="hover:bg-slate-100 p-1 pl-2 font-semibold"><span id="student-id"></span></td>
									</tr>

									<tr>
										<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="30">Status</td>
										<td width="70" class="hover:bg-slate-100 p-1 pl-2"><a class="cursor-pointer" id="status"></a></td>
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
										<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="20">Purpose</td>
										<td width="80" class="hover:bg-slate-100 p-1 pl-2">
											<p id="purpose"></p>
										</td>
									</tr>

									<tr>
										<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="20">RA11261 Beneficiary</td>
										<td id="beneficiary" width="80" class="width-full hover:bg-slate-100 p-1 pl-2"></td>
									</tr>
								</table>	
							</div>

							<div class="flex flex-col gap-2 w-full mt-2">
								<p class="pl-2 pt-2 font-semibold">Student Information</p>
								<table class="w-full table-fixed">
									<tr>
										<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="30">Name</td>
										<td width="70" class="hover:bg-slate-100 p-1 pl-2"><span class="cursor-pointer" id="name"></span></td>
									</tr>

									<tr>
										<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="30">Course</td>
										<td width="70" class="hover:bg-slate-100 p-1 pl-2"><span class="cursor-pointer" id="course"></span></td>
									</tr>

									<tr>
										<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="30">Year</td>
										<td width="70" class="hover:bg-slate-100 p-1 pl-2"><span class="cursor-pointer" id="year"></span></td>
									</tr>

									<tr>
										<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="30">Section</td>
										<td width="70" class="hover:bg-slate-100 p-1 pl-2"><span class="cursor-pointer" id="section"></span></td>
									</tr>
								</table>
							</div>

							<div class="flex flex-col gap-2 w-full mt-2">
								<p class="pl-2 pt-2 pb-4 font-semibold">Additional Information</p>
								<table class="w-full table-fixed">
									
									<tr id="tor" class="border-t border-slate-200 hidden"> 
										<td class="text-slate-500 p-1 pl-2" width="30">
											<p class="text-sm text-slate-700">Transcipt Of Records</p>
											<p>Academic Year</p>
										</td>
										<td width="70" class="py-2 pl-2"><span id="academic-year"></span></td>
									</tr>
								
									<tr id="diploma" class="border-t border-slate-200 hidden">
										<td class="text-slate-500 py-2 pl-2" width="30">
											<p class="text-sm text-slate-700">Diploma</p>
											<p>Year Graduated</p>
										</td>
										<td width="70" class="py-2 pl-2"><span id="year-graduated" ></span></td>
									</tr>
									
									<tr id="gradeslip" class="border-t border-slate-200 hidden">
										<td class="text-slate-500 py-2 pl-2" width="30">
											<p class="text-sm text-slate-700">Gradeslip</p>
											<p>Year & Sem</p>
										</td>
										<td width="70" class="py-2 pl-2"><span id="year-sem" class=""></span></td>
									</tr>
									
									<tr id="ctc" class="border-t border-slate-200 hidden">
										<td class="text-slate-500 py-2 pl-2" width="30">
											<p class="text-sm text-slate-700">Certified True Copy</p>
											<p>Document</p>
										</td>
										<td width="70" class="p-1 pl-2"><a href="#" id="ctc-document" class="hover:underline text-blue-700"></a></td>
									</tr>

									<tr id="other" class="border-t border-slate-200 hidden">
										<td class="text-slate-500 p-1 pl-2" width="30">
											<p class="text-sm text-slate-700">Other Requested Doc</p>
											<p>Document</p>
										</td>
										<td width="70" class="p-1 pl-2"><span id="other-document" class=""></span></td>
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
			</div>
		</div>
	</div>

</main>

<!-------------------------------------- script ---------------------------------->

<script>
	<?php
		require APPROOT.'/views/academic-document/records/records.js';
	?>
</script>


