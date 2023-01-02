
<!-- Page content-->
<div class="gm_page">
  <div class=" container-fluid ">
    <h1>Organization List Level -2 </h1>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th scope="col">Sr no</th>
          <th scope="col">Date</th>
          <th scope="col">Organization Name</th>
          <th scope="col">Document-1 Status</th>
          <th scope="col">Document-2 Status</th>
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

      		$org_f_name = $org->F_Name;
      		$org_l_name = $org->L_Name;
      		$org_contcat_name = $org_f_name . ' ' . $org_l_name;

      		$org_appl_id = $org->Appln_ID;
      		$org_appl_status = $org->Appln_status;
      		$org_appl_status_String = applyStatusToString($org_appl_status); 

          $Doc1_Upload=$org->Doc1_Upload;
          $Doc1_Upload_msg ="Not Uploaded";
          if($Doc1_Upload==1){
            $Doc1_Upload_msg ="Uploaded";
          }

          $Doc2_Upload=$org->Doc2_Upload;
          $Doc2_Upload_msg ="Not Uploaded";
          if($Doc2_Upload==1){
            $Doc2_Upload_msg ="Uploaded";
          }
          ?>
          <tr>
            <th scope="row"><?php echo $cnt++; ?></th>
            <td><?php echo $org_date ?></td>
            <td><?php echo $org_name ?></td>
            <td><?php echo $Doc1_Upload_msg; ?></td>
            <td><?php echo $Doc2_Upload_msg; ?></td>
            <td><?php echo $org_appl_status_String; ?></td>

            <td>
              <div class='myDiv'>
          

                <?php if ($org_appl_status == 1): ?>
                  <a href="<?php echo base_url('/show_companyDetails?applid=' . $org_appl_id) ?>">View</a>
                <?php endif?>

                <?php if ($Doc1_Upload == 0 || $Doc2_Upload==0): ?>
                  | <a href="<?php echo base_url('/upload_documents/'.$org_appl_id) ?>">Upload Documents</a>
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

