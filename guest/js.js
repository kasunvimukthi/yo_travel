// Enquiry Send
$(document).ready(function()
{
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
// =====================================================================================================
//                                          USER LOGIN
// =====================================================================================================
      $('#login_button').click(function() {
        $('#login').modal('show');
        
      });

  // Sacan QR Code & Login
    $('#login_qr').click(function() {
      $('#login').modal('hide');
      $('#login_qr_modal').modal('show');
      
      let scanner = new Instascan.Scanner({ video: document.getElementById('login_qr_preview')});
      Instascan.Camera.getCameras().then(function(cameras){
          if(cameras.length > 0 ){
              scanner.start(cameras[0]);
          } else{
              alert('No cameras found'); // If device not have camera, popup error message
          }

      }).catch(function(e) {
          console.error(e);
      });

      scanner.addListener('scan',function (c){ // Read QR Code
        
        $('#qr_email').val(c); // QR values add in to text box
       
          $('#login_with_qr').submit(); // submit login forms
      });
    });

// =====================================================================================================
//                                          CREATE NEW ACCOUNT
// =====================================================================================================
      $('#new_account').click(function() {
        $('#login').modal('hide');
        $('#register_now').modal('show');
        
      });

      $('#have_account').click(function() {
        $('#register_now').modal('hide');
        $('#login').modal('show');
        
      });


      


    });