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
			<div class="h-max w-10/12 py-14 pb-24">
				<div class="flex flex-col">
					<p class="text-2xl font-bold">New Professor</p>
					<p class="text-sm text-slate-500">Create new account for professor</p>
				</div>

				<div class="w-10/12">
					<?php
						require APPROOT.'/views/flash/fail.php';
						require APPROOT.'/views/flash/success.php';
					?>
					<form method="POST" action="<?php echo URLROOT;?>/professor/add">
						<input type="hidden" name="type" value="professor"/>

						<div class="flex flex-col mt-4">
							<span class="text-neutral-700 font-medium">Professor ID<span class="text-sm font-normal"> (required)</span></span>
							<input class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2" type="number" name="id"/>
						</div>		
						
						<div class="flex flex-col mt-5">
							<span class="text-neutral-700 font-medium">Email<span class="text-sm font-normal"> (required)</span></span>
							<input class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2" type="email" name="email"/>
							<p class="text-sm text-slate-500">You have to set an active email address. Email registered here will be used for notification and other stuff within the application</p>
						</div>

						<div class="flex mt-4 gap-1">
							<div class="flex flex-col w-full">
								<span class="text-neutral-700 font-medium">Password<span class="text-sm font-normal"> (required)</span></span>
								<input class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2" type="password" name="pass"/>
							</div>

							<div class="flex flex-col w-full">
								<span class="text-neutral-700 font-medium">Confirm password<span class="text-sm font-normal"> (required)</span></span>
								<input class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2" type="password" name="confirm-pass"/>
							</div>
						</div>
						<p class="text-sm text-slate-500">Password should be atleast 8 characters long. Alphanumeric</p>

						<div class="flex mt-4 gap-1">
							<div class="flex flex-col w-full">
								<span class="text-neutral-700 font-medium">Lastname<span class="text-sm font-normal"> (required)</span></span>
								<input class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2" type="text" name="lname"/>
							</div>

							<div class="flex flex-col w-full">
								<span class="text-neutral-700 font-medium">Firstname<span class="text-sm font-normal"> (required)</span></span>
								<input class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2" type="text" name="fname"/>
							</div>
						</div>
						
						<div class="flex flex-col mt-5">
							<span class="text-neutral-700 font-medium">Middlename</span>
							<input class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2" type="text" name="mname"/>
						</div>

						<div class="flex mt-4 gap-1">
							<div class="flex flex-col w-full">
								<span class="text-neutral-700 font-medium">Gender<span class="text-sm font-normal"> (required)</span></span>
								<select class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2" name="gender">
									<option value="">Choose option</option>
									<option value="Male">Male</option>
									<option value="Female">Female</option>
								</select>
							</div>

							<div class="flex flex-col w-full">
								<span class="text-neutral-700 font-medium">Contact<span class="text-sm font-normal"> (required)</span></span>
								<input class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2" type="number" name="contact"/>
							</div>
						</div>

						<div class="flex flex-col mt-5">
							<span class="text-neutral-700 font-medium">Department<span class="text-sm font-normal"> (required)</span></span>
							<select class="border rounded-sm border-slate-300 py-1 px-2 outline-1 outline-blue-500 mt-2" name="department">
								<option value="">Choose option</option>
								<option value="College of Computer Science and Information Technology">College of Computer Science and Information Technology</option>
								<option value="College of Business and Accountancy">College of Business and Accountancy</option>
								<option value="College of Education">College of Education</option>
								<option value="College of Engineering">College of Engineering</option>		
							</select>
						</div>

						<input class=" mt-10 rounded-sm bg-blue-700 text-white border w-max px-5 py-1 rounded-md cursor-pointer" type="submit" value="Add new professor"/>
						<p class="text-sm text-slate-500 mt-2">Upon submission, SMS and an Email will be sent to notify the professor. </p>
					</form>
				</div>

			</div>
		</div>
	</div>
</main>

<!-------------------------------------- script ---------------------------------->

<script>
	<?php require APPROOT.'/views/admin/add/add.js'; ?>
</script>

