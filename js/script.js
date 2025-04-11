$(document).ready(function(){
    //add/edit user
    $(document).on("submit","#addfrom", function(event){
        event.preventDefault();
        $.ajax({
            url:"phpcrudajax/ajax.php",
            type:"POST",
            dataType:"json",
            data: new FormData(this),
            processData: false,
            contentType: false,
            beforeSend: function(){
                console.log("wait..");
            },
            success,function(response){
                console.log(response);
            },
            error: function(){
                console.log("Oops, something went wrong..");
                
            }
        })
    })
})