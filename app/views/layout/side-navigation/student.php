
<li class="flex flex-col py-1 text-slate-700 rounded-sm">
	<a id="document-request-dropdown-btn" class=" flex items-center gap-2 justify-between py-1 px-2">
		<p>Document Request</p>
		<span id="document-request-dropdown-icon">
		      <svg class="fill-current h-4 w-4 transform transition duration-150 ease-in-out" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" /></svg>
		</span>
	</a>

	<ul id="document-request-menu" class="h-max overflow-hidden bg-slate-100 pl-2">
		<a href="<?php echo URLROOT; ?>/academic_document"><li class="flex py-1 px-4 hover:bg-slate-200 text-slate-700 rounded-sm <?php echo $data['document-nav-active'] ?>">
			<p>Academic Documents</p>
		</li></a>	

		<a href="<?php echo URLROOT; ?>/good_moral"><li class="flex py-1 px-4 hover:bg-slate-200 text-slate-700 rounded-sm <?php echo $data['moral-nav-active'] ?>">
			<p>Good Moral</p>
		</li></a>

		<a href="<?php echo URLROOT; ?>/statement_of_account"><li class="flex py-1 px-4 hover:bg-slate-200 text-slate-700 rounded-sm <?php echo $data['soa-nav-active'] ?>">
			<p>SOA / Order Of Payment</p>
		</li></a>		
	</ul>
</li>

<li class="flex flex-col py-1 text-slate-700 rounded-sm">
	<a id="consultation-dropdown-btn" class=" flex items-center gap-2 justify-between py-1 px-2">
		<p>Consultation</p>
		<span id="consultation-dropdown-icon">
		      <svg class="fill-current h-4 w-4 transform transition duration-150 ease-in-out" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" /></svg>
		</span>
	</a>

	<ul id="consultation-menu" class="h-max overflow-hidden bg-slate-100 pl-2">
		<a href="<?php echo URLROOT; ?>/consultation/request"><li class="flex py-1 px-4 hover:bg-slate-200 text-slate-700 rounded-sm <?php echo $data['consultation-request-nav-active'] ?>">
			<p>Request Consultation</p>
		</li></a>	

		<a href="<?php echo URLROOT; ?>/consultation/active"><li class="flex py-1 px-4 hover:bg-slate-200 text-slate-700 rounded-sm <?php echo $data['consultation-active-nav-active'] ?>">
			<p>Active Consultations</p>
		</li></a>

		<a href="<?php echo URLROOT; ?>/consultation/records"><li class="flex py-1 px-4 hover:bg-slate-200 text-slate-700 rounded-sm <?php echo $data['consultation-records-nav-active'] ?>">
			<p>Consultation Records</p>
		</li></a>
	</ul>
</li>


<a href="<?php echo URLROOT; ?>/record"><li class="flex py-1 px-2 hover:bg-slate-200 text-slate-700 rounded-sm <?php echo $data['record-nav-active'] ?>">
	<p>Records</p>
</li></a>