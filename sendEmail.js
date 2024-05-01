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