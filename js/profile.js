$(document).ready(() => {

    if (!localStorage.getItem("user")) {
        $(location).prop('href', 'login.html')
    } else {
        $.ajax({
            url: "/php/profile.php",
            type: "GET",
            success: profileShowHandler,
            error: function (jqXHR, textStatus, errorThrown) {
                alert(textStatus, errorThrown, jqXHR);
                $(location).prop('href', 'login.html')
            }
        });

        $(".btn-submit").click(() => {
            let valid = false

            profile = {
                username: localStorage.getItem('user'),
                name: $("#name").val().trim(),
                dob: $("#dob").val().trim(),
                phone: $("#phone").val().trim(),
                email: $("#email").val().trim(),
                bio: $("#bio").val().trim()
            }

            if (profile.name !== "" && profile.dob !== "" && profile.phone !== "" && profile.email !== "" && profile.bio !== "") {
                valid = true
            } else {
                alert("Enter all empty details and try again!")
            }

            if (valid) {
                $.ajax({
                    url: "/php/profile.php",
                    type: "POST",
                    data: profile,
                    success: profileEditHandler,
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert(textStatus, errorThrown, jqXHR);
                    }
                });
            }
        })

        $(".btn-logout").click(() => {
            $.ajax({
                url: "/php/profile.php",
                type: "GET",
                data: {
                    logout: true
                },
                success: () => {
                    localStorage.removeItem('user')
                    $(location).prop('href', 'login.html')
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(textStatus, errorThrown, jqXHR);
                }
            });
        })

        $(".form-inputs").scroll(() => {
            $(".scroll-text").css('opacity', '0')
        })
    }




})

const profileShowHandler = (response) => {
    $("#username").text(response.username)
    $("#name").val(response.name)
    $("#dob").val(response.dob)
    $("#phone").val(response.phone)
    $("#email").attr('type', 'text')
    $("#email").val(response.email)
    $("#bio").val(response.bio)
    $("#email").attr('type', 'email')
}

const profileEditHandler = (response) => {
    if (response.error) {
        alert(response.error)
    } else {
        alert("Updated successfully!")
    }
}