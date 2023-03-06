$(document).ready(() => {
    if (localStorage.getItem('user')) {
        $(location).prop('href', 'profile.html')
    } else {
        // Logout user from server
        $.ajax({
            url: "/php/profile.php",
            type: "GET",
            data: {
                logout: true
            },
            success: () => {
                localStorage.removeItem('user')
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(textStatus, errorThrown, jqXHR);
            }
        });

        $(".btn-submit").click(() => {
            let valid = false

            const user = {
                uname: $("#uname").val().trim(),
                pass: $("#pass").val().trim()
            }

            if (user.uname !== "" && user.pass !== "") {
                valid = true
            } else {
                alert("Enter all credentials!")
            }

            if (valid) {
                $.ajax({
                    url: "/php/login.php",
                    type: "POST",
                    data: user,
                    success: loginHandler,
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert(textStatus, errorThrown, jqXHR);
                    }
                });
            }
        })
    }
})

const loginHandler = (response) => {
    res = JSON.parse(response)
    if (res.user) {
        localStorage.setItem('user', res.user)

        $(location).prop('href', 'profile.html')
    } else {
        localStorage.removeItem('user')

        alert(res.error);
    }
}