$(document).ready(function(){
    $("#sort").on("change", function(){
        //this.form.submit();
        //type = this.val();

        //alert(this.value);
        // let $shopProductContainer = $('.product-container');
        // alert('$shopProductContainer');
        // $shopProductContainer.addClass('grid-style');
        // $shopProductContainer.removeClass('list-style');
        // const attachClickGridAndList = function () {
        //     $('#list-anchor').on('click',function () {
        //         $(this).addClass('active');
        //         $(this).next().removeClass('active');
        //         $shopProductContainer.removeClass('grid-style');
        //         $shopProductContainer.addClass('list-style');
        //     });
        //     $('#grid-anchor').on('click',function () {
        //         $(this).addClass('active');
        //         $(this).prev().removeClass('active');
        //         $shopProductContainer.removeClass('list-style');
        //         $shopProductContainer.addClass('grid-style');
        //     });
        // };

        var sort = $("#sort").val();
        var url = $("#url").val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url : url,
            method : "POST",
            data : {sort : sort, url : url},
            success : function(data) {
                $(".filter_products").html(data);
            },
            error : function() {
                alert("Error");
            }

        });
    });
});