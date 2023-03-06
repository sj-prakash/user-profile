$(document).ready(() => {
    if (localStorage.getItem('user')) {
        $(location).prop('href', 'profile.html')
    } else {
        $(".btn-submit").click(() => {
            const user = {
                username: $("#uname").val().trim(),
                password: $("#pass").val().trim()
            }

            const confirmPass = $("#confirm-pass").val().trim()

            const profile = {
                username: user.username,
                name: $("#name").val().trim(),
                dob: $("#dob").val().trim(),
                phone: $("#phone").val().trim(),
                email: $("#email").val().trim(),
                bio: $("#bio").val().trim()
            }

            let valid = false

            if (user.username !== "" && user.password !== "" && profile.name !== "" && profile.dob !== "" && profile.phone !== "" && profile.email !== "" && profile.bio !== "" && confirmPass !== "") {
                if (user.password == confirmPass) {
                    valid = true
                } else {
                    alert("Passwords don't match!")
                }
            } else {
                alert("Enter all details and try again!")
            }

            if (valid) {
                $.ajax({
                    url: "/php/register.php",
                    type: "POST",
                    data: {
                        user, profile
                    },
                    success: registerHandler,
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert(textStatus, errorThrown, jqXHR);
                    }
                });
            }
        })

        $(".form-inputs").scroll(() => {
            $(".scroll-text").css('opacity', '0')
        })
    }
})

const registerHandler = (response) => {
    if (response) {
        console.log(response);
    } else {
        $(location).prop('href', 'login.html')
    }
}