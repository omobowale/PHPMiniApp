$(function(){
    
            $("#accesscodeinput").focus(function(){
                $(this).attr("placeholder", "")
                $("#accesscodespan").show();    
            });
            
            
            $("#loginform").submit(function(event){
                event.preventDefault();
                var accesscode = $("#accesscode").val();
               
                $.ajax({
                    url: "others/validateaccesscode.php",
                    type: "post",
                    data: {accesscode: accesscode},
                    success: function(rdata){
                            //remove the newline character in the returned data
                            ndata = rdata.substring(0, rdata.length-1);
                         if(ndata === "false"){
                            $("#message").attr("class", "alert alert-danger text-center").html("Error: Invalid access code");
                         }
                         else if(ndata.length == 64){
                            window.location.href = "others/go.php?data=" + ndata;
                         }
                         else {
                             $("#message").attr("class", "alert alert-danger text-center").html("Unknown error");
                         }
                         
                    },
                    error: function(){
                        $("#message").attr("class", "alert alert-danger text-center").html("Error: Could not load page");
                    }
                    
                });
                
                
            });
    
    
            
            
            $("#applicationform").submit(function(event){
                
                event.preventDefault();
                
                var imagefile = $("#file").prop("files")[0];
                
                if(!((imagefile.type == "image/jpeg") || (imagefile.type == "image/png") || (imagefile.type == "image/gif") || (imagefile.type == "image/bmp") || (imagefile.type == "image/webp"))){
                    alert("Only images of type jpg, gif, bmp or png are allowed");
                }
                else {
                    if(imagefile.size < 2*1024*1024){

                        if(confirm("Are you sure you want to submit this application? \nYou won't be able to edit once submitted")){
                        var formdata = new FormData(this);
                        $.ajax({
                            url: "others/validateapplicationform.php",
                            type: "post",
                            data: formdata,
                            processData: false,
                            contentType: false,
                            success: function (data){
                                if(data.length == 64){
                                    window.location.href = "others/go.php?response=" + data;
                                }
                                else{
                                    $("#message").html("<small class='text-danger'>" + data + "</small>");
                                }
                            },
                            error: function (){

                            }
                        });

                        }
                    }


                    else {
                        alert("Image file too large.\nPlease select a file not greater than 2MB");
                    }
                }
            })
            
})