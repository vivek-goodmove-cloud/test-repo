
      <!-- Page content-->
      <div class=" container-fluid container">
        <h1>Upload Document</h1>
        <div class="form-box">

          <form enctype="multipart/form-data" id="save_Org_Documents">

            <div class="form-group">
              <label for="app_id">Application Id</label>
              <input class="form-control" id="app_id" type="text" name="app_id" placeholder="Enter Application Id" autocomplete="off" value="">
              <span class="error_flag" id="appId_err"></span>
            </div>

            <!-- <div class="form-group">
              <label for="doc_type">Document Type-1</label>
              <select id="doc_type" class="form-control">
                <option value="">Select Document Type</option>
                <option value="comp_reg document">Company Registered document</option>
                <option value="pan_card">Pan Card</option>
                <option value="other">Other</option>
              </select>
              <span class="error_flag" id="docType_err"></span>
            </div> -->
            <div class="form-group">
              <label for="comp_reg_doc_1">Upload company registered document -1 </label>
              <input type="file" class="form-control" name="comp_reg_doc_1" id="comp_reg_doc_1" >
            </div>

            <div class="form-group">
              <label for="comp_reg_doc_2">Upload company registered document -2 </label>
              <input type="file" class="form-control" name="comp_reg_doc_2" id="comp_reg_doc_2" >
            </div>

            <div class="cmxform"></div>
            <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url() ?>">
            <br><label class="error_flag all_messages" id="save_rs_err"></label>
            <br><label class="success_flag all_messages" id="save_rs_succ"></label>
            <div class="form-actions col-md-12" >
              <div class="row" style="float:right;">
                <div class="col-md-offset">
                  <a href="#" id="back" class="btn btn-default">Back</a>
                  <button type="submit" id="submit_btn" class="btn btn-success">Upload</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    <script src="<?php echo base_url(); ?>/assets/js/FormValidate.js"></script>
    <script src="<?php echo base_url(); ?>/assets/js/upload_documents.js"></script>
    <style type="text/css">
      .form-box {
        max-width: 800px;
        margin: auto;
        padding: 50px;
        background: #ffffff;
        border: 10px solid #f2f2f2;
      }

      input, textarea {
        width: 100%;
      }
      .error_flag{
          color: red;
          font-size: 13px;
      }
      .success_flag{
          color: green;
          font-size: 13px;
      }
    </style>

  </html>
