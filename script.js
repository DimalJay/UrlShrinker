$(".download-panel").hide();
$(".subscribe").click(function(){
    
    var email_addr = $(".email").val();
    var key_code = $("#key").val();

    async function Tutor() {
        if(ValidateEmail(email_addr)){
            await sleep(30);
            $(".email-feild").hide();
            $(".download-panel").show();


            $.post("rog.php",
            {
                update: "true" ,
                email: email_addr,
                key : key_code
            },
            function(data){
                if(data=="true"){
                    $(".download").prop("disabled",false);
                }
            });
        
        }else{
            $('input[name=email]').addClass("is-invalid");
            $(this).html("Subcribing. . .");
            $("#spinner").hide();
            $(this).prop("disabled",true);

            if($(this).find("btn-sucess").length > 0){
                
            }else{
                $(this).toggleClass('btn-danger btn-success');
            }
        }
        
    }
    Tutor();

});

$(".download").click(function(){
    var key_code = $("#key").val();    
    $.post("download.php",
    {
        file:key_code
    },function(data){
        window.location.href = "http://localhost";
    });
});


function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

function ValidateEmail(mail) {
    if (/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test(mail)){
        return (true)
    }
    return (false)
}