const token = $('meta[name="csrf-token"]').attr("content");
const baseUrl = window.location.origin;
let pond;

$(() => {
    // Activity Logs
    if (window.location.href === route("admin.activity_logs.index")) {
        const columns = [
            {
                data: "id",
            },
            { data: "description" },
            {
                data: "created_at",
                render(data) {
                    return formatDate(data, "datetime");
                },
            },
            { data: "properties.ip" },
        ];
        c_index(
            $(".activitylog_dt"),
            route("admin.activity_logs.index"),
            columns
        );
    }

    // Buyer
    if (window.location.href === route("admin.buyers.index")) {
        const columns = [
            { data: "id" },
            {
                data: "avatar",
                render(data) {
                    return handleNullAvatar(data);
                },
            },
            { data: "first_name" },
            { data: "middle_name" },
            { data: "last_name" },
            { data: "sex" },
            {
                data: "birth_date",
                render(data) {
                    return formatDate(data, "full");
                },
            },
            { data: "address" },
            // { data: "barangay" },
            { data: "contact" },
            { data: "email" },
            {
                data: "created_at",
                render(data) {
                    return formatDate(data, "full");
                },
            },
            { data: "actions", orderable: false, searchable: false },
        ];
        c_index($(".buyer_dt"), route("admin.buyers.index"), columns);
    }

    // Seller
    if (window.location.href === route("admin.sellers.index")) {
        const columns = [
            { data: "id" },
            {
                data: "avatar",
                render(data) {
                    return handleNullAvatar(data);
                },
            },
            { data: "owner" },
            { data: "business_name" },
            { data: "contact" },
            { data: "email" },
            {
                data: "proof_of_ownership",
                render(data) {
                    return handleNullImage(data, "", 50);
                },
            },
            {
                data: "created_at",
                render(data) {
                    return formatDate(data, "full");
                },
            },
            {
                data: "status",
                render(data) {
                    return isApproved(data);
                },
            },
            { data: "actions", orderable: false, searchable: false },
        ];
        c_index($(".seller_dt"), route("admin.sellers.index"), columns);
    }

    //User;
    if (window.location.href === route("admin.users.index")) {
        const columns = [
            {
                data: "id",
                render(data, type, row) {
                    return row.DT_RowIndex;
                },
            },
            {
                data: "avatar",
                render(data) {
                    return handleNullAvatar(data);
                },
            },
            { data: "name" },
            {
                data: "email_verified_at",
                render(data) {
                    return isVerified(data);
                },
            },
            {
                data: "role",
                render(data) {
                    return `<span class='badge badge-primary'>${data}</span>`;
                },
            },
            {
                data: "is_activated",
                render(data) {
                    return isActivated(data);
                },
            },
            {
                data: "created_at",
                render(data) {
                    return formatDate(data.date, "full");
                },
            },
            { data: "actions", orderable: false, searchable: false },
        ];
        c_index($(".user_dt"), route("admin.users.index"), columns);
    }

    // Admin
    if (window.location.href === route("admin.admins.index")) {
        const columns = [
            {
                data: "id",
                render(data, type, row) {
                    return row.DT_RowIndex;
                },
            },
            { data: "first_name" },
            { data: "middle_name" },
            { data: "last_name" },
            { data: "sex" },
            { data: "address" },
            { data: "barangay.name" },
            { data: "contact" },
            { data: "email" },
            {
                data: "created_at",
                render(data) {
                    return formatDate(data, "full");
                },
            },
            { data: "actions", orderable: false, searchable: false },
        ];
        c_index($(".admin_dt"), route("admin.admins.index"), columns);
    }

    /** Start Pet Management */

    //Category;
    if (window.location.href === route("admin.categories.index")) {
        const columns = [
            {
                data: "id",
                render(data, type, row) {
                    return row.DT_RowIndex;
                },
            },
            { data: "name" },
            {
                data: "has_vaccination",
                render(data) {
                    return isBool(data);
                },
            },
            {
                data: "has_deworming",
                render(data) {
                    return isBool(data);
                },
            },
            { data: "actions", orderable: false, searchable: false },
        ];
        c_index($(".category_dt"), route("admin.categories.index"), columns);
    }

    //Breed;
    if (window.location.href === route("admin.breeds.index")) {
        const columns = [
            {
                data: "id",
                render(data, type, row) {
                    return row.DT_RowIndex;
                },
            },
            { data: "name" },
            { data: "category.name" },
            { data: "actions", orderable: false, searchable: false },
        ];
        c_index($(".breed_dt"), route("admin.breeds.index"), columns);
    }

    // Pet

    if (window.location.href === route("admin.pets.index")) {
        const columns = [
            {
                data: "id",
                render(data, type, row, meta) {
                    return row.DT_RowIndex;
                },
            },
            {
                data: "avatar",
                render(data) {
                    return handlleNullAvatarForPet(data, "", 50);
                },
            },
            { data: "name" },
            { data: "breed" },
            { data: "type" },
            { data: "category" },
            { data: "seller" },
            { data: "price" },
            {
                data: "proof_of_ownership",
                render(data) {
                    return handleNullImage(data, "", 50);
                },
            },
            {
                data: "is_available",
                render(data) {
                    return isAvailable(data);
                },
            },
            {
                data: "status",
                render(data) {
                    return isApproved(data);
                },
            },
            {
                data: "created_at",
                render(data) {
                    return formatDate(data, "full");
                },
            },
            { data: "actions", orderable: false, searchable: false },
        ];
        c_index($(".pet_dt"), route("admin.pets.index"), columns);
    }

    // Adoption

    if (window.location.href === route("admin.adoptions.index")) {
        const columns = [
            {
                data: "id",
                render(data, type, row, meta) {
                    return row.DT_RowIndex;
                },
            },
            {
                data: "avatar",
                render(data) {
                    return handlleNullAvatarForPet(data, "", 50);
                },
            },
            { data: "pet_name" },
            { data: "breed" },
            { data: "type" },
            { data: "category" },
            { data: "seller" },
            // { data: "price" },
            {
                data: "proof_of_ownership",
                render(data) {
                    return handleNullImage(data, "", 50);
                },
            },
            {
                data: "is_adopted",
                render(data) {
                    return isAdopted(data);
                },
            },
            {
                data: "status",
                render(data) {
                    return isApproved(data);
                },
            },
            {
                data: "created_at",
                render(data) {
                    return formatDate(data, "full");
                },
            },
            { data: "actions", orderable: false, searchable: false },
        ];
        c_index($(".adoption_dt"), route("admin.adoptions.index"), columns);
    }
    /** End Pet Management */

    /** Start Order Management */

    // Manage Payment Methods
    if (window.location.href === route("admin.payment_methods.index")) {
        const column_data = [
            { data: "type" },
            { data: "account_name" },
            { data: "account_no" },
            {
                data: "is_online",
                render(data) {
                    log(data);
                    return isActivated(data);
                },
            },
            { data: "actions", orderable: false, searchable: false },
        ];
        c_index(
            $(".payment_method_dt"),
            route("admin.payment_methods.index"),
            column_data
        );
    }

    // Order
    if (window.location.href === route("admin.orders.index")) {
        const columns = [
            {
                data: "id",
                render(data, type, row) {
                    return row.DT_RowIndex;
                },
            },
            { data: "transaction_no" },
            { data: "reference_no" },
            {
                data: "payment_type",
                render(data) {
                    return `<span class='badge badge-primary'>${data}</span>`;
                },
            },
            { data: "pet" },
            { data: "breed" },
            {
                data: "buyer",
                render(data) {
                    return `<span class='text-capitalize'>${data}</span>`;
                },
            },
            {
                data: "status",
                render(data) {
                    return handleOrderStatus(data);
                },
            },
            {
                data: "updated_at",
                render(data) {
                    return formatDate(data, "full");
                },
            },
            { data: "actions", orderable: false, searchable: false },
        ];
        c_index($(".order_dt"), route("admin.orders.index"), columns);

        $("#order_management_nav").addClass("active");
    }
    /** End Order Management */
});

//=========================================================
// Custom Functions()
document.addEventListener("DOMContentLoaded", function (event) {
    // initiate global glightbox

    setTimeout(() => {
        GLightbox({
            selector: ".glightbox",
        });
    }, 1000);
});

function filterOrderByStatus(status) {
    const columns = [
        {
            data: "id",
            render(data, type, row) {
                return row.DT_RowIndex;
            },
        },
        { data: "transaction_no" },
        { data: "reference_no" },

        {
            data: "payment_type",
            render(data) {
                return `<span class='badge badge-primary'>${data}</span>`;
            },
        },
        { data: "pet" },
        { data: "breed" },
        {
            data: "buyer",
            render(data) {
                return `<span class='text-capitalize'>${data}</span>`;
            },
        },
        {
            data: "status",
            render(data) {
                return handleOrderStatus(data);
            },
        },
        {
            data: "updated_at",
            render(data) {
                return formatDate(data, "full");
            },
        },
        { data: "actions", orderable: false, searchable: false },
    ];
    c_index(
        $(".order_dt"),
        route("admin.orders.index", {
            status: status.value,
        }),
        columns,
        null,
        true
    );
}

function filterPetForSaleByCategory(category) {
    const columns = [
        {
            data: "id",
            render(data, type, row, meta) {
                return row.DT_RowIndex;
            },
        },
        {
            data: "avatar",
            render(data) {
                return handlleNullAvatarForPet(data, "", 50);
            },
        },
        { data: "name" },
        { data: "breed" },
        { data: "category" },
        { data: "seller" },
        {
            data: "proof_of_ownership",
            render(data) {
                return handleNullImage(data, "", 50);
            },
        },
        {
            data: "is_available",
            render(data) {
                return isAvailable(data);
            },
        },
        {
            data: "status",
            render(data) {
                return isApproved(data);
            },
        },
        {
            data: "created_at",
            render(data) {
                return formatDate(data, "full");
            },
        },
        { data: "actions", orderable: false, searchable: false },
    ];
    c_index(
        $(".pet_dt"),
        route("admin.pets.index", {
            category: category.value,
        }),
        columns,
        null,
        true
    );
}

function filterPetForAdoptionByCategory(category) {
    const columns = [
        {
            data: "id",
            render(data, type, row, meta) {
                return row.DT_RowIndex;
            },
        },
        {
            data: "avatar",
            render(data) {
                return handlleNullAvatarForPet(data, "", 50);
            },
        },
        { data: "pet_name" },
        { data: "breed" },
        { data: "category" },
        { data: "seller" },
        {
            data: "proof_of_ownership",
            render(data) {
                return handleNullImage(data, "", 50);
            },
        },
        {
            data: "is_adopted",
            render(data) {
                return isAdopted(data);
            },
        },
        {
            data: "status",
            render(data) {
                return isApproved(data);
            },
        },
        {
            data: "created_at",
            render(data) {
                return formatDate(data, "full");
            },
        },
        { data: "actions", orderable: false, searchable: false },
    ];
    c_index(
        $(".adoption_dt"),
        route("admin.adoptions.index", {
            category: category.value,
        }),
        columns,
        null,
        true
    );
}
