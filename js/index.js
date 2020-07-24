$(function(){
    
            $("#accesscodeinput").focus(function(){
                $(this).attr("placeholder", "")
                $("#accesscodespan").show();    
            });
            
            
            $("#loginform").submit(function(event){
                event.preventDefault();
                var datatopost = $("#accesscodeinput").val();
                $.ajax({
                   url: "others/validateaccesscode.php",
                    type: "POST",
                    data: {val: datatopost},
                    success: function(data){
                         $("#message").attr("class", "alert alert-success text-center").html(data);
                         window.location.href = "others/go.php?data=" + data;
                    },
                    error: function(){
                        $("#message").attr("class", "alert alert-danger text-center").html("Error: Could not load page");
                    }
                    
                });
                
                
            });
            
})