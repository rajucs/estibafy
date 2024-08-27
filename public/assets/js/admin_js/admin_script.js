$(document).ready(function () {

// Confirm Delete for All
    $(document).on("click", ".confirmDelete", function () {

        var recordDeleteUrl = $(this).attr('recordid');

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {

                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Deleted Successfully',
                    showConfirmButton: false,
                    timer: 1500
                });

                window.location.href = recordDeleteUrl;

                // window.location.href = "admin/delete-"+record+"/"+recordid;
                // Swal.fire(
                //     'Deleted!',
                //     'Your file has been deleted.',
                //     'success'
                // )
            }
        })


    });


});