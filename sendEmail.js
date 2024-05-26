function sendMail(){
    let params = {
        firstname : document.getElementById("firstname").value,
        lastname : document.getElementById("lastname").value,
        email : document.getElementById("email").value,
        phoneNumber : document.getElementById("phoneNumber").value,
        mesgSubject : document.getElementById("mesgSubject").value,
        msg : document.getElementById("msg").value
    }
    emailjs.send("service_lxmqzq5", "template_6zufajn", params).then(alert("Email has been sent successfully! We will respond to you shortly."))
}

Script to send email
	Fom Elasticemail.com/SMTPJS.com
	This code is not working

    function sendMail(){
        Email.send({
			SecureToken: "23a0e1b7-6dd7-4f96-8bc3-3819c13aeb02",
            To : 'okothgerald449@gmail.com',
            From : document.getElementById("email").value,
            Subject : document.getElementById("mesgSubject").value,
            Body : "First Name: " + document.getElementById("firstname").value +
                    " <br> Last Name: " + document.getElementById("lastname").value +
                    " <br> Email: " + document.getElementById("email").value +
                    " <br> Number: " + document.getElementById("phoneNumber").value +
                    " <br> Subject: " + document.getElementById("mesgSubject").value +
                    " <br> Message: " + document.getElementById("msg").value
        }).then(
        message => alert("message sent successfully!")
        );
    }