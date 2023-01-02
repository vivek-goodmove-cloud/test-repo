function verify_emailId(app_id,email_id){

  let base_url = $("#base_url").val();
  var url =base_url+"verify_app_emailId";
  $.ajax({
    url:url,
    type:"POST",
    data:{'app_id':app_id,'email_id':email_id},
    success: function(data){
      console.log(data);
      var json_obj = $.parseJSON(data);
       
      $("#all_messages").html("");
      if(json_obj.errr==1){
        alert(json_obj.msg)
        //$("#save_rs_err").html(json_obj.msg)
      }else{
        alert(json_obj.msg)
        $("#save_rs_succ").html(json_obj.msg)
      }
    }
  });
}

function verify_Website(app_id,website){
  
  let base_url = $("#base_url").val();
  var url =base_url+"verify_app_Website";
  $.ajax({
    url:url,
    type:"POST",
    data:{'app_id':app_id,'website':website},
    success: function(data){
      console.log(data);
      var json_obj = $.parseJSON(data);
       
      $("#all_messages").html("");
      if(json_obj.errr==1){
        alert(json_obj.msg)
        //$("#save_rs_err").html(json_obj.msg)
      }else{
        alert(json_obj.msg)
        $("#save_rs_succ").html(json_obj.msg)
      }
    }
  });
}