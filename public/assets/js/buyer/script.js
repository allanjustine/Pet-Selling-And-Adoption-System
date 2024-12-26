const token = $('meta[name="csrf-token"]').attr("content");
const baseUrl = window.location.origin;
let pond;

$(() => {
    $('[data-toggle="tooltip"]').tooltip();
});

document.addEventListener("DOMContentLoaded", function (event) {
    // initiate global glightbox

    setTimeout(() => {
        GLightbox({
            selector: ".glightbox",
        });
    }, 1000);
});

// Like
async function like(pet_id) {
    try {
        const res = await axios.post(route("likes.store"), {
            pet_id,
        });
        let output = `  <span class="text-primary h5 ml-1" role="button" onclick="dislike(${pet_id})">
        <i class="fas fa-thumbs-up fa-lg"></i>
    </span>`;

        $("#like_count-" + pet_id).html(res.data.result);
        $("#like_icon-" + pet_id).html(output); // change like to  dislike button
    } catch (e) {
        const responses = e.response.data.errors;
        log(responses);
        if (responses) {
            const errors = Object.values(responses);
            errors.forEach((e) => {
                toastDanger(e);
            });
        } else {
            error(e.response.data.message);
        }
    }
}

async function dislike(pet_id) {
    try {
        const res = await axios.delete(route("likes.destroy", pet_id));

        let output = `  <span class="text-primary h5 ml-1" role="button" onclick="like(${pet_id})">
                        <i class="far fa-thumbs-up fa-lg"></i>
                    </span>`;

        $("#like_count-" + pet_id).html(res.data.result);
        $("#like_icon-" + pet_id).html(output); // change dislike to like button
    } catch (e) {
        const responses = e.response.data.errors;
        if (responses) {
            const errors = Object.values(responses);
            errors.forEach((e) => {
                toastDanger(e);
            });
        } else {
            error(e.response.data.message);
        }
    }
}

// End Like

// Comment
async function addComment(pet_id, event) {
    const keyPressed = event.keyCode || event.which;
    // if (keyPressed === 13) {
    event.preventDefault();
    if (isNotEmpty($("#comment_input-" + pet_id))) {
        try {
            // execute
            const res = await axios.post(route("comments.store"), {
                pet_id,
                comment: $("#comment_input-" + pet_id).val(),
            });
            $("#comment_input-" + pet_id).val("");
            const comment = res.data.result;
            let output = `<div class='rounded' id='comment_row-${comment.id}'>
                            <div class="d-flex justify-content-start align-items-center px-2 mt-2">
                            ${handleNullAvatar(comment.avatar, "", "30")}
                                        <div class="mx-3 w-100">
                                            <div class="px-2 float-right">
                                            <div class="dropdown dropdown d-flex justify-content-end text-right">
                                                    <a class='btn btn-sm btn-icon-only text-light'
                                                    href='#' role='button' data-toggle='dropdown'
                                                    data-display="static" aria-expanded='false'>
                                                    <i class='fas fa-ellipsis-v'></i>
                                                </a>
                                                
                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu">
                                                <button class="dropdown-item" type="button" onclick='editComment(${JSON.stringify(
                                                    comment
                                                )})'>Edit</button>
                                                <button class="dropdown-item" type="button" onclick="removeComment(${
                                                    comment.pet_id
                                                }, ${
                comment.id
            })">Delete</button>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="comment_body">
                                        <h4 class='font-weight-normal mt-2'>${
                                            comment.user
                                        }
                                            <span class="text-muted ml-1"> - just now </span>
                                        </h4>
                                        <h4 class='font-weight-normal'>${
                                            comment.comment
                                        }</h4>
                                    </div>
                                </div>
                            </div>
                         </div>
                        `;
            $("#d_comments-" + pet_id).prepend(output); // append newly added comment
            $("#comment_count-" + pet_id).html(comment.count); // update comment count
            $("div.emojionearea-editor").data("emojioneArea").setText("");
        } catch (e) {
            log(e);
            const responses = e.response.data.errors;
            if (responses) {
                const errors = Object.values(responses);
                errors.forEach((e) => {
                    toastDanger(e);
                });
            } else {
                error(e.response.data.message);
            }
        }
    }
    //}
}

function editComment(comment) {
    $("#m_comment").modal("show");
    $(".modal-header").removeClass("bg-info").addClass("bg-primary");
    $(".btn_update_comment").attr("data-id", comment.id);
    $("#comment").val(comment.comment);
    $("#pet_id").val(comment.pet_id);
}

async function updateComment(form, route_name, event) {
    // convert the first form in the parameter into a form data object
    const form_data = new FormData($(form)[0]);
    form_data.append("_method", "PUT");
    const model_id = event.target.getAttribute("data-id");

    try {
        // request
        const res = await axios.post(
            `${route(route_name, model_id)}`,
            form_data
        ); // fake update request

        const comment = res.data.result;

        let output = `
                        <div class="d-flex justify-content-start align-items-center px-2 mt-3" id="comment_row-${
                            comment.id
                        }">
                        ${handleNullAvatar(comment.avatar, "", "30")}
                            <div class="mx-3 w-100">
                                <div class="px-2 float-right">
                                    <div class="dropdown dropdown d-flex justify-content-end text-right">
                                            <a class='btn btn-sm btn-icon-only text-light'
                                            href='#' role='button' data-toggle='dropdown'
                                            data-display="static" aria-expanded='false'>
                                            <i class='fas fa-ellipsis-v'></i>
                                        </a>
                                        
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu">
                                        <button class="dropdown-item" type="button" onclick='editComment(${JSON.stringify(
                                            comment
                                        )})'>Edit</button>
                                        <button class="dropdown-item" type="button" onclick="removeComment(${
                                            comment.pet_id
                                        }, ${comment.id})">Delete</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="comment_body">
                                <h4 class='font-weight-normal'>${comment.user}
                                    <span class="text-muted ml-1"> - just now </span>
                                </h4>
                                <h4 class='font-weight-normal'>${
                                    comment.comment
                                }</h4>
                                </div>
                            </div>
                        </div>
        
                      `;
        $("#comment_row-" + comment.id).html(output);

        $("#m_comment").modal("hide");
        $(form)[0].reset(); // clear input field
        success("Your comment updated successfully");
    } catch (e) {
        log(e);
        error(e.response.data.message);
    }
}
async function removeComment(pet, comment) {
    const result = await confirm();
    if (result.isConfirmed) {
        try {
            const res = await axios.delete(route("comments.destroy", comment), {
                params: {
                    pet,
                },
            });
            success("Your comment has deleted successfully");
            $("#comment_row-" + comment).remove(); // remove specific comment
            $("#comment_count-" + pet).html(res.data.result); // update comment count
        } catch (e) {
            log(e);
            error(e.response.data.message);
        }
    }
}

async function showComments(pet) {
    $(".pet_form-" + pet).toggle();
    $("#d_comments-" + pet).toggle();
}

// End Comment

/**
 * send OTP
 * @param {*} event
 */
async function sendOtp(event) {
    const contact = $("#contact");
    log(contact.val());

    if (isNotEmpty(contact)) {
        try {
            event.target.innerText = "Sending ...";

            const res = await axios.post(route("buyer.otp.store"), {
                contact: contact.val(),
            });
            success(res.data.message);
            event.target.innerText = "Send OTP";
        } catch (e) {
            const responses = e.response.data.errors;
            if (responses) {
                const errors = Object.values(responses);
                errors.forEach((e) => {
                    toastDanger(e);
                });
            } else {
                error(e.response.data.message);
            }
        }
    }
}
