$(document).ready(function () {

    // call datatables
    $('#sections').DataTable();
    $('#brands').DataTable();
    $('#categories').DataTable();
    $('#products').DataTable();
    $('#attributes').DataTable();


    $('.nav-item').removeClass('active');
    $('.nav-link').removeClass('active');
    //Check Admin Password is Correct or not
    $('#current_password').keyup(function () {
        let current_password = $('#current_password').val();


        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: '/admin/check-current-password',
            data: { current_password: current_password },
            success: function (resp) {
                if (resp == 'false') {
                    $('#check_current_password').html(" <font color='red'> Incorrect Current Password! </font>");
                } else if (resp == 'true') {
                    $('#check_current_password').html(" <font color='green'> Correct Current Password </font>");
                }
            },
            error: function (err) {
                alert(err);
            }

        });
    });

    // Update Admin Status
    $(document).on("click",".updateAdminStatus", function(){
        let status = $(this).children("i").attr("status");
        let admin_id = $(this).attr("admin_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: "/admin/update-admin-status",
            data: {status:status, admin_id:admin_id},
            success: function(resp){
                // alert(resp);
                if(resp['status'] == 0){
                    alert("This user is now InActive");
                    $("#admin-"+admin_id).html("<i style='font-size:25px' class='mdi mdi-bookmark-outline' status='InActive'> </i>");
                    
                }else if(resp['status'] == 1){
                    alert("This user is now Active");
                    $("#admin-"+admin_id).html("<i style='font-size:25px' class='mdi mdi-bookmark-check' status='Active'> </i>");
                    
                }

            },
            error: function(){
                alert("Error happen..Please refresh the page and do it again..");
            },

        });
    });

    // Update Section Status
    $(document).on("click",".updateSectionStatus", function(){
        let status = $(this).children("i").attr("status");
        let section_id = $(this).attr("section_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: "/admin/update-section-status",
            data: {status:status, section_id:section_id},
            success: function(resp){
                // alert(resp);
                if(resp['status'] == 0){
                    alert("This user is now InActive");
                    $("#section-"+section_id).html("<i style='font-size:25px' class='mdi mdi-bookmark-outline' status='InActive'> </i>");
                    
                }else if(resp['status'] == 1){
                    alert("This user is now Active");
                    $("#section-"+section_id).html("<i style='font-size:25px' class='mdi mdi-bookmark-check' status='Active'> </i>");
                    
                }

            },
            error: function(){
                alert("Error happen..Please refresh the page and do it again..");
            },

        });
    });

    // Confirm Deletion (Default Javascript)
    // $(".confirmDelete").click(function(){
    //     var title = $(this).attr("title");

    //     if(confirm("Are you sure you want to delete this "+title+"?")){
    //         return true;
    //     }else{
    //         return false;
    //     }
    // });

    // Confirm Deletion (SweetAlert Javascript)
    $(".confirmDelete").click(function(){
        let module = $(this).attr('module');
        let moduleid = $(this).attr('moduleid');
        
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
                Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
                )
                window.location = "/admin/delete-"+module+"/"+moduleid;
            }
            
        })
    });

    // Append Categories Level
    $("#section_id").change(function(){
        var section_id = $(this).val();
        // $.ajaxSetup({
            
        // });

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'get',
            url: '/admin/append-categories-level',
            data: {
                section_id : section_id,
            },
            success: function(resp){
               
                $("#appendCategoriesLevel").html(resp);
            },
            error: function(){
                alert("Error");
            }
        });
    });


    // Update Category Status
    $(document).on("click",".updateCategoryStatus", function(){
        let status = $(this).children("i").attr("status");
        let category_id = $(this).attr("category_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: "/admin/update-category-status",
            data: {status:status, category_id:category_id},
            success: function(resp){
                // alert(resp);
                if(resp['status'] == 0){
                    alert("This user is now InActive");
                    $("#category-"+category_id).html("<i style='font-size:25px' class='mdi mdi-bookmark-outline' status='InActive'> </i>");
                    
                }else if(resp['status'] == 1){
                    alert("This user is now Active");
                    $("#category-"+category_id).html("<i style='font-size:25px' class='mdi mdi-bookmark-check' status='Active'> </i>");
                    
                }

            },
            error: function(){
                alert("Error happen..Please refresh the page and do it again..");
            },

        });
    });

    // Update Brand Status
    $(document).on("click",".updateBrandStatus", function(){
        let status = $(this).children("i").attr("status");
        let brand_id = $(this).attr("brand_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: "/admin/update-brand-status",
            data: {status:status, brand_id:brand_id},
            success: function(resp){
                // alert(resp);
                if(resp['status'] == 0){
                    alert("This user is now InActive");
                    $("#brand-"+brand_id).html("<i style='font-size:25px' class='mdi mdi-bookmark-outline' status='InActive'> </i>");
                    
                }else if(resp['status'] == 1){
                    alert("This user is now Active");
                    $("#brand-"+brand_id).html("<i style='font-size:25px' class='mdi mdi-bookmark-check' status='Active'> </i>");
                    
                }

            },
            error: function(){
                alert("Error happen..Please refresh the page and do it again..");
            },

        });
    });

    // Update Product Status
    $(document).on("click",".updateProductStatus", function(){
        let status = $(this).children("i").attr("status");
        let product_id = $(this).attr("product_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: "/admin/update-product-status",
            data: {status:status, product_id:product_id},
            success: function(resp){
                // alert(resp);
                if(resp['status'] == 0){
                    alert("This user is now InActive");
                    $("#product-"+product_id).html("<i style='font-size:25px' class='mdi mdi-bookmark-outline' status='InActive'> </i>");
                    
                }else if(resp['status'] == 1){
                    alert("This user is now Active");
                    $("#product-"+product_id).html("<i style='font-size:25px' class='mdi mdi-bookmark-check' status='Active'> </i>");
                    
                }

            },
            error: function(){
                alert("Error happen..Please refresh the page and do it again..");
            },

        });
    });

    // Add Remove Attributes
    
    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML = '<div><div style="height:15px"> </div><input type="text" style="width:120px" name="size[]" placeholder="Size"/>&nbsp;<input type="text" style="width:120px" name="sku[]" placeholder="SKU"/>&nbsp;<input type="text" style="width:120px" name="price[]" placeholder="Price"/>&nbsp;<input type="text" style="width:120px" name="stock[]" placeholder="Stock"/>&nbsp;<a href="javascript:void(0);" class="remove_button">Remove</a></div>'; //New input field html 
    var x = 1; //Initial field counter is 1
    
    //Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
        }
    });
    
    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });
    



    
    

});