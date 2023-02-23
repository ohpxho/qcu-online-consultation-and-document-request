<!-- header -->
<div class="flex justify-between items-center">
	<div class="flex flex-col">
		<p class="text-3xl font-bold">Online Consultation <span class="text-sm font-normal">#<?php echo $data['request-data']->id; ?></span></p>
		<p class="text-sm text-slate-500">Review and manage online consultation</p>
	</div>
	<div>
		<div id="unseen-message-count-bubble" class="absolute z-10 -top-2 -right-1 flex h-5 w-5 p-1 rounded-full bg-red-500 items-center justify-center text-center hidden">
			<span id="unseen-message-count" class="text-white text-xs"></span>
		</div>
		<a class="flex gap-1" id="chat-btn" href="#"><img class="h-8 w-8" src="<?php echo URLROOT; ?>/public/assets/img/chat.png"></a>
	</div>
</div>

<div class="flex flex-col mt-10 gap-2 pb-24">
	<?php
		require APPROOT.'/views/flash/fail.php';
		require APPROOT.'/views/flash/success.php';
	?>

	<div class="flex flex-col gap-2">
		<div id="sched-notice" class="flex w-full bg-orange-100 gap-2 py-2 px-4 mb-3 text-orange-700 hidden">
			<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
			  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
			</svg>
			<span id="date-diff"></span>
		</div>
		
		<div class="flex flex-col">
			<p class="font-medium text-xl">Information</p>
		</div>
		<div>
			<table class="w-full table-fixed">
				<tr>
					<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="30">Status</td>
					<td width="70" class="hover:bg-slate-100 p-1 pl-2"><span class="bg-green-100 text-green-700 rounded-full px-5 py-1 cursor-pointer">active</span></td>
				</tr>

				<tr>
					<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="30">Purpose</td>
					<td width="70" class="hover:bg-slate-100 p-1 pl-2"><span id="purpose"></span></td>
				</tr>
				
				<tr>
					<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="20">Date Created</td>
					<td width="80" class="hover:bg-slate-100 p-1 pl-2"><span id="date-created" class=""></span></td>
				</tr>
				
				<tr>
					<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="20">Adviser</td>
					<td width="80" class="hover:bg-slate-100 p-1 pl-2">
						<p id="adviser"></p>
					</td>
				</tr>

				<tr>
					<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="20">Department</td>
					<td width="80" class="hover:bg-slate-100 p-1 pl-2"><span id="department"></span></td>
				</tr>

				<tr>
					<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="20">Subject Code</td>
					<td width="80" class="hover:bg-slate-100 p-1 pl-2"><span id="subject"></span></td>
				</tr>
			</table>
		</div>
	</div>

	<div class="flex flex-col gap-2 mt-5">
		<div class="flex flex-col">
			<p class="font-medium text-xl">Problem</p>
			<p class="text-sm text-slate-500">Focus subject of consultation</p>
		</div>

		<div id="problem" class="p-1 pl-2"></div>
	</div>

	<div class="flex flex-col gap-2 mt-5">
		<div class="flex flex-col">
			<p class="font-medium text-xl">Additional Information</p>
			<p class="text-sm text-slate-500"></p>
		</div>

		<table class="w-full table-fixed">			
			<tr>
				<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="30">Preferred Date</td>
				<td width="70" class="hover:bg-slate-100 p-1 pl-2"><span id="preferred-date" class=""></span></td>
			</tr>
		
			<tr>
				<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="30">Preferred Time</td>
				<td width="70" class="hover:bg-slate-100 p-1 pl-2"><span id="preferred-time" class=""></span></td>
			</tr>
		</table>
	</div>

	<div class="flex flex-col gap-2 mt-5">
		<div class="flex justify-between items-center">
			<div class="flex flex-col">
				<p class="font-medium text-xl">Uploaded Document/s</p>
				<p class="text-sm text-slate-500"></p>
			</div>
		</div>
		<table class="w-full table-fixed">			
			<tr>
				<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="30">Shared By Student</td>
				<td width="70" class="hover:bg-slate-100 p-1 pl-2"><a href="#" id="student-shared-doc" class="hover:text-blue-700 hover:underline text-slate-500"></a></td>
			</tr>
		
			<tr>
				<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="30">Shared By Adviser</td>
				<td width="70" class="hover:bg-slate-100 p-1 pl-2"><a href="#" id="adviser-shared-doc" class="hover:text-blue-700 hover:underline text-slate-500"></a></td>
			</tr>
		</table>
	</div>

	<div class="flex flex-col gap-2 mt-5">
		<div class="flex justify-between items-center">
			<div class="flex flex-col">
				<p class="font-medium text-xl">Schedule For Online Meeting</p>
				<p class="text-sm text-slate-500"></p>
			</div>
		</div>

		<table class="w-full table-fixed">			
			<tr>
				<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="30">Date & Time</td>
				<td width="70" class="hover:bg-slate-100 p-1 pl-2"><span id="sched-for-meet"></span></td>
			</tr>

			<tr>
				<td class="hover:bg-slate-100 text-slate-500 p-1 pl-2" width="30">Gmeet Link</td>
				<td width="70" class="hover:bg-slate-100 p-1 pl-2"><a href="#" class="cursor-pointer" id="link"></a></td>
			</tr>
		</table>
	</div>
</div>

<!-------------------------------------- chat panel ---------------------------------->

<div id="convo-panel" class="fixed z-30 top-0 w-1/4 h-full bg-white card-box-shadow right-0 transition-all ease-in-out delay-250 overflow-y-scroll pt-9">
	<div class="flex gap-2">
		<a id="convo-exit-btn" class="m-2 p-1 hover:bg-slate-100">
			<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-slate-400">
				<path stroke-linecap="round" stroke-linejoin="round" d="M11.25 4.5l7.5 7.5-7.5 7.5m-6-15l7.5 7.5-7.5 7.5" />
			</svg>
		</a>
	</div>

	<div class="flex justify-center w-full h-max gap-2">
		<div class="flex flex-col w-10/12 pt-1 pb-20">
			<div class="flex gap-2 w-full items-center">
				<div class="flex items-center rounded-sm overflow-hidden grow-0 shrink-0 justify-center h-8 w-8 text-sm font-semibold">
					<?php require APPROOT.'/views/includes/profile.picture.php'; ?>
				</div>
				<div class="flex items-center text-sm gap-2">
					<span id="adviser-name" class="text-lg font-medium leading-none"><?php echo $data['request-data']->adviser_name; ?></span>
					<div id="online-indicator" class="rounded-full w-2 h-2 bg-gray-300"></div>
				</div>
			</div>

			<div id="chat-panel" class="flex flex-col gap-2 p-2 rounded-md w-full h-96 bg-slate-50 mt-5 text-sm overflow-hidden hover:overflow-y-scroll">
				<?php foreach($data['messages'] as $message): ?>	
					<?php if($message->sender == $data['request-data']->creator): ?>
						<div class="flex justify-start first:mt-auto chat-bubble">
							<div class="flex flex-col gap-1 w-full">
								<p class="chat-datetime text-xs hide"><?php echo strtoupper(formatDateTimeOfChat($message->datetime))?></p>
								<div class="rounded-md py-1 px-2 max-w-[83.333333%] w-max bg-blue-700">
									<p class="text-white"><?php echo $message->message ?></p>
								</div>
							</div>
						</div>
					<?php else: ?>
						<div class="flex justify-end first:mt-auto chat-bubble">
							<div class="flex flex-col gap-1 items-end w-full">
								<p class="chat-datetime text-xs hidden"><?php echo strtoupper(formatDateTimeOfChat($message->datetime))?></p>
								<div class="rounded-md py-1 px-2 max-w-[83.333333%] w-max bg-gray-200">
									<p class="text-gray-700"><?php echo $message->message ?></p>
								</div>
							</div>
						</div>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>

			<div id="message-box" contenteditable="true" class="border border-slate-300 py-2 px-2 outline-1 outline-blue-500 mt-2 h-max"></div>
			
			<div class="mt-5">
				<a id="send-message-btn" class="flex gap-2 rounded-sm bg-blue-700 items-center text-white border w-max px-5 py-1 rounded-md cursor-pointer">
					<span>Send</span>
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
					 	<path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
					</svg>
				</a>
			</div>
		</div>
	</div>
</div>


<!-------------------------------------- shared document panel ---------------------------------->

<div id="shared-doc-panel" class="fixed z-35 top-0 w-1/2 h-full bg-white card-box-shadow -right-full transition-all ease-in-out delay-250 overflow-y-scroll pt-9">
	<div class="flex gap-2">
		<a id="shared-doc-exit-btn" class="m-2 p-1 hover:bg-slate-100">
			<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-slate-400">
				<path stroke-linecap="round" stroke-linejoin="round" d="M11.25 4.5l7.5 7.5-7.5 7.5m-6-15l7.5 7.5-7.5 7.5" />
			</svg>
		</a>
	</div>
	<div class="flex justify-center w-full h-max">
		<div class="flex flex-col w-10/12 pt-10 pb-20">
			<div class="flex justify-between w-full items-center ">
				<div class="flex flex-col gap2 ">
					<a id="request-id-btn" class="text-2xl cursor-pointer font-bold">Share Document/s</a>
					<p class="text-sm text-slate-500">Upload document/s for the student to see</p>
				</div>

				<a href="#" id="add-shared-doc-btn"><img class="h-7 w-7" src="<?php echo URLROOT;?>/public/assets/img/plus.png"/></a>
			</div>

			<div class="w-full">
				<form id="upload-doc-form" class="hide flex-col" method="POST" class="w-full" enctype="multipart/form-data">
					<input name="request-id" type="hidden" value="" />
					<input name="type" type="hidden" value="" />
					<input name="existing-files" type="hidden" value="" />

					<div class="flex flex-col mt-5">
						<div class="flex flex-col gap2 w-full">
							<p class="font-semibold">Upload Document/s</p>
							<input name="document[]" class="border rounded-sm border-slate-300  py-1 px-2 outline-1 outline-blue-400 mt-2" type="file" multiple="multiple"/>
						</div>
					</div>

					<input class=" mt-5 rounded-sm bg-blue-700 text-white border w-max px-5 py-1 rounded-md cursor-pointer opacity-50 cursor-not-allowed" type="submit" value="Upload" disabled/>
				</form>

				<ul id="shared-docs" class="w-full mt-5"></ul>
			</div>
		</div>
	</div>
</div>

<!-------------------------------------- script ---------------------------------->

<script>
	<?php
		require APPROOT.'/views/consultation/view/student/student.js';
	?>
</script>


