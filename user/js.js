// Enquiry Send
$('#enquiry_form').submit(function(event){
    event.preventDefault();

    var name = $('#enquiry_name').val();
    var email = $('#enquiry_email').val();
    var subject = $('#enquiry_subject').val();
    var msg = $('#enquiry_msg').val();

    if(name == '')
    {
        swal('Opps...Filling the blanks','Please Enter Your Name','info');
        return false;
    }else
    if(email == '')
    {
        swal('Opps...Filling the blanks','Please Enter Your Email','info');
        return false;
    }else
    if(subject == '')
    {
        swal('Opps...Filling the blanks','Please Enter Subject','info');
        return false;
    }else
    if(msg == '')
    {
        swal('Opps...Filling the blanks','Please Enter Massage','info');
        return false;
    }
    else{
    $.ajax(
        {
            url:"action.php",
            method:"POST",
            data:new FormData(this),
            contentType:false,
            processData:false,
            success:function(data)
            {
                if(data == 'Sent')
                {
                    swal('Successfull','Your Enquiry Sent Now','success');
                    $('#enquiry_form')[0].reset();
                }else
                if(data == 'Not_Sent')
                {
                    swal('Somthing Went Wrong','Please Contact Yo-travel Hotline','error');
                }
            }
        })
    }

    });

    // Chat-bot Icon
    $(window).scroll(function() {
        if ($(this).scrollTop() > 100) {
          $('.chat-bot').fadeIn('slow');
        } else {
          $('.chat-bot').fadeOut('slow');
    
        }
      });

      $('#chat_bot').click(function() {
        $('#chat_bot_modal').modal('show');
        
      });

// Create QR Code 
    $('.QR-code').click(function() {
        // $('#user_invoice_modal').modal('hide');
        $('#QR_modal').modal('show');
        var ID = "Invoice number = "+ $(this).attr("id");


        var action = "Create_QR-Code";

        
        $.ajax(
            {
                url:"action.php",
                method:"POST",
                data:{ID:ID, action:action},
                success:function(data)
                {
                    
                    $('#QR_output').html(data);
                   
                }
            })
    });

// Cancel Invoice
$('.invoice_cancel').click(function() {
    
    var ID = $(this).attr("id");
    var action = "invoice_cancel";
    $('#user_invoice_modal').modal('hide');

        swal({
            title: "Are you sure?",
            text: "Once Canceled, you will not be able to active this invoice!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
            
            $.ajax({
                url:"action.php",
                method:"POST",
                data:{ID:ID, action:action},
                success:function(data)
                {
                    if(data == 'cancel')
                    {
                        swal("Greate Jobe","This invoice is cancel","success");
                        window.location.reload(true);
                    }else
                    if(data == 'not_cancel')
                    {
                        swal('Somthing Went Wrong','Please Contact Yo-travel Hotline','error');
                    }
                }
            })
            } else {
            swal("This invoice is not cancel!");
            }
        });
});