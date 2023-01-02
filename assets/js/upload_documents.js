document.getElementById('save_Org_Documents').addEventListener('submit', function(e) {
  e.preventDefault();
  
  let submitOkay;

  $("#all_messages").html("");
  
  let app_id = document.querySelector('#app_id').value
  let base_url = document.getElementById('base_url').value


  $("#appId_err").html("");
  if(app_id === ''){
    $("#appId_err").html("Please enter valid Application Id")
  }

  submitOkay = app_id

  // Prevent form submission if form input is not okay
  if (submitOkay) {
   
    var url =base_url+"/save_Org_Documents";
    var formData = new FormData(this);
    
    $.ajax({
      url:url,
      type:"POST",
      data:new FormData(this),
      processData:false,
      contentType:false,
      cache:false,
      async:false,
      success: function(data){
        console.log(data);
        var json_obj = $.parseJSON(data);
       
        $("#all_messages").html("");
        if(json_obj.errr==1){
          $("#save_rs_err").html(json_obj.msg)
        }else{
          $("#save_rs_succ").html(json_obj.msg)
        }
      }
    });
  }else{
    //console.log("Final ==>"+submitOkay)
  }
});