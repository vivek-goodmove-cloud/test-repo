
<!-- Page content-->
<div class="gm_page">
  <div class=" container-fluid ">
    <h1>Approval List </h1>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th scope="col">Sr no</th>
          <th scope="col">Date</th>
          <th scope="col">Organization Name</th>
          <th scope="col">Contact Person</th>
          <th scope="col">Organization Website</th>
          <th scope="col">Application Staus</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php if (isset($orgData) && !empty($orgData)) {
	$cnt = 1;
	foreach ($orgData as $org) {
		//echo "<br>org--><pre>";	print_r($org);echo "</pre>";exit();

		$org_date = $org->Date;
		$org_name = $org->Org_Name;

		//$org_phone_code = $org->Appln_Phone_Code;
		//$org_mobile = $org->Appln_Mobile_No;
		//$org_contact = $org_phone_code . '-' . $org_mobile;

		$org_f_name = $org->F_Name;
		$org_l_name = $org->L_Name;
		$org_contcat_name = $org_f_name . ' ' . $org_l_name;

		$org_web_url = $org->Org_Website_URL;
		$org_appl_id = $org->Appln_ID;
		$org_appl_status = $org->Appln_status;
		$org_appl_status_String = applyStatusToString($org_appl_status);

		?>
          <tr>
            <th scope="row"><?php echo $cnt++; ?></th>
            <td><?php echo $org_date ?></td>
            <td><?php echo $org_name ?></td>
            <td><?php echo $org_contcat_name; ?></td>
            <td><?php echo $org_web_url; ?></td>
            <td><?php echo $org_appl_status_String; ?></td>

            <td>
              <div class='myDiv'>
                <?php if ($org_appl_status == 0): ?>
                   <a href="javascript:void(0)" class="appln_assign" data-appln_id="<?php echo $org_appl_id ?>" style='margin-right:16px;color: #fd750d;color:#13a932'>Assign</a>
                <?php endif?>

                <?php if ($org_appl_status == 1): ?>
                  <a href="<?php echo base_url('/show_companyDetails?applid=' . $org_appl_id) ?>">View</a>
                <?php endif?>

              </div>
            </td>
          </tr>
        <?php }} else {?>
          <tr>
            <td colspan="8">
              No record founds.
            </td>
          </tr>
        <?php }?>
      </tbody>
    </table>
  </div>

  <div class="row">
    <div class="col-md-12">
      <label class="error_flag" id="save_rs_err">
        <?php if (isset($errorMsg) && !empty($errorMsg)) {echo $errorMsg;}?>
      </label>
      <label class="success_flag" id="save_rs_succ"></label>
    </div>
  </div>
</div>


<style type="text/css">
  button.btn.btn-secondary {
    padding-right: 10px;
    padding-left: 10px;
  }
</style>

<script type="module" src="<?php echo base_url(); ?>/assets/js/org/org_apply_list.js"></script>

